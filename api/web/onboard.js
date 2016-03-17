(function (onboard, $, undefined ) {

    //Private Properties
    var _version = '1.3';

    /**
     * @type {int} Number of data request made.
     * @private
     */
    var _number_of_data_requests = 0;

    /**
     * @type {int} Number of saves made.
     * @private
     */
    var _number_of_save_requests = 0;

    /**
     * Visible sequence set in showStep function.
     *
     * @type {int} Current visible sequence.
     * @private
     */
    var _visible_step_sequence = 0;

    /**
     * Should continue with new chains when the current is completed.
     *
     * @type {boolean} Should continue on completion
     * @private
     */
    var _continue_on_completion = true;

    /**
     * Defines min/max height required to render the tour.
     *
     * @type {integer} min / max height
     * @private
     */
    var _min_height = null, _max_height = null;

    /**
     * Defines min/max width required to render the tour.
     *
     * @type {integer} min / max height
     * @private
     */
    var _min_width = null, _max_width = null;

    /**
     * @type {timer} The timer used for delaying the resize handler.
     * @private
     */
    var _resize_timer;

    // The main data
    var _data = {
        lowest_sequence: 1,
        highest_sequence: 1,
        steps: []
    };

    /**
     * Reset the _data and remove step parts.
     */
    function reset() {
        _data = {
            lowest_sequence: 1,
            highest_sequence: 1,
            steps: []
        };
        _number_of_data_requests =  0;
        _number_of_save_requests =  0;
        _visible_step_sequence =    0;
        _min_height = null;
        _max_height = null;
        _min_width = null;
        _max_width = null;

        $('.ob_step_part').remove();
    }

    //Public Properties
    onboard.debug =             onboard.debug           || false;

    onboard.data_url =          onboard.data_url        || undefined;
    onboard.save_url =          onboard.save_url        || undefined;
    onboard.key =               onboard.key             || undefined;
    onboard.uid =               onboard.uid             || undefined;
    onboard.language_code =     onboard.language_code   || undefined;
    onboard.version =           onboard.version         || undefined;

    //Public Methods
    onboard.selfTest = function() {
        onboard.log('Onboard script ' + _version);
        onboard.log('jQuery ' + $.fn.jquery);

        if (onboard.data_url === undefined) {
            onboard.data_url =  'https://onboard.homerun.io/v1/data/steps'
        }

        if (onboard.save_url === undefined) {
            onboard.save_url =  'https://onboard.homerun.io/v1/data/save';
        }

        if (onboard.key === undefined) {
            throw 'key not set';
        }

        if (onboard.uid === undefined) {
            throw 'uid not set';
        }

        if (onboard.language_code === undefined) {
            throw 'language_code not set';
        }

        if (onboard.version === undefined) {
            onboard.log( 'Version is not set! Using Asterisk instead! (highest version available) ');
            onboard.version = '*';
        }

    };

    onboard.log = function(message) {
        if (onboard.debug && window.console && window.console.log ) {
            console.log( 'Onboard log: ' + message );
        }
    };

    /**
     * Initialize the Onboard Script;
     */
    onboard.init = function() {
        onboard.log( 'Initializing Onboard' );
        $.ajaxSetup({ cache: false });
        onboard.selfTest();
        reset();
        $( document ).ready(function() {
            $.when(loadData()).then(function(result) {
                _data.steps = result.steps;
                setup(_data.steps);
                alignStepElements(_data.steps);
                addHooks();
                run();
            });
        });
    };

    /**
     * Retrieve the json file with Onboard data.
     * @return {Object} The jQuery Deferred object.
     */
    function loadData() {
        var deferred = $.Deferred();
        $.ajax({
            type: 'GET',
            dataType: 'jsonp',
            url: onboard.data_url,
            jsonpCallback : 'd' + _number_of_data_requests,
            cache: false,
            data: {
                'access-token': onboard.key,
                version: onboard.version,
                url: window.location.href,
                uid: onboard.uid,
                lang: onboard.language_code,
            },
        }).done(function(result) {
            onboard.log( 'Retrieved data from: ' + onboard.data_url);
            _number_of_data_requests++;
            try {
                validateObject('result', result, [
                    'version',
                    'continue_on_completion',
                    'min_window_width',
                    'max_window_width',
                    'min_window_height',
                    'max_window_height',
                    'steps'
                ]);


                onboard.log('Data version ' +  result.version);

            } catch(e) {
                onboard.log('No step data');
                return;
            }

            _continue_on_completion = result.continue_on_completion;
            _min_height = result.min_window_height;
            _max_height = result.max_window_height;
            _min_width = result.min_window_width;
            _max_width = result.max_window_width;

            if (!result.steps.length) {
                return;
            }

            var step_objs = result.steps;

            $.each(step_objs, function (key, step_obj) {

                if (step_obj.sequence <= _data.lowest_sequence) { // Collect lowest sequence.
                    _data.lowest_sequence = step_obj.sequence;
                }

                if (step_obj.sequence >= _data.highest_sequence) { // Collect highest sequence.
                    _data.highest_sequence = step_obj.sequence;
                }

                validateObject('step', step_obj, [
                    'step_code',
                    'sequence',
                    'type',
                    'highlight',
                    'parts',
                    'event_listeners_show',
                    'event_listeners_hide',
                    'event_listeners_previous',
                    'event_listeners_next',
                    'event_listeners_finish',
                    'event_listeners_skip',
                    'event_triggers_show',
                    'event_triggers_hide',
                    'event_triggers_finish',
                    'event_triggers_skip',
                    'scroll_to',
                    'show'
                ]);

                $.each(step_obj.parts, function (key, step_part_obj) { //Check parts
                    validateObject('step part', step_part_obj, [
                        'selector',
                        'title',
                        'value',
                        'position',
                        'show_button_previous',
                        'show_button_next',
                        'show_button_skip',
                        'offset_x',
                        'offset_y',
                    ]);
                });
            });
            deferred.resolve(result);
        }).fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ', ' + error;
            onboard.log( 'Data Request Failed: ' + err );
        }).always(function () {
            onboard.log( 'Data Request end' );
        });

        return deferred;
    }

    /**
     * Check if a object has all the required properties.
     * @param {String} name The object name.
     * @param {Object} obj The object to check.
     * @param {Array} properties The properties that the obj needs to have.
     * @return {Boolean} The success.
     */
    function validateObject(name, obj, properties) {
        if (typeof obj !== 'object') {
            throw 'second param is not a object';
        }
        if (!$.isArray(properties)) {
            throw 'third param is not a array';
        }
        var errors = [];
        properties.forEach(function(val) {
            if (!obj.hasOwnProperty(val)) {
                errors.push('the property: ' + val + ' of ' + name + ' is missing')
            }
        });

        if (errors.length) {
            $.each( errors, function( key, error ) {
                onboard.log(error);
            });
            throw name + ' is not valid!';
        }

        return true;
    }

    /**
     * Setup the steps elements.
     * @param {Array} steps The steps to align to their selector.
     */
    function setup(steps) {
        steps.forEach(function(step_obj, index, step_array) {
            step_obj.parts.forEach(function(step_part_obj, index, step_array){
                // Create tooltip
                var $tooltip_element = onboard.createToolTip(step_obj.sequence, index, step_part_obj, step_obj.show);
                $('body').append($tooltip_element);
            });
            // Add control events
            addEventListenersForStep(step_obj);
        });

        //Add overlay
        var $overlay = $(document.createElement('div'));
        $overlay.attr('id', 'ob_overlay').hide();
        $('body').prepend($overlay);
    }

    /**
     * Align the elements
     * @param {Array} steps The steps to align to their selector.
     *
     * @return {boolean} The success
     */
    function alignStepElements(steps) {

        if (!checkValidWindowDimensions()) {
            $('.ob_step_part').hide();
            return false;
        }

        steps.forEach(function(step_obj, index, step_array) {
            var sequence = step_obj.sequence;
            step_obj.parts.forEach(function(step_part_obj, index, step_array){
                var $target_element = $(step_part_obj.selector);
                var $tooltip_element = getTooltip(sequence, index, step_part_obj);

                if (!$target_element.length) {
                    onboard.log(step_part_obj.selector + ' Not found!');
                    $tooltip_element.hide();
                    return false;
                }

                if ($target_element.length && $tooltip_element.length) {
                    onboard.setTooltipPosition($tooltip_element, $target_element, step_part_obj.position, step_part_obj.offset_x, step_part_obj.offset_y);
                }
            });
        });

        return true;
    }

    /**
     * Check the window for the required dimensions.
     *
     * @returns {boolean}
     */
    function checkValidWindowDimensions() {

        var window_width = window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;

        var window_height = window.innerHeight
            || document.documentElement.clientHeight
            || document.body.clientHeight;

        if (_min_height != null && _min_height > window_height) {
            onboard.log('Required min height not matched');
            return false;
        }

        if (_max_height != null && _max_height < window_height) {
            onboard.log('Required max height not matched');
            return false;
        }

        if (_min_width != null && _min_width > window_width) {
            onboard.log('Required min width not matched');
            return false;
        }

        if (_max_width != null && _max_width < window_width) {
            onboard.log('Required max width not matched');
            return false;
        }

        return true;
    }

    /**
     * Gets the tooltip element of a element.
     * @param {int} sequence The sequence of the step.
     * @param {int} index The index of the step part.
     * @param {Object} step_part_obj The step_part object.
     * @returns {*|JQueryElement}
     */
    function getTooltip(sequence, index, step_part_obj) {
        return $('#ob_' + sequence + '_' + index + '_' + hashCode(step_part_obj.selector));
    }

    /**
     * Bind function to events.
     */
    function addHooks() {
        $(window).resize(onboard.onResize);
    }

    /**
     * On resize.
     */
    onboard.onResize = function() {
        clearTimeout(_resize_timer);
        _resize_timer = setTimeout(function(){
            if (alignStepElements(_data.steps)) {
                onboard.showStep(_visible_step_sequence);
            }
        }, 750);
    };

    /**
     * Starts the tour.
     */
    function run() {
        onboard.switchStep(_data.lowest_sequence, _data.lowest_sequence);
    }

    /**
     * Switch visible step.
     *
     * @param {int} current_sequence The current.
     * @param {int} target_sequence  The sequence to show.
     *
     * @returns {Boolean} The success.
     */
    onboard.switchStep = function(current_sequence, target_sequence) {
        var current_step_obj = getStepObj(current_sequence);
        var target_step_obj = getStepObj(target_sequence);

        $('.ob_step_part:visible').each(function() {
            var sequence = $(this).data('sequence');
        }).hide(); // hide all steps and run its Hide triggers!.

        // Check if we should finish.
        if (target_sequence > _data.highest_sequence) {
            finishTour(current_step_obj.sequence);
            return true;
        } else {
            if (target_step_obj !== null) {
                saveProgress(target_step_obj.step_code, false, false);
                onboard.showStep(target_step_obj.sequence);
            }
        }
    }

    /**
     * End the tour.
     *
     * @param {int} current_sequence
     */
    function finishTour(current_sequence) {
        onboard.log( 'Ending tour' );
        var current_step_obj = getStepObj(current_sequence);
        removeHighLight();
        runTriggers(current_step_obj, 'event_triggers_finish');
        $.when(saveProgress(current_step_obj.step_code, true, false)).then(function() {
            if (_continue_on_completion) {
                onboard.init();
            }
        }); // Finish on current sequence.
    }

    /**
     * End the tour.
     *
     * @param {int} current_sequence
     */
    function skipTour(current_sequence) {
        onboard.log( 'Skipping tour' );
        var current_step_obj = getStepObj(current_sequence);
        removeHighLight();
        runTriggers(current_step_obj, 'event_triggers_skip');
        $.when(saveProgress(current_step_obj.step_code, false, true)).then(function() {
            reset();
        }); // Skip on current sequence.
    }

    /**
     * Save progress for step.
     *
     * @param {string}  step_code    The step to save.
     * @param {boolean} finish          Should finish chain.
     * @param {boolean} skip            Should skip chain.
     */
    function saveProgress(step_code, finish, skip) {
        _number_of_save_requests++;
        return $.ajax({
            type: 'GET',
            dataType: 'jsonp',
            jsonp: 'callback',
            jsonpCallback : 's' + _number_of_save_requests,
            url: onboard.save_url,
            data: {
                'access-token': onboard.key,
                version: onboard.version,
                step_code: step_code,
                uid: onboard.uid,
                finish: finish,
                skip: skip,
            }
        }).done(function(result) {
            if (result.success === true) {
                onboard.log( 'Save success #' + _number_of_save_requests);
            } else {
                onboard.log( 'Save failed #' + _number_of_save_requests);
            }
        });
    }

    /**
     * Hide/remove all highlight related elements/classes.
     */
    function removeHighLight() {
        $('#ob_overlay').hide();
        $('.ob_highlight').removeClass('ob_highlight');
    }

    /**
     * Shows the steps with sequence.
     * @param {int} sequence The sequence to show.
     * @returns {Boolean} The success.
     */
    onboard.showStep = function(sequence) {
        var step_obj = getStepObj(sequence);

        _visible_step_sequence = step_obj.sequence;

        if(!alignStepElements(_data.steps)) {
            return false;
        }
        if (step_obj.highlight) { // highlight logic
            step_obj.parts.forEach(function(step_part_obj) {
                var $element = $(step_part_obj.selector);
                if ($element.length) {
                    $element.addClass('ob_highlight');
                }
            });
            $('#ob_overlay').show();
        } else {
            removeHighLight();
        }

        var $step_part = $('.ob_step_part[data-sequence="' + sequence + '"]:not(.initial-hidden)');

        $step_part.show();
        // Scroll to?
        if (step_obj.scroll_to && step_obj.show) {
            scrollTo('#' + $step_part.attr('id'));
        }

        return true;
    };


    /**
     * Scroll to element with selector.
     *
     * @param string selector.
     */
    function scrollTo(selector) {
        var el = $( selector );
        var el_offset = el.offset().top;
        var el_height = el.height();
        var window_height = $(window).height();
        var offset;

        if (el_height < window_height) {
            offset = el_offset - ((window_height / 2) - (el_height / 2));
        }
        else {
            offset = el_offset;
        }
        var speed = 500;
        $('html, body').animate({scrollTop: offset}, speed, 'swing');
    }

    /**
     * Adds various listeners to a step element. Events like
     * clicking on next or previous are handled here.
     *
     * @param {Object} step_obj The step object
     */
    function addEventListenersForStep(step_obj) {

        var sequence = parseInt(step_obj.sequence);

        step_obj.parts.forEach(function(step_part_obj, index) {

            var $tooltip_element = getTooltip(sequence, index, step_part_obj);
            var tooltip_id = '#' + $tooltip_element.attr('id');

            if (step_part_obj.show_button_skip) { // Skip button
                $(tooltip_id + ' a.skip').on('click', {sequence: sequence}, function(event) {
                    skipTour(event.data.sequence);
                });
            }

            if (step_part_obj.show_button_previous) { // Should previous add listener to button?
                addStepFlowListener(
                    tooltip_id + ' a.previous', 'click',
                    sequence - 1,
                    sequence
                );
            }

            if (step_part_obj.show_button_next) { // Should add next listener to button?
                addStepFlowListener(
                    tooltip_id + ' a.next, ' + tooltip_id + ' a.finish',
                    'click',
                    sequence + 1,
                    sequence
                );
            }
        });

        step_obj.event_listeners_previous.forEach(function(event_listeners_previous) {
            validateObject('Event previous', event_listeners_previous, ['selector', 'event']);
            addStepFlowListener(
                event_listeners_previous.selector,
                event_listeners_previous.event,
                sequence - 1,
                sequence
            );
        });

        step_obj.event_listeners_next.forEach(function(event_listeners_next) {
            validateObject('Event next', event_listeners_next, ['selector', 'event']);
            addStepFlowListener(
                event_listeners_next.selector,
                event_listeners_next.event,
                sequence + 1,
                sequence
            );
        });

        step_obj.event_listeners_show.forEach(function(event_listeners_show) {
            validateObject('Event show', event_listeners_show, ['selector', 'event']);
            addStepVisibilityListener(
                event_listeners_show.selector,
                event_listeners_show.event,
                sequence,
                true
            );
        });

        step_obj.event_listeners_hide.forEach(function(event_listeners_hide) {
            validateObject('Event hide', event_listeners_hide, ['selector', 'event']);
            addStepVisibilityListener(
                event_listeners_hide.selector,
                event_listeners_hide.event,
                sequence,
                false
            );
        });

        // Listen to Finish event.
        step_obj.event_listeners_finish.forEach(function(event_listeners_finish) {
            validateObject('Event finish', event_listeners_finish, ['selector', 'event']);
            addChainEndListener(
                event_listeners_finish.selector,
                event_listeners_finish.event,
                sequence,
                true,
                false
            );
        });

        // Listen to Skip event.
        step_obj.event_listeners_skip.forEach(function(event_listeners_skip) {
            validateObject('Event skip', event_listeners_skip, ['selector', 'event']);
            addChainEndListener(
                event_listeners_skip.selector,
                event_listeners_skip.event,
                sequence,
                false,
                true
            );
        });
    }

    /**
     * Create event for a next/previous event.
     *
     * @param {string} selector         On which element the trigger should listen.
     * @param {string} event_type       The event type: click|mouseover|etc.
     * @param {int} target_sequence     The sequence to show. 0 is show none.
     * @param {int} current_sequence    The current shown step sequence that owns this listener.
     */
    function addStepFlowListener(selector, event_type, target_sequence, current_sequence) {
        var event = function(event) {

            var current_sequence = event.data.current_sequence;
            var target_sequence = event.data.target_sequence;

            var selector = event.data.selector;
            var event_type = event.data.event_type;

            if (current_sequence != _visible_step_sequence) {
                onboard.log('1. An step-flow listener of step(' + current_sequence + ') was triggered : "' + event_type + '" on element: ' + selector);
                onboard.log('2. But the sequence is a mismatch with the currently visible step sequence(' + _visible_step_sequence + ')');
                return;
            } else {
                onboard.log('An step-flow listener of step(' + current_sequence + ') was triggered : "' + event_type + '" on element: ' + selector);
            }

            var step_obj = getStepObj(current_sequence);

            onboard.switchStep(current_sequence, target_sequence);

            if (target_sequence > current_sequence) {
                runTriggers(step_obj, 'event_triggers_next');
            }

            if (target_sequence < current_sequence && target_sequence > 0) {
                runTriggers(step_obj, 'event_triggers_previous');
            }

        };
        $(selector).on(event_type, {
            selector: selector,
            event_type: event_type,
            target_sequence: target_sequence,
            current_sequence: current_sequence
        }, event);
    }

    /**
     * Create event for a show/hide event.
     *
     * @param {string} selector         On which element the trigger should listen.
     * @param {string} event_type       The event type: click|mouseover|etc.
     * @param {int} target_sequence     The sequence to show. 0 is show none.
     * @param {int} show                Should show.
     */
    function addStepVisibilityListener(selector, event_type, target_sequence, show) {
        var event = function(event) {

            var target_sequence = event.data.target_sequence;

            var selector = event.data.selector;
            var event_type = event.data.event_type;

            if (target_sequence != _visible_step_sequence) {
                onboard.log('1. An step-Visibility listener for step(' + target_sequence + ') was triggered : "' + event_type + '" on element: ' + selector);
                onboard.log('2. But the sequence is a mismatch with the currently visible step sequence(' + _visible_step_sequence + ')');
                return;
            } else {
                onboard.log('An step-Visibility listener for step(' + target_sequence + ') was triggered : "' + event_type + '" on element: ' + selector);
            }

            var step_obj = getStepObj(target_sequence);

            if (show) {
                runTriggers(step_obj, 'event_triggers_show');
                var $step_part = $('.ob_step_part[data-sequence="' + target_sequence + '"].initial-hidden');
                $step_part.removeClass('initial-hidden');
                onboard.switchStep(target_sequence, target_sequence);
            } else {
                runTriggers(step_obj, 'event_triggers_hide');
                onboard.switchStep(target_sequence, 0);
            }

        };
        $(document).on(event_type, selector, {
            selector: selector,
            event_type: event_type,
            target_sequence: target_sequence,
            show:show
        }, event);
    }

    /**
     * End current chain.
     *
     * @param {string}  selector            On which element the trigger should listen.
     * @param {string}  event_type          The event type: click|mouseover|etc.
     * @param {int}     current_sequence    The current shown step sequence that owns this listener.
     * @param {boolean} is_finish           Is skip event.
     * @param {boolean} is_skip             Is finish event.
     */
    function addChainEndListener(selector, event_type, current_sequence, is_finish, is_skip) {
        var event = function(event) {
            var current_sequence = event.data.current_sequence;

            var selector = event.data.selector;
            var event_type = event.data.event_type;

            if (current_sequence != _visible_step_sequence) {
                onboard.log('1. An Chain-End listener of step(' + current_sequence + ') was triggered : "' + event_type + '" on element: ' + selector);
                onboard.log('2. But the sequence is a mismatch with the currently visible step sequence(' + _visible_step_sequence + ')');
                return;
            } else {
                onboard.log('An Chain-End listener of step(' + current_sequence + ') was triggered : "' + event_type + '" on element: ' + selector);
            }

            if (is_finish) {
                finishTour(current_sequence);
            } else {
                if (is_skip) {
                    skipTour(current_sequence);
                }
            }
        };
        $(selector).on(event_type, {
            selector: selector,
            event_type: event_type,
            current_sequence: current_sequence,
            is_finish: is_finish,
            is_skip: is_skip
        }, event);
    }

    /**
     * Run all trigger for a step.
     *
     * Collection names: triggers_show, triggers_hide, triggers_previous, triggers_next
     *
     * @param {object} step_obj The step object.
     * @param {string} trigger_collection_name The step object.
     */
    function runTriggers(step_obj, trigger_collection_name) {
        if (step_obj === null) {
            return;
        }

        step_obj[trigger_collection_name].forEach(function(event_trigger_show) {
            var $element = $(event_trigger_show.selector);
            if (!$element.length) {
                return;
            }
            validateObject('Event previous', event_trigger_show, ['selector', 'event']);
            $element.trigger(event_trigger_show.event);
        });
    }

    /**
     * Get step.
     *
     * @param {int} sequence The sequence to show.
     * @returns {Object|null} The step object.
     */
    function getStepObj(sequence) {
        var result = $.grep(_data.steps, function(e){ return e.sequence == sequence; });
        if (result.length === 0) {
            return null;
        } else {
            return result[0];
        }
    }

    /**
     * Generate a hashcode for a string.
     *
     * @param {string} string The string to be hashed.
     * @returns {Number} The hash.
     */
    function hashCode(string) {
        var hash = 0;
        if (string.length === 0) return hash;
        for (i = 0; i < string.length; i++) {
            var char = string.charCodeAt(i);
            hash = ((hash<<5)-hash)+char;
            hash = hash & hash; // Convert to 32bit integer
        }
        return hash;
    }

    /**
     * @param {int} sequence            The step sequence.
     * @param {int} index               The step part index (The index of the step-part within a step.).
     * @param {Element} step_part_obj   The step to create.
     * @param {boolean} show            Should show.
     *
     * @returns {Element} The tooltip element.
     */
    onboard.createToolTip = function(sequence, index, step_part_obj, show) {
        var tooltip_id = 'ob_' + sequence + '_' + index + '_' + hashCode(step_part_obj.selector);
        var $tooltip = $(tooltip_id);

        if (!$tooltip.length) { // Create element
            $tooltip = $(document.createElement('div'));
            $tooltip.attr('id', tooltip_id)
                .attr('data-sequence', sequence)
                .addClass('ob_step_part')
                .addClass('ob_pos_' + step_part_obj.position);

            if (!show) {
                $tooltip.addClass('initial-hidden');
            }

            var header_title = step_part_obj.title;
            var header = $('<div class="ob_header"></div>');
            header.append('<h3>' + header_title + '</h3>');
            header.append('<span>' + sequence + '/' + _data.highest_sequence + '</span>');
            $tooltip.append(header);

            var content_value = step_part_obj.value.replace(/(?:\r\n|\r|\n)/g, '<br />'); // Newlines
            var $content = $('<div>')
                .addClass('ob_step_part_content')
                .html('<p>' + content_value + '</p>');

            $tooltip.append($content)

            if (sequence === _data.lowest_sequence) {
                $tooltip.addClass('first');
            }

            if (sequence === _data.highest_sequence) {
                $tooltip.addClass('last');
            }

            var buttons = $('<div class="ob_buttons"></div>');
            if (step_part_obj.show_button_skip) {
                buttons.append('<a href="#" class="skip">Skip this</a>');
            }
            if (step_part_obj.show_button_previous) {
                buttons.append('<a href="#" class="previous">Prev</a>');
            }
            if (step_part_obj.show_button_next) {
                if (sequence === _data.highest_sequence) {
                    buttons.append('<a href="#" class="finish">Done</a>');
                } else {
                    buttons.append('<a href="#" class="next">Next</a>');
                }
            }

            $tooltip.append(buttons).hide();
        }
        return $tooltip;
    };

    /**
     * @param {Element} $tooltip
     * @param {Element} $element            The related element to the tooltip.
     * @param {String}  tooltip_position    The position: top, left, down, left.
     * @param {integer} offset_x            The x offset.
     * @param {integer} offset_y            The y offset.
     */
    onboard.setTooltipPosition = function($tooltip, $element, tooltip_position, offset_x, offset_y) {
        var element_offset = $element.offset();
        var element_width = $element.outerWidth();
        var element_height = $element.outerHeight();
        var element_center_x = element_offset.left + element_width / 2;
        var element_center_y = element_offset.top + element_height / 2;

        var tooltip_width = $tooltip.outerWidth();
        var tooltip_height = $tooltip.outerHeight();

        var tooltip_top = element_center_y - (tooltip_height / 2);
        var tooltip_left = element_center_x -(tooltip_width / 2);

        var distance_x = ((element_width / 2) + (tooltip_width / 2));
        var distance_y = ((element_height / 2) + (tooltip_height / 2));

        //top
        switch (tooltip_position) {
            case 'top':
                tooltip_top -= distance_y;
                break;
            case 'right':
                tooltip_left += distance_x;
                break;
            case 'bottom':
                tooltip_top += distance_y;
                break;
            case 'left':
                tooltip_left -= distance_x;
                break;
            case 'top-left':
                tooltip_top -= distance_y;
                tooltip_left -= distance_x;
                break;
            case 'top-right':
                tooltip_top -= distance_y;
                tooltip_left += distance_x;
                break;
            case 'bottom-left':
                tooltip_top += distance_y;
                tooltip_left -= distance_x;
                break;
            case 'bottom-right':
                tooltip_top += distance_y;
                tooltip_left += distance_x;
                break;
            case 'middle':
                break;
            default:
                tooltip_top -= distance_y; // top.
                break;
        }

        $tooltip.css({top: (tooltip_top + offset_y), left: (tooltip_left + offset_x)});
    };

    onboard.init();

}( window.onboard = window.onboard || {}, jQuery ));

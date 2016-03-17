(function( editor, $, undefined ) {

    //////////////////////////////////////////
    // Delete click Event Handler           //
    //////////////////////////////////////////
    $('#base-editor, #_editor_modal').on('click', 'a.delete-x', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        if (!confirm("Are you sure you want to delete this?")) {
            return false;
        }

        var url = $(this).attr('href');
        $.ajax({
            type: 'GET',
            url: url,
            context: $(this),
        }).done(function (data) {
            if (data.status === 'success') {
                $(this).closest('.editor').remove();
            } else {
                if (data.message.length) {
                    alert(data.message);
                }
            }
        });
        return false;
    });

    //////////////////////////////////////////
    // Edit / Create click Event Handler   //
    //////////////////////////////////////////
    $('#base-editor, #_editor_modal').on('click', 'a.edit-x, a.create-x', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        var url = $(this).attr('href');
        $.ajax({
            type: 'GET',
            url: url,
        }).done(function (data) {
            editor.setModalContent(data);
        });
        return false;
    });

    //////////////////////////////////////////
    // Modal submit Event Handler           //
    //////////////////////////////////////////
    $('#_editor_modal, #_editor_modal').on('submit', 'form', function (event) {
        event.preventDefault(); //STOP default action
        event.stopImmediatePropagation();
        var $form = $(this);
        var form_data = $form.serialize();
        $( "#_editor_modal :input" ).prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: $form.attr('action'),
            data: form_data,
            success: function(response) {
                if (response.status === 'success') {
                    editor.replaceEditor(response.html);
                    $('#_editor_modal').remodal().close();
                } else if(editor.isHTML(response)){
                    editor.setModalContent(response);
                }
            },
            failure: function() {
                $( "#_editor_modal :input" ).prop('disabled', true);
            }
        });
        return false;
    });

    /////////////////////////////////////////////
    // Step part language change event handler //
    /////////////////////////////////////////////
    $('#_editor_modal, #_editor_modal').on('change', 'form.existing-record select#steppartlanguage-application_language_id', function (event) {
        event.preventDefault(); //STOP default action
        event.stopImmediatePropagation();

        var step_part_id = $('#steppart-id').val();
        var language_id = $(this).val();

        $( "#_editor_modal :input" ).prop('disabled', true);

        $.getJSON('/builder/ajax-step-part/get-translation', {
            id: step_part_id,
            language_id: language_id,
        }).done(function(response) {
            if (response.status === 'success') { // Set data
                $('#_editor_modal #steppartlanguage-application_language_id').val(response.language_id);
                $('#_editor_modal #steppartlanguage-title').val(response.title);
                $('#_editor_modal #steppartlanguage-value').val(response.value);
            }
        }).always(function() {
            $('#_editor_modal :input').prop('disabled', false);
        });
    });

    //////////////////////////////////////////
    // Submit form with <a> Event Handler   //
    //////////////////////////////////////////
    $('#base-editor, #_editor_modal').on('click', '.submit-x', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        $(this).closest('form').submit();
    });

    /**
     * Check if a string is html.
     *
     * @param {string} str The string to check.
     * @returns {boolean} The success of the check.
     */
    editor.isHTML = function(str) {
        return !!$(str)[0];
    };

    /**
     * Check if a string is html.
     *
     * @param {object} $element The The new element to add.
     *
     * @returns {boolean} The success of the check.
     */
    editor.replaceEditor = function($element) {
        var $new_html = $($element);
        var $old_html = $('#' + $new_html.attr('id')); // Get first id and replace the old element with the same id.
        $old_html.replaceWith($new_html);

        $new_html.trigger('editor_loaded');
        $new_html.find('.editor .collection').trigger('collection_loaded');
        $new_html.addClass('saved');
    };

    /**
     * Set the HTML of the editor modal.
     *
     * Create if not exists.
     *
     * @param {string} content The content to put in the modal.
     */
    editor.setModalContent = function(content) {
        var $modal = $('#_editor_modal');
        var remodal_inst = $modal.remodal();
        $modal.html(content);
        if (remodal_inst.getState() === 'closed' || remodal_inst.getState() === 'closing') {
            remodal_inst.open();
        }
    };

}( window.editor = window.editor || {}, jQuery ));

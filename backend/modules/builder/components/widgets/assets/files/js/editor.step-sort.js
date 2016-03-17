(function( editor, $, undefined ) {

    ///////////////////////////////////////////////////////////
    // Set initial Sortable on step-collection               //
    ///////////////////////////////////////////////////////////
    $('#base-editor .step-collection').each(function() {
        _setSortableCollection($(this));
    });

    ///////////////////////////////////////////////////////////
    // On collection_loaded event (trigger by editor.js)     //
    ///////////////////////////////////////////////////////////
    $('#base-editor').on('editor_loaded', '.chain-editor', function() {
        var $collection = $(this).find('.step-collection');
        _setSortableCollection($collection);
    });

    /**
     * make a element sortable on its children.
     *
     * @param {object} $element The element to make sortable.
     */
    function _setSortableCollection($element) {
        $element.sortable({
            //axis: 'x',
            delay: 120,
            change: function( event, ui ) {}
        });
    }

    //////////////////////////////////////////
    // Save Step sequence                   //
    //////////////////////////////////////////
    $("#base-editor").on('click', '.controls .save-sequence-x', function (event) {
        event.preventDefault(); //STOP default action
        event.stopImmediatePropagation();

        var $chain_editor = $(this).closest('.chain-editor');

        var chain_key = $chain_editor.data('key');
        var step_keys = [];

        $chain_editor.find('.step-editor').each(function() {
            step_keys.push($(this).data('key'));
        });

        $.get('/builder/ajax-chain/save-sequence', {
            id: chain_key,
            step_sequence: step_keys.join()
        }).done(function(response) {
            if (response.status === 'success') {
                editor.replaceEditor(response.html);
            }
        });

        return false;
    });

}( window.editor = window.editor || {}, jQuery ));
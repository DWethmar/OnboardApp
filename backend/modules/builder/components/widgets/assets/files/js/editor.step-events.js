(function( editor, $, undefined ) {

    //////////////////////////////////////////
    // Save Step sequence                   //
    //////////////////////////////////////////
    $("#base-editor").on('click', '.controls .edit-step-events', function (event) {
        event.preventDefault(); //STOP default action
        event.stopImmediatePropagation();

        var $step_editor = $(this).closest('.step-editor');
        var step_key = $step_editor.data('key');

        $.get('/builder/ajax-step-event/update', {
            id: step_key,
        }).done(function(response) {
            editor.setModalContent(response);
        });
        return false;
    });

}( window.editor = window.editor || {}, jQuery ));
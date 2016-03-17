(function( editor, $, undefined ) {

    ///////////////////////////////////////////////////////////
    // Show x                                                //
    ///////////////////////////////////////////////////////////
    $('#base-editor').on('click', 'a.toggle-x', (function(e) {
        e.preventDefault();
        $(this).closest('.chain-editor').find('.step-collection').toggle();
    }));

}( window.editor = window.editor || {}, jQuery ));
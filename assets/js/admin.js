jQuery(window).load(function () {
    jQuery('textarea').each(function () {
        var textID = jQuery(this).attr('id');
        if (textID.length) {
           // wp.editor.initialize(textID);
        }
    });
});
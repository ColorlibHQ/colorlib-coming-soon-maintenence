jQuery(document).ready(function () {
    jQuery('textarea').each(function () {
        wp.editor.initialize(jQuery(this));
    });
});
jQuery(window).load(function () {
    jQuery('#sub-accordion-section-colorlib_coming_soon_section_page_settings textarea').each(function () {
        var textareaId = jQuery(this).attr('id');
        var textareaEditor = jQuery(this);
        wp.editor.initialize(textareaId, {
            tinymce: {
                wpautop: true,
                browser_spellcheck: true,
                mediaButtons: false,
                wp_autoresize_on: true,
                toolbar1: 'bold,italic,link,strikethrough',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                        jQuery(textareaEditor).trigger('change');
                    });
                }
            },
            quicktags: true
        });
    });
    wp.codeEditor.initialize('_customize-input-colorlib_coming_soon_page_custom_css');
});




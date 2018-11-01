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
});

wp.customize.bind( 'preview-ready', function() {

    wp.customize.preview.bind( 'login-designer-open-designer', function( data ) {
        // When the section is expanded, open the login designer page specified via localization.
        if ( true === data.expanded ) {
            wp.customize.preview.send( 'url', login_designer_script.login_designer_page );
        }
    });

    wp.customize.preview.bind( 'login-designer-back-to-home', function( data ) {
        // Go back to home, if the section is closed.
        wp.customize.preview.send( 'url', data.home_url );
    });
});
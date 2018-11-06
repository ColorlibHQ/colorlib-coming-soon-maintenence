jQuery(window).load(function () {
    jQuery('textarea.js-ccsm-editor').each(function () {
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

    wp.customize.panel('colorlib_coming_soon_general_panel', function (section) {
        section.expanded.bind(function (isExpanding) {
            var loginURL = CCSurls.siteurl + '?colorlib-coming-soon-customization=true';

            // Value of isExpanding will = true if you're entering the section, false if you're leaving it.
            if (isExpanding) {
                wp.customize.previewer.previewUrl.set(loginURL);
            } else {
                wp.customize.previewer.previewUrl.set(CCSurls.siteurl);
            }
        });
    });
});




(function ($) {

    //Page heading preview
    wp.customize('ccsm_settings[colorlib_coming_soon_page_heading]', function (text) {
        text.bind(function (textValue) {
            jQuery('#colorlib_coming_soon_page_heading').html(str.replace('@<(script|style)[^>]*?>.*?</\\1>@si', textValue ) );
        });
    });

    //Page content preview
    wp.customize('ccsm_settings[colorlib_coming_soon_page_content]', function (text) {
        text.bind(function (textValue) {
            jQuery('#colorlib_coming_soon_page_content').html(str.replace('@<(script|style)[^>]*?>.*?</\\1>@si', textValue ) );
        });
    });

    //Page footer preview
    wp.customize('ccsm_settings[colorlib_coming_soon_page_footer]', function (text) {
        text.bind(function (textValue) {
            jQuery('#colorlib_coming_soon_page_footer').html(str.replace('@<(script|style)[^>]*?>.*?</\\1>@si', textValue ) );
        });
    });

    //social links preview
    jQuery('#sub-accordion-section-colorlib_coming_soon_section_social_settings').find('input').each(function () {
        var controllerID = jQuery(this).attr('data-customize-setting-link');
        wp.customize(controllerID, function (text) {
            text.bind(function (textValue) {
                jQuery('#' + controllerID).html(textValue);
            });
        });
    });


})(jQuery);


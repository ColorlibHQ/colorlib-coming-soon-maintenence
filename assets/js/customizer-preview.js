(function ($) {
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


jQuery(function () {
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
            var loginURL = CCSMurls.siteurl + '?colorlib-coming-soon-customization=true';

            // Value of isExpanding will = true if you're entering the section, false if you're leaving it.
            if (isExpanding) {
                wp.customize.previewer.previewUrl.set(loginURL);
            } else {
                wp.customize.previewer.previewUrl.set(CCSMurls.siteurl);
            }
        });
    });
});

( function( $, api ) {

    api.sectionConstructor['ccsm-templates-section'] = api.OuterSection.extend( {

        // No events for this type of section.
        attachEvents: function () {
            var section = this;

            section.container.find( 'button.change-theme' ).on( 'click', function( event ) {

                if ( ! section.expanded() ) {
                    section.expand();
                }else{
                    section.collapse();
                }
                
            });

            // Expand/Collapse accordion sections on click.
            section.container.find( '.customize-section-back' ).on( 'click keydown', function( event ) {
                if ( api.utils.isKeydownButNotEnterEvent( event ) ) {
                    return;
                }
                event.preventDefault(); // Keep this AFTER the key filter above

                if ( section.expanded() ) {
                    section.collapse();
                } else {
                    section.expand();
                }
            });

        },

        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        },

        changeLabel: function( template ){
            var section = this,
                activeTemplateContiner = section.headContainer.find( '.ccsm-active_template' ),
                templateName;

            templateName = template.replace( '_', ' ' );
            activeTemplateContiner.text( templateName );
        }
        
    } );

    api.controlConstructor['ccsm-templates'] = api.Control.extend({
        ready: function() {
            var control = this;

            this.container.on( 'change', 'input:radio', function() {
                var template = $( this ).val();
                control.setting( template );
            });
        }
    });

    api.bind( 'ready', function() {

        api( 'ccsm_settings[colorlib_coming_soon_template_selection]', function( value ) {
            value.bind( function( to ) {

                // Change template label
                var section = api.control( 'ccsm_settings[colorlib_coming_soon_template_selection]' ).section();
                api.section( section ).changeLabel( to );

            });
        });

    });

} )( jQuery, wp.customize );

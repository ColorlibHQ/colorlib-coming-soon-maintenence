/*
 * Live preview bindings for the Coming Soon customizer.
 *
 * The previous version built the selector '#' + 'ccsm_settings[<key>]', which
 * jQuery parses as #ccsm_settings plus an attribute filter, so it matched
 * nothing and the whole feature was a silent no-op. The rich-text settings
 * were registered with postMessage transport but had no handler at all, so
 * their preview never updated either.
 */
(function ($) {
	'use strict';

	/** 'ccsm_settings[colorlib_coming_soon_social_facebook]' -> the bare key. */
	function settingKey(id) {
		var match = /\[([^\]]+)\]/.exec(id);
		return match ? match[1] : id;
	}

	function bind(key, callback) {
		wp.customize('ccsm_settings[' + key + ']', function (setting) {
			setting.bind(callback);
		});
	}

	/* Rich-text fields: rendered server-side with wp_kses_post(). */
	['colorlib_coming_soon_page_heading',
	 'colorlib_coming_soon_page_content',
	 'colorlib_coming_soon_page_footer'].forEach(function (key) {
		bind(key, function (value) {
			$('#' + key).html(value);
		});
	});

	/* Social links: the value is a URL, so update href rather than text. */
	['colorlib_coming_soon_social_facebook',
	 'colorlib_coming_soon_social_twitter',
	 'colorlib_coming_soon_social_youtube',
	 'colorlib_coming_soon_social_pinterest',
	 'colorlib_coming_soon_social_instagram'].forEach(function (key) {
		bind(key, function (value) {
			$('#' + key).attr('href', value);
		});
	});

	bind('colorlib_coming_soon_social_email', function (value) {
		$('#colorlib_coming_soon_social_email').attr('href', 'mailto:' + value);
	});

	/*
	 * Colors. The rules they override are printed inline with !important, so
	 * write into a stylesheet appended last and use !important too.
	 */
	function liveStyle() {
		var el = document.getElementById('ccsm-live-colors');
		if (!el) {
			el = document.createElement('style');
			el.id = 'ccsm-live-colors';
			document.head.appendChild(el);
		}
		return el;
	}

	var colors = { text: '', background: '' };

	function isHex(value) {
		return /^#([0-9a-f]{3}|[0-9a-f]{6})$/i.test(String(value).trim());
	}

	function renderColors() {
		var css = '';
		if (isHex(colors.text)) {
			css += 'h1,h2,h3,h4,p,span,li,a:not(.sign-up){color:' + colors.text + ' !important;}';
		}
		if (isHex(colors.background)) {
			css += 'body{background-color:' + colors.background + ' !important;}';
		}
		liveStyle().textContent = css;
	}

	bind('colorlib_coming_soon_text_color', function (value) {
		colors.text = value;
		renderColors();
	});

	bind('colorlib_coming_soon_background_color', function (value) {
		colors.background = value;
		renderColors();
	});

	/* Logo: swap the src in place instead of reloading the whole preview. */
	bind('colorlib_coming_soon_plugin_logo', function (value) {
		$('.wrappic1 img, .logo-link img').attr('src', value);
	});

	/* Background image. */
	bind('colorlib_coming_soon_background_image', function (value) {
		$('.simpleslide100-item, .bg-img1').css('background-image', 'url("' + value + '")');
	});

	// settingKey stays available for future bindings that read the raw id.
	window.ccsmSettingKey = settingKey;
})(jQuery);

=== Coming Soon & Maintenance Mode by Colorlib ===
Contributors: silkalns
Tags: coming soon, maintenance mode, under construction, countdown timer, landing page
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Create a coming soon page or maintenance mode screen with 15 responsive templates, countdown timer, MailChimp subscribe form, and social media links.

== Description ==

**Coming Soon & Maintenance Mode by Colorlib** is a free WordPress plugin that lets you display a professional coming soon page, under construction page, or maintenance mode screen to your visitors while you work on your site behind the scenes. Set it up in minutes directly from the WordPress Live Customizer — no coding required.

Choose from **15 fully responsive coming soon templates**, each pre-designed with modern layouts and fully customizable through the Customizer. Add your own logo, background image, heading text, countdown timer, and social media links. Collect email subscribers with the built-in MailChimp integration so you can build your audience before launch day.

Logged-in users can browse and edit the site normally while non-logged-in visitors see only the coming soon or maintenance page. The plugin also blocks the WordPress REST API for visitors to prevent content exposure while your site is under construction.

= Why Choose This Coming Soon Plugin? =

- **100% free** — no premium version, no ads, no feature restrictions
- **15 responsive templates** — professionally designed coming soon, maintenance mode, and under construction page layouts
- **Live Customizer** — customize everything in real time without touching code
- **Countdown timer** — display a launch countdown with configurable date and 12/24-hour format
- **MailChimp subscribe form** — collect emails and grow your list while in maintenance mode
- **Social media integration** — add links to Facebook, Twitter, Instagram, YouTube, Pinterest, and email
- **Custom logo and background** — upload your brand logo and a custom background image
- **Google Analytics 4** — track visitors to your coming soon page with GA4
- **Custom CSS** — add your own styles for advanced customization
- **REST API protection** — blocks public API access while the site is under construction
- **Developer friendly** — use the `ccsm_skip_redirect` and `ccsm_force_redirect` filters to control redirect behavior
- **Works with all WordPress themes** — self-contained templates run independently of your active theme
- **GDPR compliant** — collect visitor information while respecting privacy regulations

= How It Works =

1. Install and activate the plugin
2. Go to Appearance > Customize > Colorlib Coming Soon Settings
3. Pick a template and customize the content, colors, images, and countdown timer
4. Enable coming soon mode — visitors see your launch page, you keep working

= Links =

- <a href="https://colorlib.com/wp/forums/">Documentation and Support</a>
- <a href="https://github.com/ColorlibHQ/colorlib-coming-soon-maintenence">GitHub Repository</a>

This plugin is developed and maintained by <a href="https://colorlib.com/">Colorlib</a>. If you enjoy using it, please leave a review — it helps other WordPress users discover the plugin.

== Installation ==

= From the WordPress Plugin Directory =

1. Go to Plugins > Add New in your WordPress dashboard
2. Search for "Coming Soon Colorlib"
3. Click "Install Now" and then "Activate"

= Manual Upload =

1. Download the plugin ZIP file
2. Go to Plugins > Add New > Upload Plugin
3. Upload the ZIP file and click "Install Now"
4. Activate the plugin

= After Activation =

1. Navigate to Appearance > Customize > Colorlib Coming Soon Settings
2. Select a coming soon template from the Templates section
3. Customize the heading, logo, background image, countdown timer, and social links
4. Toggle "Activate Coming Soon" to enable the coming soon page for visitors
5. To connect MailChimp, go to the Subscribe Form tab and paste your MailChimp signup form action URL (found in your MailChimp account under Audience > Signup Forms > Embedded Forms)


== Frequently Asked Questions ==

= How do I enable or disable the coming soon page? =

Go to Appearance > Customize > Colorlib Coming Soon Settings > General and toggle the "Activate Coming Soon" option. You can also deactivate the plugin entirely under Plugins to disable the coming soon page.

= Who can see the coming soon page? =

Only visitors who are not logged in to WordPress will see the coming soon page. Logged-in administrators and editors can browse the site normally while working on it. The login page at wp-login.php is always accessible.

= How do I change the coming soon page template? =

Navigate to Appearance > Customize > Colorlib Coming Soon Settings > Templates. You will see a visual preview of all 15 available templates. Click on the one you want to use and the preview will update immediately.

= How do I set up the countdown timer? =

Go to Appearance > Customize > Colorlib Coming Soon Settings > General and enable "Activate Timer Countdown." Then set your launch date and time using the date picker. The timer supports both 12-hour and 24-hour formats. Note that templates 12 and 14 do not display a countdown timer.

= How do I connect MailChimp for email subscriptions? =

Go to Appearance > Customize > Colorlib Coming Soon Settings > Subscribe Form and paste your MailChimp signup form action URL. You can find this URL in your MailChimp account under Lists > Signup Forms > Embedded Forms. Copy the URL from the form's action attribute.

= Can I add social media links? =

Yes. Go to Appearance > Customize > Colorlib Coming Soon Settings > Social Links and enter your profile URLs for Facebook, Twitter, YouTube, Pinterest, Instagram, or an email address. Social links are supported on most templates (all except templates 2, 5, and 8).

= Can I customize the logo and background image? =

Yes. Under Appearance > Customize > Colorlib Coming Soon Settings > General you can upload a custom logo image (recommended size: 80x80px) and a background image. Most templates support both options, though a few templates use fixed layouts without background images.

= Can I add custom CSS to the coming soon page? =

Yes. Go to Appearance > Customize > Colorlib Coming Soon Settings > Custom CSS. This provides a code editor where you can add CSS that applies only to the coming soon page without affecting the rest of your site.

= How do I add Google Analytics tracking? =

Go to Appearance > Customize > Colorlib Coming Soon Settings > General and enter your Google Analytics 4 measurement ID (e.g., G-XXXXXXXXXX) in the tracking code field.

= Does the plugin work with caching plugins? =

Most caching plugins will not interfere because the coming soon page is served via a template redirect before caching occurs. If you experience issues, exclude the front page from your caching plugin or clear the cache after enabling or disabling coming soon mode.

= Can I allow specific pages to bypass the coming soon page? =

Yes. Developers can use the `ccsm_skip_redirect` filter to allow specific pages or URLs to bypass the coming soon redirect. For example, you might want to keep a privacy policy page accessible.

= Does the plugin block the REST API while in maintenance mode? =

Yes. When coming soon mode is active, the plugin blocks REST API requests for non-logged-in users to prevent content exposure through endpoints like /wp-json/wp/v2/posts.

= Is the plugin compatible with my theme? =

Yes. The coming soon page uses its own self-contained templates with their own styles and scripts, so it works independently of your active WordPress theme.

= What is the difference between coming soon mode and maintenance mode? =

Both modes display a full-screen page to visitors and block access to the rest of your site. A coming soon page is typically used before a new website launches to build anticipation and collect emails. A maintenance mode page is used when an existing site is temporarily offline for updates. This plugin handles both scenarios with the same set of templates.

= Can I use a countdown timer on the coming soon page? =

Yes. The countdown timer can be enabled under Appearance > Customize > Colorlib Coming Soon Settings > General. Set your launch date and time and the countdown will display days, hours, minutes, and seconds until your site goes live. Most templates support the countdown timer.

= Is the plugin free to use? =

Yes. Coming Soon & Maintenance Mode by Colorlib is completely free with no premium version, no ads, and no feature limitations. All 15 templates, the MailChimp integration, countdown timer, social media links, custom CSS, and Google Analytics tracking are included at no cost.

= Does the coming soon page work on mobile devices? =

Yes. All 15 coming soon page templates are fully responsive and work on desktops, tablets, and mobile phones. The layouts adapt automatically to different screen sizes.

== Screenshots ==

1. Template 1 — Split layout with subscribe form, countdown timer, and social media icons
2. Template 2 — Full-screen background with centered countdown timer and email subscribe form
3. Template 3 — Minimal card layout with flip-style countdown timer and subscribe form
4. Template 4 — Bold gradient background with countdown timer and call-to-action button
5. Template 5 — Vibrant gradient with top countdown timer and inline subscribe form
6. Template 6 — Full-screen background with flip clock countdown, newsletter form, and social icons
7. Template 7 — Purple overlay with subscribe form, countdown timer, and social media links
8. Template 8 — Dark purple background with centered countdown timer and email notification form
9. Template 9 — Fullscreen ocean background with large countdown timer and sign-up button
10. Template 10 — Dark elegant layout with side countdown timer, subscribe form, and social icons
11. Template 11 — Dramatic full-screen background with elegant countdown timer and sign-up button
12. Template 12 — Clean split layout with subscribe form and social media icons
13. Template 13 — Full-screen nature background with header countdown timer and sign-up button
14. Template 14 — Split layout with mountain background, subscribe form, and social links
15. Template 15 — City skyline with purple overlay, flip clock countdown, and social icons

== Changelog ==

= 1.2.0 - 06.02.2026 =
Updated: Minimum PHP version raised to 7.4 (compatible up to PHP 8.5)
Updated: Minimum WordPress version raised to 6.0
Fixed: PHP 8.x strict type comparison warnings throughout
Fixed: Uninitialized variables causing PHP warnings
Fixed: Missing capability checks on AJAX handlers
Fixed: Input sanitization on superglobal access
Fixed: wp_enqueue_scripts() misuse (was using hook name as function)
Fixed: Trailing spaces in default settings array keys
Fixed: Missing return value in review check method
Fixed: Template path validation for security
Improved: Proper escaping of AJAX nonces in inline scripts
Improved: Uninstall cleanup now removes plugin options and transients
Improved: Updated Google Analytics placeholder to GA4 format

= 1.1.2 - 05.06.2025 =
Fixed: Textdomain fix for wordpress 6.8+

= 1.1.1 - 03.02.2025 =
Fixed: Overflowing text on template no.15 ( https://github.com/ColorlibHQ/colorlib-coming-soon-maintenence/issues/77 )
Fixed: Subscribe field is overlapped and social media icons are not arranged correctly on template no.14 ( https://github.com/ColorlibHQ/colorlib-coming-soon-maintenence/issues/75 )
Fixed: Close modal button not working on template no.4 ( https://github.com/ColorlibHQ/colorlib-coming-soon-maintenence/issues/68 )

= 1.1.0 - 21.03.2024 =
Fixed: XSS security

= 1.0.99 - 27.05.202 =
Fixed: XSS security

= 1.0.98 - 11.05.2021 =
Added : Social icons for template 3 ( https://github.com/ColorlibHQ/colorlib-coming-soon-maintenence/issues/78 )

= 1.0.97 - 08.04.2021 =
Fixed: Double dots on template 15 ( https://github.com/ColorlibHQ/colorlib-coming-soon-maintenence/issues/76 )

= 1.0.96 =
* Compatibility with jQuery 3.0

= 1.0.95 =
* Fixed SSL Verification

= 1.0.94 =
* Fix timer fields width in FireFox
* Some escaping improvements

= 1.0.93 =
* Added option to add Google Analytics to landing page
* Fix toggle button bug when using themes that change the layout of customizer controls
* Review dismiss fix

= 1.0.92 =
* Review request fix / review save fix
* Fix compatibility with Colorlib 404 Customizer

= 1.0.91 =
* Prevent forcing customizer to show only coming soon page

= 1.0.9 =
* Removed news dashboard widget

= 1.0.8 =
* Display 'Days','Hours','Minutes' and 'Seconds' fix

= 1.0.7 =
* UI minor update

= 1.0.6 =
* UI minor update - toggles update

= 1.0.5 =
* Fixed countdown timer
* Added 24 hour format to timer

= 1.0.4 =
* Fixed subscribe forms

= 1.0.3 =
* Added missing translation strings
* Added missing escape function

= 1.0.2 =
* Update change template UI

= 1.0.1 =
* Remove uninstall feedback

= 1.0.0 =
* Initial release

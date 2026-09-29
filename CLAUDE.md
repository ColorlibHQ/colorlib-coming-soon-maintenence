# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

WordPress plugin: **Coming Soon and Maintenance by Colorlib** (v1.4.1). Displays a coming soon or maintenance mode page to visitors without editing rights, using one of 15 selectable templates. Content is configured in the WordPress Live Customizer; the plugin's own admin page (**Coming Soon** in the admin menu) holds the status with an on/off button, the client preview link and settings export/import. While the page is on, users who bypass it see a red status item in the admin bar (`ccsm_admin_bar_status()`).

- **Requires:** WordPress 6.0+, PHP 7.4+
- **Tested up to:** WordPress 7.1
- **Text Domain:** `colorlib-coming-soon-maintenance`
- **Main plugin file:** `colorlib-coming-soon-and-maintenance-mode.php`

## Build Commands

```bash
# Install dependencies
npm install

# Minify CSS (assets/css AND templates/*/css; writes .min.css siblings)
grunt mincss

# Generate the POT translation file (requires WP-CLI)
npm run i18n

# Build release ZIP archive (clean → mincss → copy → compress)
grunt build-archive
```

`.min.css` files are build artifacts and gitignored. `ccsm_style_url()` serves the
minified sibling automatically whenever one exists, so a release zip is minified
and a git checkout is not.

No SCSS pipeline — CSS is authored directly. No test suite exists.

## Architecture

### Request Flow

1. `ccsm_template_redirect()` hooks `template_redirect` at **priority 0**. The priority is load-bearing: core registers `redirect_canonical` and the sitemap renderer on earlier-registered callbacks that `exit` first, so at the default priority 10 the guard never ran for `/?p=123` probes or `wp-sitemap*.xml`, and both leaked the site's content inventory. Register it at load time, not from inside an `init` callback.
2. Sends `nocache_headers()`, plus `status_header(503)` and `Retry-After` in maintenance mode.
3. Loads `includes/colorlib-template.php` as the HTML wrapper (doctype, head, body), then `exit()`s — the normal theme is never rendered.
4. The wrapper fires `do_action('ccsm_header', $template)` (enqueues styles) and `do_action('ccsm_footer', $template)` before `</body>` (prints the script).
5. Includes the selected template PHP from `templates/template_XX/template_XX.php`.

`is_robots()` and `is_favicon()` deliberately return early so robots.txt keeps
working — maintenance mode adds `Disallow: /` through the `robots_txt` filter.

**Who is locked out** is decided in one place, `ccsm_is_active_for_visitor()`. Every
guard calls it so they cannot disagree. It requires the `edit_posts` capability
(filter: `ccsm_bypass_capability`) rather than merely being logged in, and it honours
the shareable preview cookie set by `?ccsm_bypass=<token>`.

**Other front-end guards:**
- `ccsm_rest_restrict()` (`rest_pre_dispatch`) returns `403 rest_forbidden`.
- `ccsm_guard_front_doors()` (`init`, priority 0) closes what `template_redirect` cannot reach: XML sitemaps, XML-RPC (including the pingback methods), `wp-links-opml.php`, `wp-comments-post.php` (its redirect leaks any post's permalink by ID), `wp-trackback.php`, and logged-out `admin-ajax.php` / `admin-post.php` actions (allowlist filter: `ccsm_allowed_nopriv_actions`).
- `wp-login.php` never reaches `template_redirect`, so it stays reachable with no special case.

The activation toggle (`colorlib_coming_soon_activation`) is the master on/off switch — distinct from `colorlib_coming_soon_mode` (coming soon = 200, maintenance = 503) and from `colorlib_coming_soon_template_selection`, which only chooses *which* template renders.

### The shell never calls `wp_head()` — consequences

`includes/colorlib-template.php` deliberately skips `wp_head()` so theme and plugin
assets stay off the page. Anything core registers from `wp_enqueue_scripts` therefore
never happens there. Two places depend on working around that:

- **Selective refresh data.** Core hooks `_customizePartialRefreshExports` from
  `wp_enqueue_scripts`; other plugins load `customize-selective-refresh` in every
  preview, so the shell hooks `export_preview_data` itself. The plugin registers **no**
  selective-refresh partials: they could never initialise here, and with no render
  callback they would only full-reload. `assets/js/customizer-preview.js` does live updates.
- **TinyMCE in the Customizer.** `wp_enqueue_editor()` prints on
  `admin_print_footer_scripts`, which `customize.php` never fires (only core's widgets
  panel does, on classic themes). `ccsm_print_editor_scripts()` prints it from
  `customize_controls_print_footer_scripts` unless that already happened.

### Key Files

| File | Purpose |
|------|---------|
| `colorlib-coming-soon-and-maintenance-mode.php` | Plugin bootstrap, hooks, style/script enqueuing, redirect logic, countdown date math |
| `includes/colorlib-template.php` | HTML shell that wraps the active template |
| `includes/class-ccsm-customizer.php` | Customizer sections/settings/controls, the admin settings page, export/import, and the per-setting sanitizers |
| `includes/class-ccsm-review.php` | Admin review request notice |
| `includes/controls/` | Custom Customizer control classes (toggle, text editor, template selector) |

### Templates

15 self-contained templates in `templates/template_01/` through `templates/template_15/`. Each has:
- `template_XX.php` — markup (uses Customizer option values via `get_option('ccsm_settings')`)
- `template_XX.jpg` — preview screenshot
- `css/main.css` + `css/util.css` — template-specific styles (`util.css` includes the reset)

All front-end behavior (validation, countdown, slideshow, modal, tilt) is handled by the single shared `assets/js/ccsm-frontend.js`; templates no longer ship their own `js/` directory.

`util.css` is **no longer per-template**. It used to be an 80 KB file copied into all
15 template directories with ~99% of its selectors unused. It is now one purged
`assets/css/ccsm-util.css` (~6 KB), referenced through a `'shared' => 'true'` flag on
the style entry so it still loads *after* the template's `main.css`, preserving the
original cascade order. If you re-purge it, keep the rule: drop a class rule only when
every class it references is absent from the template PHP, the shell, the front-end JS
and the template CSS.

Templates are selected via a radio control in the Customizer and stored in `ccsm_settings['colorlib_coming_soon_template_selection']`.

### Current Frontend Stack (dependency-free)

The front end was stripped of all frameworks. There is **no Bootstrap, no jQuery, and no vendor JS** (`assets/js/vendor/` and `assets/css/vendor/` are gone).

- **Front-end JS:** one shared, dependency-free `assets/js/ccsm-frontend.js` (~6 KB). Feature-detected modules: form validation, background slideshow (cross-fade), subscribe modal, tilt effect, and the countdown timer (native `Date`). There are no per-template JS files anymore.
- **Front-end CSS:** global `assets/css/ccsm-frontend.css` (SVG-icon + `.ccsm-cd` countdown styles) plus each template's self-contained `css/main.css` + `css/util.css` (each `util.css` ships its own reset/reboot, so no framework CSS is needed).
- **Icons:** inline SVG via the `ccsm_icon( $name, $classes )` helper in the main plugin file (Simple Icons for brands, Bootstrap Icons for UI glyphs). No icon fonts, no CDNs. Icons inherit color via `currentColor` and scale with font-size.
- **Countdown:** the stored launch date is **site-local time** (the Customizer's date control is labelled with the site timezone). `ccsm_counter_dates()` parses it with `wp_timezone()` and `ccsm_countdown_script()` emits `window.CCSM_COUNTDOWN = { target: <ms since epoch> }`. Never rebuild the date from parts in JS: `new Date(y, m, d…)` reads them in the visitor's timezone. An expired countdown is hidden by the shell (except in the Customizer preview). Templates 06 & 15 (formerly jQuery FlipClock) use the same `.ccsm-cd` digit layout as the rest.
- **Google Fonts:** loaded per-template with `<link rel="preconnect">` + `&display=swap`.
- **Admin/Customizer JS** (`assets/js/customizer*.js`, `assets/js/main.js`) **still uses jQuery** — WordPress bundles jQuery in wp-admin, so this is intentional and entirely separate from the front end.

### Customizer Options Namespace

All settings are stored in a single option: `ccsm_settings`. Keys follow the pattern `colorlib_coming_soon_*` (e.g., `colorlib_coming_soon_timer_activation`, `colorlib_coming_soon_template_selection`, `colorlib_coming_soon_background_color`).

## Important Constants

- `CCSM_PATH` — plugin directory path (filesystem)
- `CCSM_URL` — plugin directory URL
- `CCSM_PLUGIN_BASE` — plugin basename for hooks
- `CCSM_FILE_` — main plugin file path (note the trailing underscore)
- `CCSM_VERSION` — current version string (`1.4.1`); keep in sync with the plugin header, `readme.txt` `Stable tag`, and `package.json`

## Filters

- `ccsm_skip_redirect` — skip the coming-soon redirect (e.g., for specific pages)
- `ccsm_force_redirect` — force redirect even for logged-in users
- `ccsm_bypass_capability` — capability a logged-in user needs to see the real site (default `edit_posts`; return `read` for the pre-1.4.0 "any logged-in user" behaviour)
- `ccsm_allowed_nopriv_actions` — array of `admin-ajax.php` / `admin-post.php` actions that stay reachable for logged-out visitors
- `ccsm_retry_after` — seconds sent in the `Retry-After` header in maintenance mode (default 1 hour)
- `ccsm_google_fonts` — return `false` to stop templates loading Google Fonts (GDPR); fonts otherwise load non-blocking via `ccsm_async_font_tag()`

## Release Build Notes

- `grunt build-archive` copies the plugin into `build/` (excluding dev files — see the `copy` task allow/deny list in `Gruntfile.js`), then compresses it to `colorlib-coming-soon-maintenance-<version>.zip` in the repo root. The `*.zip` artifact is gitignored.
- `grunt mincss` runs `clean:css` then `cssmin` over both `assets/css/*.css` and `templates/*/css/*.css`, writing `*.min.css` siblings. Those are gitignored build artifacts.
- Translations are generated with WP-CLI (`npm run i18n`), not grunt — `grunt-wp-i18n` and `grunt-checktextdomain` were unmaintained and blind to strings in JS.
- There is no SCSS pipeline and no vendored framework CSS, so neither `.sass-cache/` nor `*.map` is relevant here despite the global convention.

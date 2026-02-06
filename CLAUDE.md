# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

WordPress plugin: **Coming Soon and Maintenance by Colorlib** (v1.2.0). Displays a coming soon or maintenance mode page to non-logged-in visitors using one of 15 selectable templates. Configuration is done via the WordPress Live Customizer.

- **Requires:** WordPress 6.0+, PHP 7.4+
- **Tested up to:** WordPress 6.9
- **Text Domain:** `colorlib-coming-soon-maintenance`
- **Main plugin file:** `colorlib-coming-soon-and-maintenance-mode.php`

## Build Commands

```bash
# Install dependencies
npm install

# Minify CSS (cleans old .min.css files, then generates new ones)
grunt mincss

# Check text domain & generate POT translation file
grunt i18n

# Build release ZIP archive (runs i18n → copy → compress)
grunt build-archive
```

No SCSS pipeline — CSS is authored directly. No test suite exists.

## Architecture

### Request Flow

1. `ccsm_template_redirect()` hooks into `template_redirect` — intercepts all front-end requests for non-logged-in users
2. Loads `includes/colorlib-template.php` as the HTML wrapper (doctype, head, body)
3. The wrapper fires `do_action('ccsm_header', $template)` which enqueues per-template styles/scripts via `ccsm_style_enqueue()`
4. Includes the selected template PHP from `templates/template_XX/template_XX.php`

### Key Files

| File | Purpose |
|------|---------|
| `colorlib-coming-soon-and-maintenance-mode.php` | Plugin bootstrap, hooks, style/script enqueuing, redirect logic, countdown date math |
| `includes/colorlib-template.php` | HTML shell that wraps the active template |
| `includes/class-ccsm-customizer.php` | Registers all Customizer sections, settings, and controls |
| `includes/class-ccsm-ajax.php` | MailChimp subscription AJAX handler |
| `includes/class-ccsm-review.php` | Admin review request notice |
| `includes/controls/` | Custom Customizer control classes (toggle, text editor, template selector) |

### Templates

15 self-contained templates in `templates/template_01/` through `templates/template_15/`. Each has:
- `template_XX.php` — markup (uses Customizer option values via `get_option('ccsm_settings')`)
- `template_XX.jpg` — preview screenshot
- `css/main.css` + `css/util.css` — template-specific styles
- `js/` — template-specific scripts (countdown initialization, etc.)

Templates are selected via a radio control in the Customizer and stored in `ccsm_settings['colorlib_coming_soon_template_selection']`.

### Current Frontend Stack

- **Bootstrap 4.0.0-beta** (vendored in `assets/css/vendor/bootstrap/` and `assets/js/vendor/bootstrap/`)
- **jQuery** (WordPress-bundled) — all JS is jQuery-dependent
- **Vendor JS:** Moment.js + Moment Timezone, FlipClock.js, countdowntime.js, jQuery Tilt, Select2
- **Icon fonts:** Ionicons (local), Font Awesome 4.7 (CDN), Material Design Icons 2.2 (CDN)
- **Google Fonts** loaded per-template via `<link>` tags

### Customizer Options Namespace

All settings are stored in a single option: `ccsm_settings`. Keys follow the pattern `colorlib_coming_soon_*` (e.g., `colorlib_coming_soon_timer_activation`, `colorlib_coming_soon_template_selection`, `colorlib_coming_soon_background_color`).

## Important Constants

- `CCSM_PATH` — plugin directory path (filesystem)
- `CCSM_URL` — plugin directory URL
- `CCSM_PLUGIN_BASE` — plugin basename for hooks
- `CCSM_FILE_` — main plugin file path

## Filters

- `ccsm_skip_redirect` — skip the coming-soon redirect (e.g., for specific pages)
- `ccsm_force_redirect` — force redirect even for logged-in users

## .gitignore Gaps

The current `.gitignore` is missing `.sass-cache/` and `*.map`. These should be added before any SCSS pipeline is introduced.

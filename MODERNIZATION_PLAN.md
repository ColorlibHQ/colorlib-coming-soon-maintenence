# Modernization Plan — Coming Soon & Maintenance by Colorlib

Audit date: 2026-07-30 · Audited version: 1.3.0 · Target: WordPress 7.0+, PHP 8.5
Security findings were verified **live** against the local WP 7.0.2 test site (`local-wp.local`) with the plugin active.

---

## Audit summary

| Dimension | Verdict |
|---|---|
| **Security** | No criticals (no SQLi/LFI/RCE/stored XSS). **1 High, 5 Medium, 13 Low.** The headline: the "closed" site leaks its full content inventory via sitemaps, canonical redirects, XML-RPC, and nopriv AJAX. |
| **Performance** | 99.1% of each template's 80 KB `util.css` is unused (duplicated 15× = 1.18 MB); render-blocking JS in `<head>`; HTTP 200 with no cache headers; ~3 MB of dead files shipped. |
| **Usability / a11y** | Keyboard focus is invisible everywhere; form errors are hover-only; pinch-zoom blocked; 5 templates have unnamed icon-only buttons; multiple outright template bugs. |
| **WP 7 / future-proofing** | PHP 8.5 clean (`php -l` passes on all 25 files). Two real admin bugs (403 Settings link, logged fatal on menu click). Legacy grunt i18n stack; readme instructions wrong for block themes. |

---

## Phase 1 — Security & correctness hotfix → release as **1.3.1**

The gate-bypass cluster shares one root cause: `ccsm_template_redirect` is registered at priority 10 from inside an `init` callback, so core callbacks registered earlier win.

1. **Fix the guard registration** (`colorlib-coming-soon-and-maintenance-mode.php:93–100`)
   - Register `add_action( 'template_redirect', 'ccsm_template_redirect', 0 )` **unconditionally at plugin load**; drop the `$pagenow === 'wp-login.php'` gate (fragile — derived from `PHP_SELF`; `wp-login.php` never reaches `template_redirect` anyway).
   - Fixes, in one change: **[HIGH] sitemap leak** (`/wp-sitemap-posts-post-1.xml` returned every post URL + `/wp-sitemap-users-1.xml` leaked usernames while the site was closed) and **[MED] `redirect_canonical` enumeration** (`/?p=1` → 301 to the pretty permalink; `/?author=1` → username disclosure).
2. **Close the remaining front doors while activation is on & visitor is logged out:**
   - `add_filter( 'wp_sitemaps_enabled', '__return_false' )` (belt-and-braces with #1).
   - **[MED] XML-RPC**: `xmlrpc_enabled` → false, and strip `pingback.*` methods (live-verified `system.listMethods` responded while closed).
   - **[MED] `admin-ajax.php` / `admin-post.php` nopriv actions**: block non-allowlisted actions with `wp_die( '', 403 )` (other plugins' `nopriv` handlers currently serve content through maintenance mode).
   - **[MED] `wp-links-opml.php`** (leaks WP version) — covered by the same early-exit logic.
3. **[MED] ABSPATH guards** — add `if ( ! defined( 'ABSPATH' ) ) { exit; }` to all 24 unguarded files (everything except the main file and `uninstall.php`): `includes/*.php`, `includes/controls/*.php`, all 15 `templates/template_XX/template_XX.php`. Direct access currently prints absolute filesystem paths when `display_errors` is on.
4. **HTTP response correctness** (`ccsm_template_redirect()`, before the include at line 134):
   - Always: `nocache_headers();` — page caches/CDNs currently cache the coming-soon HTML for anonymous users and can keep serving it after deactivation.
   - New "mode" toggle: **Maintenance** → `status_header( 503 ); header( 'Retry-After: 3600' );` **Coming soon** → 200 + optional `noindex` robots meta toggle. (Today every URL is an indexable 200 — Google recrawls an established site as duplicate placeholder pages.)
5. **Admin bugs (verified):**
   - `colorlib-coming-soon-and-maintenance-mode.php:82` — Settings action link → `admin_url( 'admin.php?page=ccsm_settings' )` (currently `options-general.php?...` → "Sorry, you are not allowed…" for everyone).
   - `includes/class-ccsm-customizer.php:580` — add `exit;` after `wp_safe_redirect()`; give `add_menu_page()` a real callback (`settings_page()` doesn't exist → logged fatal `Call to undefined method` on every menu click, can trip WP's fatal-error recovery emails).
   - `colorlib-coming-soon-and-maintenance-mode.php:892–899` — **[LOW] add `current_user_can( 'manage_options' )`** to the GA-notice dismiss AJAX (any Subscriber can currently flip the option); gate the nonce-printing footer script (`:856–884`) on the same capability *and* on the notice actually showing.
6. **Template bugs (all verified in source):**
   - `templates/template_04/template_04.php:36` — Seconds cell renders the **days** value → `['seconds']`.
   - `templates/template_10/template_10.php:150,159` — YouTube & Instagram links prefixed `mailto:` → plain `href`.
   - `templates/template_12/template_12.php:96` — stray `[` attribute in the email anchor.
   - `templates/template_14/template_14.php:63` — typo "Subcribe Now".
   - `templates/template_03/template_03.php:44–46` — heading rendered inside `id="colorlib_coming_soon_page_content"` (partial targets wrong element); social icons + footer wrongly nested inside the `if subscribe != '1'` block (disabling the form removes social links).
   - `templates/template_13/template_13.php:88–90` — dead play button (video feature removed) → delete.
   - 11 templates — `alt="<?php echo esc_url( get_bloginfo() ); ?>"` renders the site URL/mangled name as alt text → `esc_attr( get_bloginfo( 'name' ) )` (t01:66, t03:38, t06:29, t07:30, t09:44, t10:43, t11:43, t12:29, t13:44, t14:33, t15:33).
7. **Delete dead code** (all zero-reference, grep-verified):
   - `includes/class-ccsm-ajax.php` — never `require`d; contains a nonce-less nopriv handler that would be a liability if ever wired up. MailChimp works via direct form POST; the class is vestigial.
   - `CCSM_Customizer::ccsm_add_settings_link()` (`class-ccsm-customizer.php:555–560`, never hooked, wrong slug), `assets/css/customizer.css` (15 KB), `assets/js/main.js`, `assets/screenshots/` (1.52 MB duplicate of template jpgs), the empty `$encript_scripts` loop (main file `:458–459, 499–503`), and `add_action( 'ccsm_header', 'wp_print_scripts' )` (`:62` — calls `wp_print_scripts('template_01')`, a no-op).

## Phase 2 — Sanitization & escaping hardening

All 22 Customizer settings currently share one sanitizer (`wp_kses_post( force_balance_tags() )`). Replace per type in `includes/class-ccsm-customizer.php`:

| Settings | Sanitizer |
|---|---|
| `activation`, `timer_activation`, `subscribe` | strict `'1' === $v ? '1' : ''` |
| `background_color`, `text_color` | `sanitize_hex_color` |
| `plugin_logo`, `background_image`, `subscribe_form_url`, `subscribe_form_other`, 5 × `social_*` URLs | `esc_url_raw` |
| `social_email` | `sanitize_email` |
| `timer_option` | validate `Y-m-d H:i:s` via `DateTime::createFromFormat` |
| `template_selection` | whitelist against the 15 choices |
| `page_custom_css` | `wp_strip_all_tags` (kses currently mangles `>` child selectors — a functional bug too) |
| `page_heading`, `page_content`, `page_footer` | keep `wp_kses_post` (correct — TinyMCE HTML fields) |

Output-side:
- `includes/colorlib-template.php:56` + 7 templates' `<style>` blocks (t01:26, t02:20, t03:25, t09:25, t10:25, t11:25, t13:25) — colors go into CSS via `wp_kses_post`/`esc_html`, neither is a CSS sanitizer (verified: arbitrary CSS rule injection possible, admin-only) → `esc_attr( sanitize_hex_color( $v ) )`.
- GA ID (`colorlib-template.php:17,23`) — sanitize with `/^(G|UA|GT|AW|DC)-[A-Z0-9-]+$/i`, output via `esc_url()` / `wp_json_encode()` instead of the `esc_html` + quote-strip hack.
- **Missing-key hardening**: templates read ~12 `$ccsm_options[...]` keys unguarded (PHP 8 warnings on upgraded/partial options) → `wp_parse_args( get_option( 'ccsm_settings', array() ), ccsm_defaults() )` once, used everywhere.
- **Bypass capability**: gate is bare `is_user_logged_in()` — any Subscriber (and their application-password REST reads) sees the closed site → `! current_user_can( apply_filters( 'ccsm_bypass_capability', 'edit_posts' ) )`, filterable back to the old behavior.
- Plugin Check hygiene: `echo wp_kses( ccsm_icon(...), $svg_allowlist )` at the ~40 call sites (or phpcs annotations — output is internally escaped); `sprintf()` for the PHP-version i18n string (main:48–51); add `$ver` to the customizer enqueues (main:508–519); `is_array()` guard in `class-ccsm-review.php:128`.

## Phase 3 — Performance

Ranked by measured impact:

1. **Purge `util.css`** — 80.7 KB/template, 15 near-identical copies (1.18 MB shipped), **0.9% used** (21 of 2,345 selectors hit in template_01). Generate one shared purged file in `assets/css/` (~2–4 KB) + tiny per-template remainder. Biggest single win in the repo.
2. **Minify front-end assets** — zero `.min` files exist; Gruntfile's `cssmin` never touches `templates/*/css/`. Extend the build, enqueue `.min`.
3. **Un-block the head** — `wp_print_scripts( 'ccsm-frontend' )` (main:483) prints the 6.5 KB JS parser-blocking in `<head>` despite `$in_footer = true`. Print before `</body>` or add `defer` (safe — it guards on `readyState`).
4. **Skip the wasted main query** — `template_redirect` fires after the full `WP_Query` runs, result discarded on every anonymous view. Short-circuit earlier (e.g. `do_parse_request` / `send_headers`) with the same guards.
5. **Preload the LCP background** — `<link rel="preload" as="image">` in the shell head for the configured background image (currently discovered late via inline style).
6. **Customizer payload** — template selector loads 15 full-size JPGs (~1.5 MB, t14 = 238 KB): add `loading="lazy"`, recompress/resize to thumbnail dimensions (WebP ≈ halves them).
7. **Fonts** — merge the double Google Fonts requests on t01/02/06/07/08/13 into one `family=A|B` URL (t10–12/14/15 already do); audit weight-100/900 variants (t10 loads 8 weights); consider the `css2` API.
8. Small: gate `CCSM_Customizer` instantiation to `is_admin() || is_customize_preview()`; skip the inline `CCSM_COUNTDOWN` config on t12/t14 (no timer UI); drop the dead single-slide slideshow code or wire multiple backgrounds.

## Phase 4 — Accessibility (WCAG 2.2 AA pass)

Shared fixes (once each):

- **Focus visibility** — every `util.css` removes outlines (`a:focus`, inputs, `button:focus { outline: none }`) with nothing substituted; zero `:focus-visible` rules exist. Keyboard focus is completely invisible (WCAG 2.4.7). Add a shared `:focus-visible` style in `assets/css/ccsm-frontend.css` and delete the resets.
- **Shell** (`includes/colorlib-template.php`): `language_attributes()` instead of hardcoded `lang="en"`; remove `maximum-scale=1` (zoom blocked, WCAG 1.4.4); emit the Site Icon (favicon currently vanishes); use the dead `$site_description` as `<meta name="description">`; fix the early-`return` that emits a truncated document; wrap template output in `<main>`.
- **Forms** (12 templates share the pattern): visually-hidden `<label>`s; `type="email"` + `autocomplete="email"` (all are `type="text"` today); **fix the dead validation** — `ccsm-frontend.js:17` matches `name === 'email'` but every template uses `name="EMAIL"`, so the email regex never runs; make errors real — currently a CSS `:hover`-only tooltip above 992 px — with an inline `role="alert"` message, `aria-invalid`, focus to first invalid field; placeholder contrast `#999` on white ≈ 2.85:1 → darken.
- **Modal** (template_04 + `ccsm-frontend.js:94–130`): focus into dialog on open, focus trap, restore on close, `aria-modal="true"` + `aria-labelledby`, name the close button. Also fix t04's duplicate DOM id (`colorlib_coming_soon_page_footer` on both trigger and modal text).
- **Icons** — `ccsm_icon()` hardcodes `aria-hidden="true"` for UI glyphs, so every icon-only submit/close button (t04, t10, t12, t13, t14) has no accessible name. Add an optional label param; name those 5 buttons.
- **Countdown** — wrap in `role="timer"` with `aria-hidden` ticking digits + a visually-hidden static "Launching on {date}"; expand "Hr/Min/Sec" labels (t11, t13).
- **Headings** — no template has an `<h1>`; t01/03/07 have no heading element at all; t06 inverts heading/content semantics. Promote the title element per template.
- **Motion** — add a `prefers-reduced-motion` block disabling tilt, cross-fade, and `.trans-04` transitions.
- **Misc** — `rel="noopener"` on the `target="_blank"` copyright links; guarantee a dark overlay wherever white text sits on the user-chosen background image (t02/08/09/10/11/13/15).

## Phase 5 — Customizer & admin UX

- **Live preview is mostly broken**: selective-refresh partials for timer/logo/form/social are inert because their settings use `refresh` transport; `customizer-preview.js:3–9` builds an invalid jQuery selector (`#ccsm_settings[...]`) so it matches nothing — and uses `.html()` (self-XSS pattern) besides. Move colors/images/toggles to `postMessage`, rewrite the preview JS with `.text()` and correct selectors, or delete it and rely on partials.
- **Template selector** (`includes/controls/class-ccsm-template-selection.php:28–31`): images have no `alt` and the "Template N" labels are never rendered — unusable by screen reader and unlabeled for everyone. Render captions + alt + lazy thumbnails.
- **Section organization**: 7 controls share `priority => 10` in General; GA field lands between Main Content and Footer Text → give explicit priorities, move GA to its own section.
- **Labels/logic**: second "Subscribe Form Action URL" (`:386`) is actually the Sign-Up link → relabel; invert the negative "Disable Subscribe Form" toggle.
- **Defaults**: social links default to bare `https://facebook.com/` etc. and the background defaults to the plugin logo stretched full-page → ship empty socials (icons hidden until set) and a neutral gradient; when the form action URL is empty (the default), hide the form or show an admin-only hint instead of a form that posts back to itself.
- **Future-proofing**: preview URL from `home_url('/')` not `get_option('siteurl')` (wrong URL on subdirectory installs); replace core-internal `WP_Customize_Date_Time_Control` with a shipped `datetime-local` control; `wp.oldEditor.initialize` fallback in `customizer.js`; `.click()` → `.on('click')` in `class-ccsm-review.php:155,183`; update readme's "Appearance > Customize" instructions for block-theme sites (path doesn't exist there — the plugin's own "Coming Soon" menu is the entry point).

## Phase 6 — Build, i18n, docs & feature roadmap

- **i18n**: replace `grunt-wp-i18n` (unmaintained) with `wp i18n make-pot . languages/colorlib-coming-soon-maintenance.pot`; fix `potFilename` (currently `.po`); delete the stale mismatched `colorlib-coming-soon.pot`.
- **Build**: extend `cssmin` to template CSS; exclude `CLAUDE.md`, `.gitignore`, `MODERNIZATION_PLAN.md` from `copy:build` (currently shipped in the grunt zip); drop the stale `jquery-ui.min.css` whitelist; add an `engines` field.
- **Privacy/GDPR**: readme claims "GDPR compliant" while GA loads unconditionally and Google Fonts load from Google's CDN (LG München fonts rulings) → add a consent note/toggle for GA, offer locally-hosted fonts, soften the claim.
- **Feature roadmap** (all confirmed absent; standard in competing plugins):
  - Bypass URL secret token for sharing with clients.
  - Role/capability allowlist UI (builds on the Phase 2 filter).
  - Coming-soon vs maintenance **mode** toggle surfacing the 503 behavior (Phase 1).
  - Settings export/import.
  - Longer term: a standalone settings screen (options page + REST) to reduce Customizer dependence — the Customizer is feature-frozen upstream and hidden on block themes.

## Phase 7 — QA & release (1.4.0)

- `for f in $(find . -name "*.php"); do php -l "$f"; done` (PHP 8.5.6 — currently green, keep it that way).
- Run **Plugin Check** — expected flags now: EscapeOutput on `ccsm_icon` echoes, NonEnqueuedScript (GA tag), EnqueuedResourceParameters, i18n concatenation.
- Manual matrix on `local-wp.local`: 15 templates × (timer on/off, subscribe on/off, socials set/empty), block theme + classic theme, logged-out leak re-test (`/wp-sitemap.xml`, `/?p=1`, `xmlrpc.php`, `admin-ajax.php`, `robots.txt`, feeds, REST).
- Release: 1.3.1 (Phase 1 only, fast) → 1.4.0 (Phases 2–6). Keep `CCSM_VERSION`, plugin header, `readme.txt` stable tag, `package.json` in sync.

---

## Verified-clean (no action needed)

Template inclusion is whitelist-validated (no LFI); REST 403 guard works (live-tested incl. `?rest_route=` and oEmbed); feeds/search/archives/embeds correctly blocked; `esc_html( antispambot() )` is not a double-encoding bug; `ccsm_icon()` internals safe; front-end JS has no `innerHTML`/`eval`; `uninstall.php` correct; no dynamic properties / implicit nullables / deprecated WP functions; `wp-login.php` stays reachable. Note: `wp-content/uploads/` is static-served and can't be gated by PHP — worth a readme FAQ line.

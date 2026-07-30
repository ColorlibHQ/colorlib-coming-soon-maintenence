# Modernization Plan — Coming Soon & Maintenance by Colorlib

Audit: 2026-07-30 against v1.3.0 · Implemented in v1.4.0 on branch `modernization-1.4.0`
Security findings were verified live against the local WP 7.0.2 install (`local-wp.local`), before and after.

**Status: all seven phases implemented.** Six commits, +2,263 / −45,086 lines across 98 files.
Deferred items are listed at the bottom.

---

## What was wrong, and what shipped

### Phase 1 — Front-end leaks and correctness (commit `40ae961`)

The whole gate-bypass cluster had one root cause: `ccsm_template_redirect` was registered on
`template_redirect` at priority 10 *from inside* an `init` callback, so core callbacks registered
earlier ran first and `exit`ed before it.

| Leak (verified live on 1.3.0) | Now |
|---|---|
| `/wp-sitemap-posts-post-1.xml` served every post URL | placeholder, no `<loc>` entries |
| `/wp-sitemap-users-1.xml` leaked author slugs | placeholder, no author URLs |
| `/?p=1`, `/?author=1` 301'd to the real permalink | 200, no `Location` |
| XML-RPC advertised `pingback.*` | methods stripped, `xmlrpc_enabled` false |
| `wp-links-opml.php` leaked blogroll + WP version | 403 |
| logged-out `admin-ajax.php` / `admin-post.php` | 403 (allowlist: `ccsm_allowed_nopriv_actions`) |

Registered at **priority 0 at load time** instead, and the fragile `$pagenow` gate is gone
(it keyed off `PHP_SELF`; `wp-login.php` never reaches `template_redirect` anyway).
`is_robots()`/`is_favicon()` deliberately pass through so crawlers can still read the rules.

Also: a **coming soon / maintenance mode toggle** (maintenance = 503 + `Retry-After` +
`Disallow: /`), `nocache_headers()` in both modes, ABSPATH guards on the 24 files that lacked
them, the two admin bugs (403'ing Settings link; logged fatal on every menu click), the GA-notice
capability check, six template bugs, and ~3 MB of dead code deleted (`class-ccsm-ajax.php` was
never `require`d at all).

### Phase 2 — Sanitization (commit `cbb4fe8`)

All 22 settings shared one sanitizer, `wp_kses_post( force_balance_tags() )`, including colors,
URLs, dates, booleans and the template slug. Each now has a callback matching its type. Colors
were printed into CSS through HTML escapers, which leave `;`, `{` and `}` untouched — all 12 output
sites now go through `ccsm_hex_color()`. The GA ID was "sanitized" with `esc_html()` (storing
entities) and printed via a quote-stripping hack. Templates read ~12 option keys unguarded, so
upgraded sites raised PHP 8 warnings that leaked absolute paths — `ccsm_get_options()` fixes that.
The bypass gate was bare `is_user_logged_in()`, so any subscriber saw through it; now `edit_posts`,
filterable via `ccsm_bypass_capability`.

### Phase 3 — Performance (commit `c2bce7f`)

`util.css` was 80,755 bytes copied into all 15 template directories, with 21 of its 2,345 class
selectors actually used. Purged into one shared `assets/css/ccsm-util.css`.

| Measured | Before | After |
|---|---|---|
| Page CSS (live) | 97.3 KB | **24.4 KB** |
| `util.css` in repo | 1.2 MB | 8 KB |
| Selector thumbnails | 1.5 MB | 748 KB |

The front-end JS was registered `$in_footer = true` but printed from `ccsm_header`, and
`wp_print_scripts()` with an explicit handle emits immediately — so 6.5 KB sat parser-blocking in
`<head>`. Now printed from a new `ccsm_footer` action. Plus background-image preload, six templates
merged from two Google Fonts requests to one, and lazy-loaded thumbnails.

**Purge safety rule** (keep this if you re-purge): drop a class rule only when *every* class it
references is absent from the template PHP, the shell, the front-end JS and the template CSS.

**Visual regression evidence.** The 45k deleted lines are 94% duplicate `util.css` copies — the
15 files reduce to only *two* distinct checksums, so 13 were literal duplicates. The single file
that can affect rendering went 2,890 → 280 lines, so it was tested directly: every template was
screenshotted with the original 2,890-line stylesheet and again with the purged one, at 1280px and
390px. **All 15 were pixel-identical at both widths**, except two antialiasing clusters (34 and 8
pixels, max channel delta 1, drifting in both directions on icon edges).

**Retained classes.** A purge cannot see what lives in the database: heading/content/footer are
rich-text fields, so a site owner who used the Text tab may have typed utility classes of their
own. The font-size, text-alignment and colour families are therefore kept even though no shipped
template uses them (196 rules, 5.7 KB). Final stylesheet 11.8 KB vs the 78 KB original.

### Phase 4 — Accessibility (commit `40e83e1`)

Focus was invisible everywhere (every stylesheet removed the outline and substituted nothing; zero
`:focus-visible` rules existed). Email validation **never ran** — the JS compared `name === 'email'`
while every template uses `name="EMAIL"` — and the error message was a CSS `::before` revealed only
on `:hover` above 992 px. The modal never managed focus. The countdown rewrote four numbers a second
with no static equivalent.

All fixed, plus per template: `type="email"` + autocomplete, visually hidden labels, exactly one
`<h1>` (three templates had no heading element; template_06 had heading and content semantically
swapped), accessible names on icon-only buttons via a third `ccsm_icon()` argument,
`rel="noopener noreferrer"`, `language_attributes()`, Site Icon, `<main>`, no `maximum-scale`,
`prefers-reduced-motion`, and contrast raised from 2.85:1 to ≥4.5:1 on 19 selectors.

### Phase 5 — Customizer (commit `40e83e1`)

The live preview was a **no-op**: it built `'#' + 'ccsm_settings[key]'`, which jQuery parses as
`#ccsm_settings` plus an attribute filter. Separately, heading/content/footer had `postMessage`
transport with no handler at all, so those never updated either. Rewritten; colors, images and
social links now update as you type. Seven General controls shared priority 10; two controls shared
one label; a fresh install rendered a subscribe form posting to itself.

### Phase 6 — Build, docs, new features (commit `6fc6c4c`)

WP-CLI `make-pot` replaces the unmaintained grunt i18n chain; the generated template was named
`.po` (renamed) and a stale 2018 one with a different text domain was deleted. Template CSS is now
minified and `ccsm_style_url()` serves `.min.css` when present. **New:** shareable client preview
link (`?ccsm_bypass=<token>`, `hash_equals`, HttpOnly cookie, rotatable), settings export/import
(imports run through the same sanitizers as the Customizer — verified matching on all 24 settings),
and a real settings screen, which also solves block-theme discoverability since `customize.php` has
no menu entry there. Readme instructions no longer say "Appearance > Customize", and the
"GDPR compliant" claim is replaced with what actually happens.

### Phase 7 — QA (commit `ff90a16`)

Verified live with the plugin still holding a pre-1.4.0 21-key option array, so the upgrade path was
exercised: every leak vector re-tested, maintenance mode 503/`Retry-After`/robots confirmed, bypass
link confirmed end to end (right token, wrong token, with and without cookie), all 15 templates
rendering with one `h1`, a `main` landmark and **zero PHP warnings**, and screenshots of templates
1/4/6/10/13 confirming the purge broke no layout and the SVG icons still render.

---

## Deferred

- **Standalone settings UI replacing the Customizer.** The new admin page is the entry point, but
  content editing still lives in the Customizer, which is feature-frozen upstream. A REST + React
  screen is the long-term move.
- **`wp-content/uploads/` is static-served** and cannot be gated by PHP, so media attached to hidden
  posts stays fetchable by direct URL. Needs a rewrite rule; worth a readme FAQ line.
- **Remaining contrast items on indeterminate backgrounds:** templates 08/10 use `#fff` placeholders
  over a user-chosen background image, and `template_13/css/main.css:306` `.how-social` sits on an
  image. Not statically decidable — needs a per-template design pass.
- **`WP_Customize_Date_Time_Control`** is core-internal with no deprecation path; ship a copy or a
  plain `datetime-local` control.
- **Heading order in template_04**: the modal heading stays `<h3>` under the page `<h1>`, so the
  document skips `<h2>`. Best-practice issue, not a WCAG A/AA failure.

## Verified with Local's bundled tooling

Local ships WP-CLI and a MySQL client inside the app bundle, so no extra install was needed:

- `wp-cli.phar` — `/Applications/Local.app/Contents/Resources/extraResources/bin/wp-cli/wp-cli.phar`
- PHP 8.2 — `.../lightning-services/php-8.2.29+0/bin/darwin-arm64/bin/php`
- MySQL client — `.../lightning-services/mysql-8.4.0/bin/darwin-arm64/bin`

The bundled PHP does not know Local's socket, so pass it explicitly:
`php -d mysqli.default_socket="$HOME/Library/Application Support/Local/run/X6odgxrlw/mysql/mysqld.sock" wp-cli.phar --path=<site> ...`

**POT regenerated** (120 strings, stamped 1.4.0) and **Plugin Check reports zero errors and zero
warnings on the built release archive.** Check the archive under its real slug — a different
folder name makes the text-domain rule fire ~150 times spuriously.

## Release checklist

1. `for f in $(find . -name "*.php"); do php -l "$f"; done` — clean on PHP 8.5.6.
2. `npm run i18n` if strings changed since the last POT.
3. `npx grunt build-archive` → `colorlib-coming-soon-maintenance-1.4.0.zip` (812 KB, dev files
   excluded, 18 minified stylesheets, POT included). The `*.zip` is gitignored.
4. Merge `modernization-1.4.0`, tag `1.4.0`, then SVN trunk + `tags/1.4.0`.

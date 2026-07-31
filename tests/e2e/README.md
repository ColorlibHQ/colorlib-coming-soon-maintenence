# End-to-end tests

Browser tests for the behaviour that static analysis and screenshots cannot
cover: keyboard focus, form validation, the modal focus trap, and the
Customizer live preview.

They drive a real WordPress install, so they need a local site with this plugin
active. Nothing is mocked.

## Running

Playwright is not a dependency of this plugin — point at any checkout that has
it installed:

```bash
export PLAYWRIGHT_PATH=/path/to/some-project/node_modules/playwright
export CCSM_SITE=http://local-wp.local

# Front end: 21 checks. Changes the active template as it goes.
node tests/e2e/frontend.js

# Customizer: 10 checks. Needs an admin login.
CCSM_USER=admin CCSM_PASS=secret node tests/e2e/customizer.js
```

`set-option.php` writes directly into the site's `ccsm_settings` option so a
test can switch template without going through the UI. Edit the socket path in
it if your local stack differs.

## What they caught

Written during the 1.4.0 work, they found three real bugs on the first run:
`type="email"` letting native validation pre-empt the accessible error path,
the focus handler wiping the error message it had just shown, and a duplicate
`customize-selective-refresh` enqueue breaking the preview console.

/*
 * Drives the real Customizer: the one surface never exercised in a browser.
 * Verifies the rewritten preview bindings actually update the preview, and
 * that the refresh fallback fires when a setting has no element to patch.
 */
const { chromium } = require(process.env.PLAYWRIGHT_PATH || 'playwright');

const BASE = (process.env.CCSM_SITE || 'http://local-wp.local').replace(/\/+$/, '');
const USER = process.env.CCSM_USER;
const PASS = process.env.CCSM_PASS;

let pass = 0, fail = 0;
const check = (n, ok, d) => { console.log(`  ${ok ? 'PASS' : 'FAIL'}  ${n}${d ? '  -- ' + d : ''}`); ok ? pass++ : fail++; };

(async () => {
  const browser = await chromium.launch();
  const ctx = await browser.newContext({ viewport: { width: 1500, height: 950 } });
  const page = await ctx.newPage();

  const jsErrors = [];
  page.on('pageerror', e => jsErrors.push('controls: ' + e.message));
  page.on('console', m => { if (m.type() === 'error' && !/favicon|net::ERR/.test(m.text())) jsErrors.push('console: ' + m.text()); });

  // ---- log in
  await page.goto(`${BASE}/wp-login.php`, { waitUntil: 'domcontentloaded' });
  await page.fill('#user_login', USER);
  await page.fill('#user_pass', PASS);
  await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }), page.click('#wp-submit')]);
  check('logged in to wp-admin', page.url().includes('/wp-admin'), page.url().replace(BASE, ''));

  // ---- open the Customizer on our panel
  await page.goto(`${BASE}/wp-admin/customize.php?autofocus%5Bpanel%5D=colorlib_coming_soon_general_panel`,
    { waitUntil: 'load' });
  await page.waitForFunction(() => window.wp && wp.customize && wp.customize.state &&
    wp.customize.state('previewerAlive') !== undefined, null, { timeout: 60000 }).catch(() => {});
  await page.waitForTimeout(6000);

  const ready = await page.evaluate(() => !!(window.wp && wp.customize));
  check('customizer API booted', ready);

  const settingCount = await page.evaluate(() => {
    let n = 0; wp.customize.each(s => { if (String(s.id).indexOf('ccsm_settings') === 0) n++; }); return n;
  });
  check('our settings registered in the UI', settingCount === 24, `${settingCount} settings`);

  // ---- the preview iframe
  const frameHandle = await page.$('#customize-preview iframe, .wp-full-overlay-main iframe');
  const preview = frameHandle ? await frameHandle.contentFrame() : null;
  check('preview iframe present', !!preview);
  if (!preview) { await browser.close(); process.exit(1); }

  await preview.waitForSelector('#colorlib_coming_soon_page_heading', { timeout: 30000 }).catch(() => {});
  const headingBefore = await preview.locator('#colorlib_coming_soon_page_heading').first().innerText().catch(() => '');
  check('preview rendered the coming soon page', headingBefore.length > 0, headingBefore.slice(0, 40));

  // ---- 1. in-place update: change the heading via the setting API
  await page.evaluate(() => {
    wp.customize('ccsm_settings[colorlib_coming_soon_page_heading]').set('Launch Day Is Near');
  });
  await page.waitForTimeout(2500);
  const headingAfter = await preview.locator('#colorlib_coming_soon_page_heading').first().innerText().catch(() => '');
  check('heading updates live in the preview', headingAfter.includes('Launch Day Is Near'), headingAfter.slice(0, 40));

  // ---- 2. refresh fallback: a social link that renders no element yet
  const socialBefore = await preview.locator('#colorlib_coming_soon_social_facebook').count();
  await page.evaluate(() => {
    wp.customize('ccsm_settings[colorlib_coming_soon_social_facebook]').set('https://facebook.com/colorlib');
  });
  // debounce (500ms) + full preview refresh
  await page.waitForTimeout(9000);
  const fh2 = await page.$('#customize-preview iframe, .wp-full-overlay-main iframe');
  const preview2 = fh2 ? await fh2.contentFrame() : preview;
  const socialAfter = await preview2.locator('#colorlib_coming_soon_social_facebook').count().catch(() => 0);
  check('adding a social link makes the icon appear (refresh fallback)',
    socialBefore === 0 && socialAfter > 0, `before=${socialBefore} after=${socialAfter}`);

  // ---- 3. in-place href update now that the element exists
  await page.evaluate(() => {
    wp.customize('ccsm_settings[colorlib_coming_soon_social_facebook]').set('https://facebook.com/updated');
  });
  await page.waitForTimeout(2500);
  const href = await preview2.locator('#colorlib_coming_soon_social_facebook').first().getAttribute('href').catch(() => null);
  check('existing social link updates in place', href === 'https://facebook.com/updated', String(href));

  // ---- 4. colour handling through the injected stylesheet
  await page.evaluate(() => {
    var s = wp.customize('ccsm_settings[colorlib_coming_soon_background_color]');
    if (s) s.set('#112233');
  });
  await page.waitForTimeout(2000);
  const live = await preview2.evaluate(() => {
    const el = document.getElementById('ccsm-live-colors');
    return el ? el.textContent : '';
  }).catch(() => '');
  check('colour change writes the live stylesheet', live.includes('#112233'), live.slice(0, 60) || 'empty');

  check('no JavaScript errors in the customizer', jsErrors.length === 0, jsErrors.slice(0, 2).join(' | ') || 'clean');

  await browser.close();
  console.log(`\n  ${pass} passed, ${fail} failed`);
  process.exit(fail ? 1 : 0);
})().catch(e => { console.error('HARNESS ERROR:', e.message); process.exit(2); });

/*
 * Hands-on front-end tests: the interactive behaviour that static checks and
 * screenshots cannot cover. Exercises keyboard focus, form validation and the
 * modal focus trap the way a person would.
 */
const { chromium } = require(process.env.PLAYWRIGHT_PATH || 'playwright');
const { execFileSync } = require('child_process');

const SITE = process.env.CCSM_SITE || 'http://local-wp.local/';
const SETOPT = __dirname + '/set-option.php';

function setOption(pairs) {
  execFileSync('php', [SETOPT, ...pairs], { stdio: 'pipe' });
}

let pass = 0, fail = 0;
function check(name, ok, detail) {
  console.log(`  ${ok ? 'PASS' : 'FAIL'}  ${name}${detail ? '  -- ' + detail : ''}`);
  ok ? pass++ : fail++;
}

(async () => {
  const browser = await chromium.launch();

  // ---------------------------------------------------------------- template 01
  setOption([
    'colorlib_coming_soon_template_selection=template_01',
    'colorlib_coming_soon_subscribe_form_url=https://example.us1.list-manage.com/subscribe/post',
  ]);

  let page = await browser.newPage();
  await page.goto(SITE, { waitUntil: 'networkidle' });

  console.log('\n[ keyboard focus visibility ]');
  // Tab to the first focusable control and read its computed outline.
  await page.keyboard.press('Tab');
  const focused = await page.evaluate(() => {
    const el = document.activeElement;
    const cs = getComputedStyle(el);
    return { tag: el.tagName, outlineWidth: cs.outlineWidth, outlineStyle: cs.outlineStyle };
  });
  check('first Tab lands on a real control', focused.tag !== 'BODY', `focused <${focused.tag.toLowerCase()}>`);
  check('focused element has a visible outline',
    focused.outlineStyle !== 'none' && parseFloat(focused.outlineWidth) > 0,
    `outline: ${focused.outlineWidth} ${focused.outlineStyle}`);

  console.log('\n[ subscribe form validation ]');
  const emailInput = page.locator('input[name="EMAIL"]');
  // A label must be programmatically associated.
  const labelText = await page.evaluate(() => {
    const i = document.querySelector('input[name="EMAIL"]');
    const l = i && i.id ? document.querySelector(`label[for="${i.id}"]`) : null;
    return l ? l.textContent.trim() : null;
  });
  check('email input has an associated label', !!labelText, labelText || 'none found');
  check('email input uses type=email', await emailInput.getAttribute('type') === 'email');

  // Fill every other text field first, so EMAIL is the first invalid one.
  await page.evaluate(() => {
    document.querySelectorAll('form.validate-form .input100').forEach(i => {
      if (i.name !== 'EMAIL') i.value = 'Test Person';
    });
  });
  // Submit with a bad address and confirm the error is announced and visible.
  await emailInput.fill('not-an-email');
  await page.locator('form.validate-form button, form.validate-form input[type=submit]').first().click();
  await page.waitForTimeout(400);

  const err = await page.evaluate(() => {
    const r = document.querySelector('.ccsm-field-error');
    if (!r) return null;
    const cs = getComputedStyle(r);
    return { text: r.textContent.trim(), role: r.getAttribute('role'), display: cs.display, visibility: cs.visibility };
  });
  check('invalid email is rejected (still on page)', page.url().startsWith(SITE));
  check('error message rendered', !!(err && err.text), err ? err.text : 'no .ccsm-field-error');
  check('error uses role=alert', err && err.role === 'alert');
  check('error is visible without hovering', err && err.display !== 'none' && err.visibility !== 'hidden');
  check('input marked aria-invalid', await emailInput.getAttribute('aria-invalid') === 'true');
  const activeIsEmail = await page.evaluate(() => document.activeElement.name === 'EMAIL');
  check('focus moved to the invalid field', activeIsEmail);

  // A valid address should clear the error state.
  await emailInput.fill('someone@example.com');
  await page.waitForTimeout(200);
  check('error clears when the field is corrected',
    await emailInput.getAttribute('aria-invalid') === null);

  await page.close();

  // ---------------------------------------------------------------- template 04 modal
  console.log('\n[ modal focus management (template 04) ]');
  setOption(['colorlib_coming_soon_template_selection=template_04']);
  page = await browser.newPage();
  await page.goto(SITE, { waitUntil: 'networkidle' });

  const trigger = page.locator('[data-ccsm-modal]').first();
  const hasTrigger = await trigger.count() > 0;
  check('modal trigger present', hasTrigger);

  if (hasTrigger) {
    await trigger.focus();
    await page.keyboard.press('Enter');
    await page.waitForTimeout(400);

    const state = await page.evaluate(() => {
      const m = document.querySelector('.modal.show');
      return m ? {
        open: true,
        ariaModal: m.getAttribute('aria-modal'),
        labelledby: m.getAttribute('aria-labelledby'),
        focusInside: m.contains(document.activeElement),
      } : { open: false };
    });
    check('modal opens on Enter', state.open);
    check('modal announces itself as a dialog', state.ariaModal === 'true', `aria-modal=${state.ariaModal}`);
    check('modal has an accessible name', !!state.labelledby, `aria-labelledby=${state.labelledby}`);
    check('focus moves inside the modal', state.focusInside === true);

    // Tab through more elements than the modal contains; focus must not escape.
    let escaped = false;
    for (let i = 0; i < 12; i++) {
      await page.keyboard.press('Tab');
      const inside = await page.evaluate(() => {
        const m = document.querySelector('.modal.show');
        return m ? m.contains(document.activeElement) : true;
      });
      if (!inside) { escaped = true; break; }
    }
    check('focus is trapped inside the modal (12 tabs)', !escaped);

    await page.keyboard.press('Escape');
    await page.waitForTimeout(400);
    const closed = await page.evaluate(() => !document.querySelector('.modal.show'));
    check('Escape closes the modal', closed);
    const restored = await page.evaluate(() =>
      document.activeElement && document.activeElement.hasAttribute('data-ccsm-modal'));
    check('focus returns to the trigger', restored);
  }
  await page.close();

  // ---------------------------------------------------------------- reduced motion
  console.log('\n[ reduced motion ]');
  setOption(['colorlib_coming_soon_template_selection=template_01']);
  const ctx = await browser.newContext({ reducedMotion: 'reduce' });
  page = await ctx.newPage();
  await page.goto(SITE, { waitUntil: 'networkidle' });
  const dur = await page.evaluate(() => {
    const el = document.querySelector('.trans-04') || document.body;
    return getComputedStyle(el).transitionDuration;
  });
  check('transitions suppressed under prefers-reduced-motion',
    dur === '0s' || parseFloat(dur) < 0.01, `transition-duration: ${dur}`);
  await ctx.close();

  // ---------------------------------------------------------------- console errors
  console.log('\n[ javascript console ]');
  const errs = [];
  const p2 = await browser.newPage();
  p2.on('pageerror', e => errs.push(e.message));
  p2.on('console', m => { if (m.type() === 'error') errs.push(m.text()); });
  await p2.goto(SITE, { waitUntil: 'networkidle' });
  await p2.waitForTimeout(2500);
  check('no JavaScript errors on the page', errs.length === 0, errs.join(' | ') || 'clean');
  await p2.close();

  await browser.close();
  console.log(`\n  ${pass} passed, ${fail} failed`);
  process.exit(fail ? 1 : 0);
})().catch(e => { console.error('HARNESS ERROR:', e); process.exit(2); });

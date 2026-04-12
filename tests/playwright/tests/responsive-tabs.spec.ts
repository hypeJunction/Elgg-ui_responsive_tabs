import { test, expect } from '@playwright/test';
import { loginAs } from '../helpers/elgg';

/**
 * ui_responsive_tabs is a purely cosmetic plugin: it ships a CSS file that
 * restyles .elgg-tabs / .elgg-menu-filter lists, plus a tiny JS snippet that
 * toggles the .elgg-state-active class on the parent <ul> when the user taps
 * the currently selected tab. This gives a dropdown-style menu on narrow
 * viewports.
 *
 * These tests assert:
 *   1. The plugin's CSS/JS assets are actually served by the site.
 *   2. The JS click-toggle behaviour works in the browser.
 *   3. Pages with tab/filter menus still render without JS errors.
 */

test.describe('ui_responsive_tabs assets are served', () => {
  test('compiled CSS cache contains tabs rules', async ({ page }) => {
    // elgg.js bundle is referenced on every page; fetching the dashboard
    // warms the view cache and lets us probe the emitted CSS.
    const response = await page.goto('/');
    expect(response?.ok()).toBeTruthy();

    // Extract the first stylesheet href and fetch it directly.
    const cssHref = await page
      .locator('link[rel="stylesheet"]')
      .first()
      .getAttribute('href');
    expect(cssHref).toBeTruthy();

    const cssResponse = await page.request.get(cssHref!);
    expect(cssResponse.ok()).toBeTruthy();
    const css = await cssResponse.text();
    // The plugin's stylesheet uses these selectors — if extension is wired
    // up, they MUST appear in the aggregated core components CSS.
    expect(css).toContain('.elgg-tabs');
    expect(css).toContain('.elgg-menu-filter');
  });

  test('elgg.js bundle contains responsive tabs click handler', async ({ page }) => {
    await page.goto('/');
    const jsSrc = await page
      .locator('script[src*="elgg.js"], script[src*="/js/"]')
      .first()
      .getAttribute('src');

    if (!jsSrc) {
      test.skip(true, 'Could not locate elgg.js script tag on the page');
      return;
    }

    const jsResponse = await page.request.get(jsSrc);
    expect(jsResponse.ok()).toBeTruthy();
    const js = await jsResponse.text();
    expect(js).toMatch(/elgg-tabs|elgg-menu-filter/);
    expect(js).toContain('elgg-state-active');
  });
});

test.describe('Responsive tabs click behaviour', () => {
  test('clicking selected filter tab toggles elgg-state-active on parent', async ({ page }) => {
    // The members page commonly renders a filter menu. Fall back to the
    // dashboard if /members is not routable.
    let ok = false;
    for (const path of ['/members', '/members/newest', '/dashboard']) {
      const r = await page.goto(path);
      if (r && r.ok()) {
        ok = true;
        break;
      }
    }
    expect(ok).toBeTruthy();

    // Locate any responsive tabs / filter menu with a selected item.
    const menu = page.locator('ul.elgg-menu-filter, ul.elgg-tabs').first();
    const count = await menu.count();
    if (count === 0) {
      test.skip(true, 'No .elgg-tabs / .elgg-menu-filter menu on this page');
      return;
    }

    const selectedLink = menu.locator('> li.elgg-state-selected > a').first();
    const selectedCount = await selectedLink.count();
    if (selectedCount === 0) {
      test.skip(true, 'Menu has no selected item to click');
      return;
    }

    // The plugin's JS calls e.preventDefault() for the selected tab, so the
    // click should NOT navigate — it should only toggle the class.
    await selectedLink.click();
    await expect(menu).toHaveClass(/elgg-state-active/);

    // A second click removes the class again.
    await selectedLink.click();
    await expect(menu).not.toHaveClass(/elgg-state-active/);
  });
});

test.describe('Pages with tab menus render cleanly', () => {
  test('dashboard renders without JS console errors', async ({ page }) => {
    const errors: string[] = [];
    page.on('pageerror', (err) => errors.push(err.message));
    page.on('console', (msg) => {
      if (msg.type() === 'error') errors.push(msg.text());
    });

    await page.goto('/');
    await page.waitForLoadState('networkidle');
    expect(errors, `JS errors on dashboard: ${errors.join('; ')}`).toEqual([]);
  });
});

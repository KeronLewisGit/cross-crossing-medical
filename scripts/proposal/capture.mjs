// Captures full-page screenshots of every screen (desktop + phone) for the client proposal.
// Slices follow the page's own sections so a screenshot never breaks mid-block.
// Usage: npm run proposal (the dev server must already be running with demo data; env: BASE_URL, STAFF_PASSWORD)
import puppeteer from 'puppeteer-core';
import fs from 'node:fs';
import path from 'node:path';

const BASE = process.env.BASE_URL ?? 'http://127.0.0.1:8109';
const OUT = path.resolve('dist/proposal/shots');
const CHROME = process.env.CHROME_PATH ?? '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const PASSWORD = process.env.STAFF_PASSWORD ?? 'password';

fs.rmSync(OUT, { recursive: true, force: true });
fs.mkdirSync(OUT, { recursive: true });

const PUBLIC = [
  ['home', '/'], ['services', '/services'], ['emergency', '/services/accident-emergency'], ['laboratory', '/services/laboratory'],
  ['clinics', '/clinics'], ['handouts', '/patient-handouts'], ['careers', '/careers'], ['contact', '/contact'],
];
const FLOWS = [
  ['appointment', '/appointments?service=cardiology'], ['registration', '/new-patients'], ['dialysis', '/services/dialysis'], ['apply', '/careers/apply'],
];
const ADMIN_PAGES = [
  ['admin-login', '/login'],
  ['admin-dashboard', '/admin'], ['admin-inbox', '/admin/requests'], ['admin-request', 'first:appointment'],
  ['admin-appointments', '/admin/appointments'], ['admin-jobs', '/admin/jobs'], ['admin-users', '/admin/users'],
];
const RECORDS_PAGES = [['admin-registration', 'cards:registration'], ['admin-document-log', '/admin/document-log']];
const MOBILE = [['m-home', '/'], ['m-emergency', '/services/accident-emergency'], ['m-appointment', '/appointments'], ['m-registration', '/new-patients'], ['m-admin-dashboard', '/admin'], ['m-admin-request', 'first:appointment']];

const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', protocolTimeout: 60000, args: ['--hide-scrollbars', '--no-sandbox'] });
const page = await browser.newPage();
await page.emulateMediaFeatures([{ name: 'prefers-reduced-motion', value: 'reduce' }, { name: 'prefers-color-scheme', value: 'light' }]);

async function settle() {
  await page.evaluate(async () => {
    // Scroll-reveal blocks and the drawn pulse line: show their final state.
    document.querySelectorAll('[data-reveal]').forEach(e => e.classList.add('is-visible'));
    document.querySelectorAll('.pulse-line.draw').forEach(e => e.classList.remove('draw'));
    // The staff sidebar is fixed to the viewport; pin it to the page so every slice shows it full height.
    const aside = document.querySelector('body.admin > aside');
    if (aside && innerWidth >= 1024) Object.assign(aside.style, { position: 'absolute', bottom: 'auto', height: document.documentElement.scrollHeight + 'px' });
    // Lazy images below the fold would be blank in a full-page capture: load them all now.
    document.querySelectorAll('img[loading="lazy"]').forEach(i => { i.loading = 'eager'; });
    window.scrollTo(0, document.body.scrollHeight); await new Promise(r => setTimeout(r, 400)); window.scrollTo(0, 0);
    await Promise.race([
      Promise.all([...document.images].filter(i => !i.complete).map(i => new Promise(r => { i.onload = i.onerror = r; }))),
      new Promise(r => setTimeout(r, 5000)),
    ]);
    await Promise.all([...document.images].map(i => i.decode?.().catch(() => {})));
  });
  await new Promise(r => setTimeout(r, 500));
}

/**
 * Measure natural content blocks (header, each section, footer). Blocks taller than the
 * page budget are replaced by their children, recursively, so slices follow real section
 * boundaries instead of cutting wherever the pixel budget runs out.
 */
async function measureBlocks(maxH) {
  return page.evaluate((maxH) => {
    const rect = (el) => { const r = el.getBoundingClientRect(); return { top: Math.round(r.top + window.scrollY), bottom: Math.round(r.bottom + window.scrollY) }; };
    const visible = (el) => { const cs = getComputedStyle(el); const r = el.getBoundingClientRect(); return cs.display !== 'none' && cs.visibility !== 'hidden' && r.height > 24 && cs.position !== 'fixed'; };
    const skip = (el) => el.matches('script, style, template, [x-cloak], [aria-hidden="true"]:not(section)');
    const label = (el) => {
      const hs = [...el.querySelectorAll('h1, h2, h3')].filter(h => visible(h) && h.closest('nav, footer, [aria-hidden="true"]') === null);
      const seen = new Set();
      const text = (h) => { const c = h.cloneNode(true); c.querySelectorAll('[aria-hidden="true"], template, .sr-only').forEach(e => e.remove()); return c.textContent.replace(/\s+/g, ' ').trim(); };
      return hs.map(text).filter(t => t && !seen.has(t.toLowerCase()) && seen.add(t.toLowerCase())).slice(0, 4);
    };
    const explode = (el) => {
      const r = { ...rect(el), labels: label(el) };
      r.own = r.bottom - r.top; // before gaps are filled in below
      if (r.bottom - r.top <= maxH) return [r];
      const kids = [...el.children].filter(k => !skip(k) && visible(k));
      if (kids.length === 0) return [{ top: r.top, bottom: r.bottom, labels: r.labels }];
      if (kids.length === 1) return explode(kids[0]); // wrapper div – look inside it
      return kids.flatMap(explode);
    };
    // Sales desk layout: the content column is <main id="content">; public layout: body-level header/main/footer.
    const adminMain = document.querySelector('body.admin main#content');
    const roots = adminMain
      ? [...adminMain.children].map(el => ({ el, trailing: false }))
      : [...document.body.children].filter(el => ['HEADER', 'MAIN', 'FOOTER', 'DIV', 'SECTION'].includes(el.tagName) && !skip(el) && visible(el))
          .flatMap(el => el.tagName === 'MAIN' ? [...el.children].map(k => ({ el: k, trailing: false })) : [{ el, trailing: el.tagName === 'FOOTER' || (el.tagName === 'SECTION' && el.previousElementSibling?.tagName === 'MAIN') }]);
    const blocks = roots.filter(r => visible(r.el)).flatMap(r => explode(r.el).map(b => ({ ...b, trailing: r.trailing }))).filter(b => b.bottom > b.top).sort((a, b) => a.top - b.top);
    // merge overlaps / fill gaps so nothing is lost between blocks
    const merged = [];
    for (const b of blocks) {
      const last = merged[merged.length - 1];
      if (last && b.top < last.bottom - 2) { last.bottom = Math.max(last.bottom, b.bottom); last.trailing = last.trailing && b.trailing; last.labels = [...new Set([...last.labels, ...b.labels])]; } else merged.push({ ...b, labels: [...b.labels] }); // merge true overlaps only
    }
    const docH = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
    if (merged.length) { merged[0].top = 0; merged[merged.length - 1].bottom = Math.max(merged[merged.length - 1].bottom, docH); for (let i = 1; i < merged.length; i++) merged[i].top = merged[i - 1].bottom; }
    return { blocks: merged, docH, docW: document.documentElement.clientWidth };
  }, maxH);
}

/** Greedily pack consecutive blocks into page-sized groups; a lone oversize block is hard-cut as a last resort. */
function packBlocks(blocks, maxH, docH) {
  const groups = [];
  let cur = null;
  for (const [bi, b] of blocks.entries()) {
    const h = b.bottom - b.top;
    const next = blocks[bi + 1];
    // A short block (a section label) that would end one slice while its section starts the next goes with its section.
    const orphan = (b.own ?? h) < 90 && cur && next && next.bottom - cur.top > maxH && next.bottom - b.top <= maxH;
    if (cur && b.bottom - cur.top <= maxH && !orphan) { cur.bottom = b.bottom; cur.labels = [...new Set([...cur.labels, ...(b.labels ?? [])])]; continue; }
    if (cur) groups.push(cur);
    if (h > maxH) {
      for (let y = b.top; y < b.bottom; y += maxH) groups.push({ top: y, bottom: Math.min(y + maxH, b.bottom), labels: b.labels ?? [] });
      cur = null;
    } else cur = { top: b.top, bottom: b.bottom, labels: [...(b.labels ?? [])] };
  }
  if (cur) groups.push(cur);
  // swallow a tiny trailing sliver (e.g. a thin footer strip) into the previous group when it fits
  if (groups.length > 1) {
    const last = groups[groups.length - 1], prev = groups[groups.length - 2];
    if (last.bottom - last.top < maxH * 0.15 && last.bottom - prev.top <= maxH * 1.05) { prev.bottom = last.bottom; prev.labels = [...new Set([...prev.labels, ...last.labels])]; groups.pop(); }
  }
  groups[groups.length - 1].bottom = Math.min(groups[groups.length - 1].bottom, docH);
  return groups;
}

const RATIO = 1.0; // slice height ÷ width: one slice fills a letter page beneath the heading and bullets

/** "first:type" = the newest request of that type; "cards:registration" = a registration with ID and insurance cards. */
const resolved = {};
async function resolve(url) {
  if (!/^(first|cards):/.test(url)) return url;
  if (resolved[url]) return resolved[url];
  const [mode, type] = url.split(':');
  await page.goto(`${BASE}/admin/requests?type=${type}`, { waitUntil: 'networkidle0' });
  const href = await page.evaluate((mode) => {
    const rows = [...document.querySelectorAll('table.data-table tbody tr')];
    const pick = mode === 'cards' ? rows.find(r => /\b2\s*$/.test(r.cells[1]?.textContent.trim() ?? '')) ?? rows[0] : rows[0];
    return pick?.querySelector('a[href*="/admin/requests/"]')?.getAttribute('href');
  }, mode);
  return (resolved[url] = new URL(href, BASE).pathname);
}

async function shoot(name, url, { width = 1440, height = 900, fullPage = true, mobile = false } = {}) {
  url = await resolve(url);
  await page.setViewport({ width, height, deviceScaleFactor: mobile ? 2 : 1.25, isMobile: mobile, hasTouch: mobile });
  await page.goto(BASE + url, { waitUntil: 'networkidle0' });
  await settle();
  const files = []; const labels = [];
  if (!fullPage) {
    const hash = new URL(BASE + url).hash;
    if (hash) { await page.evaluate((h) => document.querySelector(h)?.scrollIntoView(), hash); await new Promise(r => setTimeout(r, 300)); }
    const file = path.join(OUT, `${name}.jpg`);
    await page.screenshot({ path: file, type: 'jpeg', quality: 72 });
    files.push(file);
    console.log(`✓ ${name} viewport`);
    return { name, url, chunks: files.map(f => path.resolve(f)), labels: [[]], sizes: [[width, height]], mobile };
  }
  const maxH = Math.round(width * RATIO);
  let { blocks, docH } = await measureBlocks(maxH);
  if (name !== 'home') { blocks = blocks.filter(b => !b.trailing); docH = blocks[blocks.length - 1].bottom; } // CTA band + footer are shown once (home)
  // The "Other departments" strip repeats on every department page; leave it out of the proposal.
  const last = blocks[blocks.length - 1];
  if (blocks.length > 1 && last.labels.length === 1 && last.labels[0] === 'Other departments') { blocks.pop(); docH = blocks[blocks.length - 1].bottom; }
  const groups = packBlocks(blocks, maxH, docH);
  for (const [i, g] of groups.entries()) {
    const file = path.join(OUT, groups.length > 1 ? `${name}-${i}.jpg` : `${name}.jpg`);
    await page.screenshot({ path: file, type: 'jpeg', quality: 72, captureBeyondViewport: true, clip: { x: 0, y: g.top, width, height: g.bottom - g.top } });
    files.push(file); labels.push(g.labels ?? []);
  }
  console.log(`✓ ${name} → ${groups.length} slice(s): ${groups.map(g => (g.labels ?? []).join(' | ') || '(no heading)').join('  ·  ')}`);
  return { name, url, chunks: files.map(f => path.resolve(f)), labels, sizes: groups.map(g => [width, g.bottom - g.top]), w: width, h: docH };
}

async function login(email) {
  await page.goto(BASE + '/login', { waitUntil: 'networkidle0' });
  await page.type('input[name=email]', email);
  await page.type('input[name=password]', PASSWORD);
  await Promise.all([page.waitForNavigation({ waitUntil: 'networkidle0' }), page.click('form button')]);
}

async function logout() {
  await page.goto(BASE + '/admin', { waitUntil: 'networkidle0' });
  await Promise.all([page.waitForNavigation({ waitUntil: 'networkidle0' }), page.evaluate(() => document.querySelector('form[action$="/logout"]').submit())]);
}

const shots = [];
for (const [n, u] of [...PUBLIC, ...FLOWS]) shots.push(await shoot(n, u));
// Staff screens are captured at a 1280 × 1000 laptop size: their content is short, and the larger
// type and taller frame fill a letter page instead of leaving its lower half blank.
const DESK = { width: 1280, height: 1000 };
shots.push(await shoot(...ADMIN_PAGES[0], DESK));
for (const [n, u] of MOBILE.filter(([n]) => !n.startsWith('m-admin'))) shots.push(await shoot(n, u, { width: 390, height: 844, mobile: true, fullPage: false }));
await login('admin@ccmc.test');
// The inbox and the 14-day appointment sheet are long lists; their first screen is enough to show them.
for (const [n, u] of ADMIN_PAGES.slice(1)) shots.push(await shoot(n, u, { ...DESK, fullPage: !['admin-appointments', 'admin-inbox'].includes(n) }));
for (const [n, u] of MOBILE.filter(([n]) => n.startsWith('m-admin'))) shots.push(await shoot(n, u, { width: 390, height: 844, mobile: true, fullPage: false }));
await logout();
// Only the registration and records role can open ID and insurance cards, so that view is captured as records.
await login('records@ccmc.test');
for (const [n, u] of RECORDS_PAGES) shots.push(await shoot(n, u, DESK));
await logout();
fs.writeFileSync(path.join(OUT, 'chunks.json'), JSON.stringify(Object.fromEntries(shots.map(s => [s.name, s])), null, 1));
await browser.close();
console.log('done');

// Builds the client proposal (letter-size PDF) from the captured screenshots, in Cross Crossing
// Medical Centre's own sign-blue and brass palette and the site's fonts.
// Usage: npm run proposal (or node scripts/proposal/build.mjs after a capture). Env: TEST_COUNT.
import puppeteer from 'puppeteer-core';
import fs from 'node:fs';
import path from 'node:path';

const CHROME = process.env.CHROME_PATH ?? '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const ROOT = path.resolve('.');
const SHOTS = path.resolve('dist/proposal/shots');
const chunks = JSON.parse(fs.readFileSync(path.join(SHOTS, 'chunks.json'), 'utf8'));
const OUT_HTML = path.resolve('dist/proposal/proposal.html');
const OUT_PDF = path.resolve('dist/proposal/Cross-Crossing-Medical-Centre-Website-Proposal.pdf');
const MAX_MB = 9.5;
const DATE = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
const TESTS = process.env.TEST_COUNT ?? '85';
const img = (f) => 'file://' + f;
const esc = (s) => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;');

// The site's self-hosted fonts (built by the Vite fonts plugin into public/build/assets).
const ASSETS = path.join(ROOT, 'public/build/assets');
const font = (prefix) => {
  const f = fs.readdirSync(ASSETS).find((n) => n.startsWith(prefix) && n.endsWith('.woff2'));
  if (!f) throw new Error(`Font ${prefix} not found in public/build/assets; run npm run build first.`);
  return 'file://' + path.join(ASSETS, f);
};
const FONTS = [
  ['Lexend', 500, 'lexend-500-normal'], ['Lexend', 600, 'lexend-600-normal'],
  ['Mulish', 400, 'mulish-400-normal'], ['Mulish', 600, 'mulish-600-normal'], ['Mulish', 700, 'mulish-700-normal'], ['Mulish', 800, 'mulish-800-normal'],
].map(([fam, w, p]) => `@font-face { font-family: "${fam}"; font-weight: ${w}; font-style: normal; src: url("${font(p)}") format("woff2"); }`).join('\n');

// The centre's building mark, the same SVG the site uses (redrawn from the logo on the Google Site).
const markSvg = fs.readFileSync(path.join(ROOT, 'resources/views/components/logo-mark.blade.php'), 'utf8').match(/<svg[\s\S]*<\/svg>/)[0]
  .replace(/\{\{[^}]*\}\}/g, '').replace(/class="[^"]*"/, '');
const MARK = (h = 34) => `<span class="mark" style="height:${h}px; padding:0 ${Math.round(h * 0.22)}px">${markSvg.replace('<svg', `<svg style="height:${Math.round(h * 0.7)}px; width:auto; color:#141463; --logo-fill:#fff"`)}</span>`;
const WORDMARK = (dark = true) => `<div class="brand">${MARK(dark ? 42 : 32)}<div><span class="n ${dark ? '' : 'ink'}">Cross Crossing Medical Centre</span><span class="s ${dark ? '' : 'ink'}">San Fernando · Open 24/7</span></div></div>`;
const sign = (code, label, dark = false) => `<p class="sign ${dark ? 'dark' : ''}"><span class="c">${esc(code)}</span><span class="l">${esc(label)}</span></p>`;
const PULSE = `<svg class="pulse" viewBox="0 0 1200 34" preserveAspectRatio="none" aria-hidden="true"><path d="M0 22H470l10-14 12 24 12-30 10 20h18l8-6 8 6H1200" fill="none" stroke="currentColor" stroke-width="2"/></svg>`;

/** Hand-written captions per slice (key = screen name, index = slice number), from what each slice shows. */
const CAPTIONS = {
  home: [
    'The home page opens on the centre\'s own photograph of the building, the two things most visitors come for (an appointment, or registering as a new patient), and the 24-hour band that runs across the top of every page. A red panel sends emergencies straight to A&E.',
    'The "where would you like to go?" directory, styled like the centre\'s own ward signs, and the four steps of an appointment request. Forms say plainly that they are not for emergencies.',
    'Every department, from A&E to the dental suite, with its ward code. The wording comes from the centre\'s current website.',
    'The tests and scans the centre lists (bone density, sleep studies, echo, ECG, stress testing, Holter and more), each one bookable, and the eleven specialist clinics.',
    'New patient registration and the Renal Centre & Dialysis Unit, on the centre\'s own photographs of its signs.',
    'Patient handouts and self-checks, careers, and the location block with both main lines and directions.',
    'Footer: phone lines, email, every department and patient page, the address and the staff sign-in.',
  ],
  services: [
    'Services and departments: the shared inner-page header used on every page, with a framed photograph and the ECG trace.',
    'Each department as a card with its ward code and a photograph: the centre\'s own sign photographs where they exist, credited Wikimedia Commons photographs elsewhere.',
    'Outpatient and inpatient care, and the reminder that emergencies need no appointment.',
  ],
  emergency: ['Accident and Emergency deliberately has no form: a red bar says to come straight in or call 811, with the 24-hour number one tap away.'],
  laboratory: ['The laboratory page explains that results are never put on the website or emailed. Patients are told how to check whether results are ready to collect.'],
  clinics: [
    'The specialties listed on the current site, each linking to the appointment form with that clinic already chosen.',
    'Clinic days are matched by the appointments team rather than promised online, so no timetable is invented.',
  ],
  handouts: [
    'The patient corner: handouts grouped by topic. The old site\'s PDFs have gone, so these start as current NIH, MedlinePlus and PAHO pages; staff can upload the centre\'s own PDFs.',
    'Bones and joints, vaccinations and general health.',
  ],
  careers: ['Careers: open vacancies (examples here), how to apply, and the kinds of role the centre recruits, each linking to the application form.'],
  contact: [
    'Contact: a phone directory with the main lines, the emergency room, fax, email, the dental suite and Facebook, beside a message form.',
    'The map, with Google Maps directions, and the rest of the message form with its consent line.',
  ],
  appointment: [
    'Request an appointment: the shared header.',
    'Step 1, the clinic or test (pre-selected when coming from a clinic page), whether the patient has been before and an optional referral letter. Step 2, the days and time of day that suit, and the earliest date.',
    'Step 3, who the appointment is for (the patient, or a child or someone in your care), contact details and consent under the Data Protection Act.',
  ],
  registration: [
    'New patient registration replaces the empty "newpatient" page: the patient\'s details, and what to bring on the first visit.',
    'Who is filling it in, how to reach them, an emergency contact, the ID to bring, and optional photos of the ID and insurance card.',
    'Consent and an optional opt-in for appointment reminders.',
  ],
  dialysis: [
    'The Renal Centre & Dialysis Unit page, on the centre\'s own sign and unit photographs.',
    'The dialysis enquiry: the patient\'s situation (new, transferring or a family member asking) and the sessions that would suit. Visiting and holiday dialysis stays switched off until the centre confirms it offers it.',
    'Who the enquiry is for, contact details and consent.',
  ],
  apply: [
    'The job application: the vacancy or kind of role, experience, professional registration and availability.',
    'CV upload (PDF or Word), up to three certificates, contact details and consent for recruitment.',
  ],
  'admin-login': ['Staff sign-in. Accounts that have been switched off are refused and signed out.'],
  'admin-dashboard': [
    'The overview leads with the one number to act on: for the front desk, patient requests not called back within their response time. Then this week\'s figures. Numbers are from the demo data; the reminder at the top stays until the notification inboxes are set.',
    'Requests per day for 30 days, requests by type, the most-requested clinics and tests, the call queue (oldest first) and what is booked for the next three days.',
  ],
  'admin-inbox': ['One inbox for every web request: type tabs, filters by status and assignee, an "overdue only" switch, search by name, phone or reference, and a CSV export that leaves out all clinical details.'],
  'admin-request': [
    'An appointment request: one-tap call and WhatsApp, what was asked for, the days that suit, status, assignment and the booked date and time.',
    'The timeline: every note, status change and document opening, with the staff member and the time.',
  ],
  'admin-appointments': ['The appointment sheet: requests booked for the next 14 days, and the requests still waiting for a date with the days patients said suit them.'],
  'admin-jobs': ['Vacancies, managed by HR: draft, open or closed, with applications and new applications counted.'],
  'admin-users': ['Staff accounts with four roles: administrator, front desk and appointments, registration and medical records, and HR.'],
  'admin-registration': [
    'A registration as the records team sees it: patient details, address, insurer and emergency contact.',
    'The ID and insurance card open for the registration and records role only, not even administrators. Every opening is written to the timeline.',
  ],
  'admin-document-log': ['The document log: who opened which patient document, when, and from where. It cannot be edited from the dashboard.'],
};

/** Screen definitions: section, key, title, bullets. */
const SECTIONS = [
  { id: 'public', eyebrow: 'Part 1', code: '01', title: 'The public website', intro: 'A new ccmctt.com written from the facts on the centre\'s current Google Site. It works on any phone, every inner page opens with the same sign-blue header, and the 24-hour status and emergency route are never more than a glance away.', screens: [
    ['home', 'Home page', ['The centre\'s own building and sign photographs, open 24 hours, and the A&E route above everything else.', 'A ward-sign directory leads straight to an appointment, registration, the dialysis unit, the lab and careers.', 'On phones, a bar with Call and Request appointment stays at the foot of every page.']],
    ['services', 'Services and departments', ['A&E, the cardiac care unit, dialysis, laboratory, X-ray and bone density, surgical suites, sleep and lung tests, vaccinations and dental.', 'Old Google Site addresses such as /facilities/dialysis redirect to the matching new page.']],
    ['emergency', 'Accident and Emergency', ['No form, on purpose: "call or come in", with 811 for an ambulance.']],
    ['laboratory', 'Laboratory', ['No results portal. Results are never shown online or emailed; patients are told how to collect them.']],
    ['clinics', 'Specialist clinics', ['Cardiology, endocrinology, family practice, internal medicine, occupational health, orthopaedic surgery, psychiatry, rheumatology, urology, paediatric and women\'s care.']],
    ['handouts', 'Patient handouts', ['Grouped by topic, from trusted public-health sources, with the centre\'s own PDFs uploaded by staff.', 'A BMI check that works without JavaScript, plus diabetes and fracture-risk checks.']],
    ['careers', 'Careers', ['Nurses, dialysis and lab technicians, radiographers and support staff.']],
    ['contact', 'Contact and directions', ['Phone directory, map, directions and a message form that lands in the staff inbox.']],
  ]},
  { id: 'requests', eyebrow: 'Part 2', code: '02', title: 'Online requests', intro: 'Four request forms, plus the contact form. Each one gives the patient a reference number on screen and by email, tells them it is not for emergencies, and puts the request in the right team\'s inbox with a call-back time.', screens: [
    ['appointment', 'Appointment request', ['Any clinic or test, the days and time of day that suit, and an optional referral letter.', 'Nothing is booked online: the appointments team calls back to agree a time, so no clinic timetable is invented.']],
    ['registration', 'New patient registration', ['Replaces the empty "newpatient" page with a five-minute pre-registration.', 'ID and insurance card photos are stored privately, off the public website, under explicit consent.']],
    ['dialysis', 'Dialysis enquiry', ['New patients start with an initial examination and review, as the centre\'s site says.']],
    ['apply', 'Job application', ['CV and certificates go to HR only.']],
  ]},
  { id: 'admin', eyebrow: 'Part 3', code: '03', title: 'The staff desk', intro: 'A private, role-based back office for the front desk, registration and medical records, HR and management. Every web request arrives with a reference number, an owner and a timeline, and anything not called back in time is flagged.', screens: [
    ['admin-login', 'Staff sign-in', ['Individual accounts; switched off, never shared.']],
    ['admin-dashboard', 'Overview', ['Each role\'s overview opens on the one number it must act on.', 'Median time to first call, bookings this week, registrations to check and documents opened.']],
    ['admin-inbox', 'Requests inbox', ['The front desk sees appointments, dialysis enquiries and messages; records sees registrations; HR sees applications.']],
    ['admin-request', 'Request detail', ['Logging a call counts as first contact and stops the overdue clock.']],
    ['admin-appointments', 'Appointment sheet', ['What came through the website, day by day. The clinic diaries stay in the centre\'s own system.']],
    ['admin-registration', 'Registration (records role)', ['ID and insurance cards open for the records team only, not even administrators.']],
    ['admin-document-log', 'Document log', ['Every opening of every patient document, for audit.']],
    ['admin-jobs', 'Vacancies', ['HR posts and closes vacancies without a developer.']],
    ['admin-users', 'Staff and roles', ['Add staff, change roles and switch accounts off.']],
  ]},
];
const SCREEN_COUNT = SECTIONS.reduce((n, s) => n + s.screens.length, 0);

const FEATURES = [
  ['Public website', ['Department pages for A&E, CCU, dialysis, lab, imaging, surgery, sleep and lung, vaccinations and dental', 'Specialist clinics', 'Patient handouts library', 'Health self-checks', 'Careers and vacancies', 'Contact with map', 'Redirects from the old Google Site', 'Phone action bar on every page']],
  ['Online requests', ['Appointment request with preferred days and times', 'New patient pre-registration', 'Private ID and insurance card upload', 'Dialysis enquiry', 'Job application with CV upload', 'Contact form', 'Reference number on screen and by email', '"Not for emergencies" on every form']],
  ['Staff desk', ['Dashboard led by the overdue count', 'Inbox split by role', 'Assignment, status, notes and timeline', 'Appointment sheet', 'Records-only ID and insurance cards', 'Document access log', 'Vacancy and handout management', 'Site-wide notice setting']],
  ['Platform', ['Laravel 13 on PHP 8.3', 'HTTPS throughout', 'Documents stored outside the web root', 'Consent recorded under the Data Protection Act', 'Rate-limited, spam-protected forms', 'Light and dark themes', `${TESTS} automated tests`, 'Packaged for one-zip installation']],
];

/**
 * Pack a section's slices onto pages by height. Units are fractions of the text width: a page holds
 * about 1.22 of image height below its heading, minus captions, bullets and sub-headings. Slices keep
 * their order and never break across pages; slices of one screen, and of different screens (the later
 * one under a small sub-heading), share a page only while everything on it stays at least 85% of the
 * text width, so every screenshot stays readable. Pages are chosen for the fewest pages, then the
 * fewest under-filled pages, then the largest screenshots.
 */
const AVAIL = 1.22, CAP_H = 0.08, SUB_H = 0.075, BULLET_H = 0.045, MIN_SCALE = 0.85, UNDERFILLED = 0.6;
const bulletsH = (b) => (b.length ? b.length * BULLET_H + 0.02 : 0);

function sectionPages(sec) {
  const items = sec.screens.flatMap(([key, title, bullets]) => {
    const c = chunks[key];
    if (!c) throw new Error(`Screenshot missing: ${key}`);
    const sizes = c.sizes ?? c.chunks.map(() => [1440, 1440]);
    return c.chunks.map((f, n) => ({ key, title, bullets, n, f, ratio: sizes[n][1] / sizes[n][0], startsScreen: n === 0, count: c.chunks.length, url: c.url }));
  });
  const over = (list) => list.reduce((t, s, i) => t + CAP_H + (s.startsScreen ? bulletsH(s.bullets) + (i ? SUB_H : 0) : 0), 0);
  const fits = (list) => {
    const img = list.reduce((t, s) => t + s.ratio, 0);
    const scale = Math.min(1, (AVAIL - over(list)) / img);
    return { scale, ok: list.length === 1 || scale >= MIN_SCALE };
  };
  const fill = (list) => (list.reduce((t, s) => t + s.ratio, 0) * fits(list).scale + over(list)) / AVAIL;
  const best = [{ cost: 0, from: -1 }];
  for (let i = 1; i <= items.length; i++) {
    best[i] = { cost: Infinity, from: -1 };
    for (let j = i - 1; j >= 0; j--) {
      const run = items.slice(j, i), f = fits(run);
      if (!f.ok) break;
      const cost = best[j].cost + 1 + (fill(run) < UNDERFILLED ? 10 : 0) + 0.2 * (1 - f.scale);
      if (cost < best[i].cost) best[i] = { cost, from: j };
    }
  }
  const pages = [];
  for (let i = items.length; i > 0; i = best[i].from) pages.unshift(items.slice(best[i].from, i));
  const bulletList = (b) => (b.length ? `<ul class="bullets">${b.map((x) => `<li>${esc(x)}</li>`).join('')}</ul>` : '');
  return pages.map((p) => {
    const scale = fits(p).scale, lead = p[0];
    return `
    <section class="page shot">
      <header class="shot-head">
        <div><p class="eyebrow">${esc(sec.title)}${lead.startsScreen ? '' : ' · continued'}</p><h2>${esc(lead.title)}</h2></div>
        <p class="url">${esc(lead.url)}</p>
      </header>
      ${p.map((s, i) => {
        const head = s.startsScreen ? (i ? `<header class="sub-head"><h3>${esc(s.title)}</h3><p class="url">${esc(s.url)}</p></header>` : '') + bulletList(s.bullets) : '';
        return `${head}<figure><img style="width:${(scale * 100).toFixed(1)}%" src="${img(s.f)}" alt="${esc(s.title)}">${caption(s.key, s.n, s.count)}</figure>`;
      }).join('')}
      ${foot()}
    </section>`;
  }).join('');
}

function caption(key, i, count) {
  const text = CAPTIONS[key]?.[i];
  if (!text) throw new Error(`Caption missing: ${key} slice ${i}`);
  const n = count > 1 ? `${i + 1}/${count} · ` : '';
  return `<figcaption class="cap"><span class="n">${esc(n)}</span>${esc(text)}</figcaption>`;
}

const foot = () => `<footer class="foot"><span class="fl">${MARK(15)}Cross Crossing Medical Centre · Website proposal</span><span>Code Canvas Consultants Ltd · ${esc(DATE)}</span></footer>`;
const notes = (list) => `<div class="phone-notes">${list.map(([t, d]) => `<div><b>${esc(t)}</b>${esc(d)}</div>`).join('')}</div>`;
const phones = (list) => `<div class="phones">${list.map(([k, c]) => `<figure><img src="${img(chunks[k].chunks[0])}" alt="${esc(c)}"><figcaption>${esc(c)}</figcaption></figure>`).join('')}</div>`;
const digits = (v) => String(v).split('').map((d) => `<i>${d}</i>`).join('');

const html = `<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Cross Crossing Medical Centre – Website Proposal</title>
<style>
  ${FONTS}
  @page { size: Letter; margin: 0.5in 0.6in 0.55in; }
  :root { --sign-950: #081a36; --sign-900: #0d2850; --sign-700: #1c4a8a; --sign-100: #e3ebf6; --bg: #f6f5f1; --surface-2: #eceef2; --ink: #121a2e; --ink-2: #39435a; --ink-3: #566078; --line: #dde1e8; --brass: #d6b06a; --brass-text: #7d5c1a; --pulse: #0b7a5e; --pulse-line: #36c79a; --ae: #c0271d; --ae-soft: #fdeceb; }
  * { box-sizing: border-box; }
  html, body { margin: 0; padding: 0; font-family: "Mulish", system-ui, sans-serif; color: var(--ink); font-size: 10.5pt; line-height: 1.45; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  h1, h2, h3 { font-family: "Lexend", system-ui, sans-serif; font-weight: 600; letter-spacing: -0.02em; color: var(--ink); margin: 0; line-height: 1.08; }
  h3 { font-weight: 500; font-size: 12pt; letter-spacing: -0.01em; }
  .page { page-break-after: always; break-after: page; height: 9.95in; display: flex; flex-direction: column; overflow: hidden; }
  .page:last-child { page-break-after: auto; }
  .eyebrow { font-size: 8pt; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; color: var(--sign-700); margin: 0 0 5px; }
  /* ward-sign label, as on the site */
  .sign { align-self: flex-start; display: inline-flex; font-size: 7.5pt; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; line-height: 1; margin: 0 0 12px; border-radius: 4px; overflow: hidden; }
  .sign span { display: inline-flex; align-items: center; padding: 6px 8px 5px; }
  .sign .c { background: var(--brass); color: var(--ink); font-family: "Lexend"; font-weight: 600; letter-spacing: .06em; }
  .sign .l { background: var(--sign-900); color: #fff; }
  .sign.dark .l { background: rgba(255,255,255,.12); box-shadow: inset 0 0 0 1px rgba(255,255,255,.25); }
  .pulse { display: block; width: 100%; height: 22px; color: var(--pulse-line); }
  /* cover and dividers: the site's stucco sign-blue band */
  .dark-page { background: var(--sign-900); color: #fff; border-radius: 16px; padding: 0.6in 0.6in 0.5in; position: relative; overflow: hidden; }
  .dark-page h1 { color: #fff; }
  .dark-page .pulse { position: absolute; left: 0; right: 0; bottom: 18px; }
  .cover { justify-content: space-between; background-image: linear-gradient(180deg, rgba(8,26,54,.55), rgba(8,26,54,.96) 60%), url("${img(path.join(ROOT, 'public/img/building-960.webp'))}"); background-size: cover; background-position: 50% 0; }
  .cover h1 { font-size: 36pt; margin: 14px 0 16px; max-width: 6.3in; }
  .cover .accent { color: var(--brass); }
  .cover .lead { color: rgba(255,255,255,.88); font-size: 13pt; max-width: 5.9in; margin: 0; }
  .cover .meta { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; border-top: 1px solid rgba(255,255,255,.2); padding-top: 16px; font-size: 9.5pt; color: rgba(255,255,255,.82); margin-bottom: 18px; }
  .cover .meta b { display: block; color: #fff; font-size: 8.5pt; letter-spacing: .14em; text-transform: uppercase; margin-bottom: 4px; }
  .brand { display: flex; align-items: center; gap: 11px; } .brand .n { display: block; font-family: "Lexend"; font-weight: 600; font-size: 16pt; color: #fff; line-height: 1; letter-spacing: -0.01em; } .brand .s { display: block; margin-top: 5px; font-size: 7pt; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; color: rgba(255,255,255,.72); }
  .mark { display: inline-flex; align-items: center; flex: none; background: #fff; border-radius: 5px; }
  .brand .ink { color: var(--ink); } .brand .s.ink { color: var(--ink-3); }
  .divider { justify-content: center; }
  .divider h1 { font-size: 36pt; margin: 6px 0 18px; } .divider p.intro { color: rgba(255,255,255,.88); font-size: 12.5pt; max-width: 6in; margin: 0; }
  .divider ol { color: rgba(255,255,255,.88); columns: 2; font-size: 10pt; margin: 26px 0 0; padding-left: 18px; } .divider li { break-inside: avoid; margin: 3px 0; }
  .divider .note { margin-top: 22px; font-size: 9pt; color: rgba(255,255,255,.68); max-width: 6in; }
  /* text pages */
  .prose h1 { font-size: 23pt; margin-bottom: 12px; }
  .prose h2 { font-size: 13pt; margin: 16px 0 6px; letter-spacing: -0.01em; }
  .prose p { margin: 0 0 8px; }
  .prose ul.plain { margin: 0 0 8px; padding-left: 16px; } .prose ul.plain li { margin: 2px 0; }
  .cols { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .card { border: 1px solid var(--line); border-radius: 12px; padding: 11px 13px; background: #fff; break-inside: avoid; }
  .card h3 { margin-bottom: 5px; }
  .card ul { margin: 0; padding-left: 15px; } .card li { margin: 2px 0; font-size: 9.6pt; }
  .evidence { border-left: 4px solid var(--brass); background: var(--bg); border-radius: 0 10px 10px 0; padding: 10px 14px 10px 30px; margin: 8px 0 10px; }
  .evidence li { margin: 3px 0; }
  .src { font-size: 8pt; color: var(--ink-3); }
  .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin: 12px 0 6px; }
  .stat { background: var(--sign-900); color: #fff; border-radius: 12px; padding: 12px 12px 11px; }
  .stat b { display: inline-flex; gap: 3px; font-family: "Lexend"; font-weight: 600; font-size: 20pt; line-height: 1; }
  .stat b i { font-style: normal; display: inline-block; min-width: .9em; text-align: center; padding: 3px 2px 2px; border-radius: 3px; background: rgba(255,255,255,.1); }
  .stat b i.hl { background: var(--brass); color: var(--ink); }
  .stat span { display: block; margin-top: 8px; font-size: 8.5pt; color: rgba(255,255,255,.8); line-height: 1.3; }
  table.feat { width: 100%; border-collapse: collapse; font-size: 9.5pt; }
  table.feat th, table.feat td { border-bottom: 1px solid var(--line); padding: 8px 8px; text-align: left; vertical-align: top; }
  table.feat th { background: var(--surface-2); font-size: 8pt; text-transform: uppercase; letter-spacing: .1em; color: var(--ink-3); }
  .pill-row { display: flex; flex-wrap: wrap; gap: 5px; } .pill { border: 1px solid #c6d4ea; background: var(--sign-100); color: var(--sign-900); border-radius: 999px; padding: 2px 9px; font-size: 8.5pt; font-weight: 700; }
  /* screenshot pages */
  .shot-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 12px; border-bottom: 2px solid var(--sign-900); padding-bottom: 6px; margin-bottom: 7px; }
  .shot-head h2 { font-size: 16pt; }
  .sub-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 12px; border-top: 1px solid var(--line); padding-top: 8px; margin: 6px 0 5px; } .sub-head h3 { font-size: 12.5pt; font-weight: 600; } .url { font-family: Menlo, Consolas, monospace; font-size: 8pt; color: var(--ink-3); margin: 0; white-space: nowrap; }
  .bullets { margin: 0 0 7px; padding-left: 16px; font-size: 9.3pt; } .bullets li { margin: 1px 0; } .bullets li::marker { color: var(--brass-text); }
  figure { margin: 0 0 8px; display: block; text-align: center; }
  figure img { display: block; margin: 0 auto; border: 1px solid var(--line); border-radius: 6px; }
  .cap { text-align: left; margin: 5px 0 0; font-size: 8.6pt; line-height: 1.35; color: var(--ink-2); border-left: 3px solid var(--brass); padding-left: 8px; }
  .cap .n { font-weight: 800; color: var(--ink-3); }
  .phones { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 12px; }
  .phones figure { margin: 0; }
  .phones img { width: 100%; border-radius: 22px; border: 7px solid var(--sign-950); }
  .phone-notes { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 14px; }
  .phone-notes div { background: var(--bg); border-radius: 10px; padding: 9px 12px; font-size: 9pt; color: var(--ink-2); }
  .phone-notes b { display: block; color: var(--ink); font-size: 9.5pt; margin-bottom: 2px; }
  .phones figcaption { text-align: center; font-size: 9pt; color: var(--ink-2); margin-top: 6px; font-weight: 700; }
  /* investment */
  .price { display: grid; grid-template-columns: 1.45fr 1fr; gap: 14px; align-items: stretch; margin: 6px 0 4px; }
  .price .big { background: var(--sign-900); color: #fff; border-radius: 14px; padding: 16px 18px; }
  .price .big .amt { white-space: nowrap; font-family: "Lexend"; font-weight: 600; font-size: 26pt; line-height: 1; color: #fff; } .price .big .amt small { font-size: 11pt; font-weight: 500; color: rgba(255,255,255,.78); }
  .price .big p { color: rgba(255,255,255,.85); margin: 8px 0 0; font-size: 9.6pt; }
  .price .year { border: 2px solid var(--brass); border-radius: 14px; padding: 14px 16px; background: #fbf5e8; }
  .price .year div { display: flex; justify-content: space-between; gap: 8px; padding: 4px 0; border-bottom: 1px dotted #d8bf8a; font-size: 10pt; } .price .year div:last-child { border: 0; }
  .price .year b { font-family: "Lexend"; font-weight: 500; }
  .terms li { margin: 3px 0; font-size: 9.6pt; }
  .sla { width: 100%; border-collapse: collapse; font-size: 9pt; margin-top: 4px; } .sla td, .sla th { border-bottom: 1px solid var(--line); padding: 4px 6px; text-align: left; } .sla th { font-size: 7.8pt; letter-spacing: .1em; text-transform: uppercase; color: var(--ink-3); background: var(--surface-2); }
  .weeks { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin: 6px 0 10px; }
  .week { border: 1px solid var(--line); border-radius: 12px; padding: 10px 12px; background: #fff; }
  .week b { display: inline-block; font-family: "Lexend"; font-weight: 500; font-size: 8.5pt; background: var(--brass); color: var(--ink); border-radius: 4px; padding: 3px 6px; margin-bottom: 5px; }
  .week p { margin: 0; font-size: 9.5pt; }
  footer.foot { margin-top: auto; padding-top: 6px; font-size: 7.8pt; color: #7a8396; display: flex; justify-content: space-between; border-top: 1px solid var(--line); align-items: center; } footer.foot .fl { display: inline-flex; align-items: center; gap: 6px; } footer.foot .mark { box-shadow: inset 0 0 0 1px var(--line); }
</style></head><body>

<section class="page dark-page cover">
  ${WORDMARK()}
  <div>
    ${sign('CCMC', 'Website proposal · ' + DATE, true)}
    <h1>A website that works <span class="accent">as hard as a 24-hour centre</span> does.</h1>
    <p class="lead">A complete rebuild of ccmctt.com: appointment requests, new-patient pre-registration, dialysis enquiries and job applications, each with a reference number, feeding a private staff desk for the front desk, medical records and HR.</p>
  </div>
  <div class="meta">
    <div><b>Prepared for</b>Cross Crossing Medical Centre<br>Oliver Avenue, Cross Crossing<br>San Fernando, Trinidad and Tobago</div>
    <div><b>Prepared by</b>Keron Lewis, Code Canvas Consultants Ltd<br>Port of Spain · codecanvastt.com<br>info@codecanvastt.com</div>
  </div>
  ${PULSE}
</section>

<section class="page prose">
  ${sign('01', 'Executive summary')}
  <h1>Why rebuild now</h1>
  <p>Cross Crossing Medical Centre is open 24 hours a day, 365 days a year, with an emergency room, a cardiac care unit, a dialysis unit, a laboratory, X-ray and surgical suites under one roof, and specialists across nine fields. Its website is a free Google Sites page, and it cannot take a single request. When we checked ccmctt.com on 26 and 27 October 2026:</p>
  <ul class="evidence">
    <li><b>There is no way to ask for anything online.</b> No appointment request, no registration and no message form: patients can only phone, fax or email.</li>
    <li><b>The "newpatient" page is empty.</b> It has a title and nothing else.</li>
    <li><b>Patient handouts have gone.</b> The blood pressure handout link now lands on an unrelated company's home page, and the diabetes and carbohydrate handouts can no longer be opened.</li>
    <li><b>Third-party content sits on the centre's pages,</b> including an embedded BMI calculator from another website that loads advertising code.</li>
  </ul>
  <p class="src">Sources: ccmctt.com (sites.google.com/site/ccmctt) and its linked pages, checked on 26 and 27 October 2026.</p>
  <p>This proposal replaces it with a site that matches the centre: clear department pages with the emergency route always visible; four request forms that each give the patient a reference number; and a staff desk where every request has an owner, a status and a call-back target, and where patients' ID and insurance cards are opened only by the records team, with every opening logged. A working demo is already built and can be shown live, on a laptop or a phone.</p>
  <div class="stat-grid">
    <div class="stat"><b>${digits(SCREEN_COUNT)}</b><span>screens designed, built and shown in this proposal</span></div>
    <div class="stat"><b><i>0</i><i class="hl">5</i></b><span>online forms, each issuing a reference number</span></div>
    <div class="stat"><b><i>0</i><i>4</i></b><span>staff roles, each seeing only its own requests</span></div>
    <div class="stat"><b>${digits(TESTS)}</b><span>automated tests run before every release</span></div>
  </div>
  <h2>What the centre gains</h2>
  <div class="cols">
    <div class="card"><h3>Patients and families</h3><ul><li>Ask for an appointment at 2 a.m. without waiting on the line</li><li>Register before the first visit, from a phone</li><li>Always one tap from the emergency room's number</li></ul></div>
    <div class="card"><h3>Front desk, records and HR</h3><ul><li>One inbox for every web request, split by team</li><li>Late call-backs flagged automatically</li><li>A record of who called each patient back, and when</li></ul></div>
  </div>
  ${foot()}
</section>

<section class="page prose">
  ${sign('02', 'At a glance')}
  <h1>What is included</h1>
  <table class="feat"><thead><tr><th style="width:20%">Area</th><th>Features</th></tr></thead><tbody>
    ${FEATURES.map(([a, f]) => `<tr><td><b>${esc(a)}</b></td><td><div class="pill-row">${f.map((x) => `<span class="pill">${esc(x)}</span>`).join('')}</div></td></tr>`).join('')}
  </tbody></table>
  <h2>How a request flows</h2>
  <p>A daughter asks for a cardiology appointment for her mother late on a Sunday, ticking Monday or Wednesday mornings. She gets a reference such as <b>AP-26-00087</b> on screen and by email; the email carries no medical details. On Monday the front desk sees the request at the top of the queue with a call-back time, calls with one tap, books the clinic in the centre's own diary and records the date. If nobody calls within two hours, the request turns red on every front-desk overview. Registrations go to the records team, who alone can open the ID and insurance card photos; job applications go to HR.</p>
  <h2>Content and imagery</h2>
  <p>Every service, clinic, phone number and description is taken from the centre's current website. Nothing is invented: no doctors' names, prices, accreditations, insurers or testimonials. The building, sign and reception photographs are the centre's own, from its current site; the clinical photographs are licensed from Wikimedia Commons, credited on the site, and ready to be replaced with your own. The requests, patients and staff shown in these screenshots are clearly marked demo data with fictitious names.</p>
  <h2>What the site deliberately does not do</h2>
  <p>It does not put test results online, does not book clinic slots on its own, and does not ask for medical history in a web form. Results are collected or given by phone; clinic times are confirmed by the appointments team; histories are taken in person.</p>
  ${foot()}
</section>

${SECTIONS.map((sec) => `
<section class="page dark-page divider">
  ${sign(sec.code, sec.eyebrow, true)}
  <h1>${esc(sec.title)}</h1>
  <p class="intro">${esc(sec.intro)}</p>
  <ol>${sec.screens.map((s) => `<li>${esc(s[1])}</li>`).join('')}</ol>
  <p class="note">Screens are from the working demo. Requests, patients, vacancies, staff names and figures are demo data.</p>
  ${PULSE}
</section>
${sectionPages(sec)}
`).join('')}

<section class="page">
  <header class="shot-head"><div><p class="eyebrow">Responsive design</p><h2>Built for phones first</h2></div><p class="url">390 × 844</p></header>
  <p style="margin:0 0 4px">Most patients and families will reach the centre from a phone, often in a hurry. Every page adapts to a small screen, and a bar with Call and Request appointment stays within thumb reach.</p>
  ${phones([['m-home', 'Home'], ['m-emergency', 'Accident and Emergency'], ['m-appointment', 'Appointment request']])}
  ${notes([['Thumb-sized buttons', 'Every button and choice is at least 44 pixels tall, and Call stays at the foot of the screen.'], ['Easy to read', '17-pixel body text, short lines and strong contrast in light and dark themes.'], ['Works without JavaScript', 'Every page and form still works on an old phone or a poor connection.']])}
  ${foot()}
</section>
<section class="page">
  <header class="shot-head"><div><p class="eyebrow">Responsive design · continued</p><h2>Registration and the staff desk on a phone</h2></div><p class="url">390 × 844</p></header>
  <p style="margin:0 0 4px">Patients can photograph their ID and insurance card straight from the form. Staff can check the queue and call a patient back from anywhere in the building.</p>
  ${phones([['m-registration', 'New patient registration'], ['m-admin-dashboard', 'Staff desk overview'], ['m-admin-request', 'Request, one-tap call']])}
  ${notes([['Camera upload', 'ID and insurance photos are taken in the form and stored privately.'], ['Late first', 'The overview opens on the requests that have waited too long for a call.'], ['One tap to reply', 'Call or WhatsApp the patient straight from the request.']])}
  ${foot()}
</section>

<section class="page prose">
  ${sign('04', 'Technology, hosting & privacy')}
  <h1>Built properly, hosted for you</h1>
  <div class="cols">
    <div class="card"><h3>Platform</h3><ul><li>Laravel 13 on PHP 8.3 with a MySQL database: open-source and widely supported, with no page builder lock-in</li><li>Tailwind CSS and Alpine.js; fonts served from your own site</li><li>No background servers needed; emails send directly</li><li>${TESTS} automated tests cover every form, every role and the document-access rules</li></ul></div>
    <div class="card"><h3>Patient privacy</h3><ul><li>Consent recorded with the time on every form, under the Data Protection Act, 2011</li><li>ID, insurance cards, referrals and CVs stored outside the public website</li><li>ID and insurance cards open for the records team only; every opening logged</li><li>Emails carry a reference number only, never health details</li><li>CSV exports carry contact and status columns only</li></ul></div>
    <div class="card"><h3>Speed and search</h3><ul><li>Responsive WebP photography in three sizes</li><li>XML sitemap and schema.org data for the centre and its vacancies</li><li>Old Google Site addresses redirect permanently to the new pages</li><li>Accessible: keyboard navigation, labelled forms, and status chips that pair an icon with text</li></ul></div>
    <div class="card"><h3>Ownership</h3><ul><li>Your content, photos, domain and patient data are always yours</li><li>Staff manage requests, vacancies, handouts and the site notice themselves</li><li>Hosting, backups, monitoring and updates are handled by Code Canvas under the monthly plan</li></ul></div>
  </div>
  <h2>Security</h2>
  <p>HTTPS throughout, security headers on every page, rate-limited and spam-trapped forms, login throttling, hashed passwords and individual staff accounts that can be switched off the day someone leaves.</p>
  ${foot()}
</section>

<section class="page prose">
  ${sign('05', 'Investment')}
  <h1>The US$1,000 a month plan</h1>
  <div class="price">
    <div class="big"><div class="amt">US$1,000 <small>per month</small></div><p><b>US$0 for design and development.</b> No setup fee and no deposit. Invoiced in US dollars. Billing starts at the end of the month in which the site launches, prorated for the days it was live; monthly invoices are due within 14 days.</p></div>
    <div class="year"><div><span>Year one</span><b>US$12,000</b></div><div><span>Or prepaid annually (10% off)</span><b>US$10,800</b></div><div><span>Build cost</span><b>US$0</b></div></div>
  </div>
  <div class="cols" style="margin-top:8px">
    <div class="card"><h3>Included every month</h3><ul>
      <li>The complete design and build shown in this proposal</li>
      <li>Managed hosting with CDN and SSL</li>
      <li>Daily backups plus a weekly off-site copy</li>
      <li>Security patches and software updates</li>
      <li>24/7 uptime monitoring</li>
      <li><b>Up to 10 hours a month</b> of content changes and small improvements</li>
      <li>Staff training</li>
      <li>Google Analytics, Search Console and a monthly summary</li>
      <li>Support by email, WhatsApp and phone, plus a quarterly review call</li>
      <li>A 30-day post-launch warranty</li>
    </ul></div>
    <div class="card"><h3>Terms</h3><ul class="terms">
      <li>No minimum term. 30 days' notice by email from either side.</li>
      <li>Price fixed for the first 24 months.</li>
      <li>Optional annual prepayment at 10% off: US$10,800 a year.</li>
      <li><b>Handover fee US$7,000, only if you leave.</b> It buys the website outright and moves it to hosting in the centre's name. It is waived if Code Canvas stops trading.</li>
      <li>Your content, domain and data are always yours.</li>
    </ul>
    <h3 style="margin-top:8px">Quoted separately, only with your approval</h3><ul>
      <li>Work beyond 10 hours in a month: US$50 an hour, or a fixed quote</li>
      <li>SMS or WhatsApp appointment reminders</li>
      <li>Integrations with a practice management, laboratory or billing system</li>
      <li>Online payments; paid advertising and SEO campaigns; professional photography</li>
    </ul></div>
  </div>
  <h2>Service levels</h2>
  <table class="sla"><thead><tr><th>Issue</th><th>Response</th><th>Fix target</th></tr></thead><tbody>
    <tr><td>Site down or forms not sending</td><td>1 hour, any day</td><td>4 hours</td></tr>
    <tr><td>Something on a page is broken</td><td>4 business hours</td><td>1 business day</td></tr>
    <tr><td>Content changes (text, photos, notices, vacancies)</td><td>Acknowledged in 1 business day</td><td>Done in 2 business days</td></tr>
  </tbody></table>
  ${foot()}
</section>

<section class="page prose">
  ${sign('06', 'Timeline')}
  <h1>Six weeks to launch</h1>
  <div class="weeks">
    <div class="week"><b>Week 1</b><p>Kick-off, brand assets and content: your logo files, photos and confirmation of every fact on the site.</p></div>
    <div class="week"><b>Week 2</b><p>Revision round 1. Forms, emails and staff roles configured with your real inboxes.</p></div>
    <div class="week"><b>Week 3</b><p>Content load: handouts, vacancies, clinic and department details, and the privacy notice after your legal review.</p></div>
    <div class="week"><b>Week 4</b><p>Revision round 2.</p></div>
    <div class="week"><b>Week 5</b><p>Formal testing with your front desk, records and HR staff on every form and screen.</p></div>
    <div class="week"><b>Week 6</b><p>Launch on HTTPS, redirects from the old addresses, Search Console, and staff training.</p></div>
  </div>
  <h2>What we need from the centre</h2>
  <ul class="plain">
    <li>Your logo as a vector file (the demo redraws the building mark from the current site, which is only 111 pixels wide).</li>
    <li>Photos of the building, departments and team, or time for a short photo session.</li>
    <li>Confirmation of clinic days, the dental suite's details, whether the unit takes visiting dialysis patients, and how results are collected.</li>
    <li>Your patient handouts as PDFs, and review of the privacy notice by your legal adviser.</li>
    <li>The staff who need accounts and their roles, and the inboxes for new-request and job-application alerts.</li>
    <li>Access to the ccmctt.com domain settings, and to your Google Business Profile and Facebook page if you would like them linked.</li>
  </ul>
  <h2>When billing starts</h2>
  <p>Not on signing. The build, both revision rounds, testing and the preview site cost nothing. Billing starts at the end of the month in which the site launches, prorated for the days it was live. Nothing goes live until you approve it in writing.</p>
  ${foot()}
</section>

<section class="page prose">
  ${sign('07', 'Next steps')}
  <h1>From proposal to launch</h1>
  <ol class="plain" style="padding-left:18px">
    <li style="margin:5px 0"><b>See the demo live.</b> We walk through the website and the staff desk together, on a laptop and a phone.</li>
    <li style="margin:5px 0"><b>Tell us what to change.</b> Pages, wording, roles or the request forms; revision round 1 opens straight away.</li>
    <li style="margin:5px 0"><b>Sign a one-page agreement</b> with the terms in this proposal: US$1,000 a month, month to month on 30 days' notice, US$0 build cost, and a US$7,000 handover fee only if you leave.</li>
    <li style="margin:5px 0"><b>Kick-off the same week</b>, with launch six weeks later.</li>
  </ol>
  <div class="card" style="margin-top:18px; max-width:4.6in">
    <h3>Contact</h3>
    <p style="margin:0">Keron Lewis, Director<br>Code Canvas Consultants Ltd, Port of Spain<br>codecanvastt.com<br><a href="mailto:info@codecanvastt.com">info@codecanvastt.com</a><br><a href="https://calendly.com/keronlewis/30min">Book a call: calendly.com/keronlewis/30min</a></p>
  </div>
  <div style="margin-top:auto; margin-bottom:12px">${WORDMARK(false)}</div>
  ${foot()}
</section>
</body></html>`;

fs.writeFileSync(OUT_HTML, html);
const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--no-sandbox', '--allow-file-access-from-files'] });
const page = await browser.newPage();
await page.goto('file://' + OUT_HTML, { waitUntil: 'networkidle0' });
await page.evaluate(() => document.fonts.ready);
await page.pdf({ path: OUT_PDF, format: 'Letter', printBackground: true, preferCSSPageSize: true, displayHeaderFooter: false });
await browser.close();
const mb = fs.statSync(OUT_PDF).size / 1024 / 1024;
console.log('PDF written:', OUT_PDF, Math.round(mb * 10) / 10 + ' MB');
if (mb > MAX_MB) {
  console.error(`The PDF is over ${MAX_MB} MB; lower the JPEG quality in capture.mjs.`);
  process.exit(1);
}

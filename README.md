# Cross Crossing Medical Centre

Website and staff desk for Cross Crossing Medical Centre (CCMC), the 24-hour private medical centre on Oliver Avenue, Cross Crossing, San Fernando, Trinidad and Tobago. It replaces the free Google Site at ccmctt.com.

## What it does

- **Public site.** Home, services and a page per department (Accident and Emergency, cardiac care, Renal Centre & Dialysis Unit, laboratory, X-ray and bone density, surgical suites, sleep and lung tests, vaccinations, dental), specialist clinics, patient handouts, health self-checks (BMI without JavaScript, plus links to diabetes and FRAX risk tests), careers with vacancies, about (with the centre's published articles), contact with map, privacy notice, photo credits and a site map. Mobile-first, light and dark themes, a phone action bar (Call, Request appointment) on every page, and every page and form works without JavaScript. Old Google Site addresses (`/newpatient`, `/facilities/dialysis`, `/site/ccmctt/…`) redirect to the new pages.
- **Accident and Emergency has no form, on purpose.** Every form says it is not for emergencies and points to the emergency room and 811.
- **Five forms, each with a reference number on screen and by email.** Confirmation emails carry the reference only, never health details.
  - Appointment request (`AP-26-00042`): clinic or test, been before, preferred days, time of day and earliest date, an optional referral letter, and who it is for. Nothing is booked online; the front desk calls back to agree a time.
  - New patient pre-registration (`PR-…`): patient details, contact (patient, parent or carer), emergency contact, the ID type to bring, and optional photos of the ID and insurance card.
  - Dialysis enquiry (`DI-…`): new, transferring or a family member asking, and sessions that suit. The visiting/holiday option only appears when `CCMC_DIALYSIS_VISITORS=true`.
  - Job application (`CV-…`): vacancy or kind of role, registration and availability, CV (PDF/Word) and up to three certificates.
  - Contact message (`EN-…`).

  Every form records Data Protection Act consent with a timestamp. All uploads go to the private disk (`storage/app/private/submissions/{id}/`), never the web root.
- **No results portal.** Lab results are never shown online or emailed; the lab page explains how patients collect them.
- **Staff desk** at `/admin`, with four roles:
  - **Administrator**: everything, except opening ID and insurance cards.
  - **Front desk & appointments**: appointment requests, dialysis enquiries and messages, plus the appointment sheet.
  - **Registration & medical records**: registrations, and the only role that can open ID and insurance card photos.
  - **Human resources**: job applications and vacancies.

  Every opening of any document (ID, insurance card, referral, CV, certificate) is written to `file_accesses` and to the request's timeline, and listed in the document log (admin and records). The overview leads with the one number each role must act on: requests not called back within their response time (2 hours for appointments and dialysis, 4 for messages, 24 for registrations, 3 days for applications). It also shows the week's figures, median time to first call, requests per day, a breakdown by type, top clinics, the call queue and the next three days' bookings. The inbox has type tabs, status/assignee/overdue filters, search and a CSV export without clinical details. Each request has one-tap call and WhatsApp, status, assignment, booked date and time, notes and a timeline. Also: the appointment sheet (14 days plus requests still waiting), vacancies, handouts (PDF upload or link), staff accounts and a site-wide notice.

## Requirements

PHP 8.3 or 8.4 with GD, Composer 2, Node 20+ for building assets, and SQLite locally or MySQL in production.

## Local setup

```sh
composer install
cp .env.example .env && php artisan key:generate
php artisan migrate --seeder=DemoSeeder   # demo staff, 3 vacancies, 11 handouts, ~118 requests over 30 days
npm install && npm run build
php artisan serve --port=8109
```

Demo logins all use the password `password`: `admin@ccmc.test`, `frontdesk@ccmc.test`, `frontdesk2@ccmc.test`, `records@ccmc.test` and `hr@ccmc.test`. Demo patients have fictitious names, and the demo ID and insurance cards are drawn images stamped "DEMO".

## Checks

```sh
php artisan test                 # every form, each role's access, document rules and logging
vendor/bin/phpstan analyse       # Larastan level 6, analysed as PHP 8.3
vendor/bin/pint --test
```

## Deploying

See [INSTALL-HOSTINGER.md](INSTALL-HOSTINGER.md). `scripts/package-hostinger.sh` builds `dist/ccmc-hostinger.zip`, which extracts straight into `public_html/`, with the app in `ccmc-app/`.

`npm run proposal` captures screenshots from the dev server on port 8109 (demo data) and builds the client proposal PDF in `dist/proposal/`.

## Before launch: confirm with the client

- **Phones, fax and email.** 868-652-4411 and 868-652-4412, fax 868-652-4413 and mail@ccmctt.com come from the Google Site's contact page and the UK FCDO list of medical providers (Nov 2021). Check that 652-4412 and the fax still work, and whether there is a WhatsApp number.
- **Clinic days and hours.** The centre is open 24/7 (its own welcome text), but clinic and test sessions are not published, so none are shown. The front desk agrees times by phone.
- **Physicians.** No doctors' names are used. Add them only if the centre supplies them with permission.
- **Dental.** Is Easy Smile Dental Centre still on site, and are 868-721-5846 and 868-382-5846 still its numbers?
- **Visiting / holiday dialysis.** Not mentioned anywhere CCMC publishes. Leave `CCMC_DIALYSIS_VISITORS=false` until the unit confirms it.
- **Insurers and payment.** Not shown. Add accepted insurers and payment methods only from the centre's own list.
- **Results.** How patients collect lab results (in person, by phone, from the doctor); the lab page wording is a placeholder for that answer.
- **ID types** accepted at registration (national ID, driver's permit, passport).
- **Notification inboxes** for new requests (`CCMC_NOTIFY_EMAIL`) and job applications (`CCMC_NOTIFY_HR_EMAIL`). The staff desk shows a reminder until they are set.
- **Handouts.** The Google Site's own PDFs are gone (the blood pressure link now lands on wellnessproposals.com's home page; the diabetes and carbohydrate files no longer open). The starter set links to NIH, MedlinePlus and PAHO pages. Ask for the centre's own PDFs.
- **Media page.** The article list in `config/ccmc.php` comes from the Google Site's Media page; check that the links still work and whether the centre wants it kept.
- **"Near Halliburton"** comes from the centre's welcome text. Check it is still a useful landmark.
- **Photos.** The building, signs, reception, lab coat and DEXA report are the centre's own, from the Google Site (low resolution). The clinical and San Fernando photos are Creative Commons images from Wikimedia Commons, credited on `/photo-credits`. Ask for high-resolution photos.
- **Logo.** The building mark is redrawn from the 111-pixel logo on the Google Site. Ask for the original artwork.
- **Domain.** ccmctt.com and www.ccmctt.com forward to sites.google.com/site/ccmctt. Get access to the DNS, keep the MX records, and retire the Google Site after launch.
- **Privacy notice**: a draft for the centre's legal adviser, under the Data Protection Act, 2011.

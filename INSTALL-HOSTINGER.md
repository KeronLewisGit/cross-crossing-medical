# Cross Crossing Medical Centre – Hostinger installation guide

Requirements: **PHP 8.3** (8.4 also works), a **MySQL database**, and SSH access if possible. Without SSH, use the zip and its one-time `setup.php` installer (Option A).

## Option A – upload the zip into public_html (fastest, no Git or SSH)

Run `scripts/package-hostinger.sh` locally. It builds `dist/ccmc-hostinger.zip`, which includes the production `vendor/` and built assets.

```
public_html/
├── index.php  .htaccess  robots.txt  favicon.svg  setup.php
├── build/                 compiled CSS, JS and fonts
├── img/                   site photography (WebP, three sizes each)
├── uploads/handouts/      patient handout PDFs added in the dashboard (scripts never run here)
└── ccmc-app/            the Laravel application (blocked from the web by its own .htaccess)
```

Before you start, do steps 1–4 of **Prepare hPanel** in Option B below (domain + SSL, PHP 8.3, MySQL database, mailbox).

1. In File Manager, empty `public_html/` (delete Hostinger's `default.php`), upload the zip to `public_html` and extract it there.
2. Copy `ccmc-app/.env.example` to `ccmc-app/.env`. Fill in the database, mail and `CCMC_*` values, and set `SETUP_TOKEN` to a long random string.
3. Open `https://www.ccmctt.com/setup.php?token=YOUR_TOKEN`. It generates the app key, migrates, creates the first staff account and deletes itself.
4. Remove `SETUP_TOKEN` from `.env`.

To update later, build a new zip, and upload and extract it over the old files. `ccmc-app/.env`, `ccmc-app/storage/` (patient documents, CVs, logs) and `uploads/` are not in the zip, so they are kept. Then visit `/setup.php?token=…` again if the release has new migrations (add a `SETUP_TOKEN` first; once a staff account exists the installer only migrates and never creates or resets accounts), or run `php artisan migrate --force` over SSH from `ccmc-app/`.

## Option B – Hostinger Git deployment (for ongoing development)

The whole repository is cloned straight into `public_html/`:

```
public_html/
├── .htaccess        forces HTTPS, rewrites every request into public/
├── .env             created by you on the server (never committed)
├── app/ bootstrap/ config/ database/ lang/ resources/ routes/ storage/ vendor/
└── public/          the only folder the web can reach (index.php, build/, robots.txt)
```

- The root `.htaccess` sends every request into `public/`, so `.env`, `storage/`, `vendor/` and `.git/` are never served.
- `composer.lock` is resolved for PHP 8.3 through `config.platform.php` in `composer.json`.
- `public/build/` holds the compiled CSS, JS and fonts. It is committed because the server has no Node, so run `npm run build` and commit the result after any CSS or JS change.
- Nothing needs a cron job or a queue worker: there are no scheduled tasks and mail is sent inline (`QUEUE_CONNECTION=sync`).

### 1. Prepare hPanel (one time)

1. **Domain and SSL.** `ccmctt.com` and `www.ccmctt.com` currently forward to a free Google Site (`sites.google.com/site/ccmctt`). Point the domain at the hosting plan instead (keep any existing MX records so `mail@ccmctt.com` keeps working), then go to hPanel → Security → SSL and install the free certificate. The `.htaccess` redirects every request to HTTPS, so the site will not load until the certificate is active.
2. **PHP version.** Go to hPanel → Advanced → PHP Configuration and choose **PHP 8.3** (8.4 also works). Leave the default extensions enabled. `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `tokenizer` and `gd` are required. Set `upload_max_filesize` and `post_max_size` to at least **20M** (forms accept ID photos and referral letters up to 8 MB each; a job application is at most a 5 MB CV plus three 4 MB certificates).
3. **Database.** Go to hPanel → Databases → MySQL Databases and create a database and a user. Write down the full names, which include the `u123456789_` prefix, and the password.
4. **Mailbox and SPF.** `ccmctt.com` mail is on Google Workspace (its MX records point at Google) and, as of October 2026, the domain publishes **no SPF record**, so mail from the website would land in spam. Ask the centre's Workspace admin for a sending mailbox such as `web@ccmctt.com` with an app password, and use `smtp.gmail.com`, port 587 (the defaults in `.env.example`). Then add the DNS TXT record `v=spf1 include:_spf.google.com ~all` and turn on DKIM in the Google Admin console. If you send through a Hostinger mailbox instead, set `MAIL_HOST=smtp.hostinger.com`, `MAIL_PORT=465`, `MAIL_SCHEME=smtps` and add `include:_spf.mail.hostinger.com` to the same SPF record. The site sends new-request alerts to staff and reference-number confirmations to patients. Patient emails never contain health details.
5. **SSH.** Go to hPanel → Advanced → SSH Access, enable it, and note the IP, port (usually `65002`) and username.

### 2. Connect the private GitHub repository

The repository (`YOUR-GITHUB-USER/cross-crossing-medical`) is private, so Hostinger needs a read-only deploy key.

1. Go to hPanel → Advanced → **GIT** and click **Generate SSH key**. Copy the public key.
2. On GitHub, go to the repository → Settings → Deploy keys → **Add deploy key**. Paste the key, name it "Hostinger", and leave *Allow write access* unchecked.
3. Hostinger only deploys into an **empty** directory. Open File Manager and delete everything in `public_html/`, including Hostinger's `default.php`.
4. Back in hPanel → GIT → Create a new repository, fill in:
   - **Repository:** `git@github.com:YOUR-GITHUB-USER/cross-crossing-medical.git` (the SSH address, not `https://`)
   - **Branch:** `master`
   - **Directory:** leave empty. An empty value deploys into `public_html/`.
5. Click **Create**, then **Deploy**. When `composer.json` is present, Hostinger runs `composer install` after it clones the repository.

### 3. First-time setup over SSH

```bash
ssh -p 65002 u123456789@YOUR_SERVER_IP
cd ~/domains/ccmctt.com/public_html

php -v                                   # must be 8.3+. If not, replace `php` below with /opt/alt/php83/usr/bin/php
ls vendor/autoload.php                   # if this is missing, Composer did not run: see the next line
composer install --no-dev --optimize-autoloader --no-interaction

cp deploy/env.production.example .env
nano .env                                # DB_*, MAIL_PASSWORD, CCMC_* values. Leave APP_KEY empty
chmod -R 775 storage bootstrap/cache
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --class=HandoutSeeder --force   # starter patient handouts (links to NIH, MedlinePlus and PAHO pages)
php artisan app:create-admin             # first administrator (prompts for name, email, password); add other staff in Staff desk → Staff
php artisan optimize
```

`SETUP_TOKEN` and the `ADMIN_*` lines in `.env` are only used by the zip installer (Option A). Leave them empty here.

Open `https://www.ccmctt.com` and sign in at `/login` to check the install.

### 4. Turn on automatic deploys (optional)

Go to hPanel → GIT → your repository → **Auto Deployment** and copy the webhook URL. On GitHub, go to Settings → Webhooks → **Add webhook**, paste the URL as the *Payload URL*, and keep the *push* event. Every push to `master` then deploys on its own.

### 5. Every later deploy

1. Locally: run `npm run build` if any CSS or JS changed, run the checks (`php artisan test`, `vendor/bin/phpstan analyse`, `vendor/bin/pint`), then commit and push to `master`.
2. Hostinger pulls the code, either through the webhook or when you click **Deploy** in hPanel → GIT. `.env`, `storage/` contents and `vendor/` are not tracked in Git, so a pull leaves them alone.
3. Over SSH:

   ```bash
   cd ~/domains/ccmctt.com/public_html
   composer install --no-dev --optimize-autoloader --no-interaction
   php artisan migrate --force
   php artisan optimize
   ```

   Do not skip `optimize`. The routes, config and views are cached, so new pages return 404 and new settings are ignored until you run it.

`optimize` also caches the configuration. After any later `.env` edit, run `php artisan optimize` again or the change is ignored.

### Troubleshooting

| Symptom | Fix |
|---|---|
| hPanel says the directory is not empty | Delete everything in `public_html/`, including hidden files, then deploy again. |
| "Permission denied (publickey)" during deploy | The deploy key is missing on GitHub, or the repository URL is the `https://` form. |
| 500 error with no message | Read `storage/logs/laravel-*.log`. Usual causes: no `.env`, empty `APP_KEY`, wrong `DB_*` values, or `storage/` not writable. |
| "Your Composer dependencies require a PHP version >= 8.3" | The website or SSH PHP is older than 8.3. Fix it in PHP Configuration, or run `/opt/alt/php83/usr/bin/php $(which composer) install --no-dev`. |
| Redirect loop or "too many redirects" | SSL is not active yet, or Cloudflare is in *Flexible* mode. Use *Full*. |
| Page loads without styling | `public/build/` was not committed. Run `npm run build` locally, commit, push and deploy again. |
| Emails never arrive | Check `MAIL_*`, `CCMC_NOTIFY_EMAIL` and `CCMC_NOTIFY_HR_EMAIL` in `.env`, run `php artisan optimize`, and check the mailbox's spam folder. The staff desk shows a reminder until the notification inboxes are set. |
| Uploads fail with "too large" | Raise `upload_max_filesize` and `post_max_size` to 20M in PHP Configuration. |

## Check after install

- `https://www.ccmctt.com/.env`, `/.git/config` and `/composer.json` must return 403 or 404. For Option A, check `/ccmc-app/` and `/ccmc-app/storage/app/private/submissions/` as well.
- `http://` must redirect to `https://`.
- From a phone, send an appointment request, a new patient registration with a small ID photo and insurance card, a dialysis enquiry, a job application with a PDF CV, and a contact message. Each should show a reference number (`AP-26-…`, `PR-…`, `DI-…`, `CV-…`, `EN-…`), email the sender, and email `CCMC_NOTIFY_EMAIL` (applications go to `CCMC_NOTIFY_HR_EMAIL`).
- Sign in as a **Registration & medical records** user and open the ID and insurance card from the registration. Then sign in as an administrator and confirm the same files show "Records team only" and cannot be opened. Check that both openings by the records user appear in Staff desk → Document log.
- Upload a handout PDF in Staff desk → Handouts and check it on `/patient-handouts`. Files are stored in `uploads/handouts/`, which never runs PHP.
- In Staff desk → Settings, add a site-wide notice if needed (for example a holiday change), and check it on the home page.
- Old Google Site addresses such as `/newpatient`, `/facilities/dialysis` and `/site/ccmctt/facilities` should redirect (301) to the new pages.
- Submit `/sitemap.xml` in Google Search Console.
- When the site replaces the live ccmctt.com, set `CCMC_PREVIEW=false`. On a temporary preview domain, set it to `true` so a banner shows and search engines skip it.
- The client zip leaves out `DemoSeeder`. For a pitch preview, build with `INCLUDE_DEMO=1 scripts/package-hostinger.sh` (makes `dist/ccmc-hostinger-preview.zip`); with `APP_ENV=production` the demo seeder only runs while `CCMC_PREVIEW=true`. Change the demo passwords straight after seeding.
- Leave `CCMC_DIALYSIS_VISITORS=false` until the centre confirms it takes visiting or holiday dialysis patients.

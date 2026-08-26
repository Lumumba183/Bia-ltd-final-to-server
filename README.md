# BIA Limited Website — bia.co.ke (cPanel Deployment Package)

This is the final, server-ready version of the BIA Limited corporate website,
built for standard cPanel/Apache hosting. No build step, Node.js, or database
is required.

## Contents

- `index.html`, `about.html`, `services.html`, `sectors.html`,
  `projects.html`, `contact.html` — site pages
- `success.html` — contact form thank-you page
- `404.html` — custom not-found page (wired via `.htaccess`)
- `send-mail.php` — contact form handler (sends enquiries by email)
- `assets/` — CSS, JavaScript, images and PDF documents
- `.htaccess` — HTTPS enforcement, custom 404, caching, compression
- `robots.txt`, `sitemap.xml` — SEO files (already set to bia.co.ke)

## Upload instructions (cPanel)

1. Log into cPanel and open **File Manager**.
2. Go to **`public_html`**.
3. **Back up first:** select all existing files, click **Compress** to make a
   zip backup, and download it (this preserves the old site).
4. Delete or move the old site files out of `public_html`.
5. Upload `BIA-website-cpanel.zip` into `public_html`, then **Extract** it.
6. Make sure the extracted files sit directly inside `public_html`
   (i.e. `public_html/index.html`, not `public_html/BIA-website/index.html`).
   Also confirm `.htaccess` was extracted — enable **Show Hidden Files** in
   File Manager settings to see it.

## Contact form email

The form posts to `send-mail.php`, which delivers enquiries to:

    info@bia.co.ke

To change the recipient, edit line 10 (`$to`) in `send-mail.php`.
For best deliverability, create a mailbox `no-reply@bia.co.ke` in cPanel
(cPanel → Email Accounts) — it is used as the sender address.

## Requirements

- Apache with `.htaccess` enabled (standard on cPanel)
- PHP 7.4+ (standard on cPanel; the handler uses only `mail()`)
- SSL certificate (already active on bia.co.ke via Let's Encrypt)

## Verifying after upload

- https://bia.co.ke/ loads the homepage
- All navigation links open their pages (no 404s)
- https://bia.co.ke/about.html shows the leadership team and associates
- Submitting the contact form lands on the success page and the enquiry
  arrives in the `info@bia.co.ke` mailbox
- A deliberately wrong URL (e.g. https://bia.co.ke/nope) shows the custom 404

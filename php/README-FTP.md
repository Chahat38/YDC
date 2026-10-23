# YDC KUST — PHP build (FTP ready)

This folder is a complete, ready-to-upload PHP version of the YDC KUST website.
**It does not use a database.** Nothing here connects to MySQL, creates tables,
or touches any existing database on the hosting account.

```
php/
├── index.php                  Home
├── about.php, vision-mission.php, objectives.php, team.php, mous.php
├── education.php, employment.php, engagement.php, environment.php
├── short-courses.php, internships.php, digital-youth-hub.php,
│   pmydp.php, youth-council.php
├── upcoming-events.php, past-events.php, magazines.php
├── opportunities.php, register.php, contact.php, 404.php
├── includes/                  header, footer, helpers, config
├── assets/                    css, js, images (same files as the HTML site)
├── data/                      saved form submissions (protected)
├── .htaccess                  Apache/LiteSpeed settings
└── README-FTP.md              this file
```

---

## 1. Upload with FTP

1. Connect with FileZilla (or your host's file manager) using the FTP details
   from your hosting panel.
2. Decide **where** the site should live:
   - **Recommended first upload — subfolder:** create `public_html/ydc/` and
     upload the **contents of this `php` folder** into it. Test at
     `https://yourdomain.com/ydc/`.
   - **Live site:** upload the same contents directly into `public_html/`.

> Upload the *contents* of `php/`, not the `php/` folder itself.

### Important — do not break the existing site
Your hosting account already has files. Before replacing anything:

1. In FileZilla, **download a backup** of the current `public_html`
   (right-click → Download), or
2. Upload to a **subfolder first** (`/ydc/`) and check everything there.

If the root already has its own `index.php`, uploading this site's `index.php`
will replace it. Rename the old one to `index.php.old` first, or keep this site
in a subfolder.

### Permissions
- Folders: `755`
- Files: `644`
- The `data/` folder needs to be writable: `755` is usually enough;
  if submissions fail, use `775`.

---

## 2. First-time settings

Open `includes/config.php` and change only what you need:

| Setting | Meaning |
|---|---|
| `site.email` | Office email shown in footer and used for notifications |
| `site.phone` / `phone_href` | Phone number and `tel:` link |
| `site.year` | Copyright year |
| `forms.store` | `true` = save each submission to `data/*.jsonl` |
| `forms.mail` | `true` = also email a copy with PHP `mail()` |
| `forms.to` | Where those emails go |

`forms.mail` is **OFF** by default because many shared hosts block `mail()`
or mark it as spam. Turn it on, send one test message, then decide.

---

## 3. Where do form submissions go?

Registration and contact forms are handled by PHP on the server.

- Default: each submission is appended to
  `data/submissions-YYYY-MM.jsonl` (one JSON object per line).
- `data/` is blocked from web access by `data/.htaccess`.
  If your host is **Nginx**, `.htaccess` is ignored — move `data/` outside the
  web root, or ask the host to deny that folder.
- To read the submissions, download the file over FTP and open it in any text
  editor, or paste a line into a JSON viewer.

Every submission gets a reference like `YDC-4F9A2C` which is shown to the user.

---

## 4. Adding a database later

When you get database access:

1. Fill in the `db` block at the bottom of `includes/config.php`.
2. Create `includes/db.php` with a PDO connection.
3. Change `ydc_store()` in `includes/functions.php` to insert into your table.

Do this **in addition to** file storage, and only create a **new** table
(for example `ydc_submissions`). Never run migrations or `DROP` on tables that
already exist on the account.

---

## 5. Editing content

The header and footer now live in one place:

- `includes/header.php` — logo, navigation, `<head>` tags
- `includes/footer.php` — footer columns, social links, scripts
- `includes/config.php` — site name, email, phone, form settings

A page body is plain HTML inside `index.php`, `team.php`, etc. Edit the text
between the `require header` line and the `require footer` line.

Internal links use `.php` (for example `team.php`). Keep that pattern.

---

## 6. Troubleshooting

| Problem | Fix |
|---|---|
| 500 Internal Server Error | Rename `.htaccess` to `.htaccess.off`. The site works without it. |
| Blank page | Enable PHP errors temporarily: add `ini_set('display_errors', '1');` at the top of `index.php`, then remove it. |
| Forms say "could not save" | Make `data/` writable (`755` or `775`), or set `forms.mail` to `true`. |
| Styles missing | Upload the `assets/` folder; check `assets/css/style.css` loads. |
| Wrong links after upload | Upload the **contents** of `php/` — do not nest an extra `php/` folder. |

---

## 7. Notes

- NAVTTC spelling is used throughout (formerly written NAVTAC).
- The old `ypdc.html` page has been removed from the HTML site as well.
- The HTML site in the parent folder is unchanged and still works; this PHP
  build is a separate deployable copy.

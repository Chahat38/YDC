# YDC KUST — website

YDC KUST ki website do versions mein hai. Dono ka content same hai.

| Version | Folder | Kab use karein |
|---|---|---|
| **PHP (FTP ke liye)** | `php/` | Hosting par upload karne ke liye. Forms server par handle hoti hain. **Database ki zaroorat nahi.** |
| **Static HTML** | root | GitHub Pages / offline preview ke liye. Forms JS se submit hoti hain. |

---

## PHP version — FTP upload

`php/` folder poora deploy-ready hai:

- `index.php` (Home) + 21 more `.php` pages
- `includes/header.php` aur `includes/footer.php` — navigation/footer sirf ek jagah
- `includes/config.php` — site name, email, phone, form settings
- `assets/` — wahi CSS, JS aur images
- `data/` — form submissions (web se blocked)
- `.htaccess` — Apache/LiteSpeed settings

**Upload kaise karein:** `php/` folder ke *contents* apne hosting ke
`public_html/` mein (ya pehle test ke liye `public_html/ydc/` mein) upload karein.
Poori guide: `php/README-FTP.md`.

### Database
Site **abhi database use nahi karti**. MySQL connect nahi hota, koi table
create/alter nahi hota — hosting par maujooda database files bilkul safe rahengi.

Form submissions default taur par `php/data/submissions-YYYY-MM.jsonl` mein
save hoti hain (web access blocked). Baad mein database milne par
`php/includes/config.php` ke neeche diya gaya `db` block bhar kar
`ydc_store()` ko PDO insert par switch kar sakte hain.

### Forms ki settings
`php/includes/config.php`:

```php
'forms' => [
    'store' => true,                 // data/*.jsonl mein save karein
    'mail'  => array('contact'),     // contact form ydc@kust.edu.pk par email
    'to'    => 'ydc@kust.edu.pk',
],
```

- **Contact form** ki har submission `ydc@kust.edu.pk` par email hoti hai (PHP `mail()`).
  Backup ke taur par har submission `data/` mein bhi save hoti hai.
- **Registration form** mein **CV upload** hai — PDF/DOC/DOCX, max 5 MB.
  File `data/cvs/` mein random naam se save hoti hai (web access blocked).
- Agar hosting `mail()` block karti hai to email nahi jayegi, lekin message
  `data/` mein save rahega — FTP se download kar sakte hain.

---

## Static HTML version

`index.html` double-click karke dekh sakte hain. Koi build tool nahi chahiye.
Forms ke liye `assets/js/config.js` mein `formEndpoint` set karein
(Google Sheet / Formspree) — details `setup/google-sheet-form.gs` mein.

---

## Structure (dono versions)

- Home: `index`
- About YDC: `about`, `vision-mission`, `objectives`, `team`, `mous`
- 4 E's: `education`, `employment`, `engagement`, `environment`
- Programs: `short-courses`, `internships`, `digital-youth-hub`, `pmydp`, `youth-council`
- Events: `upcoming-events`, `past-events`, `magazines`
- Forms: `register`, `contact`

## Update kaise karein

- **PHP version:** text `index.php` / `team.php` etc. mein edit karein.
  Header/footer `php/includes/` mein hain.
- Naya event: relevant page mein `<article class="ev">` copy karein aur
  `register.php` ki dropdown list mein option add karein.
- Social links: `php/includes/footer.php` (PHP) ya har page ka footer (HTML).
- Team photos: `assets/img/` mein photo daal kar `person` card badlein.

## Notes

- NAVTTC ka spelling har jagah **NAVTTC** hai.
- `ypdc` page hata diya gaya hai.

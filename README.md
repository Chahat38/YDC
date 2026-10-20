# YDC KUST — naya website

Static website (HTML + CSS + JS). Koi build tool nahi chahiye. `index.html` double-click karke dekh sakte hain.

## Structure
- `index.html` Home
- About YDC: `about`, `vision-mission`, `objectives`, `team`, `mous`
- 4 E's: `education`, `employment`, `engagement`, `environment`
- Programs: `short-courses`, `internships`, `digital-youth-hub`, `youth-council`
- Events: `upcoming-events`, `past-events`, `magazines`
- Forms: `register.html` (events, courses, internships, council, hub) aur `contact.html`
- `assets/css/style.css` (colours sab upar `:root` mein), `assets/js/main.js`, `assets/js/config.js`, `assets/img/`

Gallery ab navbar mein nahi hai. Photos Home, About (office) aur Past events page par hain, click karne par bari ho jati hain.

## Forms ko submit kaise karwana hai (zaroori)
Website static hai, isliye form data ko kisi jagah bhejna parta hai. Do tareeqe:
1. **Google Sheet (recommended, free):** `setup/google-sheet-form.gs` mein steps likhe hain. Jo URL milay use `assets/js/config.js` ke `formEndpoint` mein daal dein. Har registration sheet mein row ban jati hai aur ydc@kust.edu.pk par email bhi aati hai.
2. **Formspree / Web3Forms:** unka endpoint URL `formEndpoint` mein daal dein.

`formEndpoint` khali ho to form submit par email app khulti hai (ydc@kust.edu.pk ke liye pre-filled mail). Yeh sirf backup hai.

## Update kaise karein
- Naya event: `upcoming-events.html` mein ek `<article class="ev">` copy karke badal dein, aur `register.html` ki dropdown mein option add karein.
- Social media links: har page ke footer mein `href="#"` ko apne links se badlein.
- E-Magazine PDFs: `magazines.html` mein `href="#"` ki jagah PDF ka link.
- Team photos: `assets/img/` mein nayi photo daal kar `team.html` mein `person` card badlein.

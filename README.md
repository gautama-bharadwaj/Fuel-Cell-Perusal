# Fuel-Cell-Perusal

Source code for the Fuel Cell Perusal website.

Contributors:

Gautama Bharadwaj
Harikrishnan U
Navedya Ojha
Venu Bhargav

Website link - https://gautama-bharadwaj.github.io/Fuel-Cell-Perusal/
(originally http://fuelcellperusal.com/)

## How the site runs now

The site was first built with PHP. It now runs as a static site on GitHub
Pages, with the same pages and look:

- The model calculations run in the browser (`js/models.js`). They are ports
  of the PHP code and give exactly the same results.
- The PDF report is drawn in the browser with [jsPDF](https://github.com/parallax/jsPDF),
  using the same layout as the original FPDF reports (`js/fpdf.js`, `js/reports.js`).
- The visitor counter uses the free [Abacus](https://abacus.jasoncameron.dev) counting
  service and carries on from the old count of 199 (`js/counter.js`).
- Bootstrap, jQuery, Popper, Font Awesome and jsPDF are kept in `vendor/`.
  The charts still come from Google Charts.

The original PHP version is kept, unchanged, on the
[`php-original`](https://github.com/gautama-bharadwaj/Fuel-Cell-Perusal/tree/php-original)
branch. `tools/` has the scripts used for the conversion.

To try it locally, serve the folder with any static web server, for example
`python3 -m http.server`, and open http://localhost:8000/.

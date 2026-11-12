# Conversion tools

The site originally ran on PHP. Its PHP version is kept, unchanged, on the
[`php-original`](https://github.com/gautama-bharadwaj/Fuel-Cell-Perusal/tree/php-original)
branch. These scripts are how the static GitHub Pages version on `master` was
made from it. They're kept for the record; you don't need them to run the site.

| Script | What it did |
| --- | --- |
| `make-results-page.py` | Turned each PHP results page (`model1.php`, `model2.php`, `Archives/v*.php`) into a static `*-results.html` page. The calculation block is replaced by `document.write(FCP.echo)`, and the chart data now comes from `js/models.js`. |
| `make-static.py` | Site-wide changes: `index.php` to `index.html`, local copies of Bootstrap, jQuery and Font Awesome in `vendor/`, relative links for a project site, forms pointing at the results pages, and the visitor counter. |
| `translate-reports.php` | Translates the FPDF report scripts (`pdfer.php`, `pdfermodel1.php`, `Archives/v*.report.php`) into `js/reports.js`. |

The model equations in `js/models.js` were ported by hand and checked against
the PHP pages: the same inputs give exactly the same tables and chart data.

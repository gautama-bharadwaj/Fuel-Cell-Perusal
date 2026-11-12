#!/usr/bin/env python3
"""Site-wide changes so the pages work as a static GitHub Pages project site."""
import re, sys, os, glob
root = sys.argv[1]
os.chdir(root)

# index.php -> index.html: drop the PHP visitor counter, the page itself is static
idx = open('index.php').read()
idx = re.sub(r'\s*<\?php.*?\?>', '', idx, flags=re.S)
idx = idx.replace('<body class="body-index">', '<body class="body-index" data-count-visit="true">', 1)
assert 'data-count-visit' in idx
open('index.html', 'w').write(idx)

pages = sorted(glob.glob('*.html') + glob.glob('Archives/*.html'))
for p in pages:
    pre = '../' if p.startswith('Archives/') else ''
    h = open(p).read()
    # third-party libraries are kept in vendor/ so the site keeps working if a CDN goes away
    h = h.replace('https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', pre + 'vendor/bootstrap.min.css')
    h = h.replace('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', pre + 'vendor/jquery.min.js')
    h = h.replace('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', pre + 'vendor/popper.min.js')
    h = h.replace('https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', pre + 'vendor/bootstrap.min.js')
    # the old Font Awesome kit no longer loads; use the free Font Awesome 5 files instead
    h = h.replace("<script src='https://kit.fontawesome.com/a076d05399.js'></script>",
                  '<link rel="stylesheet" href="%svendor/fontawesome/css/all.min.css">' % pre)
    # root-relative paths break on a project site (username.github.io/Fuel-Cell-Perusal/)
    h = re.sub(r'((?:src|href|action)\s*=\s*")/(?!/)', lambda m: m.group(1) + pre, h)
    if pre:
        h = h.replace('href="../Archives/', 'href="').replace('action="../Archives/', 'action="')
    # input forms now go to the static results pages
    h = re.sub(r'<form action="(model\d|v[\d.]+)\.php" method="post">', r'<form action="\1-results.html" method="get">', h)
    # the home page is no longer PHP
    h = h.replace('href="index.php"', 'href="index.html"').replace('href="../index.php"', 'href="../index.html"')
    # visitor counter: the number was a PNG drawn by PHP; now it is filled in by js/counter.js
    h = h.replace('<img src="Counter_images/counter.png" border="0" alt="web counter">',
                  '<span class="visitor-count">199</span>')
    h = h.replace('<img src="../Counter_images/counter.png" border="0" alt="web counter">',
                  '<span class="visitor-count">199</span>')
    if 'visitor-count' in h and 'js/counter.js' not in h:
        h = h.replace('</body>', '<script src="%sjs/counter.js"></script>\n</body>' % pre, 1)
    open(p, 'w').write(h)

for css in ['styles.css', 'Archives/styles.css']:
    c = open(css).read()
    c = c.replace("url('/Images/", "url('" + ('../' if '/' in css else '') + "Images/")
    open(css, 'w').write(c)
print('\n'.join(pages))

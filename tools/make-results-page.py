#!/usr/bin/env python3
"""Turn an original PHP results page into a static page that runs the model in JS."""
import re, sys
src, dst, model, prefix = sys.argv[1], sys.argv[2], sys.argv[3], sys.argv[4]
h = open(src).read()
# 1. session bootstrap at the top of the file
h = h[h.index('<!DOCTYPE html>'):]
# 2. the main calculation block -> print the same HTML from JS while the page parses
pos = h.index('round(')
start = h.rindex('<?php', 0, pos)
end = h.index('?>', pos) + 2
h = h[:start] + '<script type="text/javascript">document.write(FCP.echo);</script>' + h[end:]
# 3. echoed input values
h, n = re.subn(r'''value\s*=\s*"<\?php echo \$\w+\s*=\s*\$_POST\[["'](\w+)["']\]\s*\?>"''',
               r'value="" data-fcp-param="\1"', h)
assert n > 0
# 4. chart data
h = re.sub(r'<\?php echo json_encode\(\$(\w+)\);\s*\?>', r'FCP.vars.\1', h)
# 5. charts were uploaded to the server for the PDF; keep them in memory instead
h = re.sub(r'\$\.post\("(\w+)\.php",\s*\{postapp: app1\},\s*function\(\)\s*\{\s*\}\);',
           r'FCP.charts["\1"] = app1;', h)
# 6. the "Download PDF report" form posted to a PHP report page
h, n = re.subn(r'<form ([^>]*?)action="[^"]*(?:report|pdfer\w*)\.php"([^>]*)>',
               lambda m: '<form id="report-form" ' + re.sub(r'\s*(target|method)="[^"]*"', '', m.group(1) + m.group(2)).strip() + '>', h)
h = re.sub(r'<form id="report-form"\s+>', '<form id="report-form">', h)
assert n == 1, n
# 7. load the model code right after the Google Charts loader
loader = re.search(r'<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>', h)
inject = ('\n\t\t<script type="text/javascript" src="%sjs/models.js"></script>'
          '\n\t\t<script type="text/javascript" src="%sjs/results.js"></script>'
          '\n\t\t<script type="text/javascript" src="%svendor/jspdf.umd.min.js"></script>'
          '\n\t\t<script type="text/javascript" src="%sjs/fpdf.js"></script>'
          '\n\t\t<script type="text/javascript" src="%sjs/reports.js"></script>'
          '\n\t\t<script type="text/javascript" src="%sjs/report.js"></script>'
          '\n\t\t<script type="text/javascript">FCPRun("%s");</script>') % ((prefix,) * 6 + (model,))
h = h[:loader.end()] + inject + h[loader.end():]
left = re.findall(r'<\?php.*?\?>', h, re.S)
assert not left, left
open(dst, 'w').write(h)

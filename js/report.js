/*
 * Fuel Cell Perusal - "Download PDF report" button.
 *
 * Collects what the PHP report script got from the form ($_POST) and the
 * session ($_SESSION), loads the logo and the chart images, and runs the
 * translated report (js/reports.js) through the FPDF work-alike (js/fpdf.js).
 */
(function () {
  'use strict';

  function loadImage(src) {
    return new Promise(function (resolve) {
      var img = new Image();
      img.onload = function () {
        var c = document.createElement('canvas');
        c.width = img.naturalWidth; c.height = img.naturalHeight;
        c.getContext('2d').drawImage(img, 0, 0);
        var data;
        try { data = c.toDataURL('image/png'); } catch (e) { data = src; }
        resolve({ data: data, width: img.naturalWidth, height: img.naturalHeight, format: 'PNG' });
      };
      img.onerror = function () { resolve(null); };
      img.src = src;
    });
  }

  function pad(n) { return (n < 10 ? '0' : '') + n; }
  function phpDate(fmt, t) {
    var d = t === undefined ? new Date() : new Date(t * 1000);
    return fmt.replace(/Y/g, d.getFullYear()).replace(/m/g, pad(d.getMonth() + 1)).replace(/d/g, pad(d.getDate()));
  }
  function phpTime() { return Math.floor(Date.now() / 1000); }

  window.FCPReport = function (FCP) {
    var report = window.FCPReports[FCP.model];
    if (!report) return;
    // Open the tab now, while we still have the click; the PDF opens in it when ready
    // (the original form also opened the report in a new tab).
    var win = window.open('', '_blank');
    if (win) {
      win.document.write('<title>Fuel cell perusal</title><p style="font-family:sans-serif">Preparing your report&hellip;</p>');
    }

    var POST = {};
    var form = document.getElementById('report-form');
    Array.prototype.forEach.call(form.querySelectorAll('input[name]'), function (el) { POST[el.name] = el.value; });
    var SESSION = {};
    Object.keys(report.session).forEach(function (key) { SESSION[key] = FCP.vars[report.session[key]]; });

    var wanted = { 'Images/fcp_logo.png': 'Images/fcp_logo.png' };
    Object.keys(FCP.charts).forEach(function (id) { wanted['Chart_images/' + id + '.png'] = FCP.charts[id]; });
    var names = Object.keys(wanted);
    Promise.all(names.map(function (n) { return loadImage(wanted[n]); })).then(function (imgs) {
      var assets = {};
      names.forEach(function (n, k) { if (imgs[k]) assets[n] = imgs[k]; });
      var pdf = new window.FPDF(assets);
      report.run(pdf, POST, SESSION, phpDate, phpTime);
      var doc = pdf.finished ? pdf.doc : pdf.Output();
      doc.setProperties({ title: 'Fuel Cell Perusal report' });
      var name = 'fuel-cell-perusal-' + FCP.model + '-report.pdf';
      if (win && !win.closed) {
        win.location.href = doc.output('bloburl', { filename: name });
      } else {
        doc.save(name);
      }
    }).catch(function (e) {
      if (win && !win.closed) win.close();
      window.alert('Sorry, the PDF report could not be created: ' + e.message);
    });
  };
})();

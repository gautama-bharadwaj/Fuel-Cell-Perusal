/*
 * Fuel Cell Perusal - a small FPDF work-alike on top of jsPDF.
 *
 * The original PDF reports were written with FPDF (PHP). This implements the
 * FPDF methods those reports use, with FPDF's defaults (A4, mm, 1 cm margins,
 * 2 cm automatic page break, 1 mm cell padding), so the translated report
 * code in js/reports.js lays out the page the same way.
 */
(function () {
  'use strict';

  var FAMILIES = { arial: 'helvetica', helvetica: 'helvetica', times: 'times', courier: 'courier' };
  var STYLES = { '': 'normal', B: 'bold', I: 'italic', BI: 'bolditalic', IB: 'bolditalic' };

  function FPDF(assets) {
    var JsPDF = window.jspdf.jsPDF;
    this.doc = new JsPDF({ unit: 'mm', format: 'a4', orientation: 'portrait' });
    this.assets = assets || {};
    this.k = 72 / 25.4;
    this.w = 210; this.h = 297;
    this.lMargin = 10; this.tMargin = 10; this.rMargin = 10; this.bMargin = 20;
    this.cMargin = 10 / 10;
    this.PageBreakTrigger = this.h - this.bMargin;
    this.AutoPageBreak = true;
    this.x = this.lMargin; this.y = this.tMargin;
    this.lasth = 0;
    this.page = 0;
    this.FontFamily = ''; this.FontStyle = ''; this.FontSizePt = 12; this.FontSize = 12 / this.k;
    this.LineWidth = 0.567 / this.k;
    this.FillColor = [0, 0, 0]; this.DrawColor = [0, 0, 0];
    this.InHeader = false; this.InFooter = false;
    this.AliasNbPagesStr = null;
    this.Header = function () {};
    this.Footer = function () {};
  }

  var P = FPDF.prototype;

  P.str = function (txt) {
    if (txt === undefined || txt === null || txt === false) return '';
    if (txt === true) return '1';
    if (typeof txt === 'number') return window.FCPModels.str(txt);
    return String(txt);
  };

  P.AliasNbPages = function (alias) { this.AliasNbPagesStr = alias || '{nb}'; };
  P.PageNo = function () { return this.page; };

  P.AddPage = function () {
    var family = this.FontFamily, style = this.FontStyle, size = this.FontSizePt;
    var lw = this.LineWidth, dc = this.DrawColor.slice(), fc = this.FillColor.slice();
    if (this.page > 0) {
      this.InFooter = true; this.Footer(); this.InFooter = false;
      this.doc.addPage('a4', 'portrait');
    }
    this.page++;
    this.x = this.lMargin; this.y = this.tMargin;
    this.FontFamily = '';
    this.doc.setLineWidth(lw);
    this.doc.setDrawColor(dc[0], dc[1], dc[2]);
    this.doc.setFillColor(fc[0], fc[1], fc[2]);
    if (family) this.SetFont(family, style, size);
    this.InHeader = true; this.Header(); this.InHeader = false;
    // FPDF restores the line width, colours and font after the header
    this.LineWidth = lw; this.doc.setLineWidth(lw);
    this.DrawColor = dc; this.doc.setDrawColor(dc[0], dc[1], dc[2]);
    this.FillColor = fc; this.doc.setFillColor(fc[0], fc[1], fc[2]);
    if (family) this.SetFont(family, style, size);
  };

  P.SetFont = function (family, style, size) {
    family = String(family || this.FontFamily).toLowerCase();
    style = String(style || '').toUpperCase();
    if (!size) size = this.FontSizePt;
    this.FontFamily = family; this.FontStyle = style;
    this.FontSizePt = size; this.FontSize = size / this.k;
    this.doc.setFont(FAMILIES[family] || 'helvetica', STYLES[style] || 'normal');
    this.doc.setFontSize(size);
  };

  P.SetFillColor = function (r, g, b) {
    if (g === undefined) { g = r; b = r; }
    this.FillColor = [r, g, b];
    this.doc.setFillColor(r, g, b);
  };

  P.SetDrawColor = function (r, g, b) {
    if (g === undefined) { g = r; b = r; }
    this.DrawColor = [r, g, b];
    this.doc.setDrawColor(r, g, b);
  };

  P.SetLineWidth = function (w) { this.LineWidth = w; this.doc.setLineWidth(w); };

  P.GetStringWidth = function (s) { return this.doc.getTextWidth(this.str(s)); };

  P.Cell = function (w, h, txt, border, ln, align, fill) {
    h = h || 0; txt = this.str(txt); border = border || 0; ln = ln || 0;
    align = typeof align === 'string' ? align.toUpperCase() : '';
    fill = !!fill;
    if (this.y + h > this.PageBreakTrigger && !this.InHeader && !this.InFooter && this.AutoPageBreak) {
      var x0 = this.x;
      this.AddPage();
      this.x = x0;
    }
    if (!w) w = this.w - this.rMargin - this.x;
    var doc = this.doc;
    if (fill || border === 1 || border === '1') {
      var op = fill ? (border === 1 || border === '1' ? 'FD' : 'F') : 'S';
      // PDF text uses the fill colour slot, so set the fill colour again before
      // each filled cell (FPDF does the same with its ColorFlag).
      if (fill) doc.setFillColor(this.FillColor[0], this.FillColor[1], this.FillColor[2]);
      doc.rect(this.x, this.y, w, h, op);
    }
    if (typeof border === 'string' && border !== '1' && border !== '0') {
      var x = this.x, y = this.y;
      if (border.indexOf('L') !== -1) doc.line(x, y, x, y + h);
      if (border.indexOf('T') !== -1) doc.line(x, y, x + w, y);
      if (border.indexOf('R') !== -1) doc.line(x + w, y, x + w, y + h);
      if (border.indexOf('B') !== -1) doc.line(x, y + h, x + w, y + h);
    }
    if (txt !== '') {
      var sw = this.GetStringWidth(txt), dx;
      if (align === 'R') dx = w - this.cMargin - sw;
      else if (align === 'C') dx = (w - sw) / 2;
      else dx = this.cMargin;
      doc.text(txt, this.x + dx, this.y + 0.5 * h + 0.3 * this.FontSize);
    }
    this.lasth = h;
    if (ln > 0) {
      this.y += h;
      if (ln === 1) this.x = this.lMargin;
    } else {
      this.x += w;
    }
  };

  P.Ln = function (h) {
    this.x = this.lMargin;
    this.y += (h === undefined || h === null) ? this.lasth : h;
  };

  P.Text = function (x, y, txt) { this.doc.text(this.str(txt), x, y); };
  P.Line = function (x1, y1, x2, y2) { this.doc.line(x1, y1, x2, y2); };
  P.Rect = function (x, y, w, h, style) {
    this.doc.setFillColor(this.FillColor[0], this.FillColor[1], this.FillColor[2]);
    var op = style === 'F' ? 'F' : (style === 'FD' || style === 'DF') ? 'FD' : 'S';
    this.doc.rect(x, y, w, h, op);
  };

  P.SetX = function (x) { this.x = x >= 0 ? x : this.w + x; };
  P.SetY = function (y) { this.x = this.lMargin; this.y = y >= 0 ? y : this.h + y; };
  P.SetXY = function (x, y) { this.SetY(y); this.SetX(x); };
  P.GetX = function () { return this.x; };
  P.GetY = function () { return this.y; };

  P.Image = function (file, x, y, w, h) {
    var img = this.assets[file];
    if (!img) return; // e.g. a chart that could not be drawn
    w = w || 0; h = h || 0;
    if (!w && !h) { w = img.width * 25.4 / 96; h = img.height * 25.4 / 96; }
    if (!w) w = h * img.width / img.height;
    if (!h) h = w * img.height / img.width;
    if (y === undefined || y === null) {
      if (this.y + h > this.PageBreakTrigger && !this.InHeader && !this.InFooter && this.AutoPageBreak) {
        var x2 = this.x; this.AddPage(); this.x = x2;
      }
      y = this.y; this.y += h;
    }
    if (x === undefined || x === null) x = this.x;
    this.doc.addImage(img.data, img.format || 'PNG', x, y, w, h);
  };

  // Finish the document (last footer, page count) and return the jsPDF object.
  P.Output = function () {
    if (this.page === 0) this.AddPage();
    this.InFooter = true; this.Footer(); this.InFooter = false;
    if (this.AliasNbPagesStr) this.doc.putTotalPages(this.AliasNbPagesStr);
    this.finished = true;
    return this.doc;
  };

  window.FPDF = FPDF;
})();

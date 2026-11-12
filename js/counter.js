/*
 * Fuel Cell Perusal - visitor counter.
 *
 * The original site kept the count in counter.txt and drew it as an image with
 * PHP. GitHub Pages can't run PHP, so the count is kept by Abacus, a free
 * counting service (https://abacus.jasoncameron.dev). The home page adds one
 * visit, like index.php did; the other pages only show the current number.
 * The old site had reached 199 visits, so counting continues from there.
 */
(function () {
  'use strict';
  var START = 199;
  var URL = 'https://abacus.jasoncameron.dev/';
  var KEY = 'fuel-cell-perusal/visitors';

  function show(n) {
    var els = document.querySelectorAll('.visitor-count');
    Array.prototype.forEach.call(els, function (el) { el.textContent = String(n); });
  }

  function run() {
    show(START);
    var isHome = document.body && document.body.getAttribute('data-count-visit') === 'true';
    var counted = false;
    try { counted = sessionStorage.getItem('fcp-counted') === '1'; } catch (e) { /* ignore */ }
    var action = isHome && !counted ? 'hit/' : 'get/';
    fetch(URL + action + KEY)
      .then(function (r) { return r.ok ? r.json() : null; })
      .then(function (d) {
        if (d && typeof d.value === 'number') {
          if (action === 'hit/') { try { sessionStorage.setItem('fcp-counted', '1'); } catch (e) { /* ignore */ } }
          show(START + d.value);
        }
      })
      .catch(function () { /* keep showing the last known number */ });
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', run);
  else run();
})();

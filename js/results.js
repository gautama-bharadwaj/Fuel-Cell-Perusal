/*
 * Fuel Cell Perusal - results pages.
 *
 * On the original site the input forms posted to PHP pages that ran the model
 * on the server. Here the form sends its values in the URL instead, and this
 * script runs the same model in the browser (see js/models.js).
 */
(function () {
  'use strict';

  window.FCPRun = function (model) {
    var params = new URLSearchParams(window.location.search);
    if (!window.location.search) {
      // Opened without any values: go back to the input form for this model.
      window.location.replace(window.location.pathname.replace(/-results\.html$/, '.html'));
    }
    var inputs = {};
    params.forEach(function (value, key) { inputs[key] = value; });

    var out = window.FCPModels.models[model](inputs);
    window.FCP = { model: model, inputs: inputs, echo: out.echo, vars: out.vars, charts: {} };

    document.addEventListener('DOMContentLoaded', function () {
      // Show the values that were entered, as the PHP page did.
      var fields = document.querySelectorAll('input[data-fcp-param]');
      Array.prototype.forEach.call(fields, function (el) {
        var v = inputs[el.getAttribute('data-fcp-param')];
        el.value = v === undefined ? '' : v;
      });
      var form = document.getElementById('report-form');
      if (form) {
        form.addEventListener('submit', function (e) {
          e.preventDefault();
          if (window.FCPReport) window.FCPReport(window.FCP);
        });
      }
    });
  };
})();

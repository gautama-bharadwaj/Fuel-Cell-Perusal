/*
 * Fuel Cell Perusal - simulation models.
 *
 * Direct ports of the calculations that originally ran in PHP on the server
 * (model1.php, model2.php and the versions under Archives/). The original PHP
 * is kept on the `php-original` branch of this repository.
 *
 * Every model returns:
 *   echo - the exact HTML the PHP page printed (Nernst voltage + results table)
 *   vars - the PHP variables the page's chart script and PDF report used
 * Equations, loop bounds and rounding are unchanged so results match the
 * original site digit for digit.
 */
(function (root) {
  'use strict';

  var log = Math.log, exp = Math.exp, pow = Math.pow, sqrt = Math.sqrt;

  // PHP's round($x, $precision): round half away from zero, with PHP's pre-rounding.
  function phpRound(value, precision) {
    if (!isFinite(value)) return value;
    var m = pow(10, precision);
    var scaled = Number((Math.abs(value) * m).toPrecision(15));
    var r = Math.round(scaled) / m;
    return value < 0 ? -r : r;
  }

  // How PHP prints a number with echo / string concatenation (precision=14).
  function str(value) {
    if (value === undefined || value === null) return '';
    if (typeof value !== 'number') return String(value);
    if (isNaN(value)) return 'NAN';
    if (value === Infinity) return 'INF';
    if (value === -Infinity) return '-INF';
    if (value === 0) return Object.is(value, -0) ? '-0' : '0';
    var s = value.toPrecision(14);
    var e = Math.floor(Math.log10(Math.abs(Number(s))));
    if (e < -4 || e >= 15) {
      var parts = Number(s).toExponential().split('e');
      var mant = parts[0];
      if (mant.indexOf('.') === -1) mant += '.0';
      var ex = parseInt(parts[1], 10);
      return mant + 'E' + (ex < 0 ? '-' : '+') + Math.abs(ex);
    }
    return String(Number(s));
  }

  function round5(arr, n) {
    for (var b = 0; b < n; b++) arr[b] = phpRound(arr[b], 5);
  }

  function rows(cols, from, to) {
    var h = '';
    for (var b = from; b <= to; b++) {
      h += '<tr class="table-indent">';
      for (var c = 0; c < cols.length; c++) h += '<td>' + str(cols[c][b]) + '</td>';
      h += '</tr>';
    }
    return h;
  }

  function num(p, names) {
    var o = {};
    names.forEach(function (n) { o[n] = p[n] === undefined || p[n] === null || p[n] === '' ? 0 : Number(p[n]); });
    return o;
  }

  // ---------------------------------------------------------------- model 1
  // Semi-empirical model from polarisation curve data (v1.1.1, current).
  function model1(p) {
    var v = num(p, ['R', 'F', 'z', 'T', 'No', 'V1', 'Vmin', 'Vnom', 'Imax', 'Inom', 'Eoc', 'PH2', 'PO2']);
    var R = v.R, F = v.F, z = v.z, T = v.T, No = v.No, V1 = v.V1, Vmin = v.Vmin, Vnom = v.Vnom,
      Imax = v.Imax, Inom = v.Inom, Eoc = v.Eoc, PH2 = v.PH2, PO2 = v.PO2;

    var Enernst = (1.229 + (T - 298.15) * (-44.43 / (192970)) + (R * T * log(PH2 * PO2) / (192970))) * No;
    var NA = (((V1 - Vnom) * (Imax - 1)) - ((V1 - Vmin) * (Inom - 1))) / ((log(Inom) * (Imax - 1)) - log(Imax) * (Inom - 1));
    var Rohmic = (V1 - Vnom - NA * log(Inom)) / (Inom - 1);
    var i0 = exp((V1 - Eoc + Rohmic) / NA);
    var echo = 'The calculated Nernst voltage is : ' + str(Enernst) + ' V<br>';
    var nact = [], nohm = [], nconc = [], Vfuel = [], i = [], Power = [];
    var j = 0;
    for (var cur = 1; cur <= Imax; cur += 1) {
      i[j] = cur;
      nact[j] = NA * log(cur / i0);
      nohm[j] = cur * Rohmic;
      nconc[j] = -(R * T * log(1 - (i[j] - 0.000000000001) / Imax) / (z * F)) * No;
      Vfuel[j] = Enernst - nact[j] - nohm[j] - nconc[j];
      Power[j] = Vfuel[j] * i[j] / 1000;
      j += 1;
    }
    var s = j - 1;
    [i, nact, nohm, nconc, Vfuel, Power].forEach(function (a) { round5(a, j); });
    echo += '<table class="my-special-table" border="4" bordercolor=white align="center">' +
      '<tr style="font-weight: 700;">' +
      '<th> Fuel Cell Current: </th><th> Activation Loss: </th><th> Ohmic Loss: </th>' +
      '<th> Concentration Loss: </th><th> Fuel Cell Voltage: </th><th> Power: </th></tr>' +
      rows([i, nact, nohm, nconc, Vfuel, Power], 0, j - 1) + '</table>';
    return { echo: echo, vars: { j: j, s: s, i: i, nact: nact, nohm: nohm, nconc: nconc, Vfuel: Vfuel, Power: Power,
      Enernst: Enernst, NA: NA, Rohmic: Rohmic, i0: i0, No: No } };
  }

  // ------------------------------------------------------------- model 1.0.1
  function model101(p) {
    var v = num(p, ['R', 'F', 'z', 'T', 'alpha', 'V1', 'Vmin', 'Vnom', 'Imax', 'Inom', 'Eoc', 'PH2', 'PO2', 'A']);
    var R = v.R, F = v.F, z = v.z, T = v.T, alpha = v.alpha, V1 = v.V1, Vmin = v.Vmin, Vnom = v.Vnom,
      Imax = v.Imax, Inom = v.Inom, Eoc = v.Eoc, PH2 = v.PH2, PO2 = v.PO2, A = v.A;

    var Enernst = 1.229 + (T - 298.15) * (-44.43 / (192970)) + (R * T * log(PH2 * PO2) / (192970));
    var gibbs = -Eoc * z * F - 1;
    gibbs = -1 * gibbs;
    var NA = (((V1 - Vnom) * (Imax - 1)) - ((V1 - Vmin) * (Inom - 1))) / ((log(Inom) * (Imax - 1)) - log(Imax) * (Inom - 1));
    var Rohmic = (V1 - Vnom - NA * log(Inom)) / (Inom - 1);
    var i0 = (R / (z * F) * (1 / Rohmic)) * A;
    var echo = 'The calculated Nernst voltage is : ' + str(Enernst) + ' V<br>';
    var nact = [], nohm = [], nconc = [], Vfuel = [], i = [];
    var j = 0;
    for (var cur = 0.05; cur < 1; cur += 0.05) {
      i[j] = cur;
      nact[j] = (R * T * log(i[j] / i0)) / (z * alpha * F);
      nohm[j] = cur * Rohmic;
      nconc[j] = 2.11 * exp(-5) * exp(0.08 * cur);
      Vfuel[j] = Enernst - nact[j] - nohm[j] - nconc[j];
      j += 1;
    }
    var s = j - 1;
    [i, nact, nohm, nconc, Vfuel].forEach(function (a) { round5(a, j); });
    // The original loop ran one row past the data (b <= j), printing an empty last row.
    echo += '<table class="my-special-table" border="4" bordercolor=white align="center">' +
      '<tr style="font-weight: 700;">' +
      '<th> Fuel Cell Current: </th><th> Activation Loss: </th><th> Ohmic Loss: </th>' +
      '<th> Concentration Loss: </th><th> Fuel Cell Voltage: </th></tr>' +
      rows([i, nact, nohm, nconc, Vfuel], 0, j) + '</table>';
    return { echo: echo, vars: { j: j, s: s, i: i, nact: nact, nohm: nohm, nconc: nconc, Vfuel: Vfuel,
      Enernst: Enernst, NA: NA, Rohmic: Rohmic, i0: i0, gibbs: gibbs } };
  }

  // ---------------------------------------------------------------- model 2
  // Mechanistic model with membrane resistance (v2.2.1, current).
  function model2(p) {
    var v = num(p, ['R', 'F', 'z', 'T', 'alpha', 'il', 'L_mem', 'Area', 'PH2', 'PO2']);
    var R = v.R, F = v.F, z = v.z, T = v.T, alpha = v.alpha, il = v.il, L_mem = v.L_mem, Area = v.Area,
      PH2 = v.PH2, PO2 = v.PO2;

    var Enernst = 1.229 + (T - 298.15) * (-44.43 / (z * F)) + (R * T * log(PH2 * PO2) / (z * F));
    var echo = 'The calculated Nernst voltage is : ' + str(Enernst) + ' V <br>';
    var i0 = il / 1000;
    var nact = [], nohm = [], nconc = [], Vfuel = [], Power = [], i = [], r_m = [], R_ionic = [];
    var j = 0;
    for (var cur = 0.05; cur < il; cur += 0.05) {
      i[j] = cur;
      r_m[j] = (181.6 * (1 + 0.03 * (i[j] / Area) + 0.062 * pow((T / 303), 2) * pow((i[j] / Area), 2.5))) /
        (22 - 0.634 - 3 * (i[j] / Area)) * exp(4.18 * ((T - 303) / T));
      R_ionic[j] = (r_m[j] * L_mem) / Area;
      nact[j] = R * T * log(i[j] / i0) / (z * alpha * F);
      nohm[j] = i[j] * R_ionic[j];
      nconc[j] = -R * T * log(1 - (i[j] - 0.000000000001) / il) / (z * F);
      Vfuel[j] = Enernst - nact[j] - nohm[j] - nconc[j];
      Power[j] = Vfuel[j] * i[j];
      j += 1;
    }
    [i, nact, nohm, nconc, Vfuel, Power].forEach(function (a) { round5(a, j); });
    echo += table2([i, nact, nohm, nconc, Vfuel, Power], j);
    return { echo: echo, vars: { j: j, s: j - 1, i: i, nact: nact, nohm: nohm, nconc: nconc, Vfuel: Vfuel, Power: Power,
      Enernst: Enernst, L_mem: L_mem, Area: Area } };
  }

  function table2(cols, j) {
    return '<table class="my-special-table" border="4" bordercolor="white"  align="center">' +
      '<tr><th> Fuel Cell Current: </th><th> Activation Loss: </th><th> Ohmic Loss: </th>' +
      '<th> Concentration Loss: </th><th> Fuel Cell Voltage: </th><th> Fuel Cell Power:  </th></tr>' +
      rows(cols, 0, j - 1) + '</table>';
  }

  // ------------------------------------------------------------- model 2.0.1
  function model201(p) {
    var v = num(p, ['R', 'F', 'z', 'T', 'alpha', 'i0', 'il', 'Rohmic', 'PH2', 'PO2']);
    var R = v.R, F = v.F, z = v.z, T = v.T, alpha = v.alpha, i0 = v.i0, il = v.il, Rohmic = v.Rohmic,
      PH2 = v.PH2, PO2 = v.PO2;

    var Enernst = 1.229 + (T - 298.15) * (-44.43 / (z * F)) + (R * T * log(PH2 * PO2) / (z * F));
    var echo = 'The calculated Nernst voltage is : ' + str(Enernst) + ' V <br>';
    var nact = [], nohm = [], nconc = [], Vfuel = [], Power = [], i = [];
    var j = 0;
    for (var cur = 0.05; cur < il - 0.05; cur += 0.05) {
      i[j] = cur;
      nact[j] = R * T * log(i[j] / i0) / (z * alpha * F);
      nohm[j] = i[j] * Rohmic;
      nconc[j] = R * T * log(il / (il - i[j])) / (z * F);
      Vfuel[j] = Enernst - nact[j] - nohm[j] - nconc[j];
      Power[j] = Vfuel[j] * i[j];
      j += 1;
    }
    [i, nact, nohm, nconc, Vfuel, Power].forEach(function (a) { round5(a, j); });
    echo += table2([i, nact, nohm, nconc, Vfuel, Power], j);
    return { echo: echo, vars: { j: j, s: j - 1, i: i, nact: nact, nohm: nohm, nconc: nconc, Vfuel: Vfuel, Power: Power,
      Enernst: Enernst } };
  }

  // ------------------------------------------------------------- model 2.1.1
  function model211(p) {
    var v = num(p, ['Temp', 'fuel_rate', 'P_anode', 'P_cathode', 'R_ohm']);
    var Temp = v.Temp, fuel_rate = v.fuel_rate, P_anode = v.P_anode, P_cathode = v.P_cathode, R_ohm = v.R_ohm;
    var K = 1000, F = 96485, R = 8.314, n = 2, kc = 1, del = 0.01, deff = 0.01;
    var P_O2 = P_cathode;
    var ifc = [], Vfc = [], eff = [], Pfc = [], A = [], V_conc = [], V_act = [], V_ohmic = [], alpha = [],
      fuel_util = [], P_H2 = [], Cb = [], iL = [], i0 = [], En = [], Eoc = [];
    var a = 0;
    for (var i = 0.25; i <= 4; i += 0.25) {
      ifc[a] = i;
      fuel_util[a] = (60000 * R * Temp * ifc[a]) / (n * F * P_anode * (fuel_rate) * 0.9995);
      P_H2[a] = P_anode * (1 - (fuel_util[a] / 100));
      Cb[a] = P_H2[a] / 22400;
      iL[a] = (n * F * deff * Cb[a]) / del;
      i0[a] = iL[a] / K;
      En[a] = 1.229 + (Temp - 298) * (-44.43 / (n * F)) + (R * Temp * log(P_H2[a] * sqrt(P_O2))) / (n * F);
      Eoc[a] = kc * En[a];
      V_conc[a] = -R * Temp * log(1 - ifc[a] / iL[a]) / (n * F);
      V_ohmic[a] = ifc[a] * R_ohm;
      alpha[a] = log(ifc[a] / i0[a]);
      A[a] = R * Temp / (alpha[a] * F * n);
      V_act[a] = A[a] * log(ifc[a] / i0[a]);
      Vfc[a] = Eoc[a] - (V_conc[a] + V_ohmic[a] + V_act[a]);
      Pfc[a] = Vfc[a] * ifc[a];
      eff[a] = (0.675 * Vfc[a] * fuel_util[a]) * 100;
      a = a + 1;
    }
    [ifc, V_act, V_ohmic, V_conc, Vfc, Pfc].forEach(function (x) { round5(x, a); });
    var echo = '<table class="my-special-table" border="4" bordercolor=white align="center">' +
      '<tr style="font-weight: 700;">' +
      '<th> Fuel Cell Current: </th><th> Activation Loss: </th><th> Ohmic Loss: </th>' +
      '<th> Concentration Loss: </th><th> Fuel Cell Voltage: </th><th> Fuel Cell Power:  </th></tr>' +
      rows([ifc, V_act, V_ohmic, V_conc, Vfc, Pfc], 0, 15) + '</table>';
    return { echo: echo, vars: { a: a, s: 15, ifc: ifc, V_act: V_act, V_ohmic: V_ohmic, V_conc: V_conc, Vfc: Vfc, Pfc: Pfc,
      eff: eff, fuel_util: fuel_util, P_H2: P_H2, Cb: Cb, iL: iL, i0: i0, En: En, Eoc: Eoc, alpha: alpha,
      Temp: Temp, F: F, R: R, fuel_rate: fuel_rate, P_anode: P_anode, P_cathode: P_cathode, R_ohm: R_ohm } };
  }

  var api = {
    models: { model1: model1, model2: model2, 'v1.0.1': model101, 'v1.1.1': model1,
      'v2.0.1': model201, 'v2.1.1': model211, 'v2.2.1': model2 },
    phpRound: phpRound, str: str
  };
  if (typeof module !== 'undefined' && module.exports) module.exports = api;
  else root.FCPModels = api;
})(this);

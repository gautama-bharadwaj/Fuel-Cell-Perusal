# Fuel-Cell-Perusal

Source code for the Fuel Cell Perusal website: https://fuelcellperusal.com/

Fuel Cell Perusal is a website about fuel cells, a clean and renewable source of energy. It lets you simulate a
proton exchange membrane fuel cell (PEMFC) in your browser and see how its operating conditions affect its performance.

> **About this archive:** Fuel Cell Perusal was built in 2020 as an engineering project by the team listed below.
> It is kept online here as an archive of that work. The simulator still works as it did then, but the site is no
> longer being developed.

## What the simulator does

You enter the fuel cell's parameters, and the site calculates:

- the **Nernst (open-circuit) voltage**
- the three voltage losses at each current:
  - **activation loss**, the energy needed to get the reactions going
  - **ohmic loss**, caused by the resistance of the membrane and cell
  - **concentration loss**, which occurs as the cell nears its limiting current
- the resulting **cell voltage** (the polarization curve) and **power output**

The results are shown as a table and as charts. You can also download a PDF report with your inputs, the results
table and the charts.

There are two models:

| Model | Latest version | What you enter | Use it for |
| --- | --- | --- | --- |
| **Model 1: with polarization curve** | v1.1.1 | Points read off the manufacturer's polarization curve (V1, Vmin, Vnom, Imax, Inom, Eoc), plus temperature, number of cells and gas partial pressures | Analysing the losses of a real cell or stack from its datasheet |
| **Model 2: without polarization curve** | v2.2.1 | General parameters: temperature, charge transfer coefficient, limiting current density, membrane thickness, active cell area and gas partial pressures | Exploring a single cell without a datasheet. Membrane (ionic) resistance is calculated from the inputs. |

Earlier versions (v1.0.1, v2.0.1 and v2.1.1) still work and can be opened from the **Archives** page, together with
the Excel versions of the models. The **Fuel cell fundamentals** and **Model descriptions** pages explain the
background and the two models.

## Contributors

Gautama Bharadwaj
Harikrishnan U
Navedya Ojha
Venu Bhargav

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

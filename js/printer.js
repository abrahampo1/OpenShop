const { PosPrinter } = require("@electron/remote").require(
  "electron-pos-printer"
);
const { webContents } = require("electron");
const path = require("path");
const { json } = require("stream/consumers");
console.log(
  require("@electron/remote").getCurrentWindow().webContents.getPrinters()
);

function PrecioSinIVA(precio, iva) {
  return parseFloat((precio / (1 + iva / 100)).toFixed(2));
}

function IVA(precio, iva) {
  return parseFloat((precio - PrecioSinIVA(precio, iva)).toFixed(2));
}
const options = {
  preview: true, // Preview in window or print
  silent: true,
  width: "300px", //  width of content body
  margin: "0 0 0 0", // margin of content body
  copies: 1, // Number of copies to print
  printerName: "BIXOLON SRP-350II", // printerName: string, check with webContent.getPrinters()
  timeOutPerLine: 400,
  pageSize: { height: 301000, width: 71000 }, // page size
};
let tasas_labels = ["A", "B", "C", "D", "E"];
let tasas_selected_labels = {};

let data = [
  {
    type: "text",
    value: `
    
<style>
table tr td:first-child, table th:first-child {
  text-align: left;
}
hr { display: block; height: 3px;
  border: 0; border-top: 2px solid rgb(70, 70, 70);
  margin: 1em 0; padding: 0; }

table tr td:last-child,
table th:last-child {
  text-align: right;
}

table tr, table tbody {
  border: none;
}

body {
  padding: 0px;
  box-sizing: border-box;
}

.font {
  padding: 0;
  margin: 0;
  font-size: 15px;
}

.tachado {
  text-decoration: line-through;
}

* {
  font-family: sans-serif !important;
  font-size: 15px;
}


</style>
    `,
  },
  {
    type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table
    value: "Mundo Pirata Park",
    style: `text-align:center; font-family: sans-serif; margin-bottom: 15px`,
    css: {
      "font-weight": "700",
      "font-size": "25px",
      "font-family": "sans-serif",
    },
  },
];

function print() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  let total = 0;
  let subtotal = 0;
  let items = [];
  let impuestos = {};
  let impuestos_brutos = {};

  cart.items.forEach((item) => {
    items.push({
      type: "text",
      value: "<hr>",
      style: ` margin-bottom: 10px; color: gray`,
    });
    if (!tasas_selected_labels[item.iva]) {
      tasas_selected_labels[item.iva] =
        tasas_labels[Object.values(tasas_selected_labels).length];
    }
    items.push({
      type: "table",
      tableHeader: [
        item.nombre + " x " + item.cantidad,
        (item.cantidad * parseFloat(item.precio)).toFixed(2) +
          " € " +
          tasas_selected_labels[item.iva],
      ],
      // tableBody: [
      //   ["Precio Estándar", "<span class='tachado'>11,00 €</span>"],
      //   ["Con Descuento (AGAFAN 10 %)", "9,90 €"],
      // ],
      tableHeaderStyle:
        "font-weight: 700; font-size: 15px; font-family: sans-serif;",
      tableBodyStyle:
        "font-weight: 500; border:none; font-size: 15px; font-family: sans-serif; ",
    });
    let precio = parseFloat(
      (item.cantidad * parseFloat(item.precio)).toFixed(2)
    );
    total += precio;
    if (!impuestos[item.iva]) {
      impuestos[item.iva] = 0;
    }
    if (!impuestos_brutos[item.iva]) {
      impuestos_brutos[item.iva] = 0;
    }
    impuestos[item.iva] += IVA(parseFloat(precio), parseFloat(item.iva));
    impuestos_brutos[item.iva] += parseFloat(precio);
    subtotal += PrecioSinIVA(parseFloat(precio), parseFloat(item.iva));
  });

  total = total.toFixed(2);
  data.push({
    type: "text",
    value: total + " €",
    style: `text-align:center; font-family: sans-serif;`,
    css: {
      "font-weight": "700",
      "font-size": "38px",
      "font-family": "sans-serif",
      "margin-bottom": "20px",
    },
  });
  items.forEach((element) => {
    data.push(element);
  });

  let subtotales = [["Subtotal", subtotal.toFixed(2) + " €"]];
  Object.entries(impuestos).forEach(([key, value]) => {
    subtotales.push([
      `Impuesto (${key} %)`,
      parseFloat(value).toFixed(2) + " €",
    ]);
  });
  let tasas = [["Tasa de IVA", "Neto", "IVA", "Bruto"]];
  Object.entries(impuestos_brutos).forEach(([key, value]) => {
    tasas.push([
      `${tasas_selected_labels[key]} (${key} %)`,
      PrecioSinIVA(value, parseFloat(key)).toFixed(2) + " €",
      IVA(value, parseFloat(key)).toFixed(2) + " €",
      value.toFixed(2) + " €",
    ]);
  });
  data.push(
    {
      type: "text",
      value: "<hr>",
      style: ` margin-bottom: 10px; color: gray`,
    },
    {
      type: "table",
      tableBody: subtotales,
      tableBodyStyle:
        "font-weight: 500; font-size: 15px; font-family: sans-serif;",
    }
  );
  var today = new Date();
  data.push(
    {
      type: "text",
      value: "<hr>",
      style: ` margin-bottom: 10px; color: gray`,
    },
    {
      type: "table",
      tableBody: [["Total", total + " €"]],
      tableBodyStyle:
        "font-weight: 500; font-size: 15px; font-family: sans-serif;",
    },
    {
      type: "text",
      value: "<hr>",
      style: ` margin-bottom: 10px; color: gray`,
    },
    {
      type: "table",
      tableBody: tasas,
      tableBodyStyle:
        "font-weight: 500; font-size: 15px; font-family: sans-serif;",
    },
    {
      type: "text",
      value: "<hr>",
      style: ` margin-bottom: 10px; color: gray`,
    },
    {
      type: "table",
      tableBody: [
        ["Efectivo", today.toLocaleString()],
        ["", "#10283"],
      ],
      tableBodyStyle:
        "font-weight: 500; font-size: 15px; font-family: sans-serif;",
    }
  );

  data.push(
    {
      type: "text",
      value: "<hr>",
      style: ` margin-bottom: 10px; color: gray`,
    },
    {
      type: "text",
      value: "Muchas Gracias Por Su Visita",
      style: ` margin-bottom: 10px; text-align: center`,
    },
    {
      type: "text",
      value: "<hr>",
      style: ` margin-bottom: 10px; color: gray`,
    },
    {
      type: "text",
      value: "RS92",
      style: `text-align:center;`,
      css: { "font-weight": "500" },
    },
    {
      type: "text",
      value: "CIF: B27815034",
      style: `text-align:center;`,
      css: { "font-weight": "500" },
    },
    {
      type: "text",
      value: "CRTA. MATAMA-PAZO N47",
      style: `text-align:center;`,
      css: { "font-weight": "500" },
    },
    {
      type: "text",
      value: "36213 VIGO (PONTEVEDRA)",
      style: `text-align:center; margin-bottom: 30px`,
      css: { "font-weight": "500" },
    },
    {
      type: "text",
      value: "<hr>",
      style: ` margin-bottom: 10px; color: gray`,
    }
  );

  PosPrinter.print(data, options)
    .then(() => {
      localStorage.setItem("cart", '{"items":[]}');
      LoadCart();
    })
    .catch((error) => {
      console.error(error);
    });
}

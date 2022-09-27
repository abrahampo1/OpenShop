const { PosPrinter } = require("@electron/remote").require(
  "electron-pos-printer"
);
const path = require("path");

const options = {
  preview: true, // Preview in window or print
  width: "170px", //  width of content body
  margin: "0 0 0 0", // margin of content body
  copies: 1, // Number of copies to print
  printerName: "XP-80C", // printerName: string, check with webContent.getPrinters()
  timeOutPerLine: 400,
  pageSize: { height: 301000, width: 71000 }, // page size
};

const data = [
  {
    type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table
    value: "Mundo Pirata Park",
    style: `text-align:center;`,
    css: { "font-weight": "700", "font-size": "18px" },
  },
  {
    type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
    value: "RS92",
    style: `text-align:left`,
    css: { "font-size": "8px", "margin":'0px' },
  },
  {
    type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
    value: "CIF: B27815034",
    style: `text-align:left`,
    css: { "font-size": "8px", "margin":'0px' },
  },
  {
    type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
    value: "CRTA. MATAMA-PAZO N47",
    style: `text-align:left`,
    css: { "font-size": "8px", "margin":'0px' },
  },
  {
    type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
    value: "36213 VIGO (PONTEVEDRA)",
    style: `text-align:left`,
    css: { "font-size": "8px", "margin":'0px' },
  },
  {
    type: "table",
    // style the table
    // list of the columns to be rendered in the table header
    tableHeader: ["Cant.", "Concepto", "Precio"],
    // multi dimensional array depicting the rows and columns of the table body
    tableBody: [[2, "CocaCola", "4.00€"]],
    // custom style for the table header
    // custom style for the table body
    tableBodyStyle: "border: 1px solid #ddd",
    // custom style for the table footer
    tableFooterStyle: "background-color: #000; color: white;",
  },
  {
    type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
    value: "RECUENTO IVA",
    style: `text-align:center`,
    css: { "font-size": "10px", "margin-top": "20px" },
  },
  {
    type: "table",
    // style the table
    // list of the columns to be rendered in the table header
    tableHeader: ["IVA", "TOTAL"],
    // multi dimensional array depicting the rows and columns of the table body
    tableBody: [["10%", "4.00€"]],
    // custom style for the table header
    // custom style for the table body
    tableBodyStyle: "border: 1px solid #ddd",
    // custom style for the table footer
    tableFooterStyle: "background-color: #000; color: white;",
  },
  {
    type: "table",
    // style the table
    // list of the columns to be rendered in the table header
    // multi dimensional array depicting the rows and columns of the table body
    tableBody: [["TOTAL", "23.00€"]],
    // custom style for the table header
    // custom style for the table body
    tableBodyStyle: "border: 1px solid #ddd",
    // custom style for the table footer
    tableFooterStyle: "background-color: #000; color: white;",
  },
  {
    type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
    value: "SUMATORIO",
    style: `text-align:center`,
    css: { "font-size": "10px", "margin-top": "20px" },
  },
  {
    type: "table",
    // style the table
    // list of the columns to be rendered in the table header
    // multi dimensional array depicting the rows and columns of the table body
    tableBody: [
      ["BASE IMP.", "23.00€"],
      ["IVA TOTAL.", "23.00€"],
      ["SUBTOTAL", "23.00€"],
    ],
    // custom style for the table header
    // custom style for the table body
    tableBodyStyle: "border: 1px solid #ddd",
    // custom style for the table footer
    tableFooterStyle: "background-color: #000; color: white;",
  },
];

// PosPrinter.print(data, options)
//   .then(() => {})
//   .catch((error) => {
//     console.error(error);
//   });

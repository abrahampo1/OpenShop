window.$ = window.jQuery = require("jquery");

function redirect(url) {
  location.replace(url);
}

function api(data, method = "GET") {
  return new Promise(function (resolve, reject) {
    $.ajax({
      type: method,
      url: "/api.php",
      data: data,
      success: function (response) {
        resolve(JSON.parse(response));
      },
    });
  });
}

async function AddToCart(id) {
  let itemData = await api(
    {
      resource: "itemData",
      itemId: id,
    },
    "POST"
  );
  let cart = JSON.parse(localStorage.getItem("cart")) || { items: [] };
  let i;
  if ((i = cart.items.find((o) => o.id === id))) {
    cart.items[cart.items.indexOf(i)]["cantidad"]++;
  } else {
    cart.items.push({
      id: id,
      nombre: itemData.name,
      precio: itemData.precio,
      iva: itemData.iva,
      cantidad: 1,
    });
  }

  localStorage.setItem("cart", JSON.stringify(cart));
  LoadCart();
}

function LoadCart() {
  $(".cart").html("");
  let cart = JSON.parse(localStorage.getItem("cart")) || { items: [] };
  let total = 0;
  cart.items.forEach((value, key) => {
    $(".cart").append(`
    <div class="list" onclick="CartItem(${key})">
        <div class="l10">
            ${value.cantidad}
        </div>
        <div class="l60">
            ${value.nombre}
        </div>
        <div class="l30 textcenter">
            ${(value.cantidad * value.precio).toFixed(2)}€
        </div>
    </div>
    `);
    total += parseFloat((value.cantidad * value.precio).toFixed(2));
  });

  $(".cart-total").html(total.toFixed(2) + "€");
}

function CloseModal(id) {
  $("#" + id).fadeOut("fast");
  $("#keypad").fadeOut("fast");
  $(".focused").removeClass("focused");
}
function OpenModal(id) {
  $("#" + id).fadeIn("fast");
}

function PrecioSinIVA(precio, iva = 21) {
  let mult = 1 + iva / 100;
  return parseFloat(redondear(precio / mult));
}

function ObtenerIVA(precio, iva = 21) {
  let precio_sin_iva = PrecioSinIVA(precio, iva);
  let iva_calculado = precio - precio_sin_iva;
  return parseFloat(redondear(iva_calculado));
}

function redondear(num, digitos = 2) {
  num = num.toFixed(digitos);
  return parseFloat(num);
}

function checkout(show = true) {
  if (!show) {
    $("#checkout").addClass("slide-out-bottom");
    $("#checkout").removeClass("slide-in-bottom");
    $(".closetag").css("transform", "rotate(0deg)");
    setTimeout(() => {
      $("#checkout").hide();
    }, 500);
  } else {
    $("#checkout").show();
    $("#checkout").removeClass("slide-out-bottom");
    $("#checkout").addClass("slide-in-bottom");
    $(".closetag").css("transform", "rotate(180deg)");
  }
}

function SelectFromTable(table, output) {
  return new Promise((resolve, reject) => {
    let cols = [];

    output.forEach((element) => {
      cols.push(element.column);
    });

    api({
      resource: "SelectFromTable",
      columns: cols,
      table: table,
    }).then((r) => {
      resolve(r);
    });
  });
}

function HTMLFromTable(table, output) {
  return new Promise((resolve, reject) => {
    SelectFromTable(table, output).then((r) => {
      let modal = document.createElement("div");
      modal.classList.add("modal");
      modal.style.zIndex = 1002;
      let modal_content = document.createElement("div");
      modal_content.classList.add("modal-content");
      modal_content.classList.add("flex");
      modal.appendChild(modal_content);
      r.forEach((element) => {
        let e = document.createElement("div");
        e.classList.add("table-result");
        output.forEach((col) => {
          if (!col["hide"]) {
            e.innerHTML += element[col["column"]];
            e.innerHTML += "<br>";
          }
        });
        e.onclick = () => {
          resolve(element);
          modal.remove();
        };
        modal_content.appendChild(e);
      });
      document.body.appendChild(modal);
    });
  });
}

function LoadItem(id) {
  let cart = JSON.parse(localStorage.getItem("cart")) || {
    items: [],
  };
  let item = cart.items[id];
  $("#cartItem .pu").text(item.precio);
  $("#cartItem .iva").text(item.iva);
  $("#cartItem #itemName").text(item.nombre);
  $("#cartItem .ivaincl").text(
    ObtenerIVA(item.precio, cart.items[id].iva) + "€"
  );
  $("#cartItem .total").text(
    "Total " +
      (cart.items[id].precio * cart.items[id].cantidad).toFixed(2) +
      "€"
  );
  $("#cartItem .iva").on("DOMSubtreeModified", () => {
    cart.items[id].iva = parseFloat($("#cartItem .iva").text());
    $("#cartItem .ivaincl").text(
      ObtenerIVA(item.precio, cart.items[id].iva) + "€"
    );
  });
  $("#cartItem .pu").on("DOMSubtreeModified", () => {
    cart.items[id].precio = parseFloat($("#cartItem .pu").text());
    $("#cartItem .total").text(
      "Total " +
        (cart.items[id].precio * cart.items[id].cantidad).toFixed(2) +
        "€"
    );
    $("#cartItem .ivaincl").text(
      ObtenerIVA(item.precio, cart.items[id].iva) + "€"
    );
  });
  $("#cartItem .cantidad").text(item.cantidad);
  $("#cartItem .cantidad").on("DOMSubtreeModified", () => {
    cart.items[id].cantidad = parseInt($("#cartItem .cantidad").text());
    $("#cartItem .total").text(
      "Total " +
        (cart.items[id].precio * cart.items[id].cantidad).toFixed(2) +
        "€"
    );
  });
  if (!cart.items[id].descuentos) {
    cart.items[id].descuentos = {};
  }
  $("#cartItem .descuentos").html("");
  Object.entries(cart.items[id].descuentos).forEach(([key, valor]) => {
    console.log(valor);
    $("#cartItem .descuentos").append(
      `<div class="mark">${valor.nombre}</div>`
    );
  });
  $("#cartItem .descuentos").on("click", () => {
    HTMLFromTable("mpp_descuentos", [
      {
        column: "nombre",
      },
      {
        column: "valor",
        hide: true,
      },
      {
        column: "tipo",
        hide: true,
      },
    ]).then((r) => {
      cart.items[id].descuentos[r.id] = r;

      $("#cartItem .descuentos").html("");
      Object.entries(cart.items[id].descuentos).forEach(([key, valor]) => {
        console.log(valor);
        $("#cartItem .descuentos").append(
          `<div class="mark">${valor.nombre}</div>`
        );
      });
    });
  });
  $("#cartItem .save").on("click", () => {
    localStorage.setItem("cart", JSON.stringify(cart));
    UnLoadItem();
  });
  $("#cartItem .delete").on("click", () => {
    cart.items.splice(id, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    UnLoadItem();
  });
  OpenModal("cartItem");
}

function UnLoadItem() {
  $("#cartItem .descuentos").off("click");
  $("#cartItem .save").off("click");
  $("#cartItem .delete").off("click");
  $("#cartItem .iva").off("DOMSubtreeModified");
  $("#cartItem .cantidad").off("DOMSubtreeModified");
  $("#cartItem .pu").off("DOMSubtreeModified");
  CloseModal("cartItem");
  LoadCart();
}

function CartItem(id) {
  let cart = JSON.parse(localStorage.getItem("cart")) || {};
  let article = cart.items[id];
  console.log(article);
  create_modal([
    {
      type: "text",
      text: "Información de Articulo",
      tag: "h1",
    },
    {
      type: "div",
      tag: "div",
      classList: ["flex"],
      content: [
        {
          type: "text",
          tag: "h2",
          text: "Nombre",
        },
        {
          type: "input",
          tag: "input",
          value: article["nombre"],
          required: true,
          placeholder: "Nombre....",
          name: "nombre",
          classList: ["w50"],
        },
      ],
    },
    {
      type: "div",
      tag: "div",
      classList: ["flex"],
      content: [
        {
          type: "text",
          tag: "h2",
          text: "Precio con IVA (€)",
        },
        {
          type: "input",
          tag: "input",
          required: true,
          placeholder: "Precio....",
          name: "precio",
          value: parseFloat(article["precio"]).toFixed(2),
          classList: ["w50"],
        },
      ],
    },
    {
      type: "div",
      tag: "div",
      classList: ["flex"],
      content: [
        {
          type: "text",
          tag: "h2",
          text: "Cantidad",
        },
        {
          type: "input",
          tag: "input",
          placeholder: "Cantidad....",
          required: true,
          name: "cantidad",
          value: article["cantidad"],
          classList: ["w50"],
        },
      ],
    },
    {
      type: "div",
      tag: "div",
      classList: ["flex"],
      content: [
        {
          type: "text",
          tag: "h2",
          text: "IVA (%)",
        },
        {
          type: "input",
          tag: "input",
          placeholder: "IVA....",
          required: true,
          name: "iva",
          value: article["iva"],
          classList: ["w50"],
        },
      ],
    },
    {
      type: "div",
      tag: "div",
      classList: ["flex"],
      content: [
        {
          type: "text",
          tag: "h2",
          text: "Descuento",
        },
        {
          type: "select",
          tag: "select",
          placeholder: "Selecciona un descuento",
          table: "descuentos",
          column: "nombre",
          name: "descuento",
          classList: ["w50"],
        },
      ],
    },
    {
      type: "text",
      tag: "div",
      text: '<hr>'
    },

    {
      type: "text",
      tag: "h2",
      classList: ["link", "error"],
      onclick: function (el) {
        let cart = JSON.parse(localStorage.getItem("cart")) || { items: [] };
        cart.items.splice(id, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        LoadCart();
        $(el.target).parent().parent().fadeOut("fast");
      },
      text: "Eliminar del carrito",
    },
  ]).then((r) => {
    console.log(r);
    Object.entries(r).forEach(([key, value]) => {
      cart.items[id][key] = value;
    });

    localStorage.setItem("cart", JSON.stringify(cart));
    LoadCart();
  });
}

setTimeout(() => {
  LoadCart();
}, 100);



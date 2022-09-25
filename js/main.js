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
  let itemData = await api({
    resource: "itemData",
    itemId: id,
  });
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let i;
  if ((i = cart.find((o) => o.id === id))) {
    cart[cart.indexOf(i)]["cantidad"]++;
  } else {
    cart.push({
      id: id,
      nombre: itemData.name,
      precio: itemData.sell_base_price,
      cantidad: 1,
    });
  }

  localStorage.setItem("cart", JSON.stringify(cart));
  LoadCart();
}

function LoadCart() {
  $("#cart").html("");
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let total = 0;
  cart.forEach((value, key) => {
    $("#cart").append(`
    <div class="list" onclick="LoadItem(${key})">
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

  $("button.total").html("Cobrar " + total.toFixed(2) + "€");
}

function CloseModal(id) {
  $("#" + id).fadeOut("fast");
  $("#keypad").fadeOut("fast");
  $(".focused").removeClass("focused");
}
function OpenModal(id) {
  $("#" + id).fadeIn("fast");
}

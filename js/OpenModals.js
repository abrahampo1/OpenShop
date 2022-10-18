let output = {};
const KioskBoard = require("kioskboard");
console.log("hola");
function create_modal(
  data = [
    { type: "text", tag: "h1", text: "Example" },
    { type: "input", tag: "input", placeholder: "Nombre", name: "nombre" },
    {
      type: "select",
      tag: "select",
      placeholder: "Selecciona un tipo de terminal",
      table: "og_conexiones_tipos",
      column: "nombre",
      name: "select",
    },
  ]
) {
  return new Promise((resolve, reject) => {
    let baseModal = document.createElement("div");
    baseModal.classList.add("open-modal");

    let contentModal = document.createElement("div");
    contentModal.classList.add("modal-content");
    baseModal.appendChild(contentModal);

    let closeBtn = document.createElement("button");
    closeBtn.classList.add("close");
    closeBtn.innerHTML = '<iconify-icon icon="mdi:close"></iconify-icon>';
    closeBtn.onclick = () => {
      $(baseModal).fadeOut("fast");
    };
    baseModal.appendChild(closeBtn);

    let saveBtn = document.createElement("button");
    saveBtn.classList.add("save");
    saveBtn.innerHTML = "Guardar";
    saveBtn.onclick = () => {
      let can_send = true;
      console.log(data);
      for (let index = 0; index < data.length; index++) {
        if (data[index].info) {
          const element = data[index];

          if (element.info.required && output[element.info.name] == "") {
            element.target.classList.add("focus");
            element.target.classList.remove("shake-horizontal");
            setTimeout(() => {
              element.target.classList.add("shake-horizontal");
            }, 100);
            can_send = false;
          }
        }
      }
      if (!can_send) {
        return false;
      }

      $(baseModal).fadeOut("fast");

      resolve(output);
    };
    baseModal.appendChild(saveBtn);
    output = {};
    data.forEach((element, key) => {
      let ele = switch_type(element, key);
      if (ele) {
        contentModal.appendChild(ele);
      }
    });
    baseModal.style.display = "none";
    document.body.appendChild(baseModal);
    $(baseModal).fadeIn("fast");
    KioskBoard.run(".finp");
  });

  function switch_type(element, key) {
    let el = null;
    switch (element.type) {
      case "div":
        el = document.createElement("div");

        element.content.forEach((content) => {
          let cont = switch_type(content);
          el.appendChild(cont);
        });
        break;
      case "text":
        el = document.createElement(element.tag);
        el.innerHTML = element.text;
        if (element.onclick) {
          el.onclick = function (e) {
            element.onclick(e);
          };
        }
        if (element.ajaxvalue) {
          let before = el.innerHTML;
          el.innerHTML =
            '<iconify-icon inline icon="line-md:loading-twotone-loop"></iconify-icon>';
          api({
            resource: "obtener_registro",
            tabla: element.ajaxvalue.table,
            id: element.ajaxvalue.id,
            where: element.ajaxvalue.where,
          }).then((r) => {
            el.innerHTML = before + r[element.ajaxvalue.column];
          });
        }

        break;
      case "input":
        el = document.createElement(element.tag);
        el.placeholder = element.placeholder;
        el.classList.add("w100");
        el.classList.add("finp");
        output[element.name] = "";
        el.onchange = () => {
          output[element.name] = el.value;
        };
        if (element.value) {
          el.value = element.value;
          output[element.name] = el.value;
        }
        if (element.ajaxvalue) {
          api({
            resource: "obtener_registro",
            tabla: element.ajaxvalue.table,
            id: element.ajaxvalue.id,
            where: element.ajaxvalue.where,
          }).then((r) => {
            el.value = r[element.ajaxvalue.column];
            output[element.name] = el.value;
          });
        }

        break;
      case "search":
        el = document.createElement("div");
        let search = document.createElement(element.tag);
        search.placeholder = element.placeholder;
        el.classList.add("w100");
        search.classList.add("w100");
        output[element.name] = "";

        search.oninput = (e) => {
          output[element.name] = "";
          buscar(e.target.value, e.target, element.table, element.column).then(
            (r) => {
              output[element.name] = r;
            }
          );
        };
        data[key].target = search;
        el.appendChild(search);
        break;
      case "select":
        el = document.createElement(element.tag);
        el.classList.add("w100");
        output[element.name] = "";
        let placeholder = document.createElement("option");
        placeholder.innerText = element.placeholder;
        el.appendChild(placeholder);
        api({
          resource: "obtener_tabla",
          tabla: element.table,
          columna: element.column,
        }).then((r) => {
          r.forEach((opt) => {
            let op = document.createElement("option");
            op.value = opt.id;
            op.innerText = opt[element.column];
            el.appendChild(op);
          });
        });
        el.onchange = () => {
          output[element.name] = el.value;
        };
        break;
      default:
        break;
    }

    if (element.classList) {
      element.classList.forEach((clase) => {
        el.classList.add(clase);
      });
    }
    if (element.attributes) {
      Object.entries(element.attributes).forEach(([key, value]) => {
        $(el).attr(key, value);
      });
    }
    if (element.id) {
      el.id = element.id;
    }
    data.push({ info: element, target: el });
    console.log(element);
    return el;
  }
}
function api(data, method = "POST", url = "/api.php") {
  return new Promise((resolve, reject) => {
    $.ajax({
      type: method,
      url: url,
      data: data,
      success: function (response) {
        resolve(JSON.parse(response));
      },
    });
  });
}

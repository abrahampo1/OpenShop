var ClassicGes = class ClassicGes {
  constructor(
    ip = "http://localhost",
    port = 5000,
    path = "C:/clasges6/datos"
  ) {
    this._events = {};
    this.query = (sql, limit = 50, p = path) => {
      return new Promise((resolve, reject) => {
        console.log(ip + ":" + port + "/sql")
        $.ajax({
          type: "POST",
          url: ip + ":" + port + "/sql",
          data: {
            sql: sql,
            limit: limit,
            path: p,
          },
          success: function (response) {
            if (JSON.parse(response.message).Table == undefined) {
              reject("No entry found");
            }
            if (limit == 1) {
              resolve(JSON.parse(response.message).Table[0]);
            }
            resolve(JSON.parse(response.message).Table);
          },
        });
      });
    };
  }
  removeListener(name, listenerToRemove) {
    if (!this._events[name]) {
      throw new Error(
        `Can't remove a listener. Event "${name}" doesn't exits.`
      );
    }

    const filterListeners = (listener) => listener !== listenerToRemove;

    this._events[name] = this._events[name].filter(filterListeners);
  }
  emit(name, data) {
    if (!this._events[name]) {
      throw new Error(`Can't emit an event. Event "${name}" doesn't exits.`);
    }

    const fireCallbacks = (callback) => {
      callback(data);
    };

    this._events[name].forEach(fireCallbacks);
  }
  on(name, listener) {
    if (!this._events[name]) {
      this._events[name] = [];
    }

    this._events[name].push(listener);
  }

  get ping() {
    return "pong";
  }

  fillquery(table, holder, options) {
    CLASGES.query("SELECT * FROM " + table + " " + options).then((r) => {
      Object.entries(r[0]).forEach(([key, value]) => {
        value = value.toString().trim();
        $(holder + ' input[data-ges="' + key + '"]').val(value);
        $(holder + ' input[data-ges="' + key + '"]').on("change", (e) => {
          let valor = e.currentTarget.value;
          if (
            $(holder + ' input[data-ges="' + key + '"]').attr("type") ==
            "checkbox"
          ) {
            valor = $(holder + ' input[data-ges="' + key + '"]').prop(
              "checked"
            );
          }
          valor = valor.trimEnd();
          if (!TryParseInt(valor, false)) {
            valor = '"' + valor + '"';
          }
          this.query(
            "UPDATE " + table + " SET " + key + " = " + valor + " " + options
          );
        });
        $(holder + ' select[data-ges="' + key + '"]').on("change", (e) => {
          let valor = e.currentTarget.value;
          this.query(
            "UPDATE " + table + " SET " + key + " = " + valor + " " + options
          );
        });
        if (
          $(holder + ' input[data-ges="' + key + '"]').attr("type") ==
          "checkbox"
        ) {
          $(holder + ' input[data-ges="' + key + '"]').prop("checked", value);
        }
        if ($(holder + ' select[data-ges="' + key + '"]') != undefined) {
          let select = $(holder + ' select[data-ges="' + key + '"]');
          let table = $(select).data("table");
          let optionName = $(select).data("option");
          if (table == undefined) {
            return;
          }
          this.query("SELECT * FROM " + table, 0).then((r) => {
            r.forEach((agente) => {
              let option = document.createElement("option");
              option.value = agente[key];
              option.innerText = agente[optionName];
              if (agente[key] == value) {
                option.selected = true;
              }
              $(select).append(option);
            });
          });
        }
      });
    });
  }

  table(table, opciones = "") {
    return new Promise((resolve, reject) => {
      let columns = "";
      let tablename = $(table).data("table");
      let limit = $(table).data("limit");
      limit = parseInt(limit);
      if (limit == undefined) {
        limit = 50;
      }
      let cols = [];
      $(table + " th").each(function (index, element) {
        columns += $(element).data("column") + ",";
        cols.push(element);
      });
      columns = columns.slice(0, columns.length - 1);
      this.query(`SELECT ${columns} FROM ${tablename} ${opciones}`, limit).then(
        (r) => {
          r.forEach((value) => {
            let tr = document.createElement("tr");
            let i = 0;
            cols.forEach((element) => {
              let td = document.createElement("td");
              if ($(element).data("round")) {
                value[$(element).data("column")] = parseFloat(
                  value[$(element).data("column")]
                ).toFixed(parseInt($(element).data("round")));
              }
              if (i == 0) {
                $(td).attr("data-key", "true");
              }
              i++;

              td.innerText = value[$(element).data("column")];
              tr.appendChild(td);
            });
            $(table).append(tr);
          });
          resolve(true);
        }
      );
    });
  }

  clientes(limit = 50) {
    return this.query("SELECT * FROM clientes", limit);
  }

  cliente(id) {
    return this.query("SELECT * FROM clientes WHERE clacli = " + id, 1);
  }

  update(table, column, value, idname, idvalue) {
    this.query(
      `UPDATE ${table} SET ${column} = ${value} WHERE ${idname} = ${idvalue}`
    );
    return true;
  }

  select(el) {
    let select = $(el);
    let table = select.data("table");
    let id = select.data("id");
    let idname = select.data("idcolumn");
    let response = select.data("column");
    let opt = "";
    if (select.data("option")) {
      opt = select.data("option");
    }

    if (!table && !id && !idname && !response) {
      return false;
    }
    this.query(`SELECT ${response}, ${idname} FROM ${table} ${opt}`, 0).then(
      (r) => {
        r.forEach((element) => {
          let option = document.createElement("option");
          option.textContent = element[response];
          if (element[idname] == id) {
            option.selected = true;
          }
          select.append(option);
        });
      }
    );
  }
  start(holder) {
    let clas = this;
    $(holder + " select").each(function (index, element) {
      clas.select(element);
    });
  }
  sql(sql) {
    return this.query(sql);
  }
};

function TryParseInt(str, defaultValue) {
  var retValue = defaultValue;
  if (str !== null) {
    if (str.length > 0) {
      if (!isNaN(str)) {
        retValue = parseFloat(str);
      }
    }
  }
  return retValue;
}

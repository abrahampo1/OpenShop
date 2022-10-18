var DB = class DB {
  constructor() {
    this._events = {};
    $.ajax({
      type: "POST",
      url: "/api.php",
      data: {
        resource: "get_settings",
        name: "RGDB_CLASSGES6_TOKEN",
      },
      success: function (response) {
        localStorage.setItem(
          "RGDB_CLASSGES6_TOKEN",
          JSON.parse(response).value
        );
      },
    });
    let token = localStorage.getItem("RGDB_CLASSGES6_TOKEN");
    (this.taxes = function () {
      return new Promise((resolve, reject) => {
        const Clasges = new ClassicGes(token);
        Clasges.query("SELECT * FROM iva", 1).then((r) => {
          resolve([
            {
              name: "Normal",
              porcentaje: r["iva1"],
            },
            {
              name: "Reducido",
              porcentaje: r["iva2"],
            },
            {
              name: "Superreducido",
              porcentaje: r["iva3"],
            },
            {
              name: "Exento",
              porcentaje: r["iva4"],
            },
          ]);
        });
      });
    }),
      (this.articles = function (limit = 50, page = 1, filters = {}) {
        return new Promise((resolve, reject) => {
          const Clasges = new ClassicGes(token);
          Clasges.query(
            "SELECT claart as id, nombre as name, Pvp1 as price FROM articulo"
          ).then((r) => {
            resolve(r);
          });
        });
      });
  }
};

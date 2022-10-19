var DB = class DB {
  constructor() {
    this._events = {};
    (this.taxes = function () {
      let token = localStorage.getItem("clasges_token");
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
        let token = localStorage.getItem("clasges_token");
        return new Promise((resolve, reject) => {
          const Clasges = new ClassicGes(token);
          Clasges.query(
            "SELECT claart as id, nombre as name, Pvp1 as price FROM articulo"
          ).then((r) => {
            resolve(r);
          });
        });
      });
    this.clients = function (limit = 50, page = 1, filters = {}) {
      let token = localStorage.getItem("clasges_token");
      return new Promise((resolve, reject) => {
        const Clasges = new ClassicGes(token);
        Clasges.query(
          "SELECT clacli as id, nombre as name, Email as email, telefono as phone FROM clientes"
        ).then((r) => {
          resolve(r);
        });
      });
    };
  }
};

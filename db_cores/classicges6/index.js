var DB = class DB {
  constructor() {
    this._events = {};
    this.articles = function (limit = 50, page = 1, filters = {}) {
      let token = localStorage.getItem("clasges_token");
      return new Promise((resolve, reject) => {
        const Clasges = new ClassicGes(token);
        Clasges.query("SELECT claart as id, nombre as name, Pvp1 as price FROM articulo").then(
          (r) => {
            resolve(r);
          }
        );
      });
    };
  }
};

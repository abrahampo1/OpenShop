let search_holder = document.createElement("search");
document.body.appendChild(search_holder);
function search(table, column, input) {
  return new Promise((resolve, reject) => {
    api({
      resource: "search_table",
      column: ["id", column],
      table: table,
      value: input.value,
    }).then((r) => {
      if (r) {
        search_holder.innerHTML = "";
        $(search_holder).show();
        for (let index = 0; index < r.length; index++) {
          const element = r[index];
          let item = document.createElement("searchitem");
          item.innerText = element[column];
          item.onclick = () => {
            search_holder.innerHTML = "";
            $(search_holder).hide();
            resolve(element);
          };
          search_holder.appendChild(item);
        }
        var rect = input.getBoundingClientRect();
        console.log(rect);
        search_holder.style.width = rect.width - 2;
        search_holder.style.top = rect.top + search_holder.offsetHeight + 16;
        search_holder.style.left = rect.left;
        window.onresize = function () {
          search_holder.style.width = rect.width - 2;
          search_holder.style.top = rect.top + search_holder.offsetHeight + 16;
          search_holder.style.left = rect.left;
        };

        input.onblur = function () {
          setTimeout(() => {
            search_holder.innerHTML = "";
            $(search_holder).hide();
          }, 200);
        };
      }
    });
  });
}

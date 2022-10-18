<?php

include('../../../../../functions.php');

?>


<div class="flex">
    <div class="input ">
        <input type="text" class="input--icon" placeholder="Buscar por nombre, descripción o SKU" style="width: 100%;">
        <iconify-icon class="icon--input" inline icon="ant-design:search-outlined"></iconify-icon>
    </div>
    <button class="button primary">Crear artículo</button>
</div>
<table class="table" id="articles_table">
    <tr>
        <th class="text-left">Nombre</th>
        <th class="text-right">Precio</th>
    </tr>
</table>
<div id="loading">
    <iconify-icon icon="eos-icons:loading" width="128" height="128"></iconify-icon>
</div>


<script>
    defer(function() {
        var DATABASE = new DB();
        DATABASE.articles().then(r => {
            console.log(r)
            $('#loading').hide();
            r.forEach(element => {
                let tr = document.createElement('tr');
                var n = document.createElement('td');
                n.innerText = element.name
                tr.appendChild(n);
                var n = document.createElement('td');
                n.innerText = element.price + ' €'
                n.classList.add('text-right')
                tr.appendChild(n);
                document.getElementById('articles_table').appendChild(tr)
            });
        });
    })
</script>
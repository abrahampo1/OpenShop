<?php

include('../../../../../functions.php');

?>
<div class="flex">
    <div class="input ">
        <input type="text" class="input--icon" placeholder="Buscar" style="width: 100%;">
        <iconify-icon class="icon--input" inline icon="ant-design:search-outlined"></iconify-icon>
    </div>
    <div class="flex">
        <button class="button primary">Crear Presupuesto</button>
    </div>
</div>
<table class="table" id="clients_table">
    <tr>
        <th class="text-left ">Fecha</th>
        <th class="text-center ">Cliente</th>
        <th class="text-center ">Titulo</th>
        <th class="text-right ">Importe</th>
    </tr>
</table>
<div id="loading">
    <iconify-icon icon="eos-icons:loading" width="128" height="128"></iconify-icon>
</div>
<script>
    defer(function() {
        var DATABASE = new DB();
        DATABASE.budgets().then(r => {
            console.log(r)
            $('#loading').hide();
            r.forEach(element => {
                let tr = document.createElement('tr');
                var n = document.createElement('td');
                let d = new Date(element.date)
                n.innerText = d.toLocaleDateString()
                n.classList.add('text-left')
                tr.appendChild(n);
                var n = document.createElement('td');
                n.innerText = element.client
                n.classList.add('text-center')
                tr.appendChild(n);
                var n = document.createElement('td');
                n.innerText = element.title
                n.classList.add('text-center')
                tr.appendChild(n);
                var n = document.createElement('td');
                n.innerText = parseFloat(element.total).toFixed(2) + ' €'
                n.classList.add('text-right')
                tr.appendChild(n);
                document.getElementById('clients_table').appendChild(tr)
            });
        });
    })
</script>
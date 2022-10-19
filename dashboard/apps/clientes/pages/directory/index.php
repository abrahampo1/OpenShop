<?php

include('../../../../../functions.php');

?>


<div class="flex">
    <div class="input ">
        <input type="text" class="input--icon" placeholder="Buscar" style="width: 100%;">
        <iconify-icon class="icon--input" inline icon="ant-design:search-outlined"></iconify-icon>
    </div>
    <div class="flex">
        <button class="button  tertiary">Exportar clientes</button>
        <div class="hsep"></div>
        <button class="button secondary">Crear cliente</button>
    </div>
</div>
<table class="table" id="clients_table">
    <tr>
        <th class="text-center ">Nombre</th>
        <th class="text-center ">Correo Electrónico</th>
        <th class="text-center ">Telefono</th>
    </tr>
</table>
<div id="loading">
    <iconify-icon icon="eos-icons:loading" width="128" height="128"></iconify-icon>
</div>
<script>
    defer(function() {
        var DATABASE = new DB();
        DATABASE.clients().then(r => {
            console.log(r)
            $('#loading').hide();
            r.forEach(element => {
                let tr = document.createElement('tr');
                var n = document.createElement('td');
                n.innerText = element.name
                tr.appendChild(n);
                var n = document.createElement('td');
                n.innerText = element.email 
                n.classList.add('text-left')
                tr.appendChild(n);
                var n = document.createElement('td');
                n.innerText = element.phone 
                n.classList.add('text-right')
                tr.appendChild(n);
                document.getElementById('clients_table').appendChild(tr)
            });
        });
    })
</script>
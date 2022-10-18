<?php

include('../../../../../functions.php');

?>

<div class="flex">
    <div class="input ">
        <input type="text" class="input--icon" placeholder="Buscar por nombre o porcentaje" style="width: 100%;">
        <iconify-icon class="icon--input" inline icon="ant-design:search-outlined"></iconify-icon>
    </div>
    <button class="button primary">Crear impuesto</button>
</div>
<table class="table">
    <tr>
        <th class="text-left">Nombre</th>
        <th class="text-right">Porcentaje</th>
    </tr>

</table>
<div id="loading">
    <iconify-icon icon="eos-icons:loading" width="128" height="128"></iconify-icon>
</div>
<script>
    defer(function() {
        var DATABASE = new DB();
        DATABASE.taxes().then(r => {
            console.log(r)
            $('#loading').hide();
            r.forEach(element => {
                let tr = document.createElement('tr');
                var n = document.createElement('td');
                n.innerText = element.name
                tr.appendChild(n);
                var n = document.createElement('td');
                n.innerText = element.porcentaje + ' %'
                n.classList.add('text-right')
                tr.appendChild(n);
                $('table').append(tr)
            });
        });
    })
</script>
<?php

include('../../../../../functions.php');

?>


<div class="flex">
    <div class="input ">
        <input type="text" class="input--icon" placeholder="Buscar" style="width: 100%;">
        <iconify-icon class="icon--input" inline icon="ant-design:search-outlined"></iconify-icon>
    </div>
    <div>
        <button class="button  tertiary">Exportar clientes</button>
        <button class="button secondary">Crear cliente</button>
    </div>
</div>
<table class="table">
    <tr>
        <th class="text-center ">Nombre</th>
        <th class="text-center ">Correo Electrónico</th>
        <th class="text-center ">Telefono</th>
    </tr>
    <?php

    foreach (sql_array('SELECT * FROM clientes') as $key => $value) {
    ?>

        <tr>
            <td class="text-center "><?= $value['nombre'] ?></td>
            <td class="text-center "><?= $value['email'] ?></td>
            <td class="text-center "><?= $value['telefono'] ?></td>
        </tr>

    <?php
    }

    ?>
</table>
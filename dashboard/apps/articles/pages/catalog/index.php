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
<table class="table">
    <tr>
        <th class="text-left">Nombre</th>
        <th>Existencias</th>
        <th class="text-right">Precio</th>
    </tr>
    <?php

    foreach (sql_array('SELECT * FROM tpv_inventory') as $key => $value) {
    ?>

        <tr>
            <td><?= $value['name'] ?></td>
            <td class="text-center ">-</td>
            <td class="text-right "><?= number_format($value['precio'], 2) ?> €</td>
        </tr>

    <?php
    }

    ?>
</table>
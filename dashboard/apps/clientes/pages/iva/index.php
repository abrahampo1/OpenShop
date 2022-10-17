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
    <?php

    foreach (sql_array('SELECT * FROM ivas') as $key => $value) {
    ?>

        <tr>
            <td><?= $value['nombre'] ?></td>
            <td class="text-right "><?= $value['porcentaje']?>%</td>
        </tr>

    <?php
    }

    ?>
</table>
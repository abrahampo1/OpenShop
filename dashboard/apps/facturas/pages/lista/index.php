<?php

include('../../../../../functions.php');

?>
<div class="flex">
    <div class="input ">
        <input type="text" onchange="$('#sapp').load(localStorage.getItem('current_page')+'?search=' + this.value)"
            class="input--icon" placeholder="Buscar" style="width: 100%;">
        <iconify-icon class="icon--input" inline icon="ant-design:search-outlined"></iconify-icon>
    </div>
</div>
<table class="table" id="clients_table">
    <tr>
        <th class="text-left ">Fecha</th>
        <th class="text-center ">Cliente</th>
        <th class="text-center ">Titulo</th>
        <th class="text-right ">Importe</th>
    </tr>
    <?php

    $arr = sql_array('invoices', ['id', 'client', 'date', 'reference', 'total'], ['reference'], get('search'));



    if($arr){

    foreach ($arr as $value){
        ?>

    <tr>
        <td class="text-left"><?= date('d-m-Y', strtotime($value['date']))  ?></td>
        <td class="text-left"><?= $value['client'] ?></td>
        <td class="text-left"><?= $value['reference'] ?></td>
        <td class="text-right"><?= $value['total'] ?> €</td>
    </tr>

    <?php
    }
}
    
    ?>
</table>
<?php
    

    if(!$arr){
        ?>
<p style="text-align: center;">
    <iconify-icon inline icon="akar-icons:circle-alert"></iconify-icon>
    No se han encontrado registros con estos filtros
    <a href="#" onclick="$('#sapp').load(localStorage.getItem('current_page'))">
        <iconify-icon inline icon="fluent-mdl2:cancel"></iconify-icon> Eliminar filtros
    </a>
</p>
<?php
    }
    
    ?>
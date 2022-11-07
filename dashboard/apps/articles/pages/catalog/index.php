<?php

include('../../../../../functions.php');

?>


<div class="flex">
    <div class="input ">
        <input type="text" onchange="$('#sapp').load(localStorage.getItem('current_page')+'?search=' + this.value)"
            name="search" class="input--icon" placeholder="Buscar por nombre, descripción o SKU" style="width: 100%;">
        <iconify-icon class="icon--input" inline icon="ant-design:search-outlined"></iconify-icon>
    </div>
    <button class="button primary">Crear artículo</button>
</div>
<table class="table" id="articles_table">
    <tr>
        <th class="text-left">Nombre</th>
        <th class="text-right">Precio</th>
    </tr>
    <?php
            $arr = sql_array('articles', ['id', 'name', 'price'], ['name'], get('search'));

    if($arr){

    foreach ($arr as $value){
        ?>

    <tr>
        <td class="text-left"><?= $value['name'] ?></td>
        <td class="text-right"><?= number_format($value['price'], 2,',','.') ?> €</td>
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
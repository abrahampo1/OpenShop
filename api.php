<?php


include 'functions.php';

switch (post('resource', true)) {
    case 'itemData':
        $itemID = post('itemId');
        echo json_encode(sql_data("SELECT * FROM tpv_inventory WHERE id = $itemID"));
        break;
    case 'SelectFromTable':
        $table = post('table');
        $columns = post('columns');
        $cols = '';
        foreach ($columns as $value) {
            $cols .= $value . ',';
        }

        $cols = substr($cols, 0, -1);
        echo json_encode(sql_array("SELECT id, $cols FROM $table"));
        break;
    case 'obtener_tabla':
        $table = post('tabla');
        $column = post('columna');

        echo json_encode(sql_array("SELECT id, $column FROM $table"));
        break;
    case 'get_settings':
        $name = post('name', true);
        echo json_encode(sql_data("SELECT * FROM rg_settings WHERE name = '$name'"));
        break;    
    case 'settings':
        $name = post('name', true);
        $value = post('value', true);
        include 'database.php';
        if(existe('SELECT * FROM rg_settings WHERE name = "'. $name .'"')){
            mysqli_query($link, "UPDATE `rg_settings` SET `value` = '$value ' WHERE `rg_settings`.`name` ='$name';");

        }else{
            mysqli_query($link, "INSERT INTO `rg_settings` (`id`, `name`, `value`) VALUES (NULL, '$name', '$value');");

        }
        success('Dato actualizado');

        break;
    
    default:
        # code...
        break;
}
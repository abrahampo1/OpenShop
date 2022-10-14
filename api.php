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
    default:
        # code...
        break;
}

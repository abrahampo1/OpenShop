<?php


include 'functions.php';

switch (get('resource', true)) {
    case 'itemData':
        $itemID = get('itemId');
        echo json_encode(sql_data("SELECT * FROM tpv_inventory WHERE id = $itemID"));
        break;
    case 'SelectFromTable':
        $table = get('table');
        $columns = get('columns');
        $cols = '';
        foreach ($columns as $value) {
            $cols .= $value . ',';
        }

        $cols = substr($cols, 0, -1);
        echo json_encode(sql_array("SELECT id, $cols FROM $table"));
        break;
    default:
        # code...
        break;
}
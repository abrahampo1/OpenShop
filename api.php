<?php


include 'functions.php';

switch (get('resource', true)) {
    case 'itemData':
        $itemID = get('itemId');
        echo json_encode(sql_data("SELECT * FROM tpv_inventory WHERE id = $itemID"));
        break;
    
    default:
        # code...
        break;
}
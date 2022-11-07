<?php



//DATABASE STRUCTURE FOR CLASSIC GES 6



$DBS = array();


//FACTURAS
$DBS['invoices'] = [
    'table' => 'factura',
    'columns' => [
        'id' => 'clafac',
        'client' => 'nomcli',
        'date' => 'fecha',
        'reference' => 'referencia',
        'total' => 'importe'
        ]
];


//ARTICULOS
$DBS['articles'] = [
    'table' => 'articulo',
    'columns' => [
        'id' => 'claart',
        'name' => 'nombre',
        'price' => 'Pvp1'
        ]
];

//CLIENTES
$DBS['clients'] = [
    'table' => 'clientes',
    'columns' => [
        'id' => 'clacli',
        'name' => 'nombre'
        ]
];
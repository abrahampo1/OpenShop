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
        'price' => 'Pvp1',
        'hasvariant' => 'tyc'
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


//EMPRESAS
$DBS['bussiness'] = [
    'table' => 'Empresas',
    'columns' => [
        'id' => 'Claemp',
        'name' => 'Nomemp'
    ]
];


//EJERCICIO
$DBS['campaign'] = [
    'table' => 'Ejercic',
    'columns' => [
        'id' => 'Claeje',
        'name' => 'Nomeje'
    ]
];


//COLORES 
$DBS['colors'] = [
    'table' => 'Colores',
    'columns' => [
        'id' => 'Clacol',
        'color' => 'Color',
        'article' => 'Claart'
    ]
];


//TAJAJES
$DBS['sizes'] = [
    'table' => 'Tallajes',
    'columns' => [
        'id' => 'Clatal',
        'name' => 'Nomtal',
    ]
];

<?php



//DATABASE STRUCTURE FOR CLASSIC GES 6



$DBS = array();


//FACTURAS
$DBS['invoices'] = [
    'create' => function ($clientID, $reference, $total) {
        include_once('function.php');
        $bussinesID = sql_data("SELECT value FROM rg_settings WHERE name = 'RGDB_CLASSGES6_INVOICE_DEFAULT_BUSSINESS'")->value;
        $campaignID = sql_data("SELECT value FROM rg_settings WHERE name = 'RGDB_CLASSGES6_INVOICE_DEFAULT_CAMPAIGN'")->value;
        $serial = sql_data("SELECT value FROM rg_settings WHERE name = 'RGDB_CLASSGES6_INVOICE_DEFAULT_SERIES'")->value;
        $invoiceID = send_query('SELECT TOP 1 Clafac as id FROM factura ORDER BY Clafac DESC');
        $invoiceID = $invoiceID[0]['id'] + 1; //Siguiente Clafac

        $sql = "INSERT INTO factura (Clafac, Claeje, Claemp, Serie) VALUES ($invoiceID, $campaignID, $bussinesID, '$serial')";
    },
    'table' => 'factura',
    'columns' => [
        'id' => 'clafac',
        'client' => 'nomcli',
        'clientID' => 'clacli',
        'date' => 'fecha',
        'reference' => 'referencia',
        'total' => 'importe',
        'bussiness' => 'claemp',
        'campaign' => 'Claeje'
    ]
];



//ARTICULOS
$DBS['articles'] = [
    'table' => 'articulo',
    'columns' => [
        'id' => 'claart',
        'name' => 'nombre',
        'price' => 'Pvp1',
        'hasvariant' => 'tyc',
        'taxid' => 'Tiva'
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


//TALLAJES
$DBS['sizes'] = [
    'table' => 'Tallajes',
    'columns' => [
        'id' => 'Clatal',
        'name' => 'Nomtal',
    ]
];


$DBS['invoices']['create']('', '', '');

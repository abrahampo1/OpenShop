<?php



//DATABASE STRUCTURE FOR CLASSIC GES 6



$DBS = array();


//FACTURAS
$DBS['invoices'] = [
    'create' => function ($clientID, $reference, $totalnotax, $totaltax) {
        include_once('function.php');
        $bussinesID = sql_data("SELECT value FROM rg_settings WHERE name = 'RGDB_CLASSGES6_INVOICE_DEFAULT_BUSSINESS'")->value;
        $campaignID = sql_data("SELECT value FROM rg_settings WHERE name = 'RGDB_CLASSGES6_INVOICE_DEFAULT_CAMPAIGN'")->value;
        $serial = sql_data("SELECT value FROM rg_settings WHERE name = 'RGDB_CLASSGES6_INVOICE_DEFAULT_SERIES'")->value;
        $invoiceID = send_query('SELECT TOP 1 Clafac as id FROM factura ORDER BY Clafac DESC');
        $invoiceID = $invoiceID[0]['id'] + 1; //Siguiente Clafac
        $number = send_query('SELECT TOP 1 numero as id FROM factura ORDER BY Clafac DESC');
        $number = $number[0]['id'] + 1; //Siguiente Numero
        $client = send_query('SELECT * FROM clientes WHERE clacli = ' . $clientID)[0];
        $nomcli = $client['nombre'];
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $serial = strtoupper($serial);
        $sql = "INSERT INTO factura (Clafac, Claeje, Claemp, Serie, Numero, Clacli, Nomcli,fecha, fechavalor, feccobro, referencia, bimpo, importe) VALUES ($invoiceID, $campaignID, $bussinesID, '$serial', $number, $clientID, '$nomcli' , DATETIME($year, $month, $day, 12, 0, 0), DATETIME($year, $month, $day, 12, 0, 0), DATETIME($year, $month, $day, 12, 0, 0), '$reference', $totalnotax, $totaltax)";
        send_query($sql);
        $invoiceID = send_query('SELECT TOP 1 Clafac as id FROM factura ORDER BY Clafac DESC');
        $invoiceID = $invoiceID[0]['id'] + 1; //Siguiente Clafac
        return $invoiceID;
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

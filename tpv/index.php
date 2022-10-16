<?php
include '../router.php';
include '../functions.php';

?>
<script src="/js/main.js"></script>
<?php

Route::add("/tpv/", function () {
    ?><div id="app"><?php
    include 'views/catalog/index.php';
    ?></div><?php
});

Route::add('/tpv/([a-z-0-9-]*)', function ($var1) {
    $dir = 'views';
    if (file_exists($dir . '/' . $var1 . '/index.php')) {
        
        ?><div id="app"><?php
        include $dir . '/' . $var1 . '/index.php';
        ?></div><?php
    }
});

Route::run('/');

include 'template.php';
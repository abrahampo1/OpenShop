<?php
include '../router.php';

?>

<script src="/js/main.js"></script>
<script>
    function defer(method) {
        if (window.jQuery) {
            method();
        } else {
            setTimeout(function() {
                defer(method)
            }, 50);
        }
    }
</script>



<?php

Route::add("/dashboard/", function () {
    include '../functions.php';

?><div id="app" class="index"><?php
                                include 'views/home/index.php';
                                ?></div>
    <script>
        defer(function() {
            $('#background').addClass('hide');

        })
    </script>

    <?php
});
$app_data = false;
Route::add('/dashboard/([a-z-0-9-]*)', function ($var1) {
    include '../functions.php';
    $dir = 'apps';
    if (file_exists($dir . '/' . $var1 . '/index.php')) {
        if (file_exists($dir . '/' . $var1 . '/manifest.json')) {
            $app_data = json_decode(file_get_contents($dir . '/' . $var1 . '/manifest.json'), true);

    ?>

            <script>
                defer(function() {
                    $('#current_app').html('<?= $app_data['name'] ?>')
                    $('.sidebar').addClass('hide')
                })
            </script>


        <?php

        }
        ?><div id="app" class="maximized beingapp"><?php
                                                    include $dir . '/' . $var1 . '/index.php';
                                                    ?></div><?php
                                                        }
                                                    });
                                                    Route::run('/');


                                                            ?>


<?php


include 'template.php';


?>


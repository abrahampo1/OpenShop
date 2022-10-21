<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="/js/OpenModals.css">
    <script src="https://code.iconify.design/iconify-icon/1.0.1/iconify-icon.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <?php

    if (existe('SELECT * FROM rg_settings WHERE name = "RG_DATABASE_CORE"')) {
        $val  = sql_data('SELECT * FROM rg_settings WHERE name = "RG_DATABASE_CORE"')['value'];
        echo '<script src="/db_cores/' . $val . '/index.js"></script>';
    }

    ?>
    <script src="/js/classicges.js"></script>
    <title>OpenDashboard</title>
</head>

<body>
    <div class="nav">
        <div class="home-btn" onclick="toggle_sidebar()">
            <iconify-icon inline icon="dashicons:menu-alt3"></iconify-icon> <span id="current_app">Inicio</span>
        </div>
        <img src="img/logo.png" alt="">
    </div>
    <div class="sidebar">
        <div class="sidebar-title">
            Acceso Rápido
        </div>
        <div class="sidebar-app-btn">
            <a class="content" href="./">
                <iconify-icon inline icon="ci:home-alt-outline" style="background-color: gray;"></iconify-icon> Inicio
            </a>
        </div>
        <div class="sidebar-app-btn">
            <a class="content" href="articles">
                <iconify-icon inline icon="bx:purchase-tag-alt"></iconify-icon> Artículos
            </a>
        </div>

        <hr>
        <div class="sidebar-app-list ">
            <div class="lcontent">
                Artículos y Pedidos
                <iconify-icon inline icon="akar-icons:chevron-right"></iconify-icon>
            </div>
            <div class="list hide fade-in-left">
                <div class="sidebar-app-btn">
                    <a class="content" href="articles">
                        <iconify-icon inline icon="bx:purchase-tag-alt"></iconify-icon> Artículos
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-app-list ">
            <div class="lcontent">
                Clientes
                <iconify-icon inline icon="akar-icons:chevron-right"></iconify-icon>
            </div>
            <div class="list hide fade-in-left">
                <div class="sidebar-app-btn">
                    <a class="content" href="clientes">
                        <iconify-icon style="background-color: purple;" inline icon="bi:person-lines-fill">
                        </iconify-icon> Clientes
                    </a>
                </div>
                <div class="sidebar-app-btn">
                    <a class="content" href="fidelizacion">
                        <iconify-icon style="background-color: purple;" inline icon="charm:star"></iconify-icon>
                        Fidelización
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-app-list ">
            <div class="lcontent">
                Pagos
                <iconify-icon inline icon="akar-icons:chevron-right"></iconify-icon>
            </div>
            <div class="list hide fade-in-left">
                <div class="sidebar-app-btn">
                    <a class="content" href="facturas">
                        <iconify-icon style="background-color: navy;" inline icon="la:file-invoice-dollar">
                        </iconify-icon> Facturas
                    </a>
                </div>
                <div class="sidebar-app-btn">
                    <a class="content" href="presupuestos">
                        <iconify-icon style="background-color: navy;" inline icon="la:file-invoice"></iconify-icon>
                        Presupuestos
                    </a>
                </div>
                <div class="sidebar-app-btn">
                    <a class="content" href="albaranes">
                        <iconify-icon style="background-color: navy;" inline icon="nimbus:invoice"></iconify-icon>
                        Albaranes
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-app-list ">
            <div class="lcontent">
                Ajustes
                <iconify-icon inline icon="akar-icons:chevron-right"></iconify-icon>
            </div>
            <div class="list hide fade-in-left">
                <div class="sidebar-app-btn">
                    <a class="content" href="settings">
                        <iconify-icon style="background-color: gray;" inline icon="ci:settings"></iconify-icon> Ajustes
                        de la aplicación
                    </a>
                </div>

            </div>
        </div>
    </div>
    <div id="background"></div>
</body>

</html>

<script>
    $('.sidebar-app-list').on('click', (e => {
        $('.sidebar-app-list').removeClass('selected')
        let h = $(e.currentTarget).find('.list').hasClass('hide')
        $('.sidebar-app-list .list').addClass('hide')
        if (h) {
            $(e.currentTarget).find('.list').removeClass('hide')
            $(e.currentTarget).addClass('selected')
        } else {
            $(e.currentTarget).find('.list').addClass('hide')

        }


    }))
    $('#background').fadeOut('fast')
    $('#background').on('click', (e => {
        toggle_sidebar();
    }))

    function toggle_sidebar() {
        $('.sidebar').toggleClass('hide');
        $('.index').toggleClass('maximized')
        $('.sidebar-app-list .list').addClass('hide')
        $('#background').fadeToggle('fast')
        $('.sidebar-app-list').removeClass('selected')
    }
</script>



<script src="js/OpenModals.js"></script>
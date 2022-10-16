<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="/js/OpenModals.css">
    <script src="/js/OpenModals.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.1/iconify-icon.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
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
    </div>
    <div id="background"></div>
</body>

</html>

<script>
$('.sidebar-app-list').on('click', (e => {
    $('.sidebar-app-list').removeClass('selected')
    let h = $(e.currentTarget).find('.list').hasClass('hide')
    $(e.currentTarget).find('.list').addClass('hide')
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
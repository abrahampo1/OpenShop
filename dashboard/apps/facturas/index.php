<div class="flex">
    <div class="w20">
        <div class="sidebutton" data-page="lista">
            Listado de Facturas
        </div>
        <div class="sidebutton" data-page="crear">
            Crear Factura
        </div>
        <div class="sidebutton" data-page="ajustes">
            Ajustes de Facturas
        </div>
    </div>
    <div class="w80" id="sapp"></div>
</div>
<script>
    defer(function() {
        $('.sidebutton').on('click', (e) => {
            var location = window.location.pathname;
            let i = location.split('/');
            $('.sidebutton').removeClass('selected')
            $(e.currentTarget).addClass('selected');
            $('#sapp').html('<loading><iconify-icon icon="eos-icons:bubble-loading" width="150" height="150"></iconify-icon></loading>')
            $('#sapp').load('/dashboard/apps/' + i[2] + '/pages/' + $(e.currentTarget).attr('data-page') +
                '/index.php')
            localStorage.setItem('current_page', '/dashboard/apps/' + i[2] + '/pages/' + $(e.currentTarget)
                .attr('data-page') +
                '/index.php')
        })
        $('.sidebutton')[0].click()
    })
</script>
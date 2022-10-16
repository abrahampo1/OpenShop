<div class="flex">
    <div class="w20">
        <div class="sidebutton" data-page="catalog">
            Cátalogo de Artículos
        </div>
    </div>
    <div class="w80" id="sapp"></div>
</div>
<script>
defer(function() {
    $('.sidebutton').on('click', (e) => {
        var location = window.location.pathname;
        let i = location.split('/');
        $(e.currentTarget).addClass('selected');
        $('#sapp').load('/dashboard/apps/' + i[2] + '/pages/' + $(e.currentTarget).attr('data-page') +
            '/index.php')
    })
})
</script>
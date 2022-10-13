<div class="flex h100">
    <div class="w30 h100 p10 sidebar fade-in-left">
        <h1>Ajustes</h1>
        <hr>
        <div class="link" onclick="cargar('info')">Información del dispositivo</div>
    </div>
    <div class="w70 h100 fade-in" id="ajustes_contenido">

    </div>
</div>


<script>
function cargar(pag) {
    $('#ajustes_contenido').load('views/ajustes/views/' + pag + '.php');
    $('#ajustes_contenido').removeClass('fade-in');
    setTimeout(() => {
        $('#ajustes_contenido').addClass('fade-in');
    }, 10);
}
$('#ajustes_contenido').load('views/ajustes/views/info.php');
</script>
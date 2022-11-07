<?php

include '../../../../../functions.php';

?>

<div class="flex" style="align-items: center;">
    <div class="w50">
        <h2>Base de datos</h2>
        <p>Configura la base de datos para que el programa pueda mostrar e interactuar con los conjuntos de datos que
            especifiques</p>
    </div>
    <button class="button primary">Añadir nueva base de datos</button>
</div>

<div class="flex" style="justify-content: flex-start;">
    <div class="card" data-core="internal">
        <h3>Base de datos interna</h3>
        <p>Base de datos predeterminada del programa. </p>
        <div class="settings">
            <iconify-icon inline onclick="select_bdo_core('internal')" icon="ep:select"></iconify-icon>
        </div>
    </div>
    <div class="card" data-core="classicges6">
        <h3>ClassicGes 6</h3>
        <p>Utilize su ordenador con ClassicGes como base de datos.</p>
        <div class="settings">
            <iconify-icon inline onclick="select_bdo_core('classicges6')" icon="ep:select"></iconify-icon>
            <iconify-icon inline onclick="configure_ges()" icon="ci:settings"></iconify-icon>
        </div>
    </div>
</div>


<script>
let bdocore = localStorage.getItem('bdo_core');
$('div[data-core="' + bdocore + '"]').addClass('selected')


function select_bdo_core(core, div) {
    $('.card').removeClass('selected');
    $('div[data-core="' + core + '"]').addClass('selected')
    localStorage.setItem('bdo_core', core)
    $.ajax({
        type: "POST",
        url: "/api.php",
        data: {
            resource: 'settings',
            name: 'RG_DATABASE_CORE',
            value: core
        },
        dataType: "dataType",
        success: function(response) {

        }
    });
}

function configure_ges() {
    create_modal([{
        type: 'text',
        tag: 'h1',
        text: 'Configurar ClassicGes 6'
    }, {
        type: 'text',
        tag: 'p',
        text: 'Recuerde que es necesario que el equipo donde tiene el ClassicGes 6 tenga instalado el núcleo proporcionado por Rodapro'
    }, {
        type: 'text',
        tag: 'div',
        text: '<hr>'
    }, {
        type: 'div',
        classList: ['flex', 'center'],
        tag: 'div',
        content: [{
            type: 'text',
            tag: 'h3',
            text: 'Token de acceso <a href="https://rodapro.es" target="_blank"><iconify-icon inline icon="ci:external-link"></iconify-icon></a>',
        }, {
            type: 'input',
            tag: 'input',
            placeholder: 'ASDWGDSFSD...',
            name: 'token',
            id: 'clasgestoken',
            value: "<?= (existe('SELECT * FROM rg_settings WHERE name = "RGDB_CLASSGES6_TOKEN"'))?sql_data('SELECT * FROM rg_settings WHERE name = "RGDB_CLASSGES6_TOKEN"')->value:'' ?>",
            classList: ['w50']
        }]
    }, {
        type: 'div',
        classList: ['flex', 'center'],
        tag: 'div',
        content: [{
            type: 'text',
            tag: 'div',
            text: ''
        }, {
            type: 'text',
            tag: 'div',
            classList: ["button", 'secondary'],
            text: 'Probar conexión',
            id: 'clasgestokenbtn',
            onclick: function() {
                let before = $('#clasgestokenbtn').html();
                $('#clasgestokenbtn').html(
                    '<iconify-icon inline icon="line-md:loading-twotone-loop"></iconify-icon>'
                );
                let tok = $('#clasgestoken').val()
                const Clasges = new ClassicGes(tok);
                Clasges.test().then(r => {
                    $.ajax({
                        type: "POST",
                        url: "/api.php",
                        data: {
                            resource: 'settings',
                            name: 'RGDB_CLASSGES6_TOKEN',
                            value: tok
                        },
                        dataType: "dataType",
                        success: function(response) {

                        }
                    });
                    $('#clasgestokenbtn').html(
                        '<iconify-icon inline icon="akar-icons:check"></iconify-icon>'
                    );
                    $('#clasgestokenbtn').addClass('success');
                    setTimeout(() => {
                        $('#clasgestokenbtn').html(before);
                        $('#clasgestokenbtn').removeClass('success');
                    }, 2000);
                }).catch(r => {
                    $('#clasgestokenbtn').html(
                        '<iconify-icon inline icon="akar-icons:cross"></iconify-icon>'
                    );
                    $('#clasgestokenbtn').addClass('error');
                    $('#clasgestoken').addClass('focus')
                    $('#clasgestoken').addClass('shake-horizontal')
                    $('#clasgestoken').val('');
                    setTimeout(() => {
                        $('#clasgestokenbtn').html(before);
                        $('#clasgestokenbtn').removeClass('error');
                        $('#clasgestoken').removeClass('focus')
                        $('#clasgestoken').removeClass('shake-horizontal')
                    }, 2000);
                    console.log('Mal')
                });
            }
        }]
    }])
}
</script>
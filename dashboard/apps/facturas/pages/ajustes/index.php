<?php

include('../../../../../functions.php');

?>
<h1>Ajustes de facturas</h1>
<p>Establece la configuración por omisión de las facturas.</p>
<br><br>
<div class="w100">
    <div class="flex">
        <h3 class="w30">Empresa</h3>
        <select name="" class="select" style="padding-left: 10px; padding-right: 10px; width: 70%" id="bussiness">
            <option value="">example</option>
        </select>
    </div>
    <br>
    <div class="flex">
        <h3 class="w30">Ejercicio</h3>
        <select name="" class="select" style="padding-left: 10px; padding-right: 10px; width: 70%" id="exercise">
            <option value="">example</option>
        </select>
    </div>
</div>
<script>
    defer(function() {
        var DATABASE = new DB();
        DATABASE.bussiness().then(r => {
            document.getElementById('bussiness').innerHTML = ''
            r.forEach(element => {
                let opt = document.createElement('option')
                opt.value = element.id
                opt.innerText = element.name
                document.getElementById('bussiness').appendChild(opt)
            });
        })
        DATABASE.exercises().then(r => {
            document.getElementById('exercise').innerHTML = ''
            r.forEach(element => {
                let opt = document.createElement('option')
                opt.value = element.id
                opt.innerText = element.name
                document.getElementById('exercise').appendChild(opt)
            });
        })
    })
</script>
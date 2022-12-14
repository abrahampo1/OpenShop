<?php

include('../../../../../functions.php');

?>
<h1>Ajustes de facturas</h1>
<p>Establece la configuración por omisión de las facturas.</p>
<br><br>
<div class="w100">
    <div class="flex">
        <h3 class="w30">Empresa</h3>
        <select onchange="settings('RGDB_CLASSGES6_INVOICE_DEFAULT_BUSSINESS', this.value)" class="select" style="padding-left: 10px; padding-right: 10px; width: 70%" id="bussiness">
            <option value="">-= Seleccione =-</option>
            <?php
            $def = sql_data('SELECT * FROM rg_settings WHERE name = "RGDB_CLASSGES6_INVOICE_DEFAULT_BUSSINESS"');
            if ($def) {
                $def = $def->value;
            }
            foreach (sql_array('bussiness', ['id', 'name']) as $key => $value) {
            ?>
                <option <?= ($def == $value['id']) ? 'selected' : '' ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
            <?php
            }

            ?>
        </select>

    </div>
    <br>
    <div class="flex">
        <h3 class="w30">Ejercicio</h3>
        <select name="" onchange="settings('RGDB_CLASSGES6_INVOICE_DEFAULT_CAMPAIGN', this.value)" class="select" style="padding-left: 10px; padding-right: 10px; width: 70%">
            <?php
            $def = sql_data('SELECT * FROM rg_settings WHERE name = "RGDB_CLASSGES6_INVOICE_DEFAULT_CAMPAIGN"');
            if ($def) {
                $def = $def->value;
            }
            foreach (sql_array('campaign', ['id', 'name']) as $key => $value) {
            ?>
                <option <?= ($def == $value['id']) ? 'selected' : '' ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
            <?php
            }

            ?>
        </select>
    </div>
    <br>
    <div class="flex">
        <h3 class="w30">Serie</h3>
        <select name="" id="" onchange="settings('RGDB_CLASSGES6_INVOICE_DEFAULT_SERIES', this.value)" class="select" style="padding-left: 10px; padding-right: 10px; width: 70%">
            <?php

            $letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
            $def = sql_data('SELECT * FROM rg_settings WHERE name = "RGDB_CLASSGES6_INVOICE_DEFAULT_SERIES"');
            if ($def) {
                $def = $def->value;
                $def = trim($def);
            }
            var_dump($def);
            foreach ($letters as $value) {
            ?>

                <option <?= ($def == $value) ? 'selected' : '' ?> value="<?= $value ?>"><?= strtoupper($value) ?></option>

            <?php
            }
            ?>
        </select>
    </div>
</div>
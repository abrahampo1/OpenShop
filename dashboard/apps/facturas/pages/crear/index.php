<?php

include('../../../../../functions.php');

?>
<script>
let createdata = {
    client: {
        required: true,
    },
    reference: {
        required: false
    }
}
</script>


<div class="flex" style="justify-content: center;">
    <div class="w70">
        <div class="flex center">
            <div class="w30">
                <h3 class="text-center w100">Cliente</h3>
            </div>
            <div class="w70">
                <input type="text" class="w100" onfocus="this.classList.remove('success'); this.value=''"
                    placeholder="Buscar por nombre..."
                    oninput="search('clients', 'name', this).then(r=>{createdata['client']['value']=r['id']; this.value=r['name']; this.classList.add('success')})">
            </div>
        </div>
        <div class="flex center">
            <div class="w30">
                <h3 class="text-center w100">Referencia</h3>
            </div>
            <div class="w70">
                <input type="text" class="w100" placeholder="Escribe una referencia...">
            </div>
        </div>
    </div>
</div>


<script>

</script>
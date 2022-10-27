<?php

include('../../../../../functions.php');

?>
<div class="w100">
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
        DATABASE.create_invoice()

    })
</script>
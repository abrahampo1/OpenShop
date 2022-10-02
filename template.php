<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/animations.css">
</head>

<body>
    <div id="dock">
        <div class="dock-content">
            <button class="dock-button" onclick="redirect('catalog')">
                <iconify-icon inline icon="carbon:shopping-catalog"></iconify-icon> Cátalogo
            </button>
            <button class="dock-button" onclick="redirect('parque')">
                <iconify-icon inline icon="icon-park-outline:party-balloon"></iconify-icon> Parque
            </button>
            <button class="dock-button" onclick="redirect('tickets')">
                <iconify-icon inline icon="carbon:receipt"></iconify-icon> Tickets
            </button>
            <button class="dock-button" onclick="redirect('caja')">
                <iconify-icon inline icon="la:cash-register"></iconify-icon> Caja
            </button>
        </div>
    </div>
</body>

</html>


<div class="keypad draggable" data-x="0" data-y="0" id="keypad" style="display: none;">
    <div class="flex ">
        <div class="top-span"></div>
    </div>
    <div class="flex">
        <div class="card">7</div>
        <div class="card">8</div>
        <div class="card">9</div>
        <div class="card">4</div>
        <div class="card">5</div>
        <div class="card">6</div>
        <div class="card">1</div>
        <div class="card">2</div>
        <div class="card">3</div>
        <div class="card double">0</div>
        <div class="card">.</div>
        <div class="card">C</div>
        <div class="card">AC</div>
        <div class="card">OK</div>
    </div>
</div>


<div class="modal" id="checkout" style="display: none;">
    <div class="checkout">
        <div class="closetag" onclick="checkout(false)">
            <iconify-icon inline icon="akar-icons:chevron-up"></iconify-icon>
        </div>
        <div id="app">
            <div class="p50">
                <h1>Total <strong class="cart-total">4.00€</strong></h1>
                <h2>Deglose de venta</h2>
                <div class="table cart">
                    <div class="list">
                        <div class="l10 textcenter">1</div>
                        <div class="l50">CocaCola</div>
                        <div class="l20 textcenter">IVA 21%</div>
                        <div class="l20 textcenter">4.00€</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="context">
            <div class="sm-cart">
                <div>
                    <button class="primary">
                        Realizar el Pago
                    </button>
                    <br>
                    <br>
                    <div class="center click clientcard">
                        <h2 class="black">
                            <iconify-icon inline icon="bi:person-fill"></iconify-icon> Público en general
                        </h2>
                    </div>
                    <h3>¿Como va a pagar el cliente?</h3>
                    <div class="table" id="metododepago">
                        <?php
                        
                        foreach (sql_array("SELECT * FROM mpp_tipo_pago") as $key => $value) {
                            ?>

                        <div data-id="<?= $value['id'] ?>"
                            class="list <?= ($value['defecto'] == 1)? 'selected': ''  ?>">
                            <?= $value['nombre'] ?>
                        </div>

                        <?php
                        }
                        
                        ?>

                    </div>
                    <br>
                    <button class="card-text click secondary" onclick="checkout(false)">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/draggable.js"></script>
<script src="js/keypad.js"></script>
<script src="js/printer.js"></script>


<script>
document.body.onload = function() {
    LoadCart();

    $("#metododepago .list").on("click", (data) => {
        let element = data.target;
        $("#metododepago .selected").removeClass("selected");
        $(element).addClass("selected");

    });

}
</script>
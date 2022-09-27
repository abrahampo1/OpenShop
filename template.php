<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <div id="dock">
        <div class="dock-content">
            <button class="dock-button" onclick="redirect('catalog')">
                Cátalogo
            </button>
            <button class="dock-button" onclick="redirect('tickets')">
                Tickets
            </button>
            <button class="dock-button" onclick="redirect('caja')">
                Caja
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


<div class="modal" id="checkout">
    <div class="checkout">
        <div id="app">
            <div class="p50">
                <h1>Total 4.00€</h1>
                <h2>Deglose de venta</h2>
                <div class="table">
                    <div class="list">
                        <div class="l10 textcenter">1</div>
                        <div class="l50">CocaCola</div>
                        <div class="l20 textcenter">IVA 21%</div>
                        <div class="l20 textcenter">4.00€</div>
                    </div>
                </div>
            </div>
        </div>
        <div id="dock">
            <div class="dock-content">
                <div class="card-text click">
                    <h2 class="black textcenter">Realizar Pago</h2>
                </div>
                <div class="card-text click">
                    <h4 class="black textcenter">Aplicar Descuentos</h4>
                </div>
                <h3>¿Como va a pagar el cliente?</h3>
                <div class="table">
                    <div class="list selected">
                        Efectivo
                    </div>
                    <div class="list">
                        Tarjeta
                    </div>
                    <div class="list">
                        Transferencia Bancaria
                    </div>
                </div>
                <br>
                <div class="card-text click cancel" onclick="checkout(false)">
                    <h4 class=" textcenter cancel">Cancelar</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/draggable.js"></script>
<script src="js/keypad.js"></script>
<script src="js/printer.js"></script>
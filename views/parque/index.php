<div class="flex h100">
    <div class="flex w70 p10 fade-in">
        <div class="card blue click" onclick="AddToCart()">
            <div class="card-text">
                <h2>Pedro</h2>
                <h3>Entrada 21:00</h3>
            </div>
        </div>
    </div>
    <div class="flex xcenter w30 fade-in-right">
        <div class="sm-cart zig-zag-top closed">
            <div class="abfull">
                <div class="center click clientcard">
                    <h2 class="black">
                        <iconify-icon inline icon="bi:person-fill"></iconify-icon> Público en general
                    </h2>
                </div>
                <div class="table cart">
                </div>
            </div>
            <div class="buttons">
                <button class="secondary">
                    Guardar Ticket
                </button>
                <button class="total mt10" onclick="checkout(true)">
                    Cobrar <strong class="cart-total">4.00€</strong>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="cartItem" style="display: none;">
    <div class="modal-content">
        <div class="header">
            <iconify-icon icon="ep:close-bold" onclick="UnLoadItem()"></iconify-icon>
            <h1 id="itemName">Ejemplo</h1>
            <div></div>
        </div>
        <div class="formGroup flex">
            <h2>Cantidad</h2>
            <div class="w70 xcenter">
                <div class="input ">
                    <div class="textfield cantidad" onclick="KeyPadFocus(this)"></div>
                </div>
            </div>
        </div>
        <div class="formGroup flex">
            <h2>Precio por unidad</h2>
            <div class="w70 xcenter">
                <div class="input ">
                    <div class="textfield pu" onclick="KeyPadFocus(this)"></div>
                </div>
            </div>
        </div>
        <div class="formGroup flex">
            <h2>IVA</h2>
            <div class="w70 xcenter">
                <div class="input ">
                    <div class="textfield iva" onclick="KeyPadFocus(this)"></div>
                </div>
            </div>
        </div>
        <div class="formGroup flex">
            <h2>Descuentos Aplicados</h2>
            <div class="w70 xcenter">
                <div class="input ">
                    <div class="flex h100 w100 descuentos">
                    </div>
                </div>
            </div>
        </div>
        <h1>IVA/UD <strong class="ivaincl">4.00€</strong></h1>
        <h1 class="total">Total 4.00€</h1>
        <hr>
        <div class="flex">
            <button class="delete">Eliminar</button>
            <button class="save">Guardar</button>
        </div>
    </div>
</div>


<script>

</script>
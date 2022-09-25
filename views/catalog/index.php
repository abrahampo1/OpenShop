<div class="flex h100">
    <div class="flex w70 p10">
        <?php
        
        
        foreach (sql_array('SELECT * FROM tpv_inventory') as $key => $value) {
            ?>

        <div class="card blue click" onclick="AddToCart(<?= $value['id'] ?>)">
            <div class="card-text">
                <h2><?= $value['name'] ?></h2>
                <h3><?= number_format($value['sell_base_price'], 2) ?>€</h3>
            </div>
        </div>

        <?php
        }
        
        ?>
    </div>
    <div class="flex xcenter w30">
        <div class="sm-cart zig-zag-top closed">
            <div class="abfull">
                <div class="table" id="cart">
                </div>
            </div>
            <div class="buttons">
                <button>
                    Guardar Ticket
                </button>
                <button class="total">
                    Cobrar 4.00€
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="cartItem" style="display: none;">
    <div class="modal-content">
        <h1>Ejemplo</h1>
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

        <h1 class="total">Total 4.00€</h1>
        <hr>
        <div class="flex">
            <button onclick="UnLoadItem()">Cerrar</button>
            <button class="delete">Eliminar</button>
            <button class="save">Guardar</button>
        </div>
    </div>
</div>


<script>
LoadCart()



function LoadItem(id) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let item = cart[id];
    $('#cartItem .pu').text(item.precio)
    $('#cartItem .total').text('Total ' + (cart[id].precio * cart[id].cantidad).toFixed(2) + '€')
    $('#cartItem .pu').on('DOMSubtreeModified', () => {
        cart[id].precio = parseFloat($('#cartItem .pu').text())
        $('#cartItem .total').text('Total ' + (cart[id].precio * cart[id].cantidad).toFixed(2) + '€')
    })
    $('#cartItem .cantidad').text(item.cantidad)
    $('#cartItem .cantidad').on('DOMSubtreeModified', () => {
        cart[id].cantidad = parseInt($('#cartItem .cantidad').text())
        $('#cartItem .total').text('Total ' + (cart[id].precio * cart[id].cantidad).toFixed(2) + '€')
    })
    $('#cartItem .save').on('click', () => {
        localStorage.setItem("cart", JSON.stringify(cart));
        UnLoadItem()
    })
    $('#cartItem .delete').on('click', () => {
        cart.splice(id, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        UnLoadItem()
    })
    OpenModal('cartItem')
}

function UnLoadItem() {
    $('#cartItem .cantidad').off('DOMSubtreeModified')
    $('#cartItem .pu').off('DOMSubtreeModified')
    CloseModal('cartItem');
    LoadCart()
}
</script>
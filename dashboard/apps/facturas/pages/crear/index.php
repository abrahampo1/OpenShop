<?php

include('../../../../../functions.php');

?>
<script>
    var taxes = {
        1: 21,
        2: 10,
        3: 4,
        4: 0
    }

    var createdata = {
        client: {
            required: true,
        },
        reference: {
            required: false,
            value: ''
        },
        total: {
            required: true,
        },
        totalnotax: {
            required: true
        }

    }
</script>


<div class="flex" style="justify-content: center;">
    <div class="w70">
        <div class="flex">
            <div></div>
            <div class="flex">
                <div class="hsep"></div>
                <button class="button primary" onclick="start_creation()">Guardar</button>
            </div>
        </div>
        <br>
        <div class="flex center">
            <div class="w30">
                <h3 class=" w100">Cliente</h3>
            </div>
            <div class="w70">
                <input type="text" class="w100" onfocus="this.classList.remove('success'); this.value=''" placeholder="Buscar por nombre..." oninput="search('clients', 'name', this).then(r=>{createdata['client']['value']=r['id']; this.value=r['name']; this.classList.add('success')})">
            </div>
        </div>
        <div class="flex center">
            <div class="w30">
                <h3 class=" w100">Referencia</h3>
            </div>
            <div class="w70">
                <input type="text" class="w100" placeholder="Escribe una referencia..." onchange="createdata['reference']['value'] = this.value">
            </div>
        </div>
        <div class="flex center">
            <h3>Artículos</h3>
        </div>
        <div class="flex center">
            <div class="w100">
                <input type="text" id="article" class="w100" onfocus="this.classList.remove('success'); this.value=''" oninput="search('articles', 'name', this).then(r=>{createdata['client']['value']=r['id']; this.value=r['name'];this.dataset['selid'] = r['id']; this.classList.add('success')})" placeholder="Buscar por referencia, nombre, ...">
            </div>
            <div style="margin: 5px"></div>
            <div class=" flex center" style="justify-content: center;">
                <button class="button secondary" onclick="add_article()">Añadir</button>
            </div>
        </div>
        <br>
        <div class="w100" id="items">

        </div>
        <div class="w100 flex">
            <div class="w50"></div>
            <div class="w50">
                <div class="flex center">
                    <p>Subtotal</p>
                    <p id="subtotal">0 €</p>
                </div>
                <div class="flex center">
                    <p>IVA Incluido</p>
                    <p id="tax">0 €</p>
                </div>
                <div class="flex center">
                    <h2>Total</h2>
                    <h3 id="total">0 €</h3>
                </div>
            </div>
        </div>
        <br>
        <br>
        <h2>Proximamente...</h2>
        <div class="flex center disabled">
            <div class="w30">
                <h3 class=" w100">Enviar por correo</h3>
            </div>
            <div class="w70">
                <input type="text" disabled class="w100" onfocus="this.classList.remove('success'); this.value=''" placeholder="Correo electrónico del cliente..." oninput="search('clients', 'name', this).then(r=>{createdata['client']['value']=r['id']; this.value=r['name']; this.classList.add('success')})">
            </div>
        </div>
        <div class="flex center disabled">
            <div class="w30">
                <h3 class=" w100">Permitir pago directo</h3>
            </div>
            <div class="w70">
            </div>
        </div>
        <div class="flex center disabled">
            <div class="w30">
                <h3 class=" w100">Calendario de pagos</h3>
            </div>
            <div class="w70">
            </div>
        </div>
        <br>
        <br>

    </div>
</div>


<script>
    async function createFile() {
        Object.entries(createdata).forEach(([key, value]) => {
            console.log(value)
            if (value['required'] && !value['value']) {
                alert('Necesitas indicar el campo "' + key + '"')
                return;
            }
        })

        let cart = JSON.parse(localStorage.getItem('temp-cart')) || false;
        if (!cart) {
            alert('No se puede crear una factura vacía')
            return;
        }

        let invoiceID = api({
            resource: 'create_row',
            table: 'invoices',

        })

    }

    function add_article() {
        let art = $('#article').data('selid');
        $('#article').removeClass('success')
        $('#article').val('')
        if (!art) {
            alert('oh oh')
        }

        let cart = JSON.parse(localStorage.getItem('temp-cart')) || [];

        cart.push()
        let cartIndex;

        let cartArticle = cart.findIndex(function(ar) {
            return ar.id == art
        });
        console.log(cartArticle)
        if (cartArticle >= 0) {
            cart[cartArticle].quantity++;
            localStorage.setItem('temp-cart', JSON.stringify(cart))
            load_cart()
        } else {
            api({
                resource: 'search_table_id',
                column: ['name', 'id', 'price', 'hasvariant', 'taxid'],
                table: 'articles',
                value: art
            }).then(r => {
                let article = r[0]
                let id = article.id
                article.tax = taxes[article.taxid]
                article.quantity = 1;
                cart.push(article)
                localStorage.setItem('temp-cart', JSON.stringify(cart))

                load_cart()
            })
        }

    }

    function load_cart() {
        let cart = JSON.parse(localStorage.getItem('temp-cart')) || [];
        $('#items').html('')
        let i = 0;
        let total = 0
        let tax = 0;
        cart.forEach(article => {
            $('#items').append(`
                <div class="flex center article" onclick="modify_cart(${i})">
                    <p class="w30">${article.name}</p>
                    <p class="w30 text-center">x${article.quantity}</p>
                    <p class="w20f text-right" >${article.price} €/UD</p>
                    <p class="w20f text-right" >${((article.price * 100) * article.quantity / 100)} €</p>
                </div>
                `)
            i++;
            tax += ObtenerIVA(((article.price * 100) * article.quantity / 100), article.tax)
            total += ((article.price * 100) * article.quantity / 100);
            $('#subtotal').text(total.toFixed(2) + ' €')
            $('#total').text(total.toFixed(2) + ' €')
            $('#tax').text(tax.toFixed(2) + ' €')

            createdata['total']['value'] = total.toFixed(2);
            createdata['totalnotax']['value'] = (total - tax).toFixed(2);
        });
    }

    async function modify_cart(id) {
        let cart = JSON.parse(localStorage.getItem('temp-cart')) || [];
        let article = cart[id];
        let modal = [{
            type: 'text',
            tag: 'h1',
            text: 'Modificar Artículo'
        }, {
            type: "div",
            tag: "div",
            classList: ["flex", "center"],
            content: [{
                    type: "text",
                    tag: "h3",
                    text: "Nombre",
                    classList: ["w30"],
                },
                {
                    type: "input",
                    tag: "input",
                    value: article.name.trim(),
                    required: true,
                    placeholder: "Nombre....",
                    name: "name",
                    classList: ["w70"],
                },
            ],
        }, {
            type: "div",
            tag: "div",
            classList: ["flex", "center"],
            content: [{
                    type: "text",
                    tag: "h3",
                    text: "Precio",
                    classList: ["w30"],
                },
                {
                    type: "input",
                    tag: "input",
                    value: article.price,
                    required: true,
                    placeholder: "Precio....",
                    name: "price",
                    classList: ["w70"],
                },
            ],
        }, {
            type: "div",
            tag: "div",
            classList: ["flex", "center"],
            content: [{
                    type: "text",
                    tag: "h3",
                    text: "Cantidad",
                    classList: ["w30"],
                },
                {
                    type: "input",
                    tag: "input",
                    value: article.quantity,
                    required: true,
                    placeholder: "Cantidad....",
                    name: "quantity",
                    classList: ["w70"],
                },
            ],
        }, {
            type: "div",
            tag: "div",
            classList: ["flex", "center"],
            content: [{
                    type: "text",
                    tag: "h3",
                    text: "Impuesto",
                    classList: ["w30"],
                },
                {
                    type: "input",
                    tag: "input",
                    value: article.tax,
                    required: true,
                    placeholder: "Porcentaje....",
                    name: "tax",
                    classList: ["w70"],
                },
            ],
        }]

        create_modal(modal).then(r => {
            Object.entries(r).forEach(([key, value]) => {
                cart[id][key] = value;
                localStorage.setItem('temp-cart', JSON.stringify(cart))
                load_cart()
            })
        })
    }


    function create_invoice() {
        return new Promise((resolve, reject) => {
            api({
                resource: 'CreateInvoice',
                clientID: createdata['client']['value'],
                reference: createdata['reference']['value'],
                totalnotax: createdata['totalnotax']['value'],
                total: createdata['total']['value']
            }).then(r => {
                resolve(r)
            })
        })
    }

    async function start_creation() {
        $('#loading').fadeIn();
        $('#loading .text').text('Creando archivo de factura...')
        let clafac = await create_invoice();
        $('#loading .text').text('Se ha creado una factura con el Código: ' + clafac)
        setTimeout(async () => {
            $('#loading .text').text('Comenzando asignación de articulos a esa factura')
            let cart = JSON.parse(localStorage.getItem('temp-cart')) || [];
            for (let index = 0; index < cart.length; index++) {
                const element = cart[index];
                await upload_article(clafac, element)

            }

        }, 1000);

    }


    function upload_article(clafac, article) {
        return new Promise((resolve, reject) => {
            console.log(article)
            $('#loading .text').text('Subiendo articulo "' + article.name + '"')
            setTimeout(() => {
                resolve()
            }, 2000);
        })

    }

    load_cart()
</script>
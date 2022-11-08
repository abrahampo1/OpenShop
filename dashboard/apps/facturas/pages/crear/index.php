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
                <h3 class=" w100">Cliente</h3>
            </div>
            <div class="w70">
                <input type="text" class="w100" onfocus="this.classList.remove('success'); this.value=''"
                    placeholder="Buscar por nombre..."
                    oninput="search('clients', 'name', this).then(r=>{createdata['client']['value']=r['id']; this.value=r['name']; this.classList.add('success')})">
            </div>
        </div>
        <div class="flex center">
            <div class="w30">
                <h3 class=" w100">Referencia</h3>
            </div>
            <div class="w70">
                <input type="text" class="w100" placeholder="Escribe una referencia...">
            </div>
        </div>
        <div class="flex center">
            <h3>Artículos</h3>
        </div>
        <div class="flex center">
            <div class="w100">
                <input type="text" id="article" class="w100" onfocus="this.classList.remove('success'); this.value=''"
                    oninput="search('articles', 'name', this).then(r=>{createdata['client']['value']=r['id']; this.value=r['name'];this.dataset['selid'] = r['id']; this.classList.add('success')})"
                    placeholder="Buscar por referencia, nombre, ...">
            </div>
            <div style="margin: 5px"></div>
            <div class=" flex center" style="justify-content: center;">
                <button class="button primary" onclick="add_article()">Añadir</button>
            </div>
        </div>
        <br>
        <div class="w100" id="items">

        </div>
    </div>
</div>


<script>
function add_article() {
    let art = $('#article').data('selid');

    if (!art) {
        alert('oh oh')
    }

    let cart = JSON.parse(localStorage.getItem('temp-cart')) || [];

    cart.push()

    api({
        resource: 'search_table_id',
        column: ['name', 'id', 'price', 'hasvariant'],
        table: 'articles',
        value: art
    }).then(r => {
        let article = r[0]
        let id = article.id

        let cartIndex;

        function searchID(article, index) {
            if (article.id === id) {
                cartIndex = index;
                return index;

            }
        }
        let cartArticle = cart.find(searchID);
        console.log(cartIndex)

        if (cartIndex == null || cartIndex < 0) {
            article.quantity = 1;
            cart.push(article)
            localStorage.setItem('temp-cart', JSON.stringify(cart))
        } else {
            cart[cartIndex].quantity++;
            localStorage.setItem('temp-cart', JSON.stringify(cart))
        }

        load_cart()
    })
}

function load_cart() {
    let cart = JSON.parse(localStorage.getItem('temp-cart')) || [];
    $('#items').html('')
    let i = 0;
    cart.forEach(article => {
        $('#items').append(`
                <div class="flex center article" onclick="modify_cart(${i})">
                    <p class="w40">${article.name}</p>
                    <p class="w30 text-center">${article.quantity}</p>
                    <p class="w30 text-right" >${article.price} €</p>
                </div>
                `)
        i++;

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
    }]
    if (article.hasvariant) {
        modal.push({
            type: 'text',
            tag: 'h2',
            text: 'Talla'
        }, {
            type: 'select',
            tag: 'select',
            value: ['hola', 'test']
        })
    }
    create_modal(modal)
}


load_cart()
</script>
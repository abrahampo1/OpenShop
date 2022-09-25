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


<script src="js/draggable.js"></script>
<script src="js/keypad.js"></script>
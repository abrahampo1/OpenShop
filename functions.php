<?php
function getRandomString($n)
{
    $characters =
        '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}
function get($data, $required = false)
{
    if (isset($_GET[$data])) {
        return $_GET[$data];
    } elseif ($required) {
        error($data . ' is required');
    } else {
        return false;
    }
}
function post($data, $required = false)
{
    if (isset($_POST[$data])) {
        return $_POST[$data];
    } elseif ($required) {
        error($data . ' is required');
    } else {
        return false;
    }
}

function success($text)
{
    echo json_encode([
        'success' => true,
        'message' => $text,
    ]);
    exit();
}

function error($text)
{
    echo json_encode([
        'success' => false,
        'status' => 'error',
        'error' => $text,
    ]);
    exit();
}

function sql_array($sql)
{
    include 'database.php';
    $do = mysqli_query($link, $sql);
    if (!$do) {
        error('Error en la base de datos \n' . mysqli_error($link));
    }
    $res = [];
    while ($row = mysqli_fetch_assoc($do)) {
        $res[] = $row;
    }
    return $res;
}

function sql_data($sql)
{
    if (isset(sql_array($sql)[0])) {
        return sql_array($sql)[0];
    } else {
        return false;
    }
}



function existe($sql)
{
    include 'database.php';
    $do = mysqli_query($link, $sql);
    if ($do->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

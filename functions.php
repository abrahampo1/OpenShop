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

function sql_array($table, $columns = [], $search_cols = null, $search_value = null, $order = [])
{
    include_once 'databases/classicges6/function.php';
    include 'databases/classicges6/structure.php';
    $cols = '';
    $table_data = $DBS[$table];
    $table_name = $table_data['table'];
    foreach ($columns as $value) {
        $cols .= $table_data['columns'][$value] . ' as ' .  $value . ',';
    }

    $cols = substr($cols, 0, -1);

    $search = '';
    if ($search_cols && $search_value) {
        $search = ' WHERE ';
        foreach ($search_cols as $value) {
            $search .= 'LOWER(' . $table_data['columns'][$value] . ') LIKE LOWER("%' .  $search_value . '%") OR ';
        }
    }
    $search = substr($search, 0, -3);

    $or = '';
    if ($order != []) {
        $or = ' ORDER BY ';
        foreach ($order as $key => $value) {
            $or .= $table_data['columns'][$value[0]] . ' ' . $value[1];
        }
    }

    return send_query("SELECT $cols FROM $table_name $search $or");
}

function sql_by_id($table, $columns, $id)
{
    include_once 'databases/classicges6/function.php';
    include 'databases/classicges6/structure.php';
    $cols = '';
    $table_data = $DBS[$table];
    $table_name = $table_data['table'];
    foreach ($columns as $value) {
        $cols .= $table_data['columns'][$value] . ' as ' .  $value . ',';
    }

    $cols = substr($cols, 0, -1);

    $search = ' WHERE ' . $table_data['columns']['id'] . ' = ' . $id;

    return send_query("SELECT $cols FROM $table_name $search");
}

function sql_data($sql)
{
    include 'database.php';
    if (existe($sql)) {
        $l = mysqli_query($link, $sql);
        $row = mysqli_fetch_object($l);
        return $row;
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

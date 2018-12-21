<?php

if (isset($_POST['id_tabla'])) {
    include_once $_SERVER['DOCUMENT_ROOT'].'/progresa/business/globals.php';
    include_once SERVER.'/business/class.conexion.php';
    include_once SERVER.'/business/controller/class.mtablas.php';
    $arr = \cprogresa\MTablas::getTablaCheckBox($_POST['id_tabla'], null,4);
    if (is_array($arr)) {
        header('Content-type: application/json');
        echo json_encode($arr);
    }
}


<?php

include_once dirname(__DIR__, 1) . '/Modelos/clasesDao/inventarioDao.php';
include_once dirname(__DIR__, 1).'/Modelos/clasesDao/loginDao.php';

$inventario = new inventarioDao();
$usDao = new LoginDao();

if (isset($_GET['codBarra']) && $_GET['fecha']) {
    $objInventario = setObjInventario(
        ($_GET['codBarra']),
        str_replace('T', ' ', $_GET['fecha'])
    );
    if ($inventario->insertarInventario($objInventario) == 0) {
        echo json_encode('FailInventario');
    } else {
        echo "todo bien";
    }
}

if (isset($_GET['usuario']) && $_GET['contra']) {
    $usuario = $_GET['usuario'];
    $contra = $_GET['contra'];
    $resp= $usDao->validarUsuario($usuario,$contra);
    if($resp){
        echo "inicio sesion";
    }else{
        echo "invalido";
    }
}

if(isset($_GET["cerrar"])){
    session_destroy();
}

function setObjInventario(
    $codigoBarra,
    $fechaInventario
){
    $objInventario = new Inventario();
    $objInventario->setCodigoBarra($codigoBarra);
    $objInventario->setFechaInventario($fechaInventario);
    return $objInventario;
}

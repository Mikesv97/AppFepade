<?php

include_once dirname(__DIR__, 1).'/Modelos/clasesDao/inventarioDao.php';

$inventario = new inventarioDao();

if ($_POST) {
    if (isset($_POST['key'])) {
        $tipo = $_POST['key'];
        switch ($tipo) {
            case "insertar":
                $objInventario = setObjInventario(
                    $_POST['txtCodigoBarra'],
                    $_POST['fechaCodBarra']
                );
                if($inventario->insertarInventario($objInventario) == 0){
                    echo json_encode('FailInventario');
                }else{
                    echo json_encode('InsertadoInventario');
                }
                break;
        }
    }
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

?>
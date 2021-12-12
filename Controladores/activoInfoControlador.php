<?php

include_once '../Modelos/activoFijoInformacionDao.php';



if ($_POST) {
    if (isset($_POST['key'])) {
        $activo = $_POST['key'];
        switch ($activo) {
            case "getInfoActivo":
                $obj = new Activo_fijo_informacion;
                $resp = $obj->tablaActivoFijo();
                echo json_encode($resp);
            break;
            case "mostrarInformaci":
                break;
            case "modificar":
                break;
            case "eliminar":
                break;
        }
    }
}

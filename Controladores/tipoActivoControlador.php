<?php

include_once '../Modelos/tipoActivoDao.php';
$tipoActivo = new tipoActivoDao();

if ($_POST) {
    if (isset($_POST['key'])) {
        $tipo = $_POST['key'];
        switch ($tipo) {
            case "insertar":
                $objTipoActivo = setObjTipoActivo(
                    $_POST['tipoActivoId'],
                    $_POST['tipoActivoNombre'],
                    $_POST['usuarioId']
                );
                if($tipoActivo->insertarTipoActivo($objTipoActivo) == 0){
                    echo json_encode('FailTipoActivo');
                }else{
                    echo json_encode('InsertadoTipoActivo');
                }
                break;
            case "modificar":
                $objTipoActivoMod = setObjTipoActivoMod(
                    $_POST['tipoActivoNombre'],
                    $_POST['usuarioId'],
                    $_POST['tipoActivoId']
                );
                if($tipoActivo->modificarTipoActivo($objTipoActivoMod) == 0){
                    echo json_encode('FailTipoActivo');
                }else{
                    echo json_encode('ModificadoTipoActivo');
                }
                break;
            case "eliminar":
                $id = $_POST['tipoActivoId'];
                if($tipoActivo->eliminarTipoActivo($id) == 0){
                    echo json_encode('FailTipoActivo');
                }else{
                    echo json_encode('DeleteTipoActivo');
                }
                break;
            case "mostrar":
                $resp = $tipoActivo->mostrarTipoActivo();
                echo json_encode($resp);
                break;
        }
    }
}

function setObjTipoActivo(
    $tipoActivoId,
    $tipoActivoNombre,
    $usuarioId
){
    $objTipoActivo = new tipo_Activo();
    $objTipoActivo->setTipoActivoId($tipoActivoId);
    $objTipoActivo->setTipoActivoNombre($tipoActivoNombre);
    $objTipoActivo->setUsuarioId($usuarioId);
    return $objTipoActivo;
}

function setObjTipoActivoMod(
    $tipoActivoNombre,
    $usuarioId,
    $tipoActivoId
){
    $objTipoActivoMod = new tipo_Activo();
    $objTipoActivoMod->setTipoActivoNombre($tipoActivoNombre);
    $objTipoActivoMod->setUsuarioId($usuarioId);
    $objTipoActivoMod->setTipoActivoId($tipoActivoId);
    return $objTipoActivoMod;
}

?>
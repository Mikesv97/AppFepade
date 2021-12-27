<?php

include_once '../Modelos/activoResponsableDAO.php';

$activoResponsable = new activoResponsableDao();

if ($_POST) {
    if (isset($_POST['key'])) {
        $responsable = $_POST['key'];
        switch ($responsable) {
            case "insertar":
                $objResposanble = setObjResposanble(
                    $_POST['CodigoResponsable'],
                    $_POST['NombreResponsable'],
                    $_POST['Estado']
                );
                if($activoResponsable->insertarResponsable($objResposanble) == 0){
                    echo json_encode('FailResponsable');
                }else{
                    echo json_encode('InsertadoResponsable');
                }
                break;
            case "modificar":
                $objResposanbleMod = setObjResposanbleMod(
                    $_POST['CodigoResponsable'],
                    $_POST['NombreResponsable'],
                    $_POST['Estado'],
                    $_POST['ResponsableCodigo']
                );
                if($activoResponsable->modificarResponsable($objResposanbleMod) == 0){
                    echo json_encode('FailResponsable');
                }else{
                    echo json_encode('ModificadoResponsable');
                }
                break;
            case "eliminar":
                $id = $_POST['ResponsableCodigo'];
                if($activoResponsable->eliminarResponsable($id) == 0){
                    echo json_encode('FailResponsable');
                }else{
                    echo json_encode('DeleteResponsable');
                }
                break;
            case "mostrar":
                $resp = $activoResponsable->mostrarActivoResponsable();
                echo json_encode($resp);
                break;
        }
    }
}


function setObjResposanble(
    $CodigoResponsable,
    $NombreResponsable,
    $Estado
){
    $objResposanble = new responsable_Activo();
    $objResposanble->setCodigoResponsable($CodigoResponsable);
    $objResposanble->setNombreResponsable($NombreResponsable);
    $objResposanble->setEstado($Estado);
    return $objResposanble;
}

function setObjResposanbleMod(
    $CodigoResponsable,
    $NombreResponsable,
    $Estado,
    $ResponsableId
){
    $objResposanbleMod = new responsable_Activo();
    $objResposanbleMod->setCodigoResponsable($CodigoResponsable);
    $objResposanbleMod->setNombreResponsable($NombreResponsable);
    $objResposanbleMod->setEstado($Estado);
    $objResposanbleMod->setResponsableCodigo($ResponsableId);
    return $objResposanbleMod;
}
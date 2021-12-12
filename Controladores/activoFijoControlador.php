<?php
include_once '../Modelos/activoFijoDao.php';
include_once '../Modelos/activoEspecificacionDao.php';
include_once '../Modelos/historialActivoDao.php';

$activoFijo = new activoFijoDAO();
$actifoEspe = new activoEspecificacionDao();
$activoHist = new historialActivoDao();

if ($_POST) {
    if (isset($_POST['key'])) {
        $activo = $_POST['key'];
        switch ($activo) {
            case "insertar":
            
            $tipoActivo = $_POST["tipoActivo"];

            $objActivoFijo = setObjActivoFijo(
                $_POST['ActivoReferencia'],
                $_POST['PartidaCta'],
                $_POST['EmpresaId'],
                $_POST['numeroSerie'],
                $_POST['ActivoFechaAdq'],
                $_POST['ActivoFactura'],
                $_POST['ActivoTipo'],
                $_POST['ActivoDescripcion'],
                $_POST['Estructura1Id'],
                $_POST['Estructura2Id'],
                $_POST['Estructura3Id'],
                $_POST['UsuarioId'],
                $_POST['ActivoFechaCaduc'],
                $_POST['ActivoEliminado'],
                $_POST['estado'],
                $_POST['ResponsableId']
            );

            echo json_encode($activoFijo->insertarActivoFijo($objActivoFijo));
                break;
        }
    }
}

//FUNCION PARA CARGAR LA IMAGEN AL SERVIDOR LOCAL Y INSERTAR EL NOMBRE DE LA IMAGEN EN EL SERVIDOR
function cargarImagen()
{
    $nombreimg = $_FILES["Imagen"]["name"];
    $archivo = $_FILES["Imagen"]["tmp_name"];
    $ruta = "../Recursos/Multimedia/Imagenes/Upload/";
    if (move_uploaded_file($archivo, $ruta . $nombreimg)) {
        return $nombreimg;
    } else {
        return "error de carga de imagen";
    }
}

function setObjActivoFijo(
    $ActivoReferencia,
    $PartidaCta,
    $EmpresaId,
    $NumeroSerie,
    $ActivoFechaAdq,
    $ActivoFactura,
    $ActivoTipo,
    $ActivoDescripcion,
    $Estructura1Id,
    $Estructura2Id,
    $Estructura3Id,
    $UsuarioId,
    $ActivoFechaCaduc,
    $ActivoEliminado,
    $Estado,
    $ResponsableCodigo
) {
    $objActivoFijo = new Activo_Fijo();
    $objActivoFijo->setActivoReferencia($ActivoReferencia);
    $objActivoFijo->setPartidaCta($PartidaCta);
    $objActivoFijo->setEmpresaId($EmpresaId);
    $objActivoFijo->setNumeroSerie($NumeroSerie);
    $objActivoFijo->setActivoFechaAdq($ActivoFechaAdq);
    $objActivoFijo->setActivoFactura($ActivoFactura);
    $objActivoFijo->setActivoTipo($ActivoTipo);
    $objActivoFijo->setActivoDescripcion($ActivoDescripcion);
    $objActivoFijo->setEstructura1Id($Estructura1Id);
    $objActivoFijo->setEstructura2Id($Estructura2Id);
    $objActivoFijo->setEstructura3Id($Estructura3Id);
    $objActivoFijo->setUsuarioId($UsuarioId);
    $objActivoFijo->setActivoFechaCaduc($ActivoFechaCaduc);
    $objActivoFijo->setActivoEliminado($ActivoEliminado);
    $objActivoFijo->setEstado($Estado);
    $objActivoFijo->setImagen(cargarImagen());
    $objActivoFijo->setResponsableCodigo($ResponsableCodigo);

    return $objActivoFijo;
    
}

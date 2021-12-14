<?php
include_once '../Modelos/activoFijoDao.php';
include_once '../Modelos/activoEspecificacionDao.php';
include_once '../Modelos/historialActivoDao.php';

$activoFijo = new activoFijoDAO();
$activoEspe = new activoEspecificacionDao();
$activoHist = new historialActivoDao();

if ($_POST) {
    if (isset($_POST['key'])) {
        $activo = $_POST['key'];
        switch ($activo) {
            case "insertar":
                //VARIABLE DONDE SE ALMACENA EL ID TIPO ACTIVO
                $tipoActivo = $_POST["tipoActivo"];
                //ASIGNADO A LA FUNCION SETOBJETIVOACTIVOFIJO LO QUE VIENE POR LOS INPUT SEGUN EL NAME
                $objActivoFijo = setObjActivoFijo(
                    $_POST['ActivoReferencia'],
                    $_POST['PartidaCta'],
                    $_POST['EmpresaId'],
                    $_POST['numeroSerie'],
                    str_replace('T', ' ', $_POST['ActivoFechaAdq']),
                    $_POST['ActivoFactura'],
                    $_POST['ActivoTipo'],
                    $_POST['ActivoDescripcion'],
                    $_POST['Estructura1Id'],
                    $_POST['Estructura2Id'],
                    $_POST['Estructura3Id'],
                    $_POST['UsuarioId'],
                    str_replace('T', ' ', $_POST['ActivoFechaCaduc']),
                    $_POST['activoDel'],
                    $_POST['activoInac'],
                    $_POST['ResponsableId']
                );
                //GUARDANDO EN LA VARIABLE ACTIVOINSERTADO LO QUE VENGA DE LA FUNCION INSERTAACTIVOFIJO
                $activoInsertado = $activoFijo->insertarActivoFijo($objActivoFijo);

                //SI INSERTARACTIVO FIJO ES DIFERENTE A 0 ENTONCES SE OBTETIENE ENTONCES SE OBTIENE EL ID ACTIVO
                //DEL ACTIVO QUE SE ESTA INSERTADO, SI NO MANDA A ERROR
                if ($activoInsertado != 0) {
                    $obtejerIdActivo = $activoEspe->obtenerId();
                    if ($obtejerIdActivo != 0) {
                        //DEPENDIENDO DEL ID TIPO ACTIVO QUE VENGA ASI SE REALIZA EL INSERT EN LA TABLA CON SUS CAMPOS
                        $insertActive = false;
                        switch ($tipoActivo) {
                            case 1:

                                //ASIGNADO A LA FUNCION SETOBJETIVO LO QUE VIENE POR LOS INPUT SEGUN EL NAME
                                $objActivoEspeComp = setObjActivoEspeComp(
                                    $obtejerIdActivo, //LLAMANDO A LA VARIABLE DONDE TIENE LA FUNCION PARA OBTENER EL ID ACTIVO INGRESADOR
                                    $_POST['Procesador'],
                                    $_POST['Generacion'],
                                    $_POST['Ram'],
                                    $_POST['TipoRam'],
                                    $_POST['DiscoDuro'],
                                    $_POST['CapacidadD1'],
                                    $_POST['DiscoDuro2'],
                                    $_POST['CapacidadD2'],
                                    $_POST['SO'],
                                    $_POST['Office'],
                                    $_POST['Modelo'],
                                    $_POST['ip']
                                );
                                if ($activoEspe->insertarActEspCom($objActivoEspeComp) == 0) {
                                    echo json_encode('FailActiveEspe');
                                } else {
                                    $insertActive = true;
                                }

                                break;
                            case 2:

                                //ASIGNADO A LA FUNCION SETOBJETIVOLO QUE VIENE POR LOS INPUT SEGUN EL NAME
                                $objActivoEspeComp = setObjActivoEspeComp(
                                    $obtejerIdActivo,
                                    $_POST['Procesador'],
                                    $_POST['Generacion'],
                                    $_POST['Ram'],
                                    $_POST['TipoRam'],
                                    $_POST['DiscoDuro'],
                                    $_POST['CapacidadD1'],
                                    $_POST['DiscoDuro2'],
                                    $_POST['CapacidadD2'],
                                    $_POST['SO'],
                                    $_POST['Office'],
                                    $_POST['Modelo'],
                                    $_POST['ip']
                                );
                                if ($activoEspe->insertarActEspCom($objActivoEspeComp) == 0) {
                                    echo json_encode('FailActiveEspe');
                                } else {
                                    $insertActive = true;
                                }
                                break;
                            case 3:

                                $objActivoEspeImpre = setObjActivoEspeImpre(
                                    $obtejerIdActivo,
                                    $_POST['Modelo'],
                                    $_POST['TonerN'],
                                    $_POST['TonerM'],
                                    $_POST['TonerC'],
                                    $_POST['TonerA'],
                                    $_POST['tambor'],
                                    $_POST['fusor']
                                );
                                if ($activoEspe->insertarActEspImp($objActivoEspeImpre) == 0) {
                                    echo json_encode('FailActiveEspe');
                                } else {
                                    $insertActive = true;
                                }
                                break;
                            case 4:

                                $objActivoEspeProy = setObjActivoEspeProy(
                                    $obtejerIdActivo,
                                    $_POST['Modelo'],
                                    $_POST['HorasUso'],
                                    $_POST['HoraEco']
                                );
                                if ($activoEspe->insertarActEspProy($objActivoEspeProy) == 0) {
                                    echo json_encode('FailActiveEspe');
                                } else {
                                    $insertActive = true;
                                }
                                break;
                        }
                        if ($insertActive) {
                            //ASIGNANDO A LA FUNCION OBJACTIVOHISTORIAL LO QUE VIENEN EN LOS INPUT SEGUN SU NAME
                            $objActivoHistorial = setObjActivoHistorial(
                                $obtejerIdActivo,
                                $_POST['Estructura3Id'],
                                $_POST['ResponsableId'],
                                $_POST['HistoricoComentario'],
                                $_POST['UsuarioId'],
                                $_POST['activoInac']
                            );
                            if ($activoHist->insertarHistorial($objActivoHistorial) == 0) {
                                echo json_encode('FailActiveEspe');
                            } else {
                                echo json_encode('Insertado');
                            }
                        }else{
                            echo json_encode("FailActiveEspe");
                        }
                    } else {
                        echo json_encode("FailActiveEspe");
                    }
                } else {
                    echo json_encode("FailActiveEspe");
                }
                break;
                //MOSTRANDO TABLA ACTIVO FIJO
            case "getInfoActivo":
                $resp = $activoFijo->tablaActivoFijo();
                echo json_encode($resp);
                break;
            case "getInfoHistorial":
                $id = $_POST['ActivoId'];
                $resp2 = $activoHist->mostrarHistorial($id);
                echo json_encode($resp2);
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

//OBJETO DONDE SETAMOS LOS VALORES PARA INSERTAR EN LA TABLA ACTIVO FIJO
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
//OBJETO DONDE SETEAMOS LOS VALORES PARA INSERTAR EN ACTIVO ESPECIFICACION SI ES COMPUTADORA
function setObjActivoEspeComp(
    $ActivoId,
    $Procesador,
    $Generacion,
    $Ram,
    $TipoRam,
    $DiscoDuro,
    $CapacidadD1,
    $DiscoDuro2,
    $CapacidadD2,
    $SO,
    $Office,
    $Modelo,
    $IP
) {
    $objActivoEspeComp = new Activo_Especificacion();
    $objActivoEspeComp->setActivoId($ActivoId);
    $objActivoEspeComp->setProcesador($Procesador);
    $objActivoEspeComp->setGeneracion($Generacion);
    $objActivoEspeComp->setRam($Ram);
    $objActivoEspeComp->setTipoRam($TipoRam);
    $objActivoEspeComp->setDiscoDuro($DiscoDuro);
    $objActivoEspeComp->setCapacidad_D1($CapacidadD1);
    $objActivoEspeComp->setDiscoDuro2($DiscoDuro2);
    $objActivoEspeComp->setCapacidad_D2($CapacidadD2);
    $objActivoEspeComp->setSO($SO);
    $objActivoEspeComp->setOffice($Office);
    $objActivoEspeComp->setModelo($Modelo);
    $objActivoEspeComp->setIP($IP);

    return $objActivoEspeComp;
}

//OBJETO DONDE SETEAMOS LOS VALORES PARA INSERTAR EN ACTIVO ESPECIFICACION SI ES UNA IMPRESORA
function setObjActivoEspeImpre(
    $ActivoId,
    $Modelo,
    $TonerN,
    $TonerM,
    $TonerC,
    $TonerA,
    $tambor,
    $fusor
) {
    $objActivoEspeImpre = new Activo_Especificacion();
    $objActivoEspeImpre->setActivoId($ActivoId);
    $objActivoEspeImpre->setModelo($Modelo);
    $objActivoEspeImpre->setTonerN($TonerN);
    $objActivoEspeImpre->setTonerM($TonerM);
    $objActivoEspeImpre->setTonerC($TonerC);
    $objActivoEspeImpre->setTonerA($TonerA);
    $objActivoEspeImpre->setTambor($tambor);
    $objActivoEspeImpre->setFusor($fusor);
    return $objActivoEspeImpre;
}

//OBJETO DONDE SETEAMOS LOS VALORES PARA INSERTAR EN ACTIVO ESPECIFICACION SI ES UN PROYECTOR
function setObjActivoEspeProy(
    $ActivoId,
    $Modelo,
    $HorasUso,
    $HoraEco
) {
    $objActivoEspeProy = new Activo_Especificacion();
    $objActivoEspeProy->setActivoId($ActivoId);
    $objActivoEspeProy->setModelo($Modelo);
    $objActivoEspeProy->setHorasUso($HorasUso);
    $objActivoEspeProy->setHoraEco($HoraEco);
    return $objActivoEspeProy;
}

//OBJETO DONDE SETEAMOS LOS VALORES PARA INSERTAR EN HISTORIAL DE ACTIVO
function setObjActivoHistorial(
    $ActivoId,
    $Estructura31_id,
    $Responsable_id,
    $Historico_comentario,
    $Usuario_id,
    $Estado
) {
    $objActivoHistorial = new historial_Activo();
    $objActivoHistorial->setActivoId($ActivoId);
    $objActivoHistorial->setEstructura31Id($Estructura31_id);
    $objActivoHistorial->setResponsableId($Responsable_id);
    $objActivoHistorial->setHistoricoComentario($Historico_comentario);
    $objActivoHistorial->setUsuarioId($Usuario_id);
    $objActivoHistorial->setEstado($Estado);
    return $objActivoHistorial;
}

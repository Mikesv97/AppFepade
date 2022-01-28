<?php
include_once dirname(__DIR__, 1) . '/Modelos/clasesDao/activoFijoDao.php';
include_once dirname(__DIR__, 1) . '/Modelos/clasesDao/activoEspecificacionDao.php';
include_once dirname(__DIR__, 1) . '/Modelos/clasesDao/historialActivoDao.php';

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

                //AQUI SE EVALUA QUE EL TIPO DE ACTIVO SEA DE LOS 4 SOLICITADOS SI NO ES ASI NO SE INSERTARA EL ACTIVO
                if ($tipoActivo == 1 || $tipoActivo == 2 || $tipoActivo == 3 || $tipoActivo == 4 || $tipoActivo == 5 || $tipoActivo == 6) {
                    //ASIGNADO A LA FUNCION SETOBJETIVOACTIVOFIJO LO QUE VIENE POR LOS INPUT SEGUN EL NAME
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

                            /*
                            ID TIPO ACTIVO 1 ---> PC
                            ID TIPO ACTIVO 2 ---> LAPTOP
                            ID TIPO ACTIVO 3 ---> IMPRESOR
                            ID TIPO ACTIVO 4 ---> PROYECTOR
                            */
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
                                        $_POST['ip'],
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
                                case 5:
                                    $noDatos = 'N/A';
                                    //ASIGNADO A LA FUNCION SETOBJETIVO LO QUE VIENE POR LOS INPUT SEGUN EL NAME
                                    $objActivoEspeComp = setObjActivoEspeComp(
                                        $obtejerIdActivo, //LLAMANDO A LA VARIABLE DONDE TIENE LA FUNCION PARA OBTENER EL ID ACTIVO INGRESADOR
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $_POST['Modelo'],
                                        $_POST['ip']
                                    );

                                    if ($activoEspe->insertarActEspCom($objActivoEspeComp) == 0) {
                                        echo json_encode('FailActiveEspe');
                                    } else {
                                        $insertActive = true;
                                    }

                                    break;
                                case 6:
                                    $noDatos = 'N/A';
                                    //ASIGNADO A LA FUNCION SETOBJETIVO LO QUE VIENE POR LOS INPUT SEGUN EL NAME
                                    $objActivoEspeComp = setObjActivoEspeComp(
                                        $obtejerIdActivo, //LLAMANDO A LA VARIABLE DONDE TIENE LA FUNCION PARA OBTENER EL ID ACTIVO INGRESADOR
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $noDatos,
                                        $_POST['Modelo'],
                                        $noDatos
                                    );

                                    if ($activoEspe->insertarActEspCom($objActivoEspeComp) == 0) {
                                        echo json_encode('FailActiveEspe');
                                    } else {
                                        $insertActive = true;
                                    }

                                    break;
                            }

                            //evaluamos i el insert del tipo de activo que se inserto fue exitoso
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
                            } else {
                                echo json_encode("FailActiveEspe");
                            }
                        } else {
                            echo json_encode("FailActiveEspe");
                        }
                    } else {
                        echo json_encode("FailActiveEspe");
                    }
                } else {
                    echo json_encode('TipoNoSolicitado');
                }
                break;
            case "modificar":
                //VARIABLE DONDE SE ALMACENA EL ID TIPO ACTIVO
                $tipoActivo = $_POST["tipoActivo"];
                //AQUI SE EVALUA QUE EL TIPO DE ACTIVO SEA DE LOS 4 SOLICITADOS SI NO ES ASI NO SE MODIFICARA EL ACTIVO
                if ($tipoActivo == 1 || $tipoActivo == 2 || $tipoActivo == 3 || $tipoActivo == 4 || $tipoActivo == 5 || $tipoActivo == 6) {
                    //ASIGNADO A LA FUNCION SETOBJETIVOACTIVOFIJO LO QUE VIENE POR LOS INPUT SEGUN EL NAME
                    $objActivoFijoMod = setObjActivoFijoMod(
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
                        $_POST['activoDel'],
                        $_POST['activoInac'],
                        $_POST['ResponsableId'],
                        $_POST['ActivoId']
                    );
                    $actiMod = $activoFijo->modificarActivoFijo($objActivoFijoMod);
                    $updateActive = false;
                    if ($actiMod != 0) {
                        switch ($tipoActivo) {
                                /*
                            ID TIPO ACTIVO 1 ---> PC
                            ID TIPO ACTIVO 2 ---> LAPTOP
                            ID TIPO ACTIVO 3 ---> IMPRESOR
                            ID TIPO ACTIVO 4 ---> PROYECTOR
                            */
                            case 1:
                                //ASIGNADO A LA FUNCION SETOBJETIVO LO QUE VIENE POR LOS INPUT SEGUN EL NAME
                                $ObjActivoEspeCompMod = setObjActivoEspeCompMod(
                                    $_POST['Procesador'],
                                    $_POST['Generacion'],
                                    $_POST['Ram'],
                                    $_POST['DiscoDuro'],
                                    $_POST['Modelo'],
                                    $_POST['SO'],
                                    $_POST['Office'],
                                    $_POST['ip'],
                                    $_POST['TipoRam'],
                                    $_POST['CapacidadD1'],
                                    $_POST['DiscoDuro2'],
                                    $_POST['CapacidadD2'],
                                    $_POST['ActivoId']
                                );

                                if ($activoEspe->modificarActEspCom($ObjActivoEspeCompMod) == 0) {
                                    echo json_encode('FailModificarActivo');
                                } else {
                                    $updateActive = true;
                                }
                                break;
                            case 2:
                                //ASIGNADO A LA FUNCION SETOBJETIVO LO QUE VIENE POR LOS INPUT SEGUN EL NAME
                                $ObjActivoEspeCompMod = setObjActivoEspeCompMod(
                                    $_POST['Procesador'],
                                    $_POST['Generacion'],
                                    $_POST['Ram'],
                                    $_POST['DiscoDuro'],
                                    $_POST['Modelo'],
                                    $_POST['SO'],
                                    $_POST['Office'],
                                    $_POST['ip'],
                                    $_POST['TipoRam'],
                                    $_POST['CapacidadD1'],
                                    $_POST['DiscoDuro2'],
                                    $_POST['CapacidadD2'],
                                    $_POST['ActivoId']
                                );

                                if ($activoEspe->modificarActEspCom($ObjActivoEspeCompMod) == 0) {
                                    echo json_encode('FailModificarActivo');
                                } else {
                                    $updateActive = true;
                                }
                                break;
                            case 3:
                                $objActivoEspeImpreMod = setObjActivoEspeImpreMod(
                                    $_POST['Modelo'],
                                    $_POST['ip'],
                                    $_POST['TonerN'],
                                    $_POST['TonerM'],
                                    $_POST['TonerC'],
                                    $_POST['TonerA'],
                                    $_POST['tambor'],
                                    $_POST['fusor'],
                                    $_POST['ActivoId']
                                );

                                if ($activoEspe->modificarActEspImp($objActivoEspeImpreMod) == 0) {
                                    echo json_encode('FailModificarActivo');
                                } else {
                                    $updateActive = true;
                                }
                                break;
                            case 4:
                                $objActivoEspeProyMod = setObjActivoEspeProyMod(
                                    $_POST['Modelo'],
                                    $_POST['HorasUso'],
                                    $_POST['HoraEco'],
                                    $_POST['ActivoId']
                                );

                                if ($activoEspe->modificarActEspProy($objActivoEspeProyMod) == 0) {
                                    echo json_encode('FailModificarActivo');
                                } else {
                                    $updateActive = true;
                                }
                                break;
                            case 5:
                                $noDatos = 'N/A';
                                //ASIGNADO A LA FUNCION SETOBJETIVO LO QUE VIENE POR LOS INPUT SEGUN EL NAME
                                $ObjActivoEspeCompMod = setObjActivoEspeCompMod(
                                    $noDatos,
                                    $noDatos,
                                    $noDatos,
                                    $noDatos,
                                    $_POST['Modelo'],
                                    $noDatos,
                                    $noDatos,
                                    $_POST['ip'],
                                    $noDatos,
                                    $noDatos,
                                    $noDatos,
                                    $noDatos,
                                    $_POST['ActivoId']
                                );

                                if ($activoEspe->modificarActEspCom($ObjActivoEspeCompMod) == 0) {
                                    echo json_encode('FailModificarActivo');
                                } else {
                                    $updateActive = true;
                                }
                                break;
                            case 6:
                                $noDatos = 'N/A';
                                //ASIGNADO A LA FUNCION SETOBJETIVO LO QUE VIENE POR LOS INPUT SEGUN EL NAME
                                $ObjActivoEspeCompMod = setObjActivoEspeCompMod(
                                    $noDatos,
                                    $noDatos,
                                    $noDatos,
                                    $noDatos,
                                    $_POST['Modelo'],
                                    $noDatos,
                                    $noDatos,
                                    $noDatos,
                                    $noDatos,
                                    $noDatos,
                                    $noDatos,
                                    $noDatos,
                                    $_POST['ActivoId']
                                );

                                if ($activoEspe->modificarActEspCom($ObjActivoEspeCompMod) == 0) {
                                    echo json_encode('FailModificarActivo');
                                } else {
                                    $updateActive = true;
                                }
                                break;
                        }
                        if ($updateActive) {
                            echo json_encode('Modificado');
                        }
                    } else {
                        echo json_encode('FailModificarActivo');
                    }
                } else {
                    echo json_encode('TipoNoSolicitado');
                }
                break;
            case "eliminar":
                $id = $_POST['ActivoId'];
                if ($activoFijo->eliminarrActivoFijo($id) == 0) {
                    echo json_encode('FailActivoEliminado');
                } else {
                    echo json_encode('EliminadoAct');
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
            case "insertarHistorial":
                $historialInsertado = false;
                $ObjHistorico = setObjHistorico(
                    $_POST['guardarIdActivo2'],
                    $_POST['fechaHistorico'],
                    $_POST['Estructura3IdH'],
                    $_POST['ResponsableIdH'],
                    $_POST['HistoricoComentarioH'],
                    $_POST['UsuarioIdH'],
                    $_POST['activoInacH']
                );

                if ($activoHist->insertarNuevoHistorial($ObjHistorico) == 0) {
                    echo json_encode('FailHistorico');
                } else {
                    $historialInsertado = true;
                    if ($historialInsertado) {

                        $ObjActualizarEstActivo = setObjActualizarEstActivo(
                            $_POST['activoInacH'],
                            $_POST['ResponsableIdH'],
                            $_POST['Estructura3IdH'],
                            $_POST['guardarIdActivo2']
                        );

                        if ($activoFijo->updateEstado($ObjActualizarEstActivo) == 0) {
                            echo json_encode('FailHistorico');
                        } else {
                            echo json_encode('Insertado');
                        }
                    } else {
                        echo json_encode('FailHistorico');
                    }
                }
                break;
            case "eliminarHistorial":
                if ($activoHist->eliminarHistorial($_POST['historicoId']) == 0) {
                    echo json_encode('FailHistoricoEliminado');
                } else {
                    echo json_encode('Eliminado');
                }
                break;
            case "modificarHisotial":
                $ObjModificarHistorico = setObjModificarHistorico(
                    $_POST['fechaHistorico'],
                    $_POST['Estructura3IdH'],
                    $_POST['ResponsableIdH'],
                    $_POST['HistoricoComentarioH'],
                    $_POST['UsuarioIdH'],
                    $_POST['activoInacH'],
                    $_POST['historicoId']
                );

                //SI ES LA PRIMERA LINEA DE LA TABLA HISTORICO ES LA QUE SE SELECCIONO SE DEBE ACTUALIZAR EL ESTADO EN LA TABLA ACTIVO
                if ($_POST['ultimoLinea'] == 1) {
                    //EVALUAMOS LOS VALORES QUE VIENEN SETEADOS
                    if ($activoHist->modificarHistorial($ObjModificarHistorico) == 0) {
                        //SI MODIFICAR HISTORIAL ES IGUAL A CERO ENVIAMOS ERROR
                        echo json_encode('FailHistoricoModificado');
                    } else {
                        //SETEANDO EL OBJETO ESTADO PARA ENVIAR LOS VALORES A INSERTAR EN ACTIVO
                        $ObjActualizarEstActivo = setObjActualizarEstActivo(
                            $_POST['activoInacH'],
                            $_POST['ResponsableIdH'],
                            $_POST['Estructura3IdH'],
                            $_POST['guardarIdActivo2']
                        );
                        //EVALUAMOS QUE LOS DATOS DE ESTADO Y ACTIVOID SEAN DIFERENTE A 0
                        if ($activoFijo->updateEstado($ObjActualizarEstActivo) == 0) {
                            //SI EL VALOR ES IGUAL A CERO MANDA ERROR
                            echo json_encode('FailHistoricoModificado');
                        } else {
                            //SI NO ENVIAMOS MODIFICAR
                            echo json_encode('modificar');
                        }
                    }
                } else if ($_POST['ultimoLinea'] == 0) {
                    if ($activoHist->modificarHistorial($ObjModificarHistorico) == 0) {
                        //SI EL VALOR ES IGUAL A CERO MANDA ERROR
                        echo json_encode('FailHistoricoModificado');
                    } else {
                        //SI NO ENVIAMOS MODIFICAR
                        echo json_encode('modificar');
                    }
                }

                break;
            case "getInfAreas":
                $resp = $activoFijo->getDataArea();
                echo json_encode($resp);
                break;
        }
    }
}

//FUNCION PARA CARGAR LA IMAGEN AL SERVIDOR LOCAL Y INSERTAR EL NOMBRE DE LA IMAGEN EN EL SERVIDOR
function cargarImagen()
{
    $nombreimg = $_FILES["Imagen"]["name"];
    if ($nombreimg != null) {
        $archivo = $_FILES["Imagen"]["tmp_name"];
        $ruta = "../Recursos/Multimedia/Imagenes/Upload/";
        if (move_uploaded_file($archivo, $ruta . $nombreimg)) {
            return $nombreimg;
        } else {
            return "error de carga de imagen";
        }
    } else {
        $imagenBD = $_POST['imagenBD'];
        return $imagenBD;
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
    $objActivoFijo->setActivoReferencia(trim($ActivoReferencia));
    $objActivoFijo->setPartidaCta(trim($PartidaCta));
    $objActivoFijo->setEmpresaId(trim($EmpresaId));
    $objActivoFijo->setNumeroSerie(trim($NumeroSerie));
    $objActivoFijo->setActivoFechaAdq(trim($ActivoFechaAdq));
    $objActivoFijo->setActivoFactura(trim($ActivoFactura));
    $objActivoFijo->setActivoTipo(trim($ActivoTipo));
    $objActivoFijo->setActivoDescripcion(trim($ActivoDescripcion));
    $objActivoFijo->setEstructura1Id(trim($Estructura1Id));
    $objActivoFijo->setEstructura2Id(trim($Estructura2Id));
    $objActivoFijo->setEstructura3Id(trim($Estructura3Id));
    $objActivoFijo->setUsuarioId(trim($UsuarioId));
    $objActivoFijo->setActivoFechaCaduc(trim($ActivoFechaCaduc));
    $objActivoFijo->setActivoEliminado(trim($ActivoEliminado));
    $objActivoFijo->setEstado(trim($Estado));
    $objActivoFijo->setImagen(cargarImagen());
    $objActivoFijo->setResponsableCodigo(trim($ResponsableCodigo));

    return $objActivoFijo;
}

//OBJETO DONDE SETAMOS LOS VALORES PARA MODIFICAR EN LA TABLA ACTIVO FIJO
function setObjActivoFijoMod(
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
    $ResponsableCodigo,
    $ActivoId
) {
    $objActivoFijoMod = new Activo_Fijo();
    $objActivoFijoMod->setActivoReferencia(trim($ActivoReferencia));
    $objActivoFijoMod->setPartidaCta(trim($PartidaCta));
    $objActivoFijoMod->setEmpresaId(trim($EmpresaId));
    $objActivoFijoMod->setNumeroSerie(trim($NumeroSerie));
    $objActivoFijoMod->setActivoFechaAdq(trim($ActivoFechaAdq));
    $objActivoFijoMod->setActivoFactura(trim($ActivoFactura));
    $objActivoFijoMod->setActivoTipo(trim($ActivoTipo));
    $objActivoFijoMod->setActivoDescripcion(trim($ActivoDescripcion));
    $objActivoFijoMod->setEstructura1Id(trim($Estructura1Id));
    $objActivoFijoMod->setEstructura2Id(trim($Estructura2Id));
    $objActivoFijoMod->setEstructura3Id(trim($Estructura3Id));
    $objActivoFijoMod->setUsuarioId(trim($UsuarioId));
    $objActivoFijoMod->setActivoFechaCaduc(trim($ActivoFechaCaduc));
    $objActivoFijoMod->setActivoEliminado(trim($ActivoEliminado));
    $objActivoFijoMod->setEstado(trim($Estado));
    $objActivoFijoMod->setImagen(cargarImagen());
    $objActivoFijoMod->setResponsableCodigo(trim($ResponsableCodigo));
    $objActivoFijoMod->setActivoId(trim($ActivoId));
    return $objActivoFijoMod;
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
    $objActivoEspeComp->setActivoId(trim($ActivoId));
    $objActivoEspeComp->setProcesador(trim($Procesador));
    $objActivoEspeComp->setGeneracion(trim($Generacion));
    $objActivoEspeComp->setRam(trim($Ram));
    $objActivoEspeComp->setTipoRam(trim($TipoRam));
    $objActivoEspeComp->setDiscoDuro(trim($DiscoDuro));
    $objActivoEspeComp->setCapacidad_D1(trim($CapacidadD1));
    $objActivoEspeComp->setDiscoDuro2(trim($DiscoDuro2));
    $objActivoEspeComp->setCapacidad_D2(trim($CapacidadD2));
    $objActivoEspeComp->setSO(trim($SO));
    $objActivoEspeComp->setOffice(trim($Office));
    $objActivoEspeComp->setModelo(trim($Modelo));
    $objActivoEspeComp->setIP(trim($IP));

    return $objActivoEspeComp;
}

//OBJETO DONDE SETEAMOS LOS VALORES PARA MODIFICAR EN ACTIVO ESPECIFICACION SI ES COMPUTADORA
function setObjActivoEspeCompMod(
    $Procesador,
    $Generacion,
    $Ram,
    $DiscoDuro,
    $Modelo,
    $SO,
    $Office,
    $IP,
    $TipoRam,
    $CapacidadD1,
    $DiscoDuro2,
    $CapacidadD2,
    $ActivoId
) {
    $ObjActivoEspeCompMod = new Activo_Especificacion();

    $ObjActivoEspeCompMod->setProcesador(trim($Procesador));
    $ObjActivoEspeCompMod->setGeneracion(trim($Generacion));
    $ObjActivoEspeCompMod->setRam(trim($Ram));
    $ObjActivoEspeCompMod->setDiscoDuro(trim($DiscoDuro));
    $ObjActivoEspeCompMod->setModelo(trim($Modelo));
    $ObjActivoEspeCompMod->setSO(trim($SO));
    $ObjActivoEspeCompMod->setOffice(trim($Office));
    $ObjActivoEspeCompMod->setIP(trim($IP));
    $ObjActivoEspeCompMod->setTipoRam(trim($TipoRam));
    $ObjActivoEspeCompMod->setCapacidad_D1(trim($CapacidadD1));
    $ObjActivoEspeCompMod->setDiscoDuro2(trim($DiscoDuro2));
    $ObjActivoEspeCompMod->setCapacidad_D2(trim($CapacidadD2));
    $ObjActivoEspeCompMod->setActivoId(trim($ActivoId));
    return $ObjActivoEspeCompMod;
}

//OBJETO DONDE SETEAMOS LOS VALORES PARA INSERTAR EN ACTIVO ESPECIFICACION SI ES UNA IMPRESORA
function setObjActivoEspeImpre(
    $ActivoId,
    $Modelo,
    $IP,
    $TonerN,
    $TonerM,
    $TonerC,
    $TonerA,
    $tambor,
    $fusor
) {
    $objActivoEspeImpre = new Activo_Especificacion();
    $objActivoEspeImpre->setActivoId(trim($ActivoId));
    $objActivoEspeImpre->setModelo(trim($Modelo));
    $objActivoEspeImpre->setIP(trim($IP));
    $objActivoEspeImpre->setTonerN(trim($TonerN));
    $objActivoEspeImpre->setTonerM(trim($TonerM));
    $objActivoEspeImpre->setTonerC(trim($TonerC));
    $objActivoEspeImpre->setTonerA(trim($TonerA));
    $objActivoEspeImpre->setTambor(trim($tambor));
    $objActivoEspeImpre->setFusor(trim($fusor));
    return $objActivoEspeImpre;
}

//OBJETO DONDE SETEAMOS LOS VALORES PARA MODIFICAR EN ACTIVO ESPECIFICACION SI ES UNA IMPRESORA
function setObjActivoEspeImpreMod(
    $Modelo,
    $IP,
    $TonerN,
    $TonerM,
    $TonerC,
    $TonerA,
    $tambor,
    $fusor,
    $ActivoId
) {
    $objActivoEspeImpreMod = new Activo_Especificacion();
    $objActivoEspeImpreMod->setModelo(trim($Modelo));
    $objActivoEspeImpreMod->setIP(trim($IP));
    $objActivoEspeImpreMod->setTonerN(trim($TonerN));
    $objActivoEspeImpreMod->setTonerM(trim($TonerM));
    $objActivoEspeImpreMod->setTonerC(trim($TonerC));
    $objActivoEspeImpreMod->setTonerA(trim($TonerA));
    $objActivoEspeImpreMod->setTambor(trim($tambor));
    $objActivoEspeImpreMod->setFusor(trim($fusor));
    $objActivoEspeImpreMod->setActivoId(trim($ActivoId));
    return $objActivoEspeImpreMod;
}

//OBJETO DONDE SETEAMOS LOS VALORES PARA INSERTAR EN ACTIVO ESPECIFICACION SI ES UN PROYECTOR
function setObjActivoEspeProy(
    $ActivoId,
    $Modelo,
    $HorasUso,
    $HoraEco
) {
    $objActivoEspeProy = new Activo_Especificacion();
    $objActivoEspeProy->setActivoId(trim($ActivoId));
    $objActivoEspeProy->setModelo(trim($Modelo));
    $objActivoEspeProy->setHorasUso(trim($HorasUso));
    $objActivoEspeProy->setHoraEco(trim($HoraEco));
    return $objActivoEspeProy;
}

//OBJETO DONDE SETEAMOS LOS VALORES PARA MODICAR EN ACTIVO ESPECIFICACION SI ES UN PROYECTOR
function setObjActivoEspeProyMod(
    $Modelo,
    $HorasUso,
    $HoraEco,
    $ActivoId
) {
    $objActivoEspeProyMod = new Activo_Especificacion();
    $objActivoEspeProyMod->setModelo(trim($Modelo));
    $objActivoEspeProyMod->setHorasUso(trim($HorasUso));
    $objActivoEspeProyMod->setHoraEco(trim($HoraEco));
    $objActivoEspeProyMod->setActivoId(trim($ActivoId));
    return $objActivoEspeProyMod;
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
    $objActivoHistorial->setActivoId(trim($ActivoId));
    $objActivoHistorial->setEstructura31Id(trim($Estructura31_id));
    $objActivoHistorial->setResponsableId(trim($Responsable_id));
    $objActivoHistorial->setHistoricoComentario(trim($Historico_comentario));
    $objActivoHistorial->setUsuarioId(trim($Usuario_id));
    $objActivoHistorial->setEstado(trim($Estado));
    return $objActivoHistorial;
}

//OBJETO DONDE SETEAMOS LOS VALORES PARA INSERTAR UN NUEVO HISTORICO DEL ACTIVO
function setObjHistorico(
    $ActivoId,
    $Historico_fecha,
    $Estructura31_id,
    $Responsable_id,
    $Historico_comentario,
    $Usuario_id,
    $Estado
) {
    $ObjHistorico = new historial_Activo();
    $ObjHistorico->setActivoId(trim($ActivoId));
    $ObjHistorico->setHistoricoFecha(trim($Historico_fecha));
    $ObjHistorico->setEstructura31Id(trim($Estructura31_id));
    $ObjHistorico->setResponsableId(trim($Responsable_id));
    $ObjHistorico->setHistoricoComentario(trim($Historico_comentario));
    $ObjHistorico->setUsuarioId(trim($Usuario_id));
    $ObjHistorico->setEstado(trim($Estado));
    return $ObjHistorico;
}

//OBJETO DONDE SETEAMOS LOS VALORES PARA ACTUALIZAR EL ESTADO Y EL RESPONSABLE EN LA TABLA ACTIVO
function setObjActualizarEstActivo(
    $Estado,
    $ResponsableId,
    $Estructura3Id,
    $ActivoId
) {
    $ObjActualizarEstActivo = new Activo_Fijo();
    $ObjActualizarEstActivo->setEstado(trim($Estado));
    $ObjActualizarEstActivo->setResponsableCodigo(trim($ResponsableId));
    $ObjActualizarEstActivo->setActivoId(trim($ActivoId));
    $ObjActualizarEstActivo->setEstructura3Id(trim($Estructura3Id));
    return $ObjActualizarEstActivo;
}

//OBJETO DONDE SETEAMOS LOS VALORES PARA MODIFICAR UN HISTORICO DEL ACTIVO
function setObjModificarHistorico(
    $historicoFecha,
    $Estructura31Id,
    $ResponsableIdd,
    $HistoricoComentario,
    $UsuarioId,
    $Estado,
    $HistoritoId
) {
    $ObjModificarHistorico = new historial_Activo();
    $ObjModificarHistorico->setHistoricoFecha(trim($historicoFecha));
    $ObjModificarHistorico->setEstructura31Id(trim($Estructura31Id));
    $ObjModificarHistorico->setResponsableId(trim($ResponsableIdd));
    $ObjModificarHistorico->setHistoricoComentario(trim($HistoricoComentario));
    $ObjModificarHistorico->setUsuarioId(trim($UsuarioId));
    $ObjModificarHistorico->setEstado(trim($Estado));
    $ObjModificarHistorico->setHistoricoId(trim($HistoritoId));
    return $ObjModificarHistorico;
}

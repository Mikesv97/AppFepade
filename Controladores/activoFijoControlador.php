<?php
include_once '../Modelos/activoFijoDao.php';
include_once '../Modelos/activoEspecificacionDao.php';
include_once '../Modelos/historialActivoDao.php';

$obj = new activoFijoDAO();
$obj2 = new activoEspecificacionDao();
$Obj3 = new historialActivoDao();

//VARIABLE PARA SACAR EL DIA QUE NOS ENCONTRAMOS
$fecha = date('d-m-Y');

//FUNCION PARA CARGAR LA IMAGEN AL SERVIDOR LOCAL Y INSERTAR EL NOMBRE DE LA IMAGEN EN EL SERVIDOR
function cargarImagen()
{
    $nombreimg = $_FILES["FileImagen"]["name"];
    $archivo = $_FILES["FileImagen"]["tmp_name"];
    $ruta = "../Recursos/Multimedia/Imagenes/Upload/";
    if (move_uploaded_file($archivo, $ruta . $nombreimg)) {
        return $nombreimg;
    } else {
        return "error de carga de imagen";
    }
}

if ($_POST) {
    if (isset($_POST['key'])) {
        $activo = $_POST['key'];
        switch ($activo) {
            case "imagen":

                $tipoActivo = $_POST["tipoActivo"];
                $var = new Activo_Fijo();
                $var2 = new Activo_Especificacion();
                $var3 = new historial_Activo();

                //DATOS GENERALES DE ACTIVOS
                $var->setActivoReferencia($_POST['referencia']);
                $var->setPartidaCta($_POST['codContabilidad']);
                $var->setEmpresaId($_POST['codProyectos']);
                $var->setNumeroSerie($_POST['numSerie']);
                $var->setActivoFechaAdq($_POST['fechaAdq']);
                $var->setActivoFactura($_POST['numFactura']);
                $var->setActivoTipo($_POST['comboTipoActivo']);
                $var->setUsuarioId($_POST['usuario']);
                $var->setEstructura1Id($_POST['comboDepartamento']);
                $var->setEstructura2Id($_POST['comboFondos']);
                $var->setEstructura3Id($_POST['comboArea']);
                $var->setActivoDescripcion($_POST['descripcion']);
                $var->setActivoFechaCaduc($_POST['fechaCad']);
                $var->setEstado($_POST['estado']);
                $var->setActivoEliminado($_POST['estadoEliminado']);
                $var->setImagen(cargarImagen());//LLAMANDO A LA FUNCION QUE SUBE LA IMAGEN Y RETONAR EL NOMBRE DE LA IMAGEN

                //DATOS DE ESPECIFICACIONES PARA ACTIVO COMPUTADORA
                $var2->setProcesador($_POST['procesador']);
                $var2->setGeneracion($_POST['generacion']);
                $var2->setRam($_POST['ram']);
                $var2->setTipoRam($_POST['tipoRam']);
                $var2->setDiscoDuro($_POST['disco']);
                $var2->setSO($_POST['sistema']);
                $var2->setOffice($_POST['office']);
                $var2->setModelo($_POST['modelo']);
                $var2->setIP($_POST['ip']);
                $var2->setCapacidad_D1($_POST['capacidadD1']);
                $var2->setDiscoDuro2($_POST['disco2']);
                $var2->setCapacidad_D2($_POST['capacidadD2']);

                //DATOS DE ESPECIFICACIONES PARA ACTIVO IMPRESORA
                $var2->setTonerN($_POST['tonerNegro']);
                $var2->setTonerM($_POST['tonerMagenta']);
                $var2->setTonerC($_POST['tonerCyan']);
                $var2->setTonerA($_POST['tonerAmarillo']);
                $var2->setTambor($_POST['tambor']);
                $var2->setFusor($_POST['fusor']);

                //DATOS DE ESPECIFICACIONES PARA ACTIVO PROYECTOR
                $var2->setHorasUso($_POST['horasUso']);
                $var2->setHoraEco($_POST['horasEco']);

                //DATOS DE HISTORIAL DE RESPONSABLE
                $var3->setResponsableId($_POST['comboResponsable']);
                $var3->setHistoricoComentario($_POST['comentario']);

                //PENDIENTE DE COMPROBAR SI EL INPUT FECHA VIENE CON DATOS O NO YA QUE SIEMPRE LLEGA AL ELSE AUNQUE SE PONGA FECHA
                $caducacion = $var->setActivoFechaCaduc($_POST['fechaCad']);
                if (empty($caducacion)) {
                    $var->setActivoFechaCaduc('01/01/1900');
                } else {
                    $var->setActivoFechaCaduc($_POST['fechaCad']);
                }

                //INSERTANDOP ACTIVO FIJO
                $resultado = $obj->insertarActivoFijo(
                    $var->getActivoReferencia(),
                    $var->getPartidaCta(),
                    $var->getEmpresaId(),
                    $var->getNumeroSerie(),
                    $var->getActivoFechaAdq(),
                    $var->getActivoFactura(),
                    $var->getActivoTipo(),
                    $var->getActivoDescripcion(),
                    $var->getEstructura1Id(),
                    $var->getEstructura2Id(),
                    $var->getEstructura3Id(),
                    $var->getUsuarioId(),
                    $fecha,
                    $var->getActivoFechaCaduc(),
                    $var->getActivoFechaAdq(),
                    $var->getEstado(),
                    $var->getActivoEliminado(),
                    $var3->getResponsableId(),
                    $var->getImagen()
                );

                //LLAMANDO FUNCION QUE OBTIENE EL ID DEL ACTIVO FIJO QUE SE ESTA INSERTANDO
                $valorid =  $obj2->obtenerId();
                //OBTENIDO EL ULTIMO ACTIVO ID QUE SE INSERTANDO EN LA TABLA ACTIVO_FIJO
                $var2->setActivoId($valorid);

                //SI EL TIPO DE ACTIVO SELECCIONADO ES COMPUTADORA SE INSERTARAN LOS DATOS CORRESPONDIENTES y TAMBIEN SE INSERTAN LOS DATOS EN HISTORIAL DEL ACTIVO
                if ($tipoActivo == "computadora") {
                    $resultadoComp = $obj2->insertarActEspCom(
                        $var2->getActivoId(),
                        $var2->getProcesador(),
                        $var2->getGeneracion(),
                        $var2->getRam(),
                        $var2->getTipoRam(),
                        $var2->getDiscoDuro(),
                        $var2->getSO(),
                        $var2->getOffice(),
                        $var2->getModelo(),
                        $var2->getIP(),
                        $var2->getCapacidad_D1(),
                        $var2->getDiscoDuro2(),
                        $var2->getCapacidad_D2()
                    );


                    $insertarHistorial = $Obj3->insertarHistorial(
                        $var2->getActivoId(),
                        $fecha,
                        $var->getEstructura3Id(),
                        $var3->getResponsableId(),
                        $var3->getHistoricoComentario(),
                        $var->getUsuarioId(),
                        $fecha,
                        $var->getEstado()
                    );
                    echo json_encode(true);
                } else if ($tipoActivo == "impresora") {
                    $resultadoImp = $obj2->insertarActEspImp(
                        $var2->getActivoId(),
                        $var2->getModelo(),
                        $var2->getIP(),
                        $var2->getTonerN(),
                        $var2->getTonerM(),
                        $var2->getTonerC(),
                        $var2->getTonerA(),
                        $var2->getTambor(),
                        $var2->getFusor()
                    );
                    $insertarHistorial = $Obj3->insertarHistorial(
                        $var2->getActivoId(),
                        $fecha,
                        $var->getEstructura3Id(),
                        $var3->getResponsableId(),
                        $var3->getHistoricoComentario(),
                        $var->getUsuarioId(),
                        $fecha,
                        $var->getEstado()
                    );
                    echo json_encode(true);
                } else if ($tipoActivo == "proyector") {
                    $resultadoProy = $obj2->insertarActEspProy($var2->getActivoId(), $var2->getModelo(), $var2->getHorasUso(), $var2->getHoraEco());
                    $insertarHistorial = $Obj3->insertarHistorial(
                        $var2->getActivoId(),
                        $fecha,
                        $var->getEstructura3Id(),
                        $var3->getResponsableId(),
                        $var3->getHistoricoComentario(),
                        $var->getUsuarioId(),
                        $fecha,
                        $var->getEstado()
                    );
                    echo json_encode(true);
                }
                break;
        }
    }
}

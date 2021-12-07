<?php
include_once '../Modelos/activoFijoDao.php';
include_once '../Modelos/activoEspecificacionDao.php';
$obj = new activoFijoDAO();
$obj2 = new activoEspecificacionDao();
//VARIABLE PARA SACAR EL DIA QUE NOS ENCONTRAMOS
$fecha = date('d-m-Y');
//VARIABLE SESION DONDE SE MANTIENE EL ID DEL USUARIO QUE INICIO SESION EN EL SISTEMA
//$idUSuario = $_SESSION["usuario"]["id"];

if($_POST){
    if(isset($_POST['key'])){
        $activo = $_POST['key'];
        switch($activo){
            case "insertar":
                $tipoActivo = $_POST["tipoActivo"];
                $var = new Activo_Fijo();
                $var2 = new Activo_Especificacion();
                parse_str($_POST["data"],$data);

                //DATOS GENERALES DE ACTIVOS
                $var->setActivoReferencia($data['referencia']);
                $var->setPartidaCta($data['codContabilidad']);
                $var->setEmpresaId($data['codProyectos']);
                $var->setNumeroSerie($data['numSerie']);
                $var->setActivoFechaAdq($data['fechaAdq']);
                $var->setActivoFactura($data['numFactura']);
                $var->setActivoTipo($data['comboTipoActivo']);
                $var->setUsuarioId($data['usuario']);
                $var->setEstructura1Id($data['comboDepartamento']);
                $var->setEstructura2Id($data['comboFondos']);
                $var->setEstructura3Id($data['comboArea']);
                $var->setActivoDescripcion($data['descripcion']);
                
                //DATOS DE ESPECIFICACIONES PARA ACTIVO COMPUTADORA
                $var2->setProcesador($data['procesador']);
                $var2->setGeneracion($data['generacion']);
                $var2->setRam($data['ram']);
                $var2->setTipoRam($data['tipoRam']);
                $var2->setDiscoDuro($data['disco']);
                $var2->setSO($data['sistema']);
                $var2->setOffice($data['office']);
                $var2->setModelo($data['modelo']);
                $var2->setIP($data['ip']);

                //DATOS DE ESPECIFICACIONES PARA ACTIVO IMPRESORA
                $var2->setTonerN($data['tonerNegro']);
                $var2->setTonerM($data['tonerMagenta']);
                $var2->setTonerC($data['tonerCyan']);
                $var2->setTonerA($data['tonerAmarillo']);
                $var2->setTambor($data['tambor']);
                $var2->setFusor($data['fusor']);

                //DATOS DE ESPECIFICACIONES PARA ACTIVO PROYECTOR
                $var2->setHorasUso($data['horasUso']);
                $var2->setHoraEco($data['horasEco']);

                //INSERTANDOP ACTIVO FIJO
                $resultado = $obj->insertarActivoFijo($var->getActivoReferencia(),$var->getPartidaCta(),$var->getEmpresaId(),$var->getNumeroSerie(),$var->getActivoFechaAdq(),
                                                      $var->getActivoFactura(),$var->getActivoTipo(),$var->getActivoDescripcion(),$var->getEstructura1Id(),$var->getEstructura2Id(),
                                                      $var->getEstructura3Id(),$var->getUsuarioId(),$fecha,'01/01/1900',$var->getActivoFechaAdq());

                //LLAMANDO FUNCION QUE OBTIENE EL ID DEL ACTIVO FIJO QUE SE ESTA INSERTANDO
                $valorid =  $obj2->obtenerId();
                //OBTENIDO EL ULTIMO ACTIVO ID QUE SE INSERTANDO EN LA TABLA ACTIVO_FIJO
                $var2->setActivoId($valorid);

                //SI EL TIPO DE ACTIVO SELECCIONADO ES COMPUTADORA SE INSERTARAN LOS DATOS CORRESPONDIENTES
                if($tipoActivo == "computadora"){
                   $resultadoComp = $obj2->insertarActEspCom($var2->getActivoId(),$var2->getProcesador(),$var2->getGeneracion(),$var2->getRam(),$var2->getTipoRam(),$var2->getDiscoDuro(),
                                                             $var2->getSO(),$var2->getOffice(),$var2->getModelo(),$var2->getIP());
                    echo json_encode($resultadoComp);
                }else if($tipoActivo == "impresora"){
                    $resultadoImp = $obj2->insertarActEspImp($var2->getActivoId(),$var2->getModelo(),$var2->getIP(),$var2->getTonerN(),$var2->getTonerM(),$var2->getTonerC(),$var2->getTonerA(),
                                                            $var2->getTambor(),$var2->getFusor());
                    echo json_encode($resultadoImp);
                }else if($tipoActivo == "proyector"){
                    $resultadoProy = $obj2->insertarActEspProy($var2->getActivoId(),$var2->getModelo(),$var2->getHorasUso(),$var2->getHoraEco());
                    echo json_encode($resultadoProy);
                }
                
                break;
        }
    }
}

?>
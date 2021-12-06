<?php
include_once '../Modelos/activoFijoDao.php';
include_once '../Modelos/activoEspecificacionDao.php';
$obj = new activoFijoDAO();
$obj2 = new activoEspecificacionDao();

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
                $var->setUsuarioId($data['comboUsuario']);
                $var->setEstructura1Id($data['comboDepartamento']);
                $var->setEstructura2Id($data['comboFondos']);
                $var->setEstructura3Id($data['comboArea']);
                $var->setActivoDescripcion($data['descripcion']);
                
                //DATOS DE ESPECIFICACIONES PARA LOS ACTIVOS
                $var2->setProcesador($data['procesador']);
                $var2->setGeneracion($data['generacion']);
                $var2->setRam($data['ram']);
                $var2->setTipoRam($data['tipoRam']);
                $var2->setDiscoDuro($data['disco']);
                $var2->setSO($data['sistema']);
                $var2->setOffice($data['office']);
                $var2->setModelo($data['modelo']);
                $var2->setIP($data['ip']);

                $resultado = $obj->insertarActivoFijo($var->getActivoReferencia(),$var->getPartidaCta(),$var->getEmpresaId(),$var->getNumeroSerie(),$var->getActivoFechaAdq(),
                                                      $var->getActivoFactura(),$var->getActivoTipo(),$var->getActivoDescripcion(),$var->getEstructura1Id(),$var->getEstructura2Id(),
                                                      $var->getEstructura3Id(),$var->getUsuarioId(),'01/12/2021','01/12/2021');

                
                $valorid =  $obj2->obtenerId();
                //DATOS DE ESPECIFICACIONES PARA LOS ACTIVOS
                $var2->setActivoId($valorid);

                if($tipoActivo == "computadora"){
                   $resultadoComp = $obj2->insertarActEspCom($var2->getActivoId(),$var2->getProcesador(),$var2->getGeneracion(),$var2->getRam(),$var2->getTipoRam(),$var2->getDiscoDuro(),
                                                             $var2->getSO(),$var2->getOffice(),$var2->getModelo(),$var2->getIP());
                    echo json_encode($resultadoComp);
                }else if($tipoActivo == "impresora"){
                    //AQUI VA EL CODIGO PARA INSERTAR ACTIVO DESCRIPCION PARA IMPRESORA
                }else if($tipoActivo == "proyector"){
                    //AQUI VA EL CODIGO PARA INSERTAR ACTIVO DESCRIPCION PARA PROYECTOR
                }
                
                break;
        }
    }
}

?>
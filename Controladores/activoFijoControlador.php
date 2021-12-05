<?php
include_once '../Modelos/activoFijoDao.php';
$obj = new activoFijoDAO();

if($_POST){
    if(isset($_POST['key'])){
        $activo = $_POST['key'];
        switch($activo){
            case "insertar":
                $var = new Activo_Fijo();
                parse_str($_POST["data"],$data);

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

                $resultado = $obj->insertarActivoFijo($var->getActivoReferencia(),$var->getPartidaCta(),$var->getEmpresaId(),$var->getNumeroSerie(),$var->getActivoFechaAdq(),
                                                      $var->getActivoFactura(),$var->getActivoTipo(),$var->getActivoDescripcion(),$var->getEstructura1Id(),$var->getEstructura2Id(),
                                                      $var->getEstructura3Id(),$var->getUsuarioId(),'01/12/2021','01/12/2021');

                echo json_encode($resultado);
                if($resultado){
                    echo json_encode(true);
                }
                
                break;
        }
    }
}

?>
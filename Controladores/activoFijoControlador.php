<?php
include_once '../Modelos/activoFijoDao.php';
$obj = new activoFijoDAO();

if($_POST){
    if(isset($_POST['key'])){
        $activo = $_POST['key'];
        switch($activo){
            case "insertar":
                parse_str($_POST["data"],$data);
                $referencia = $data['referencia'];
                $codContabilidad = $data['codContabilidad'];
                $codProyectos = $data['codProyectos'];
                $numSerie = $data['numSerie'];
                $fechaAdq = $data['fechaAdq'];
                $numFactura = $data['numFactura'];
                $tipo = $data['tipo'];
                $ip = $data['ip'];
                $usuario = $data['usuario'];
                $modelo = $data['modelo'];
                $departamento = $data['departamento'];
                $ff = $data['ff'];
                $area = $data['area'];
                $descripcion = $data['descripcion'];

                $resultado = $obj->insertarActivoFijo($referencia,$codContabilidad,$codProyectos,$numSerie,$fechaAdq,$numFactura,
                $tipo,$descripcion,$departamento,$ff,$area,$usuario,'01/12/2021','01/12/2021');

                echo json_encode($resultado);
                if($resultado){
                    echo json_encode(true);
                }
                
                break;
        }
    }
}

?>
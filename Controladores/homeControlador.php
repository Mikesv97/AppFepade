<?php
/* ESTE ES EL CONTROLADOR GENERAL QUE SE EJECUTA DESDE EL NAVABAR DEL SISTEMA PARA TODAS LAS VISTA EN GENERAL */
include_once dirname(__DIR__, 1)."/Modelos/clasesDao/rolMenuDao.php";
include_once dirname(__DIR__, 1)."/Modelos/clasesDao/rolAccionesDao.php";

if(isset($_POST["key"])){
    $key=$_POST["key"];
    switch($key){
        case "solicitarMenu":
           $idRol = $_POST["idRol"];
           $rMenuDao= new RolMenuDao();
           if(!empty($idRol)){
                echo json_encode($rMenuDao->obtenerMenuRoles($idRol));
           }else{
               echo json_encode("ID Rol No Definido");
           }
        break;
        case "soliAccRol":
            $idRol = $_POST["idRol"];
            $rAccDao= new RolAccionesDao();
            if(!empty($idRol)){
                 echo json_encode($rAccDao->obtenerAccRoles($idRol));
            }else{
                echo json_encode("ID Rol No Definido");
            }
        break;
    }
}
?>
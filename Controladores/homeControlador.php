<?php
/* ESTE ES EL CONTROLADOR GENERAL QUE SE EJECUTA DESDE EL NAVABAR DEL SISTEMA PARA TODAS LAS VISTA EN GENERAL */
include_once "../Modelos/rolesDao.php";
if(isset($_POST["key"])){
    $key=$_POST["key"];
    switch($key){
        case "solicitarMenu":
           $idRol = $_POST["idRol"];
           $rDao= new RolesDao();
           if(!empty($idRol)){
                echo json_encode($rDao->obtenerMenuRoles($idRol));
           }else{
               echo json_encode("ID Rol No Definido");
           }
        break;
        case "soliAccRol":
            $idRol = $_POST["idRol"];
            $rDao= new RolesDao();
            if(!empty($idRol)){
                 echo json_encode($rDao->obtenerAccRoles($idRol));
            }else{
                echo json_encode("ID Rol No Definido");
            }
        break;
    }
}
?>
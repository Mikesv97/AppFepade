<?php
include_once "../Modelos/rolesDao.php";
include_once "../Modelos/menuDao.php";
if(isset($_POST["key"])){
    $key=$_POST["key"];
    switch($key){
        case "obtenerRoles":
           $rDao = new RolesDao();
           echo json_encode($rDao->obtenerRoles());
        break;
        case "obtenerMenu":
            $mDao = new MenuDao();
            echo json_encode($mDao->obtenerMenu());
        break;
        case "obtenerAcciones":
            $rDao = new RolesDao();
            echo json_encode($rDao->obtenerAcciones());
        break;
    }
}
?>
<?php

include "../Modelos/rolesDao.php";
include "../Modelos/usuarioNuevoDao.php";
if(isset($_POST["key"])){   
    $key=$_POST["key"];
    switch($key){
        case "getRoles":
            $roles = new RolesDao();
           $resp= $roles->obtenerCmbRoles();
            echo json_encode($resp);
        break;
        case "cerrarSesion":

        break;
        case "validarRemember":

        break;
        case "validarCorreo":
        break;
        case "enviarCodigo":
        break;
        case "cambiarPass":

        break;
    }
}
?>
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
        case "insertatUsuario":
            //desempacamos data
            parse_str($_POST["data"],$data);
            //seteamos datos y cargamos obj
            $objUsuario= setearObjeto(
                $data["txtIdUser"],
                $data["txtPassword1"],
                $data["txtNombreUser"],
                $data["txtCorreoUsuario"],
                $data["selectRol"]);
             
            //creamos obj DAO de usuario
            $userDao= new UsuarioNuevoDao();
            echo json_encode($userDao->insertarUsuario($objUsuario));
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

function setearObjeto($id,$clave, $nombre, $correo, $idRol){
    $user = new UsuarioNuevo();
    $user->setUsuarioId($id);
    $user->setUsuarioNombre($nombre);
    $user->setUsuarioClave(password_hash($clave,PASSWORD_DEFAULT,array("cost"=>12)));
    $user->setCorreoElectronico($correo);
    $user->setIdRol($idRol);  
    $user->setRemember(0);

    return $user;
}
?>
<?php
session_start();
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
            //declaramos objeto dao
            $userDao= new UsuarioNuevoDao();
            //desempacamos data
            parse_str($_POST["data"],$data);

            //insertamos en bitacora para obtener su ID e insertarlo en tabla usuario
            $userDao->insertarBitacoraUs($data["txtIdUser"], $_SESSION["usuario"]["nombre"]);

            $idBitacora= $userDao->obtenerIdBitacora();
            //seteamos datos y cargamos obj
            $objUsuario= setearObjeto(
                $data["txtIdUser"],
                $data["txtPassword1"],
                $data["txtNombreUser"],
                $data["txtCorreoUsuario"],
                $data["selectRol"],
                $idBitacora,
                "fepadeDefault.png",
                1
            );
             
            //creamos obj DAO de usuario
            
            echo json_encode($userDao->insertarUsuario($objUsuario));
        break;
        case "getUsuarios":
            $userDao= new UsuarioNuevoDao();
           echo json_encode($userDao->obtenerUsuarios());
        break;
        case "validarCorreo":
        break;
        case "enviarCodigo":
        break;
        case "cambiarPass":

        break;
    }
}

function setearObjeto($id,$clave, $nombre, $correo, $idRol,$idBitacora,$foto,$usuarioNuevo){
    $user = new UsuarioNuevo();

    $user->setUsuarioId($id);
    $user->setUsuarioNombre($nombre);   
    $user->setUsuarioClave(password_hash($clave,PASSWORD_DEFAULT,array("cost"=>12)));
    $user->setCorreoElectronico($correo);
    $user->setIdRol($idRol);  
    $user->setRemember(0);
    $user->setIdBitacora($idBitacora);
    $user->setFotoUsuario($foto);
    $user->setUsuarioNuevo($usuarioNuevo);

    return $user;
}
?>
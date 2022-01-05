<?php
session_start();
include dirname(__DIR__, 1)."/Modelos/clasesDao/rolesDao.php";
include dirname(__DIR__, 1)."/Modelos/clasesDao/usuarioNuevoDao.php";

if(isset($_POST["key"])){   
    $key=$_POST["key"];
    switch($key){
        case "getRoles":
            $roles = new RolesDao();
           $resp= $roles->obtenerCmbRoles();
            echo json_encode($resp);
        break;
        case "insertarUsuario":
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
                1
            );
             
            //creamos obj DAO de usuario
            
            echo json_encode($userDao->insertarUsuario($objUsuario));
        break;
        case "getUsuarios":
            $userDao= new UsuarioNuevoDao();
           echo json_encode($userDao->obtenerUsuarios());
        break;
        case "eliminarUsuario":
            $id = $_POST["id"];
            $userDao = new UsuarioNuevoDao();
            echo json_encode($userDao->eliminarUsuario($id));

        break;
        case "enviarCodigo":
        break;
        case "editarUsuario":
            $userDao= new UsuarioNuevoDao();
            //seteamos el objeto con los datos a actualizar
            $user = setearObjeto($_POST["idUser"],
            null,
            $_POST["nombreUser"],
            $_POST["correoUser"],
            $_POST["idRolUser"],
            null,
            0);

            //actualizamos bitacora
            $actBit = $userDao->actualizarBitacoraUs($user->getUsuarioId(), $_SESSION["usuario"]["nombre"]);

            //evaluamos la insersion
            if($actBit){
                //actualizamos el usuario
                $actUser = $userDao->actualizarUsuario($user);

                if($actUser){
                    echo json_encode(true);
                }else{
                    echo json_encode($actUser);
                }
            }else{
                //envamos el error o contenido diferente a exitoso
                echo json_encode($actBit);
            }
        break;
    }
}

function setearObjeto($id,$clave, $nombre, $correo, $idRol,$idBitacora,$usuarioNuevo){
    $user = new UsuarioNuevo();

    $user->setUsuarioId($id);
    $user->setUsuarioNombre($nombre);   
    $user->setUsuarioClave(password_hash($clave,PASSWORD_DEFAULT,array("cost"=>12)));
    $user->setCorreoElectronico($correo);
    $user->setIdRol($idRol);  
    $user->setRemember(0);
    $user->setIdBitacora($idBitacora);
    $user->setUsuarioNuevo($usuarioNuevo);

    return $user;
}
?>
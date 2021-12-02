<?php
include_once '../Modelos/usuariosDao.php';

$usDao = new UsuariosDao();

if($_POST){
    if(isset($_POST["key"])){

        $key=$_POST["key"];
        
        switch($key){
            case "validarUser":
                parse_str($_POST["data"],$data);
                
                $nombre = $data["txtUsuario"];
                $contraseña = $data["txtContraseña"];

                $resp= $usDao->validarUsuario($nombre,$contraseña);
                echo json_encode($resp);
            break;
            case "cerrarSesion":
                session_destroy();
                echo json_encode(true);
        }
    }

}



?>
<?php

include_once '../Modelos/usuariosDao.php';

$usDao = new UsuariosDao();

if($_POST){
    if(isset($_POST["key"])){
        
        $key=$_POST["key"];
        
        switch($key){
            case "validarUser":
                //descerializamos los datos que envia ajax
                parse_str($_POST["data"],$data);
                //seteamos variables para mejor manejo
                $nombre = $data["txtUsuario"];
                $contraseña = $data["txtContraseña"];
                $rem = $_POST["valor"];

                //validamos si hay usuario con los datos ingresados
                $usuarioExiste= $usDao->validarUsuario($nombre,$contraseña);

                if($usuarioExiste){
                    //si hay datos vemos si quiere ser recordado
                    if($rem==1){
                        
                        //si es que queire ser recordado
                        //creamos un número aleatorio para usarlo como "token"
                        $numero_aleatorio = mt_rand(1000000,999999999);
                        $token = ($numero_aleatorio +1);

                        //actualizo el token del usuario en la BD
                        $saveToken= $usDao->setUserToken($nombre, $token);
                        
                        if($saveToken){

                            //si se actualizo creo las cookie por un mes
                         
                            setcookie("usuario", $_SESSION["usuario"]["nombre"], time()+30*24*60*60 );
                            setcookie("token", $token, time()+30*24*60*60);
                            
                            //retornamos true para redireccionar con ajax en succes
                            echo json_encode(true);
                        }else{
                            //retornamos false para que muestre error con ajax
                            echo json_encode(false);
                        }
                        
                    }else{
                        //si no esta marcado recuerdame, evaluamos si hay cookies 
                        echo json_encode("olvidame");
                    }
                }else{
                    //si no hay usuario con los datos ingresados
                    //retornamos falso
                    echo json_encode(false);
                }
                
            break;
            case "cerrarSesion":
                session_destroy();
                echo json_encode(true);
            break;
            case "validarRemember":
                //si hay cookies
                if(isset($_COOKIE["usuario"]) && isset($_COOKIE["token"])){
                    //se llama la funcion del modelo dao de usuario
                    //pasandole los valores de cada cookie, y ver su respuesta
                   $usDao->validarDatosCookie($_COOKIE["usuario"], $_COOKIE["token"]);
                   
                }else{
                    //si no hay cookies se retorna false
                    echo json_encode(false);
                }

               
            break;
        }
    }

}
?>
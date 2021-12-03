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

                //vemos si ya hay cookies de recuerdame
                if(isset($_COOKIE["usuario"]) && isset($_COOKIE["token"])){
                    //si hay cookies de recuerdame veo si el checkbox esta seleccionado
                    if($rem==0){
                        //si no esta seleccionado ya no quiere ser recordado
                        //destruyo las cookies
                        setcookie("usuario", "", time()-60);
                        setcookie("token", "", time()-60);
                        //actualizo a null el valor del token del usuario en BD
                        $updateToken= $usDao->setUserToken($nombre,null);
                        if($updateToken){
                            //si se actualizo correctamente el campo
                            //comprobamos datos de las cookies
                            $userValid= $usDao->validarUsuarioCookie($nombre,$contraseña);
                            if($userValid){
                                //si esta todo bien con lso datos de la cookie retornamos true
                                echo json_encode(true);
                            }else{
                                // si fallo con los datos de la cookie
                                echo json_encode(false);
                            }
                        }else{
                            //si no se actualizo el campo
                            echo json_encode(false);
                        }
                    }else{
                        //si el checkbox de recuerdame esta seleccionado compruebo datos
                        $usuarioValidoCok= $usDao->validarUsuarioCookie($nombre,$contraseña);
                        if($usuarioValidoCok){
                            //si los datos estan bien, genero un nuevo token
                            $numero_aleatorio = mt_rand(1000000,999999999);
                            $token = ($numero_aleatorio +1);
                            //actualizo el campo del token del usuario
                            $actualizarToken= $usDao->setUserToken($nombre,$token);
                            if($actualizarToken){
                                //si se actualizo el campo, paso el valor a la cookie token
                                setcookie("token", $token, time()+30*24*60*60);
                                echo json_encode(true);
                            }else{
                                //si no se actualiza el token
                                echo json_encode(false);
                            }
                            
                        }else{
                            //si los datos de la cookie no son validos
                            echo json_encode(false);
                        }
                    }
                 }else{
                     //si no hay cookies
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
                            //si no quiere ser recordado simplemente
                            //retornamos true para que redireccione ajax
                            echo json_encode(true);
                        }
                    }else{
                        //si no hay usuario con los datos ingresados
                        //retornamos falso
                        echo json_encode(false);
                    }
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
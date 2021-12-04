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
                $userChange = $_POST["userChange"];

                //preguntamos si hay cookies de recuerdame
                if(isset($_COOKIE["usuario"]) && isset($_COOKIE["token"])){ //si hay cookies
                    //evaluamos si el usuario cargado por cookie fue cambiado.
                    switch($userChange){
                        case "conCambio"://si se cambio el usuario

                            //validamos al usuario con los datos ingresados
                            $usuarioExiste= $usDao->validarUsuario($nombre,$contraseña);

                            if($usuarioExiste){//si existe
                                if($rem==1){//vemos si desea ser recordado
                                                                    //generamos token para su futuro acceso con recuerdame
                                    $token = $usDao->generarToken();

                                    //actualizamos el campo token en BD del usuario
                                    $saveToken= $usDao->setUserToken($nombre,$token);

                                    //comprobamos resultado de la actualización de token
                                    if($saveToken){//si es correcto 
                                    
                                    //creamos las cookies
                                    setcookie("usuario", $_SESSION["usuario"]["nombre"], time()+30*24*60*60 );
                                    setcookie("token", $token, time()+30*24*60*60);

                                    //regresamos verdadero para un proceso exitoso
                                    echo json_encode(true);

                                    }else{

                                    //si fallo algo, mandamos mensaje de fallo proceso
                                    echo json_encode("falloToken");
                                    }
                                }else{//si no desea ser recordado el nuevo usuario
                                   
                                    //como existe
                                    echo json_encode(true);
                                }
                            }else{//si no existe el usuario
                                echo json_encode("datosLogNull");   
                            }
                        break;
                        case "sinCambio":
                            //validamos los datos
                            $userValid= $usDao->validarUsuarioCookie($nombre,$contraseña);
                            if($userValid){//si es valido el usuario

                                //evaluamos si quiere ser recordado
                                if($rem==1){//si quiere ser recordado

                                    //obtenemos nuevo token
                                    $token = $usDao->generarToken();

                                    //actualizamos el campo token en BD del usuario
                                    $saveToken= $usDao->setUserToken($nombre,$token);

                                    //comprobamos resultado de la actualización de token
                                    if($saveToken){//si es correcto 
                                    
                                    //actualizamos cookies
                                    setcookie("usuario", $_SESSION["usuario"]["nombre"], time()+30*24*60*60 );
                                    setcookie("token", $token, time()+30*24*60*60);

                                    //regresamos verdadero para un proceso exitoso
                                    echo json_encode(true);

                                    }else{

                                    //si fallo algo, mandamos mensaje de fallo proceso
                                    echo json_encode("falloToken");
                                    }

                                }else{//si ya no quiere ser recordado
                                    //eliminamos las cookies
                                    setcookie("usuario", "", time()-60);
                                    setcookie("token", "", time()-60);
                                   echo json_encode(true);
                                }   
                                

                            }else{//si es invalido los datos, mandamos llave de error
                                echo json_encode("datosLogNull");
                            }
                            
                            
                        break;
                    }
                    
                
                }else{//si no hay cookies
                    
                    //validamos al usuario con los datos ingresados
                    $usuarioExiste= $usDao->validarUsuario($nombre,$contraseña);

                    //si existe usuario con los datos ingresados
                    if($usuarioExiste){

                        //vemos si quiere ser recordado
                        if($rem ==1){//si quiere ser recordado

                            //generamos token para su futuro acceso con recuerdame
                            $token = $usDao->generarToken();

                            //actualizamos el campo token en BD del usuario
                            $saveToken= $usDao->setUserToken($nombre,$token);

                            //comprobamos resultado de la actualización de token
                            if($saveToken){//si es correcto 
                                //creamos las cookies
                                setcookie("usuario", $_SESSION["usuario"]["nombre"], time()+30*24*60*60 );
                                setcookie("token", $token, time()+30*24*60*60);

                                //regresamos verdadero para un proceso exitoso
                                echo json_encode(true);
                            }else{
                                //si fallo algo, mandamos mensaje de fallo proceso
                                echo json_encode("falloToken");
                            }
                            
                        }else{//no quiere ser recordado
                       
                            //como sus datos son correctos, solo retornamos exito
                            echo json_encode(true);
                        }
                        
                    }else{//si son incorrectos los datos del usuario
                        echo json_encode("datosLogNull");
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
            case "validarCorreo":
                $correoValido=$usDao->validarCorreo($_POST["correo"]);
                if($correoValido==1){
                    $senCorreo = mail($_POST["correo"], "Yo soy el asunto del correo", "Yo soy el mensaje");
                    if($senCorreo){
                        echo json_encode(true);
                    }else{
                        echo json_encode("problemas al enviar correo");
                    }
                    
                }else{
                    echo json_encode("invalidMail");
                }

            break;
        }
    }

}
?>
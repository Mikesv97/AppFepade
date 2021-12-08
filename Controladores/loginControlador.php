<?php

include_once '../Modelos/loginDao.php';
include_once '../Modelos/sendMail.php';
$usDao = new LoginDao();
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
                $userRem = $_POST["userRemember"];

                //evaluamos si los datos son validos con usuario y password
                $resp= $usDao->validarUsuario($nombre,$contraseña);

                if($resp){//si da verdadero vemos si quiere que le recuerde el sistema
                    if($rem!=1){
                        //no quiere ser recordado
                        $respRem = $usDao->actualizarRemUser(0, $nombre);
                        echo json_encode($respRem);
                    }else{
                        //si quiere ser recordado
                        //comprobamos cual usuario está con recuerdame en BD
                        $dataRem = $usDao->comprobarRememberUs();
                        //comprobamos no venga vacia la información
                        if(sizeof($dataRem)!= 0){
                            //recorremos
                            foreach($dataRem as $d){
                                if($nombre!=$d["usuario_user"]){
                                    //asigamos recuerdame en BD al usuario ingreado en login
                                   $usDao->actualizarRemUser(0, $d["usuario_user"]);
                                }
                            }
                            //respondemos el resultado
                            echo json_encode( $usDao->actualizarRemUser(1, $nombre));
                        }else{
                            $respRem = $usDao->actualizarRemUser(1, $nombre);
                            echo json_encode($respRem);
                        }
                    }
                   
                }else{
                    //en caso contrario mandamos error
                    echo json_encode("datosLogNull");
                }
               
            break;
            case "cerrarSesion":
                session_destroy();
                echo json_encode(true);
            break;
            case "validarRemember":
                //buscamos en la base de dato un usuario que tenga activo "1" remember
                $usDao->validarRemember();
            break;
            case "validarCorreo":

                $correoValido=$usDao->validarCorreo($_POST["correo"]);
                if($correoValido==1){
                    echo json_encode(true);
                }else{
                    echo json_encode("invalidMail");
                }
            break;
            case "enviarCodigo":
                $code=$usDao->generarToken();
                if(SendMail::enviarCodCorreo($_POST["correo"],$code)){
                    echo json_encode($code);
                }else{
                    echo json_encode("invalidMail");
                }
                
            break;
            case "cambiarPass":
                $pass= $_POST["pass"];
                $mail = $_POST["correo"];
                $updatePass= $usDao->actualizarPassUser($pass,$mail);
                if($updatePass>0){
                    echo json_encode(true);
                }else{
                    echo json_encode(false);
                }
            break;
        }
}
?>
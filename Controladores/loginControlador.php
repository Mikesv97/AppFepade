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
                //evaluamos si los datos son validos con usuario y password
                $resp= $usDao->validarUsuario($nombre,$contraseña);

                if($resp){//si da verdadero vemos si quiere que le recuerde el sistema
                    if($rem!=1){
                        //no quiere ser recordado, borramos cookies
                        setcookie("usuario",$nombre,time()-3600*24*30);
                        setcookie("token",$contraseña,time()-3600*24*30);
                        echo json_encode($usDao->actualizarEstadoUser(1,$nombre));
                    }else{
                        //si quiere ser recordado creamos las cookies
                        setcookie("usuario",$nombre,time()+3600*24*30);
                        setcookie("token",$contraseña,time()+3600*24*30);
                        echo json_encode($usDao->actualizarEstadoUser(1,$nombre));
                    }
                   
                }else{
                    //en caso contrario mandamos error
                    echo json_encode("datosLogNull");
                }
               
            break;
            case "cerrarSesion":
                session_destroy();
                $nombreUser=$_POST["nombre"];
                echo json_encode($usDao->actualizarEstadoUser(0,$nombreUser));
            break;
            case "validarRemember":
                //validamos si hay cookies con los datos
                if(isset($_COOKIE["usuario"]) && isset($_COOKIE["token"])){
                    //si hay validamos que los datos sean correctos
                    $usDao->validarRemember($_COOKIE["usuario"],$_COOKIE["token"]);
                }else{
                 echo json_encode("noRemUser");
                }
               
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
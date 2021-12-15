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
                $usChange = $_POST["usChange"];
                //evaluamos si los datos son validos con usuario y password
                $resp= $usDao->validarUsuario($nombre,$contraseña);

                if($resp){//si da verdadero vemos si quiere que le recuerde el sistema
                    if(isset($_COOKIE["usuario"]) && isset($_COOKIE["usuario"])){
                        recordarmeCookies($rem,$nombre, $contraseña,$usChange);
                        echo json_encode($usDao->actualizarEstadoUser(1,$nombre));
                    }else{
                        recordarmeNoCookies($rem,$nombre, $contraseña);
                        echo json_encode($usDao->actualizarEstadoUser(1,$nombre));
                    }
                }else{
                    //en caso contrario mandamos error
                    echo json_encode("datosLogNull");
                }
               
            break;
            case "cerrarSesion":
                
                $nombreUser=$_POST["nombre"];
                session_destroy();
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
            case "validarPassOld":
              $usuario= $_POST["usuario"];
              $passOld = $_POST["passOld"];
              echo $passOld;
            break;
        }
}


function recordarmeCookies($rem, $nombre,$contraseña, $usChange){
    //evaluamos si el usuario cambio al que estaba seteado
    if($usChange ==0){
        //si no cambio el usuario solo evaluamos si quiere seguir
        //siendo recordado
        if($rem!=1){
            //no quiere ser recordado, borramos cookies
            setcookie("usuario",$nombre,time()-3600*24*30);
            setcookie("token",$contraseña,time()-3600*24*30);
            
        }else{
            //si quiere ser recordado creamos las cookies
            setcookie("usuario",$nombre,time()+3600*24*30);
            setcookie("token",$contraseña,time()+3600*24*30);
        }

    }else{
        if($rem!=0){
            //si quiere ser recordado creamos las cookies
            setcookie("usuario",$nombre,time()+3600*24*30);
            setcookie("token",$contraseña,time()+3600*24*30);
        }
    }

}

function recordarmeNoCookies($rem,$nombre,$contraseña){

        //si quiere ser recordado creamos las cookies
        setcookie("usuario",$nombre,time()+3600*24*30);
        setcookie("token",$contraseña,time()+3600*24*30);

}
?>
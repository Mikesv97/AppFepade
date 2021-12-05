<?php
include_once 'sendMail.php';
include_once '../Modelos/usuariosDao.php';
$nombre="ss@gmail.com";
$contraseña="douglas97";
$token="592647152";
$usDao = new UsuariosDao();
$code= $usDao->generarToken();
if(SendMail::enviarCodCorreo("sdadad@assa.com",$code)){
    echo "enviado";
}else{
    echo "no enviado";
}

?>
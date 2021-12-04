<?php

include_once '../Modelos/usuariosDao.php';
$nombre="douglas miguel figueroa";
$contraseña="douglas97";
$token="592647152";
$usDao = new UsuariosDao();
$code= $usDao->generarToken();
$senCorreo = mail("kimichisv@gmail.com", "Yo soy el asunto del correo, tu codigo es: ", "Yo soy el mensaje, tú codigo es:".$code);

var_dump($senCorreo);
?>
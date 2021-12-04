<?php

include_once '../Modelos/usuariosDao.php';
$nombre="douglas miguel figueroa";
$contraseña="douglas97";
$token="592647152";
$usDao = new UsuariosDao();

$senCorreo = mail("douglas.figuroa20@itca.edu.sv", "Yo soy el asunto del correo", "Yo soy el mensaje");
echo $senCorreo;
?>
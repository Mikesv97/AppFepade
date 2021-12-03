<?php

include_once '../Modelos/usuariosDao.php';
$nombre="douglas miguel figueroa";
$contraseña="douglas97";
$token="592647152";
$usDao = new UsuariosDao();
$dato = $usDao->validarDatosCookie($nombre, $token);
$dato["nombre"];


<?php
include_once 'sendMail.php';
include_once '../Modelos/usuariosDao.php';
<<<<<<< HEAD
$nombre="ss@gmail.com";
=======
<<<<<<< HEAD
include_once '../Modelos/activoFijoDao.php';

$obj = new activoFijoDAO();
$obj->insertarActivoFijo(1,1,1,1,'01/12/2021',1,1,'prueba2',1,1,1,'AEC','02/12/2021','02/12/2021');

=======
$nombre="raidenprueba75@gmail.com";
>>>>>>> 8be6e0790a8afb91311ce58bb89af0d13a3cdcd4
$contraseña="douglas97";
$token="592647152";
$usDao = new UsuariosDao();
$code= $usDao->generarToken();
if(SendMail::enviarCodCorreo("sdadad@assa.com",$code)){
    echo "enviado";
}else{
    echo "no enviado";
}
>>>>>>> 617c26cf8ab87d3c5762ab0020c5cc001fedf6f3

?>
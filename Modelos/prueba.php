<?php
include_once 'sendMail.php';
include_once '../Modelos/loginDao.php';
include_once '../Modelos/activoFijoDao.php';
include_once '../Modelos/usuarioNuevoDao.php';
include_once '../Modelos/activoEspecificacionDao.php';
include_once '../Modelos/historialActivoDao.php';
include_once "reportes.php";
include_once "../Modelos/rolesDao.php";
// $activoEspe = new activoEspecificacionDao();
// $activoHist = new historialActivoDao();
// // // // $us = new LoginDao();
// $nuser = new UsuarioNuevoDao();

// $l = new LoginDao();

// // echo $l->eliminarEstadoNuevoUser("adriana",0);
// $t = new ActivoFijoDao();
// $a = $t->reporteTipoActivo(1);
// $fecha = Reportes::obtenerFecha();
// $hora=Reportes::obtenerHora();
// $tiempo= str_replace(":","-",$hora);
// Reportes::reporteTipoActivo($a,$fecha,$tiempo);

$rDao= new RolesDao();

     echo json_encode($rDao->obtenerMenuRoles(1));


?>

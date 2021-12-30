<?php
include_once 'sendMail.php';
include_once '../Modelos/loginDao.php';
include_once '../Modelos/activoFijoDao.php';
include_once '../Modelos/usuarioNuevoDao.php';
include_once '../Modelos/activoEspecificacionDao.php';
include_once '../Modelos/historialActivoDao.php';
include_once "reportes.php";
include_once "../Modelos/rolesDao.php";
include_once "../Modelos/rolAccionesDao.php";

$r = new RolAccionesDao();
$a = new RolAcciones();

$a->setIdRol(7);
$a->setIdAccion(2);

echo json_encode($r->insertarRolAcciones($a));

?>

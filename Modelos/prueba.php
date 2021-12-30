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

$rDao = new RolesDao();
$rAccRolDao = new RolAccionesDao();
$rMenuDao = new RolMenuDao();

$oRol = new Roles();

echo json_encode($rDao -> editarRol($oRol));

?>

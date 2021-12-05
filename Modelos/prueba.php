<?php

include_once '../Modelos/usuariosDao.php';
include_once '../Modelos/activoFijoDao.php';

$obj = new activoFijoDAO();
$obj->insertarActivoFijo(1,1,1,1,'01/12/2021',1,1,'prueba2',1,1,1,'AEC','02/12/2021','02/12/2021');


?>
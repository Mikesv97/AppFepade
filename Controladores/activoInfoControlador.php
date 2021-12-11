<?php

include_once '../Modelos/activoFijoInformacionDao.php';

$obj = new Activo_fijo_informacion;
$resp = $obj->prueba();
echo json_encode($resp);

?>
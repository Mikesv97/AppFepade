<?php
require  "conexion.php";
include_once dirname(__DIR__, 1).'/Modelos/clases/reportesPlantilla.php';
include_once dirname(__DIR__, 1).'/Modelos/clasesDao/reportesDao.php';

$area ="administracion";
$r = new ReportesDao();
 $resp = $r->getDataRptActivosArea($area);


$r->generarReportePdf($resp,$area);

?>








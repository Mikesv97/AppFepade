<?php
require  "conexion.php";
include_once dirname(__DIR__, 1).'/Modelos/clases/reportesPlantilla.php';
include_once dirname(__DIR__, 1).'/Modelos/clasesDao/reportesDao.php';

if(isset($_POST["btnReporte"])){

    $area=$_POST["sAreaR"];
    $areaNombre= $_POST["hdnNameArea"];
    $r = new ReportesDao();
    $resp = $r->getDataRptActivosArea($area);


    $r->generarReportePdf($resp,$areaNombre);
}
?>








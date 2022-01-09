<?php
require  "conexion.php";
include_once dirname(__DIR__, 1).'/Modelos/clases/reportesPlantilla.php';
include_once dirname(__DIR__, 1).'/Modelos/clasesDao/reportesDao.php';

 if(isset($_POST["btnRptActArea"])){

    $tipoAct = $_POST["sTipoActivoR"];

    if(isset($tipoAct) && $tipoAct == 0){
        $area=$_POST["sAreaR"];
        $areaNombre= $_POST["hdnNameArea"];
        $r = new ReportesDao();
        $resp = $r->getDataRptActivosArea($area);
    
    
        $r->generarRptPdfArea($resp,$areaNombre);
    }else{

    }

 }




/*$tipoActivo = "Laptop";
$r = new ReportesDao();
$resp = $r->getDataRptActivosTipo($tipoActivo);


$r->generarRptPdfTipAct($resp,$tipoActivo);*/

?>








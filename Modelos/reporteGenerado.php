<?php
require  "conexion.php";
include_once dirname(__DIR__, 1) . '/Modelos/clases/reportesPlantilla.php';
include_once dirname(__DIR__, 1) . '/Modelos/clasesDao/reportesDao.php';

if (isset($_POST["btnRptActArea"])) {

    $tipoAct = $_POST["sTipoActivoR"];
    $area=$_POST["sAreaR"];
    $areaNombre= $_POST["hdnNameArea"];
    $rpt = new ReportesDao();

    if(isset($tipoAct) && $tipoAct == 0){

        $resp = $rpt->getDataRptActivosArea($area);
        $rpt->generarRptPdfActArea($resp,$areaNombre);

    }else{
        $resp = $rpt->getDataRptTipActArea($area,$tipoAct);
        $rpt->generarRptPdfActArea($resp,$areaNombre);
    }

 }

if (isset($_POST["btnRptActTipoActivo"])) {

    $tipoActRpt = $_POST["sTipoActivoR2"];

    $r = new ReportesDao();
    $resp = $r->getDataRptActivosTipo($tipoActRpt);

    echo $resp;
    die;

    $r->generarRptPdfTipAct($resp,$tipoActRpt);
}

 




/*$tipoActivo = "Laptop";
$r = new ReportesDao();
$resp = $r->getDataRptActivosTipo($tipoActivo);


$r->generarRptPdfTipAct($resp,$tipoActivo);*/

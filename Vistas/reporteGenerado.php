<?php
require dirname(__DIR__, 1) ."/Modelos/conexion.php";
include_once dirname(__DIR__, 1) . '/Modelos/clases/reportesPlantilla.php';
include_once dirname(__DIR__, 1) . '/Modelos/clasesDao/reportesDao.php';

if (isset($_POST["btnRptActArea"])) {

    $tipoAct = $_POST["sTipoActivoR"];
    $area=$_POST["sAreaR"];
    $areaNombre= $_POST["hdnNameArea"];
    $rpt = new ReportesDao();

    if($tipoAct == 0 && $area != 100){

        $resp = $rpt->getDataRptActivosArea($area, false,1);
        $rpt->generarRptPdfActArea($resp,$areaNombre);

    }
    
    if($tipoAct !=0 && $area != 100){
        $resp = $rpt->getDataRptTipActAreaTodas($tipoAct,$area);
        $rpt->generarRptPdfActArea($resp,$areaNombre);
    }

    if($area==100 && $tipoAct==0){
        $htmlArray = $rpt->getDataRptTipActAreaTodas(0,100);
        $rpt->generearRptTipActAreaAll($htmlArray);
    }

    if($area==100 && $tipoAct!=0){
        $htmlArray = $rpt->getDataRptTipActAreaTodas($tipoAct, $area);
        $rpt->generearRptTipActAreaAll($htmlArray);
    }



}



if (isset($_POST["btnRptActTipoActivo"])) {

    $tipoActRpt = $_POST["sTipoActivoR"];
    $tipoActNombre=$_POST["hdnNameAct"];

    $r = new ReportesDao();

    //creamos array para manejar la cant de tipo activos
    $arrayContTAct = getArrayCantByActiTipo($r);


    $resp = $r->getDataRptActivosTipo($tipoActRpt);

    $r->generarRptPdfTipAct($resp,$arrayContTAct, $tipoActNombre);
}

if(isset($_POST["btnRptResAct"])){
    $rpt = new ReportesDao();

    $html = $rpt->getDataRptResTipAct();
    $rpt->generarRptPdfResTipAct($html);
}

if(isset($_POST["btnRptCantTon"])){
    $rpt = new ReportesDao();

    $html = $rpt->getDataRptTipoActivoImp();
    $rpt->generarRptPdfResImpToner($html);
}

if(isset($_POST["btnRptAreas"])){
    $area=$_POST["sAreaR"];
    $areaNombre= $_POST["hdnNameArea"];
    $rpt = new ReportesDao();
    $resp = $rpt->getDataRptActivosArea($area, true,2);
    $rpt->generarRptPdfActArea($resp,$areaNombre);
    
    
}

if(isset($_POST["btnRptMant"])){
    $area=$_POST["sAreaR"];
    $areaNombre= $_POST["hdnNameArea"];
    $rpt = new ReportesDao();
    $resp = $rpt->getDataRptMantenimiento($area);
    $rpt->generarRptPdfMantenimiento($resp,$areaNombre);
}

if(!$_POST){

    header("Location: reportes.php");

}

function getArrayCantByActiTipo($rptDao){
    $array = array();

    //1 = pc, 2=laptop, 3= impresor, 4=proyecto, 5=telefono, 6 = monitor
    $array["PC"] = $rptDao -> contTotalTipAct(1);
    $array["Laptop"] = $rptDao -> contTotalTipAct(2);
    $array["Impresor"] = $rptDao -> contTotalTipAct(3);
    $array["Proyector"] = $rptDao -> contTotalTipAct(4);
    $array["Telefono"] = $rptDao -> contTotalTipAct(5);
    $array["Monitor"] = $rptDao -> contTotalTipAct(6);

    return $array;
}
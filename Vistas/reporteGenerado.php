<?php
require dirname(__DIR__, 1) ."/Modelos/conexion.php";
include_once dirname(__DIR__, 1) . '/Modelos/clases/reportesPlantilla.php';
include_once dirname(__DIR__, 1) . '/Modelos/clasesDao/reportesDao.php';

//CUANDO SE DA CLICK BOTÓN REPORTE TIPO ACTIVO- ÁREA
if (isset($_POST["btnRptActArea"])) {

    $tipoAct = $_POST["sTipoActivoR"];
    $area=$_POST["sAreaR"];
    $areaNombre= $_POST["hdnNameArea"];

    $rpt = new ReportesDao();

    if($tipoAct !=0 && $area != 100){
        $resp = $rpt->getDataRptTipActAreaTodas($tipoAct,$area, false, false);
        $rpt->generarRptPdfActArea($resp,$areaNombre);
    }

    if($area==100 && $tipoAct==0){
        $htmlArray = $rpt->getDataRptTipActAreaTodas(0,100, false, false);
        $rpt->generearRptTipActAreaAll($htmlArray);
    }

    if($area==100 && $tipoAct!=0){
        $htmlArray = $rpt->getDataRptTipActAreaTodas($tipoAct, $area, false, false);
        $rpt->generearRptTipActAreaAll($htmlArray);
    }

    if($area!=100 && $tipoAct==0){
        $htmlArray = $rpt->getDataRptTipActAreaTodas($tipoAct, $area, false, false);
        $rpt->generearRptTipActAreaAll($htmlArray);
    }



}


//CUANDO SE HACE CLICK EN BOTÓN REPORTE TIPO ACTIVO
if (isset($_POST["btnRptActTipoActivo"])) {

    $tipoActRpt = $_POST["sTipoActivoR"];
    $tipoActNombre=$_POST["hdnNameAct"];

    $r = new ReportesDao();

    //creamos array para manejar la cant de tipo activos
    $arrayContTAct = getArrayCantByActiTipo($r);


    $resp = $r->getDataRptActivosTipo($tipoActRpt);
    $r->generarRptPdfTipAct($resp,$arrayContTAct, $tipoActNombre);
}



//CUANDO SE HACE CLICK EN BOTÓN RESUMEN DE ACTIVOS TOTALES
if(isset($_POST["btnRptResAct"])){
    $rpt = new ReportesDao();

    $html = $rpt->getDataRptResTipAct();
    $rpt->generarRptPdfResTipAct($html);
}


//CUANDO SE HACE CLICK EN REPORTE DE TONER
if(isset($_POST["btnRptCantTon"])){
    $rpt = new ReportesDao();

    $html = $rpt->getDataRptTipoActivoImp();
    $rpt->generarRptPdfResImpToner($html);
}


//CUANDO SE HACE CLICK EN REPORTES ÁREAS
if(isset($_POST["btnRptAreas"])){
    $tipoAct = $_POST["sTipoActivoR"];
    $area=$_POST["sAreaR"];
    $areaNombre= $_POST["hdnNameArea"];
    
    $rpt = new ReportesDao();

    if($tipoAct !=0 && $area != 100){
        $resp = $rpt->getDataRptTipActAreaTodas($tipoAct,$area, true, false);
        $rpt->generarRptPdfActArea($resp,$areaNombre);
    }

    if($area==100 && $tipoAct==0){
        $htmlArray = $rpt->getDataRptTipActAreaTodas(0,100, true, false);
        $rpt->generearRptTipActAreaAll($htmlArray);
    }

    if($area==100 && $tipoAct!=0){
        $htmlArray = $rpt->getDataRptTipActAreaTodas($tipoAct, $area, true, false);
        $rpt->generearRptTipActAreaAll($htmlArray);
    }

    
    
}



//CUANDO SE HACE CLICK EN REPORTE MANTENIMIENTO
if(isset($_POST["btnRptMant"])){
    $tipoAct = $_POST["sTipoActivoR"];
    $area=$_POST["sAreaR"];
    $areaNombre = $_POST["hdnNameArea"];
    $tipoActNombre = $_POST["hdnNameAct"];

    $rpt = new ReportesDao();
    if($tipoAct !=0 && $area != 100){
        $resp = $rpt->getDataRptTipActAreaTodas($tipoAct,$area, false, true);
        $rpt->generarRptPdfMantenimiento($resp, $areaNombre);
    }

    if($area==100 && $tipoAct==0){
        $htmlArray = $rpt->getDataRptTipActAreaTodas(0,100, false, true);
        $rpt->generarRptPdfMantenimiento($htmlArray, $areaNombre);
    }

    if($area==100 && $tipoAct!=0){
        $htmlArray = $rpt->getDataRptTipActAreaTodas($tipoAct, $area, false, true);
        $rpt->generarRptPdfMantenimiento($htmlArray, $areaNombre);
    }
    //$resp = $rpt->getDataRptMantenimiento($area);
    //$rpt->generarRptPdfMantenimiento($resp,$areaNombre);
}


///SI NO VIENE NADA POR POST REDIRECCIONAMOS A VISTA REPORTES
if(!$_POST){

    header("Location: reportes.php");

}


//FUNCIÓN QUE CARGA ARRAY CON TIPO ACTIVO Y SU CANTIDAD TOTAL EN EL SISTEMA
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

function getArrayNombreActiTipo(){
    $array = array("PC","Laptop","Impresor","Proyector","Telefono","Monitor");

    return $array;
}
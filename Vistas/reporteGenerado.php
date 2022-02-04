<?php
require dirname(__DIR__, 1) ."/Modelos/conexion.php";
include_once dirname(__DIR__, 1) . '/Modelos/clases/reportesPlantilla.php';
include_once dirname(__DIR__, 1) . '/Modelos/clasesDao/reportesDao.php';

//CUANDO SE DA CLICK BOTÓN REPORTE TIPO ACTIVO- ÁREAfals
if (isset($_POST["btnRptActArea"])) {

    $tipoAct = $_POST["sTipoActivoR"];
    $area=$_POST["sAreaR"];

    $r = new ReportesDao();
    $r -> rptTipoActArea(true, $tipoAct, $area);


}


//CUANDO SE HACE CLICK EN BOTÓN REPORTE TIPO ACTIVO
if (isset($_POST["btnRptActTipoActivo"])) {
    $tipoAct = $_POST["sTipoActivoR"];
    $r = new ReportesDao();
    $r->rptTipoAct($tipoAct, true);
}



//CUANDO SE HACE CLICK EN BOTÓN RESUMEN DE ACTIVOS TOTALES
if(isset($_POST["btnRptResAct"])){
    $r = new ReportesDao();
    $r->rptResumenAct();
}


//CUANDO SE HACE CLICK EN REPORTE DE TONER
if(isset($_POST["btnRptCantTon"])){
    $r = new ReportesDao();
    $r-> rptResumenToner();
}


//CUANDO SE HACE CLICK EN REPORTES ÁREAS
if(isset($_POST["btnRptAreas"])){

    $tipoAct = $_POST["sTipoActivoR"];
    $area=$_POST["sAreaR"];

    $r = new ReportesDao();
    $r -> rptTipoActArea(false, $tipoAct, $area);
    
    
}



//CUANDO SE HACE CLICK EN REPORTE MANTENIMIENTO
if(isset($_POST["btnRptMant"])){
    $tipoAct = $_POST["sTipoActivoR"];
    $area=$_POST["sAreaR"];
    $r = new ReportesDao();
    $r-> rptMantenimiento($tipoAct, $area);
}


///SI NO VIENE NADA POR POST REDIRECCIONAMOS A VISTA REPORTES
/*if(!$_POST){

    header("Location: reportes.php");

}*/



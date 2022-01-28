<?php
include('layout/header.php');
include('layout/navbar.php');
include_once dirname(__DIR__, 1) . '/Modelos/clasesDao/reportesDao.php';

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.js"></script>
<link href="../recursos/css/reportes.css" rel="stylesheet">
<link href="../Recursos/CSS/nuevoUsuario.css" rel="stylesheet">
<script src="../recursos/JS/reportes.js"></script>
<div class="content-body">
    <div class="container-fluid">

        <!--barra top -->
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Bienvenido <?= $_SESSION["usuario"]["nombre"]; ?>!</h4>
                    <p class="mb-0">Rol: <?= $_SESSION["usuario"]["rol"]; ?></p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Reportes</a></li>
                </ol>
            </div>
        </div>
        <!-- fin barra top -->

        <!--combo box tipo activo -->
        <div class="row page-titles mx-0 shadow mb-3">
            <div class="col-md-12 text-center mb-5 my-3">
                <h3 class="titulo">Reporte de activos por área y tipo de activo</h3>
            </div>
            <div class="col-md-6 p-md-0">
                <form name="formRptActTA" method="post" action="reporteGenerado.php" target="_blank">
                    <input type="hidden" name="hdnNameArea" id="hdnNameArea">
                    <input type="hidden" name="hdnNameAct" id="hdnNameAct">
                    <label for="sTipoActivoR">Seleccionar tipo de activo</label>
                    <select class="form-control" id="sTipoActivoR" name="sTipoActivoR">
                        <option value="0">Todos</option>
                    </select>
            </div>
            <div class="col-md-6 p-md-0">
                <label for="sTipoActivoR">Seleccionar área</label>
                <select class="form-control" id="sAreas" name="sAreaR">
                <option value="100">Todas</option>
                </select>
            </div>
            <div class="col-md-12"><p class="alertError my-2 mb-2" role="alert" id="labelError"></p></div>
            <div class="row my-3">
                <div class="col-md-12">
                    <button type="submit" id="btnRptActArea" name="btnRptActArea" class="btn outLineRed my-3">Reporte tipo-área</button>
                    <button type="submit" id="btnRptActTipoActivo" name="btnRptActTipoActivo" class="btn outLineRed my-3">Reporte tipo activo</button>
                    <button type="submit" id="btnRptAreas" name="btnRptAreas" class="btn outLineRed my-3">Reporte áreas</button>
                    <button type="submit" id="btnRptMant" name="btnRptMant" class="btn outLineRed my-3">Reporte mantenimiento</button>
                    <button type="submit" id="btnRptResAct" name="btnRptResAct" class="btn outLineRed my-3">Reporte activos totales</button>
                    <button type="submit" id="btnRptCantTon" name="btnRptCantTon" class="btn outLineRed my-3">Reporte toners</button>
                    </form>
                </div>
            </div>
                
        </div>
    </div>
</div>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<?php
include('layout/footer.php');
?>
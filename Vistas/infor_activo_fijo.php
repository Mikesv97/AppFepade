<?php
include('layout/header.php');
include('layout/navbar.php');
include_once '../Modelos/activoFijoInformacionDao.php';
$obj = new Activo_fijo_informacion();

//variables que almacenan el nombre y id del usuario que inicia sesion
$usuario = $_SESSION["usuario"]["nombre"];
$idUSuario = $_SESSION["usuario"]["id"];
//variable que genera la fecha actual
$date = date('d-m-Y');
?>

<!-- script para mostrar o ocultar los campos segun, el tipo de activo que se ingresara -->
<script src="../Recursos/JS/tipoActivo.js"></script>
</script>

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Bienvenido <?= $usuario; ?>!</h4>
                    <p class="mb-0">Rol: <?= $_SESSION["usuario"]["rol"]; ?></p>
                    <p class="mb-0">Hora: <?= $date; ?></p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Components</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ingreso de activo nuevo</h4>
                    </div>
                    <div class="card-body">
                        <form action="#" id="formActivo" class="formActivo" method="POST" enctype="multipart/form-data">
                            <div>
                                <h4>Información de activo</h4>
                                <br>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Referencia*</label>
                                                <input type="text" name="referencia" class="form-control" placeholder="ABC123" maxlength="30" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código contabilidad</label>
                                                <input type="text" name="codContabilidad" class="form-control" placeholder="123456" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Referencia*</label>
                                                <input type="text" name="referencia" class="form-control" placeholder="ABC123" maxlength="30" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código contabilidad</label>
                                                <input type="text" name="codContabilidad" class="form-control" placeholder="123456" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Referencia*</label>
                                                <input type="text" name="referencia" class="form-control" placeholder="ABC123" maxlength="30" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código contabilidad</label>
                                                <input type="text" name="codContabilidad" class="form-control" placeholder="123456" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Referencia*</label>
                                                <input type="text" name="referencia" class="form-control" placeholder="ABC123" maxlength="30" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código contabilidad</label>
                                                <input type="text" name="codContabilidad" class="form-control" placeholder="123456" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Referencia*</label>
                                                <input type="text" name="referencia" class="form-control" placeholder="ABC123" maxlength="30" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código contabilidad</label>
                                                <input type="text" name="codContabilidad" class="form-control" placeholder="123456" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Referencia*</label>
                                                <input type="text" name="referencia" class="form-control" placeholder="ABC123" maxlength="30" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código contabilidad</label>
                                                <input type="text" name="codContabilidad" class="form-control" placeholder="123456" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Referencia*</label>
                                                <input type="text" name="referencia" class="form-control" placeholder="ABC123" maxlength="30" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código contabilidad</label>
                                                <input type="text" name="codContabilidad" class="form-control" placeholder="123456" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Referencia*</label>
                                                <input type="text" name="referencia" class="form-control" placeholder="ABC123" maxlength="30" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código contabilidad</label>
                                                <input type="text" name="codContabilidad" class="form-control" placeholder="123456" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Referencia*</label>
                                                <input type="text" name="referencia" class="form-control" placeholder="ABC123" maxlength="30" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código contabilidad</label>
                                                <input type="text" name="codContabilidad" class="form-control" placeholder="123456" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success">Success</button>
                                </section>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Activos fijos en sistema</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="activoInformacion" name="activoInformacion" class='table table-striped dt-responsive nowrap' style='width:100%; text-align: center'>
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Empresa</th>
                                        <th>Departamento</th>
                                        <th>F.F.</th>
                                        <th>Área</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Empresa</th>
                                        <th>Departamento</th>
                                        <th>F.F.</th>
                                        <th>Área</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- script para mostrar o ocultar los campos segun, el tiepo de activo que se ingresara -->
<script src="../Recursos/JS/tipoActivo.js"></script>
<script src="../Recursos/JS/activoInformacion.js"></script>

<!-- Datatable -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script> -->

<!-- script para poner el boton que muestra las demas columnas de la tabla activo fijo y cambiando el idioma-->
<script>
    
        $('#activoInformacion').DataTable({
            "ajax":{
                "url": "../Controladores/activoInfoControlador.php",
                "dataSrc": ""
            },
            "columns": [
                {"data": "Activo_id"},
                {"data": "Empresa_id"},
                {"data": "Estructura1_id"},
                {"data": "Estructura2_id"},
                {"data": "Estructura3_id"},
            ],
            responsive: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por pagina",
                "zeroRecords": "No se han encontrado datos - intente nuevamente",
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay datos disponibles",
                "infoFiltered": "(Filtrado de _MAX_ activos totales)",
                "search": "Buscar",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    
</script>

<!--**********************************
            Content body end
        ***********************************-->
<?php
include('layout/footer.php');
?>
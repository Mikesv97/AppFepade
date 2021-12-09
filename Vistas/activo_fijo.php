<?php
include('layout/header.php');
include('layout/navbar.php');
include_once '../Modelos/activoFijoDao.php';
$obj = new activoFijoDAO();

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
                        <form action="#" id="step-form-horizontal" class="step-form-horizontal">
                            <div>
                                <h4>Informacion de activo</h4>
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
                                                <label class="text-label">Codigo Contabilidad*</label>
                                                <input type="text" name="codContabilidad" class="form-control" placeholder="123456" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Codigo para proyectos*</label>
                                                <input type="text" name="codProyectos" class="form-control" placeholder="123456" maxlength="10" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Numero de serie*</label>
                                                <input type="text" name="numSerie" class="form-control" placeholder="123456" maxlength="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Codigo Automatico*</label>
                                                <input type="text" name="codAutomatico" class="form-control" placeholder="123456" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label for="party">Fecha de adquisicion</label>
                                                <input id="party" type="date" name="fechaAdq" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Numero de factura*</label>
                                                <input type="text" name="numFactura" class="form-control" placeholder="123456" maxlength="15" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Tipo de activo*</label>
                                                <select name="comboTipoActivo" id="comboTipoActivo" class="form-control">
                                                    <?php
                                                    $data = $obj->comboTipoActivo();
                                                    foreach ($data as $indice => $valor) {
                                                        echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">IP*</label>
                                                <input type="text" name="ip" class="form-control" placeholder="192.168.137.1" required maxlength="50" required>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h4>Descripcion del activo</h4>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Usuario*</label>
                                                <input type="text" name="usuario" value="<?= $idUSuario; ?>" hidden>
                                                <input type="text" name="nombreUsuario" class="form-control" value="<?= $usuario; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Modelo*</label>
                                                <input type="text" name="modelo" class="form-control" placeholder="123456" required maxlength="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Departamento*</label>
                                                <select name="comboDepartamento" id="comboDepartamento" class="form-control">
                                                    <?php
                                                    $data = $obj->comboDapartamento();
                                                    foreach ($data as $indice => $valor) {
                                                        echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">F.F.</label>
                                                <select name="comboFondos" id="comboFondos" class="form-control">
                                                    <?php
                                                    $data = $obj->comboFondos();
                                                    foreach ($data as $indice => $valor) {
                                                        echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Area</label>
                                                <select name="comboArea" id="comboArea" class="form-control">
                                                    <?php
                                                    $data = $obj->comboArea();
                                                    foreach ($data as $indice => $valor) {
                                                        echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Descripcion de activo*</label>
                                                <textarea class="form-control" name="descripcion" rows="3" maxlength="1000" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Foto de activo*</label>
                                                <input type="file" name="FileImagen" id="FileImagen" class="form-control" accept="image/x-png,image/gif,image/jpeg" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label for="party">Fecha de caducacion*</label>
                                                <input id="party" type="date" name="fechaCad" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h4>Informacion de activo</h4>
                                <section>
                                    <input type="text" id="tipoactivo">
                                    <div id="computadora">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Procesador*</label>
                                                    <input type="text" name="procesador" class="form-control" placeholder="Inter I3" required maxlength="50">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Generacion*</label>
                                                    <input type="text" name="generacion" class="form-control" placeholder="Tercera" required maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">RAM*</label>
                                                    <input type="text" name="ram" class="form-control" placeholder="4GB" required maxlength="50">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Tipo de RAM*</label>
                                                    <input type="text" name="tipoRam" class="form-control" placeholder="DDR3" required maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Disco Duro*</label>
                                                    <input type="text" name="disco" class="form-control" placeholder="100GB" required maxlength="50">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Sistema Operativo*</label>
                                                    <input type="text" name="sistema" class="form-control" placeholder="Winwdows 10" required maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Office*</label>
                                                    <input type="text" name="office" class="form-control" placeholder="2019" required maxlength="50">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Otros datos*</label>
                                                    <input type="text" name="otros" class="form-control" placeholder="otros datos" required maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="impresora">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Toner Negro*</label>
                                                    <input type="text" name="tonerNegro" class="form-control" placeholder="CE1234" required maxlength="50">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Toner Magenta*</label>
                                                    <input type="text" name="tonerMagenta" class="form-control" placeholder="CE1234" required maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Toner Cyan*</label>
                                                    <input type="text" name="tonerCyan" class="form-control" placeholder="CE1234" required maxlength="50">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Toner Amarillo*</label>
                                                    <input type="text" name="tonerAmarillo" class="form-control" placeholder="CE1234" required maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Tambor*</label>
                                                    <input type="text" name="tambor" class="form-control" placeholder="" maxlength="50">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Fusor*</label>
                                                    <input type="text" name="fusor" class="form-control" placeholder="" maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="proyector">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Horas de uso*</label>
                                                    <input type="number" name="horasUso" class="form-control" placeholder="12345678" required maxlength="50">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Horas economicas*</label>
                                                    <input type="number" name="horasEco" class="form-control" placeholder="123456" required maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h4>Renposable de activo</h4>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Estado de activo*</label>
                                                <select name="estado" id="estado" class="form-control">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Activo eliminado*</label>
                                                <select name="estadoEliminado" id="estado" class="form-control">
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Responsable*</label>
                                                <select name="comboResponsable" id="comboResponsable" class="form-control">
                                                    <?php
                                                    $data = $obj->comboResponsable();
                                                    foreach ($data as $indice => $valor) {
                                                        echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Comentarios de asignacion*</label>
                                                <textarea class="form-control" name="comentario" rows="3" maxlength="50"></textarea>
                                            </div>
                                        </div>
                                    </div>
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
                            <?php
                            echo $obj->mostrarActivoFijo();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- script para mostrar o ocultar los campos segun, el tiepo de activo que se ingresara -->
<script src="../Recursos/JS/tipoActivo.js"></script>
<!-- Datatable -->
<!-- <script src="../Recursos/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../Recursos/JS/plugins-init/datatables.init.js"></script> -->

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script> -->

<script>
    $('#activoTabla').DataTable({
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
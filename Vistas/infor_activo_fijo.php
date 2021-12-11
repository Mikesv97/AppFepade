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
                        <h4 class="card-title">Información de activo</h4>
                    </div>
                    <div class="card-body">
                        <form action="#" id="formActivo" class="formActivo" method="POST" enctype="multipart/form-data">
                            <div>
                                <h4>Información de activo</h4>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Referencia*</label>
                                                <input type="text" name="referencia" class="form-control" maxlength="30" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código contabilidad</label>
                                                <input type="text" name="codContabilidad" class="form-control" maxlength="10" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código para proyectos*</label>
                                                <input type="text" name="codProyectos" class="form-control" maxlength="10" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Número de serie</label>
                                                <input type="text" name="numSerie" class="form-control" maxlength="50" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Código automático*</label>
                                                <input type="text" name="codAutomatico" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label for="party">Fecha de adquisición*</label>
                                                <input id="party" type="date" name="fechaAdq" class="form-control" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Número de factura*</label>
                                                <input type="text" name="numFactura" class="form-control" maxlength="15" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Tipo de activo*</label>
                                                <select name="comboTipoActivo" id="comboTipoActivo" class="form-control" disabled>
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
                                                <input type="text" name="ip" class="form-control" required maxlength="50" required readonly> 
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
                                                <input type="text" name="modelo" class="form-control" required maxlength="50" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Departamento*</label>
                                                <select name="comboDepartamento" id="comboDepartamento" class="form-control" disabled>
                                                    <?php
                                                    $data = $obj->comboDapartamento();
                                                    foreach ($data as $indice => $valor) {
                                                        echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="ccol-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">F.F.*</label>
                                                <select name="comboFondos" id="comboFondos" class="form-control" disabled>
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
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Área*</label>
                                                <select name="comboArea" id="comboArea" class="form-control" disabled>
                                                    <?php
                                                    $data = $obj->comboArea();
                                                    foreach ($data as $indice => $valor) {
                                                        echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Descripción de activo*</label>
                                                <textarea class="form-control" name="descripcion" rows="3" maxlength="1000" required readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Foto de activo*</label>
                                                <input type="file" name="FileImagen" id="FileImagen" class="form-control" accept="image/x-png,image/gif,image/jpeg" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label for="party">Fecha de caducación*</label>
                                                <input id="party" type="date" name="fechaCad" class="form-control" readonly>
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
                                                    <input type="text" name="procesador" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Generación*</label>
                                                    <input type="text" name="generacion" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">RAM*</label>
                                                    <input type="text" name="ram" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Tipo de RAM*</label>
                                                    <input type="text" name="tipoRam" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Disco duro principal*</label>
                                                    <input type="text" name="disco" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Capacidad disco principal*</label>
                                                    <input type="text" name="capacidadD1" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Disco duro secundario</label>
                                                    <input type="text" name="disco2" class="form-control" maxlength="50" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Capacidad disco secundario</label>
                                                    <input type="text" name="capacidadD2" class="form-control"maxlength="50" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Office*</label>
                                                    <input type="text" name="office" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Sistema operativo*</label>
                                                    <input type="text" name="sistema" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="impresora">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Toner negro*</label>
                                                    <input type="text" name="tonerNegro" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Toner magenta*</label>
                                                    <input type="text" name="tonerMagenta" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Toner cyan*</label>
                                                    <input type="text" name="tonerCyan" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Toner amarillo*</label>
                                                    <input type="text" name="tonerAmarillo" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Tambor</label>
                                                    <input type="text" name="tambor" class="form-control" maxlength="50" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Fusor</label>
                                                    <input type="text" name="fusor" class="form-control" maxlength="50" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="proyector">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Horas de uso*</label>
                                                    <input type="number" name="horasUso" class="form-control" required maxlength="50" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="text-label">Horas economicas*</label>
                                                    <input type="number" name="horasEco" class="form-control" required maxlength="50" readonly>
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
                                                <label class="text-label">Estado de activo</label>
                                                <select name="estado" id="estado" class="form-control" disabled>
                                                    <option value="1">Disponible</option>
                                                    <option value="0">No disponible</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Activo eliminado</label>
                                                <select name="estadoEliminado" id="estado" class="form-control" disabled>
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <div class="form-group">
                                                <label class="text-label">Responsable</label>
                                                <select name="comboResponsable" id="comboResponsable" class="form-control" disabled>
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
                                                <label class="text-label">Comentarios de asignación</label>
                                                <textarea class="form-control" name="comentario" rows="3" maxlength="50" readonly></textarea>
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
                            <table id="activoInformacion" name="activoInformacion" class='table table-striped dt-responsive nowrap' style='width:100%; text-align: center'>
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Empresa</th>
                                        <th>Departamento</th>
                                        <th>F.F.</th>
                                        <th>Área</th>
                                        <th>Opciones</th>
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
                                        <th>Opciones</th>
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
<script src="../Recursos/JS/activoInformacion.js"></script>

<!--**********************************
            Content body end
        ***********************************-->
<?php
include('layout/footer.php');
?>
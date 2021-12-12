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

<style>
    .alturaFija {
        min-height: 400px;
    }
</style>

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
            <button type="button" class="btn btn-tumblr mb-5 ml-4" data-toggle="collapse" href="#mostrarFormulario" aria-controls="mostrarFormulario">
                Mostrar formulario
            </button>
            <div class="col-xl-12 col-xxl-12 collapse" id="mostrarFormulario">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Formulario activo fijo</h4>
                    </div>
                    <div class="card-body">
                        <form action="#" id="formActivo" class="formActivo" method="POST" enctype="multipart/form-data">
                            <div class="row ">
                                <div class="col-md-6">
                                    <!-- INICIO PRIMERA COLUMNA DEL FORM -->
                                    <h5>Información de activo</h5>
                                    <br>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Referencia*</label>
                                            <input type="text" name="ActivoReferencia" class="form-control" maxlength="30" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Código contabilidad</label>
                                            <input type="text" name="PartidaCta" class="form-control" maxlength="10">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Código para proyectos*</label>
                                            <input type="text" name="EmpresaId" class="form-control" maxlength="10" value="1" readonly required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Número de serie</label>
                                            <input type="text" name="numeroSerie" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Código automático*</label>
                                            <input type="text" name="ActivoId" class="form-control" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="party">Fecha de adquisición*</label>
                                            <input id="party" type="date" name="ActivoFechaAdq" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Número de factura*</label>
                                            <input type="text" name="ActivoFactura" class="form-control" maxlength="15" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Tipo de activo*</label>
                                            <select name="ActivoTipo" id="ActivoTipo" class="form-control">
                                                <?php
                                                $data = $obj->comboTipoActivo();
                                                foreach ($data as $indice => $valor) {
                                                    echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">IP*</label>
                                            <input type="text" name="ip" class="form-control" required maxlength="50" required>
                                        </div>
                                    </div>
                                    <!-- FIN PRIMERA COLUMNA DEL FORM -->
                                </div>
                                <div class="col-md-6">
                                    <!-- INICIO SEGUNDA COLUNMA DEL FORM -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Usuario*</label>
                                            <input type="text" name="UsuarioId" value="<?= $idUSuario; ?>" hidden>
                                            <input type="text" name="nombreUsuario" class="form-control" value="<?= $usuario; ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Modelo*</label>
                                            <input type="text" name="Modelo" class="form-control" required maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Departamento*</label>
                                            <select name="Estructura1Id" id="Estructura1Id" class="form-control">
                                                <?php
                                                $data = $obj->comboDapartamento();
                                                foreach ($data as $indice => $valor) {
                                                    echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">F.F.*</label>
                                            <select name="Estructura2Id" id="Estructura2Id" class="form-control">
                                                <?php
                                                $data = $obj->comboFondos();
                                                foreach ($data as $indice => $valor) {
                                                    echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Área*</label>
                                            <select name="Estructura3Id" id="Estructura3Id" class="form-control">
                                                <?php
                                                $data = $obj->comboArea();
                                                foreach ($data as $indice => $valor) {
                                                    echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Descripción de activo*</label>
                                            <textarea class="form-control" name="ActivoDescripcion" rows="3" maxlength="1000" required></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Foto de activo*</label>
                                            <input type="file" name="Imagen" id="Imagen" class="form-control" accept="image/x-png,image/gif,image/jpeg">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Fecha de caducación</label>
                                            <input type="date" name="ActivoFechaCaduc" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Activo eliminado</label>
                                            <select name="ActivoEliminado" id="ActivoEliminado" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- FIN SEGUNDA COLUMNA DEL FORM -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 bg-warning">
                                    <div class="form-row ">
                                        <div class="form-group col-md-4">
                                            <label class="text-label">Estado de activo</label>
                                            <select name="estado" id="estado" class="form-control">
                                                <option value="1">Disponible</option>
                                                <option value="0">No disponible</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="text-label">Responsable</label>
                                            <select name="ResponsableId" id="ResponsableId" class="form-control">
                                                <?php
                                                $data = $obj->comboResponsable();
                                                foreach ($data as $indice => $valor) {
                                                    echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="text-label">Comentarios de asignación</label>
                                            <textarea class="form-control" name="HistoricoComentario" rows="3" maxlength="50"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="tipoactivo">
                                    <h5>Especificaciones de activo </h5>
                                    <br>
                                    <div class="form-row" id="computadora">
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Procesador*</label>
                                            <input type="text" name="Procesador" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Generación*</label>
                                            <input type="text" name="Generacion" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">RAM*</label>
                                            <input type="text" name="Ram" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Tipo de RAM*</label>
                                            <input type="text" name="TipoRam" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Disco duro principal*</label>
                                            <input type="text" name="DiscoDuro" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Capacidad disco principal*</label>
                                            <input type="text" name="CapacidadD1" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Disco duro secundario</label>
                                            <input type="text" name="DiscoDuro2" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Capacidad disco secundario</label>
                                            <input type="text" name="CapacidadD2" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Office*</label>
                                            <input type="text" name="Office" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Sistema operativo*</label>
                                            <input type="text" name="SO" class="form-control" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="form-row alturaFija" id="impresora">
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Toner negro*</label>
                                            <input type="text" name="TonerN" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Toner magenta*</label>
                                            <input type="text" name="TonerM" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Toner cyan*</label>
                                            <input type="text" name="TonerC" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Toner amarillo*</label>
                                            <input type="text" name="TonerA" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Tambor</label>
                                            <input type="text" name="tambor" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Fusor</label>
                                            <input type="text" name="fusor" class="form-control" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="form-row alturaFija" id="proyector">
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Horas de uso*</label>
                                            <input type="number" name="HorasUso" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Horas economicas*</label>
                                            <input type="number" name="HoraEco" class="form-control" maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 bg-danger">

                                </div>
                            </div>
                            <button type="submit" class="btn btn-tumblr" name="btnInsertar" id="btnInsertar">Insertar</button>
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
<script src="../Recursos/JS/activoFijo.js"></script>


<!-- Datatable -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script> -->

<!-- script para poner el boton que muestra las demas columnas de la tabla activo fijo y cambiando el idioma-->
<script src="../Recursos/JS/activoInformacion.js"></script>

<script>

</script>

<!--**********************************
            Content body end
        ***********************************-->
<?php
include('layout/footer.php');
?>
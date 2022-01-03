<?php
include('layout/header.php');
include('layout/navbar.php');
include_once dirname(__DIR__, 1).'/Modelos/clasesDao/activoFijoDao.php';
$obj = new activoFijoDAO();

//variables que almacenan el nombre y id del usuario que inicia sesion
$usuario = $_SESSION["usuario"]["nombre"];
$idUSuario = $_SESSION["usuario"]["id"];
//variable que genera la fecha actual
$date = date('d-m-Y');
?>

<!-- script para mostrar o ocultar los campos segun, el tipo de activo que se ingresara -->
<script src="../Recursos/JS/tipoActivo.js"></script>

<style>
    .borde {
        /* border: 0.5px solid rgba(0, 0, 0, 0.3); */
        padding: 10px;
    }

    .comentarioAsig {
        min-height: 250px;
        max-height: 250px;
        min-width: 100%;
        max-width: 100%;
        overflow: scroll;
        resize: none;
    }

    .descripcionActivo {
        min-height: 80px;
        max-height: 80px;
        min-width: 100%;
        max-width: 100%;
        overflow: scroll;
        resize: none;
    }

    #mostrarImagen {
        background-color: white;
        max-width: 420px;
        max-height: 400px;
        margin: 0 auto;
    }

    .desabilitado {
        background: #dddddd !important;
    }

    .habilitado {
        background: none;
    }

    #ActivoReferenciaH {
        font-weight: bold;
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
                    <a href="" id="inicioForm"></a>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Registro de activos</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <button type="button" class="btn btn-tumblr mb-5 ml-4" data-toggle="collapse" href="#mostrarFormulario" aria-controls="mostrarFormulario" id="verFormulario">
                Ingresar activo fijo
            </button>
            <div class="col-xl-12 col-xxl-12 collapse" id="mostrarFormulario">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Formulario activo fijo</h4>
                    </div>
                    <div class="card-body">
                        <form action="#" id="formActivo" class="formActivo" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 borde">
                                    <!-- INICIO PRIMERA COLUMNA DEL FORM -->
                                    <h5 class="my-2 label label-danger col-md-12">Información general de activo</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Referencia*</label>
                                            <input type="text" name="ActivoReferencia" id="ActivoReferencia" class="form-control" maxlength="30" required>
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
                                            <input id="ActivoFechaAdq" type="date" name="ActivoFechaAdq" class="form-control" required>
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
                                    <h5 class="my-2 label label-danger col-md-12">Información general de activo</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="text" name="UsuarioId" value="<?= $idUSuario; ?>" hidden>
                                            <input type="text" name="nombreUsuario" class="form-control" value="<?= $usuario; ?>" hidden>
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
                                            <p class="medium p-1 alertError" role="alert" id="labelError2"></p>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Descripción de activo*</label>
                                            <textarea class="form-control" name="ActivoDescripcion" id="ActivoDescripcion" rows="3" maxlength="1000" required></textarea>
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
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="ActivoEliminado" id="ActivoEliminado">
                                                <label class="form-check-label" for="ActivoEliminado">Eliminado</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- FIN SEGUNDA COLUMNA DEL FORM -->
                                </div>
                            </div>
                            <div class="row borde-top">
                                <div class="col-md-6 borde" id="ResCompAsig">
                                    <h5 class="my-2 label label-danger col-md-12">Responsable y comentarios de asignación</h5>
                                    <div class="form-row ">
                                        <div class="form-group col-md-6">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="estado" id="estado">
                                                <label class="form-check-label" for="estado">Inactivo</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
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
                                        <div class="form-group col-md-12">
                                            <label class="text-label">Comentarios de asignación</label>
                                            <textarea class="form-control comentarioAsig" name="HistoricoComentario" id="HistoricoComentario" rows="3" maxlength="50"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 borde">
                                    <div class="text-center">
                                        <h5 class="my-2 label label-danger col-md-12">Imagen de activo fijo</h5>
                                        <input type="text" name="imagenBD" id="imagenBD" hidden>
                                        <div>
                                            <img id="mostrarImagen" src="../Recursos/Multimedia/Imagenes/Upload/nodisponible.jpg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <h5 class="my-2 label label-danger col-md-12">Especificaciones computadora</h5>
                                    <div class="form-row my-2 ">
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
                                        <div class="form-group col-md-12">
                                            <label class="text-label">Office*</label>
                                            <input type="text" name="Office" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="text-label">Sistema operativo*</label>
                                            <input type="text" name="SO" class="form-control" maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="my-2 label label-danger col-md-12">Especificaciones impresora</h5>
                                    <div class="form-row my-2">
                                        <div class="form-group col-md-6">
                                            <label class="text-label">Toner negro*</label>
                                            <input type="text" name="TonerN" id="TonerN" class="form-control" maxlength="50">
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
                                        <h5 class="my-4 label label-danger col-md-12">Especificaciones proyector</h5>

                                        <div class="form-group col-md-12">
                                            <label class="text-label">Horas de uso*</label>
                                            <input type="number" name="HorasUso" class="form-control" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="text-label">Horas economicas*</label>
                                            <input type="number" name="HoraEco" class="form-control" maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="my-2 label label-danger col-md-12">Historial activo</h5>
                                    <div class="" id="prueba">
                                        <table id="activoHistorial" name="activoHistorial" class='table table-striped dt-responsive nowrap' style='width:100%; text-align: center'>
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Área</th>
                                                    <th>Responsable</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Área</th>
                                                    <th>Responsable</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <button type="button" id="btnMostrarHistorial" class="btn btn-facebook btn-block" data-toggle="modal" data-target=".modalHistorial">Transladar activo</button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-tumblr my-4" name="btnInsertar" id="btnInsertar">Insertar</button>
                            <button type="button" class="btn btn-tumblr my-4" name="btnModificar" id="btnModificar">Modificar</button>
                            <button type="button" class="btn btn-tumblr my-4" name="btnEliminar" id="btnEliminar">Eliminar</button>
                            <button type="button" class="btn btn-tumblr my-4" name="btnCancelar" id="btnCancelar">Cancelar</button>
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
                                        <th>Activo id</th>
                                        <th>Referencia</th>
                                        <th>Código contabilidad</th>
                                        <th>Código proyecto</th>
                                        <th>Número de serie</th>
                                        <th>Fecha adquisición</th>
                                        <th>Fecha de caducación</th>
                                        <th>Número de factura</th>
                                        <th>Tipo de activo</th>
                                        <th>IP</th>
                                        <th>Nombre de usuario</th>
                                        <th>Modelo</th>
                                        <th>Departamento</th>
                                        <th>F.F.</th>
                                        <th>Área</th>
                                        <th>Descripción de activo</th>
                                        <th>Activo Eliminado</th>
                                        <th>Cargar Información</th>
                                        <th>Acciones</th>
                                        <th>Imagen</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Activo id</th>
                                        <th>Referencia</th>
                                        <th>Código contabilidad</th>
                                        <th>Código proyecto</th>
                                        <th>Número de serie</th>
                                        <th>Fecha adquisición</th>
                                        <th>Fecha de caducación</th>
                                        <th>Número de factura</th>
                                        <th>Tipo de activo</th>
                                        <th>IP</th>
                                        <th>Nombre de usuario</th>
                                        <th>Modelo</th>
                                        <th>Departamento</th>
                                        <th>F.F.</th>
                                        <th>Área</th>
                                        <th>Descripción de activo</th>
                                        <th>Activo Eliminado</th>
                                        <th>Cargar Información</th>
                                        <th>Acciones</th>
                                        <th>Imagen</th>
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

<!-- MODAL PARA HISTORIAL DE ACTIVO -->
<div class="modal fade modalHistorial" tabindex="-1" role="dialog" aria-hidden="true" id="probando">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <a href="" id="inicioFormHistorial"></a>
                <h5 class="modal-title">Historial de activo fijo</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- INPUT QUE GUARDA EL ID ACTIVO PARA CARGAR EL DATA TABLE DE HISTORICO -->
                <input type="text" id="guardarIdActivo" hidden>
                <form action="#" id="formHistorico" class="formHistorico" method="POST">
                    <div class="row">
                        <div class="col-md-12 borde">
                            <!-- INICIO PRIMERA COLUMNA DEL FORM -->
                            <div class="form-row">
                                <!-- INPUT QUE GUARDA EL ID ACTIVO PARA INSERTARLO EN LA BASE DE DATOS -->
                                <input type="text" id="guardarIdActivo2" name="guardarIdActivo2" hidden>
                                <!-- INPUT QUE GUARDA EL ID USUARIO PARA INSERTARLO EN LA BASE DE DATOS -->
                                <input type="text" name="UsuarioIdH" value="<?= $idUSuario; ?>" hidden>
                                <!-- INPUT QUE GUARDA EL ID HISTORICO PARA ELIMINAR UN HISTORICO -->
                                <input type="text" name="historicoId" id="historicoId" hidden>
                                <label class="label label-danger col-md-12">Activo</label>
                                <div class="form-group col-md-5">
                                    <input type="text" name="ActivoReferenciaH" id="ActivoReferenciaH" class="form-control" maxlength="30" required readonly>
                                </div>
                                <div class="form-group col-md-7">
                                    <textarea class="form-control descripcionActivo" name="ActivoDescripcionH" rows="3" maxlength="1000" required readonly></textarea>
                                </div>
                                <label class="label label-danger col-md-12">Área</label>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="idArea" id="idArea" readonly>
                                </div>
                                <div class="form-group col-md-9">
                                    <select name="Estructura3IdH" id="Estructura3IdH" class="form-control">
                                        <?php
                                        $data = $obj->comboArea();
                                        foreach ($data as $indice => $valor) {
                                            echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="label label-danger col-md-12">Responsable</label>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="idResponsable" id="idResponsable" readonly>
                                </div>
                                <div class="form-group col-md-9">
                                    <select name="ResponsableIdH" id="ResponsableIdH" class="form-control">
                                        <?php
                                        $data = $obj->comboResponsable();
                                        foreach ($data as $indice => $valor) {
                                            echo ' <option value="' . $indice . '">' . $valor . ' </option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="label label-danger col-md-12">Fecha y estado de activo</label>
                                <div class="form-group col-md-6">
                                    <input id="fechaHistorico" type="date" name="fechaHistorico" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="estadoH" id="estadoH">
                                        <label class="form-check-label" for="estadoH">Inactivo</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="label label-danger col-md-12">Comentarios de asignación</label>
                                    <textarea class="form-control descripcionActivo" name="HistoricoComentarioH" rows="3" maxlength="50"></textarea>
                                </div>

                                <div class="col-md-12 responsive-table"">
                                    <h5 class=" my-2 label label-danger col-md-12">Historico de ubicaciones</h5>
                                    <div class="">
                                        <table id="historial" name="historial" class='table table-striped dt-responsive nowrap' style='width:100%; text-align: center'>
                                            <thead>
                                                <tr>
                                                    <th>Fecha de historico</th>
                                                    <th>Nombre de área</th>
                                                    <th>Área</th>
                                                    <th>Responsable</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Fecha de historico</th>
                                                    <th>Nombre de área</th>
                                                    <th>Área</th>
                                                    <th>Responsable</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-snapchat" id="btnNuevoHistorico">Nuevo Historial</button>
                    <button type="submit" class="btn btn-whatsapp" id="btnInsertarHistorico">Insertar</button>
                    <button type="button" class="btn btn-facebook" id="btnModificarHostorico">Modificar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-google-plus" id="btnCerrar" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- script para mostrar o ocultar los campos segun, el tiepo de activo que se ingresara -->

<!-- Datatable -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script> -->

<script src="../Recursos/JS/activoFijo.js"></script>

<!--**********************************
            Content body end
        ***********************************-->
<?php
include('layout/footer.php');
?>
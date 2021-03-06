<?php
include('layout/header.php');
include('layout/navbar.php');
include_once dirname(__DIR__, 1)."/Modelos/clasesDao/menuDao.php";
$mDao = new MenuDao();
$menu = $mDao->obtenerMenu();
basename(__FILE__);
?>
<link href="../recursos/css/nuevoUsuario.css" rel="stylesheet">
<script src="../Recursos/JS/activoResponsable.js"></script>
<div class="content-body">
    <div class="container-fluid">
    <a href="" id="inicioFormRespon"></a>
        <!--barra top -->
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Bienvenido <?= $_SESSION["usuario"]["nombre"]; ?>!</h4>
                    <span class="mb-0 rol">Rol: <?= $_SESSION["usuario"]["rol"]; ?></span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Activo Responsable</a></li>
                </ol>
            </div>
        </div>
        <!-- fin barra top -->

        <!--cuerpo form -->
        <div class="row page-titles mx-0 justify-content-center">
            <div class="col-sm-6 p-md-0">
                <div class="text-center">
                    <h1 class="text-gray-900 my-4 mb-4">Nuevo responsable</h1>
                </div>


                <form id="frmResponsable" class="my-4">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="ResponsableCodigo" name="ResponsableCodigo" readonly hidden>
                            <label for="txtCorreoUsuario">Codigo Responsable *</label>
                            <input type="text" class="form-control" id="CodigoResponsable" name="CodigoResponsable" placeholder="AEC123" maxlength="15" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtPassword1">Nombre de responsable *</label>
                            <input type="text" class="form-control" id="NombreResponsable" name="NombreResponsable" placeholder="Nombre y Apellido" maxlength="200" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-label">Estado*</label>
                            <select name="Estado" id="Estado" class="form-control">
                                <option value="0">Activo</option>
                                <option value="1">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-12 my-2 respMr"><p class="alertError my-2" role="alert" id="lbError"></p></div>
                    </div>
                        <div class="col-md-4 respMr my-2">
                            <button type="submit" class="outLineRed btn" id="btnInsertar" name="btnInsertar">Ingresar</button>      
                        </div>
                        <div class="col-md-4 respMr my-2">
                            <button type="button" class="outLineRed btn" id="btnModificar" name="btnModificar">Modificar</button>
                        </div>
                        <div class="col-md-4 respMr my-2">
                            <button type="button" class="outLineRed btn" id="btnCancelar" name="btnCancelar">Cancelar</button>
                        </div>
                </form>
            </div>
        </div>
        <!-- fin cuerpo form -->


        <div class="row page-titles mx-0">
            <div class="col-md-12 p-md-0">
                <div class="table-responsive">
                    <table id="tblResponsables" name="tblResponsables" class='table table-striped dt-responsive nowrap' style='width:100%;'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Codigo responsable</th>
                                <th>Nombre de responsable</th>
                                <th>Estado</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
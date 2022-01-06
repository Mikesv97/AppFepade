<?php
include('layout/header.php');
include('layout/navbar.php');
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
                    <p class="mb-0">Rol: <?= $_SESSION["usuario"]["rol"]; ?></p>
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
                    <img src="../recursos/multimedia/imagenes/logo.jpg" alt="logoFepade">
                    <h1 class="text-gray-900 my-2 mb-4">Nuevo responsable</h1>
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
                        <div class="col-md-12"><p class="alertError my-2" role="alert" id="lbError"></p></div>
                        <div class="col-md-12">
                            <button type="submit" class="btnLogin btn" id="btnInsertar" name="btnInsertar">Ingresar</button>
                            <button type="button" class="btnLogin btn ml-2" id="btnModificar" name="btnModificar">Modificar</button>
                            <button type="button" class="btnLogin btn ml-2" id="btnCancelar" name="btnCancelar">Cancelar</button>
                        </div>
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
                                <th></th>
                                <th></th>
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
<?php
include('layout/header.php');
include('layout/navbar.php');

//variables que almacenan el nombre y id del usuario que inicia sesion
$usuario = $_SESSION["usuario"]["nombre"];
$idUSuario = $_SESSION["usuario"]["id"];
?>
<link href="../recursos/css/nuevoUsuario.css" rel="stylesheet">
<script src="../Recursos/JS/tipoActivoC.js"></script>
<div class="content-body">
    <div class="container-fluid">
    <a href="" id="inicioFormTipoAct"></a>
        <!--barra top -->
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Bienvenido <?= $usuario; ?>!</h4>
                    <p class="mb-0 rol">Rol: <?= $_SESSION["usuario"]["rol"]; ?></p>
                    <a href="" id="inicioForm"></a>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Tipo de activo</a></li>
                </ol>
            </div>
        </div>
        <!-- fin barra top -->

        <!--cuerpo form -->
        <div class="row page-titles mx-0 justify-content-center">
            <div class="col-sm-6 p-md-0">
                <div class="text-center">
                    <div class="vistaTitulo"><h1  class="text-gray-900 my-2 mb-4">Nuevo tipo de activo</h1></div>
                </div>

                <form id="frmTipoActivo" class="my-4">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtNombreUser">ID*</label>
                            <input type="text" class="form-control" id="tipoActivoId" name="tipoActivoId" placeholder="1" pattern="[0-9]{1,4}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtCorreoUsuario">Nombre de activo*</label>
                            <input type="text" class="form-control" id="tipoActivoNombre" name="tipoActivoNombre" placeholder="PC,Laptop,etc..." maxlength="75" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtPassword1">Usuario ID*</label>
                            <input type="text" class="form-control" id="usuarioId" name="usuarioId" maxlength="15" value="<?= $idUSuario; ?>" readonly>
                        </div>
                        
                    </div>
                    <div class="col-md-12"><p class="alertError my-2" role="alert" id="lbError"></p></div>
                    <div class="col-md-4 my-3 respMr">
                        <button type="submit" class="outLineRed btn" id="btnInsertar" name="btnInsertar">Ingresar</button>
                    </div>
                    <div class="col-md-4 my-3 respMr">
                        <button type="button" class="outLineRed btn" id="btnModificar" name="btnModificar">Modificar</button>
                    </div>
                    <div class="col-md-4 my-3 respMr">
                        <button type="button" class="outLineRed btn" id="btnCancelar" name="btnCancelar">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- fin cuerpo form -->


        <div class="row page-titles mx-0">
            <div class="col-md-12 p-md-0">
                <div class="table-responsive">
                    <table id="tblTipoActivo" name="tblTipoActivo" class='table table-striped dt-responsive nowrap' style='width:100%;'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre tipo activo</th>
                                <th>Usuario ID</th>
                                <th>Fecha</th>
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
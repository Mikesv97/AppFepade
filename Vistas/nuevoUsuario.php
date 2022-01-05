<?php
include('layout/header.php');
include('layout/navbar.php');
?>
  <link href="../recursos/css/nuevoUsuario.css" rel="stylesheet">
  <script src="../recursos/JS/nuevoUsuario.js"></script>
  
<div class="content-body">
    <div class="container-fluid">

        <!--barra top -->
        <div class="row page-titles mx-0">
            <a id="inicioForm" href="#"></a>
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Bienvenido <?=$_SESSION["usuario"]["nombre"];?>!</h4>
                    <p class="mb-0">Rol: <?=$_SESSION["usuario"]["rol"];?></p>
                </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Nuevo usuario</a></li>
                </ol>
            </div>
        </div>
        <!-- fin barra top -->

        <!--cuerpo form -->
        <div class="row page-titles mx-0 justify-content-center">
            <div class="col-sm-6 p-md-0">
                <div class="text-center">
                    <img src="../recursos/multimedia/imagenes/logo.jpg" alt="logoFepade"><h1 class="text-gray-900 my-2 mb-4">Nuevo usuario</h1>
                </div>


                <form id="frmNuevoUsuario" class="my-4">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="txtNombreUser">Nombre completo *</label>
                            <input type="text" class="form-control" id="txtNombreUser" name ="txtNombreUser" maxlength="100" placeholder="Nombre completo del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="txtCorreoUsuario">Correo electrónico *</label>
                            <input type="email" class="form-control" id="txtCorreoUsuario" name="txtCorreoUsuario" placeholder="alguien@algo.com" maxlength="50" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="txtPassword1">Contraseña *</label>
                                <input type="password" class="form-control" id="txtPassword1" name="txtPassword1" placeholder="contraseña" maxlength="10" required>
                            </div>
                                <div class="form-group col-md-6">
                                <label for="txtPassword2">Repite la contraseña *</label>
                                <input type="password" class="form-control" id="txtPassword2" name="txtPassword2" placeholder="confirmar contraseña" maxlength="10" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="txtNickUser">ID del usuario *</label>
                                <input type="text" class="form-control" id="txtIdUser" name ="txtIdUser" maxlength="15" required> 
                            </div>
                            <div class="form-group col-md-8">
                                <label for="inputState" >Selecciona rol de este usuario *</label>
                                <select id="selectRol" name="selectRol" class="form-control" required>
                                    <option value="0">Escoger rol... *</option>
                                </select>
                            </div>
                            <p class="my-2 p-1 gold" id="lbError"></p>
                        </div>                     
                        <button type="submit" class="btnLogin btn" id="btnNewUser">Registrar usuario</button>
                        <button type="submit" class="mx-2 btnLogin btn" id="btnGuardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- fin cuerpo form -->


        <div class="row page-titles mx-0">
            <div class="col-md-12 p-md-0">
            <div class="table-responsive">
                <table id="usuarios" name="activoInformacion" class='table table-striped dt-responsive nowrap' style='width:100%;'>
                    <thead>
                        <tr>
                            <th>Usuario id</th>
                            <th>Usuario nombre</th>
                            <th>Fecha creación</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Usuario Responsable</th>
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
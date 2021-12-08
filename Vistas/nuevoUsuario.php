<?php
include('layout/header.php');
include('layout/navbar.php');
?>
  <link href="../recursos/css/nuevoUsuario.css" rel="stylesheet">

<div class="content-body">
    <div class="container-fluid">

        <!--barra top -->
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Bienvenido <?=$_SESSION["usuario"]["nombre"];?>!</h4>
                    <p class="mb-0">Rol: <?=$_SESSION["usuario"]["rol"];?></p>
                </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Nuevo Usuario</a></li>
                </ol>
            </div>
        </div>
        <!-- fin barra top -->

        <!--cuerpo form -->
        <div class="row page-titles mx-0 justify-content-center">
            <div class="col-sm-6 p-md-0">
                <div class="text-center">
                    <img src="../recursos/multimedia/imagenes/logo.jpg" alt="logoFepade"><h1 class="text-gray-900 my-2 mb-4">NUEVO USUARIO</h1>
                </div>


                <form id="frmNuevoUsuario" class="my-4">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="txtNombreUser">Nombre Completo</label>
                            <input type="text" class="form-control" id="txtNombreUser" name ="txtNombreUser" maxlength="100" placeholder="Nombre completo del usuario">
                        </div>
                        <div class="form-group">
                            <label for="txtCorreoUsuario">Correo Electronico</label>
                            <input type="email" class="form-control" id="txtCorreoUsuario" name="txtCorreoUsuario" placeholder="alguien@algo.com" maxlength="50">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="txtPassword1">Contraseña</label>
                                <input type="password" class="form-control" id="txtPassword1" name="txtPassword1" placeholder="contraseña" maxlength="10">
                            </div>
                                <div class="form-group col-md-6">
                                <label for="txtPassword2">Repite La Contraseña</label>
                                <input type="password" class="form-control" id="txtPassword2" name="txtPassword2" placeholder="confirmar contraseña" maxlength="10">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="txtIdUser">ID Del Usuario</label>
                                <input type="text" class="form-control" id="txtIdUser" name ="txtIdUser" maxlength="15">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="txtNickUser">Nick Del Usuario</label>
                                <input type="text" class="form-control" id="txtNickUser" name ="txtNickUser" maxlength="12">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="inputState">Selecciona Rol De Este Usuario</label>
                                <select id="selectRol" class="form-control">
                                    <option selected>Choose...</option>
                                    <option>Rol A</option>
                                    <option>Rol B</option>
                                    <option>Rol C</option>
                                </select>
                            </div>
                        </div>                     
                        <button type="submit" class="btnLogin btn">Registrar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- fin cuerpo form -->

    </div>
</div>

<?php
include('layout/footer.php');
?>
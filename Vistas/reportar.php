<?php
session_start();
if (isset($_SESSION["usuario"]["nombre"]) && isset($_SESSION["usuario"]["usuarioNuevo"])) {
    if ($_SESSION["usuario"]["usuarioNuevo"] == 0) {
        header("Location: vistas/infor_activo_fijo.php");
    } else {
        header("Location: vistas/primerlogin.php");
    }
}

if (isset($_REQUEST["s"])) {
    if ($_REQUEST["s"]) {
        session_destroy();
        header("Location: index.php");
    }
}
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Reportar - cambio de contrasena</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href="../recursos/css/ruang-admin.min.css" rel="stylesheet">
    <link href="../recursos/css/ruang-admin.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card dd shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="login-form ">
                                    <div class="text-center just">
                                        <img src="../recursos/multimedia/imagenes/logo.jpg" alt="logoFepade">
                                        <h1 class="h3 text-gray-900 my-2 mb-4">Cambio de contraseña no solicitada</h1>
                                    </div>
                                    <form id="frmLogin" class="user">
                                        <div class="form-group">
                                            <label for="txtUsuario">Ingrese su usuario *</label>
                                            <input type="text" class="miControl form-control" id="txtUsuario" name="txtUsuario" maxlength="15" placeholder="Ingresa Usuario">
                                        </div>
                                        <div class="form-group">
                                            <label for="txtCorreo">Ingrese su correo electronico *</label>
                                            <input type="email" class="miControl form-control" id="txtCorreo" name="txtCorreo" maxlength="50" placeholder="correo@gmail.com">
                                            <p class="my-2 p-1 gold" id="labelError"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtContraseña">Ingrese su contraseña *</label>
                                            <input type="password" class="miControl form-control" id="txtContraseña" name="txtContraseña" maxlength="10" placeholder="Contraseña">
                                        </div>
                                        <div class="form-group">
                                            <label for="txtContraseñaRep">Repita su contraseña *</label>
                                            <input type="password" class="miControl form-control" id="txtContraseñaRep" name="txtContraseñaRep" maxlength="10" placeholder="Contraseña">
                                            <p class="my-2 p-1 gold" id="labelErrorContra">
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <button class="miControl btn btnLogin btn-block" type="submit" id="btnCambiar">Cambiar contraseña</button>
                                        </div>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src=""></script>

</body>

</html>
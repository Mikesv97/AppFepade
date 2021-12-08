<?php
session_start();
/*if(isset($_SESSION["usuario"]["nombre"])){
    header("Location: vistas/home.php");
}*/


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Bienvenidos- Login</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <link href="recursos/css/ruang-admin.min.css" rel="stylesheet">
  <link href="recursos/css/ruang-admin.css" rel="stylesheet">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-12 col-md-9">
        <div class="card dd shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <img src="recursos/multimedia/imagenes/logo.jpg" alt="logoFepade"><h1 class="h4 text-gray-900 my-2 mb-4">IDENTIFICATE</h1>
                  </div>
                  <form id="frmLogin"class="user">
                    <div class="form-group">
                      <input type="text" class="miControl form-control" name="txtUsuario" maxlength="12" placeholder="Ingresa Usuario">
                    </div>
                    <div class="form-group">
                      <input type="password" class="miControl form-control" name="txtContraseña" maxlength="10" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                      <div class="miControl custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox" class="custom-control-input" id="customCheck" value="1">
                        <label  class=" custom-control-label" for="customCheck">Recordarme</label>
                      </div>
                      <p class="my-2 p-1 gold" id="labelError">
                      </p>
                    </div>
                    <div class="form-group">
                      <button class="miControl btn btnLogin btn-block" type="submit" id="btnLogin">Login</button>
                    </div>
                    <hr>
                  </form>
                  <div class="text-center">
                    <a class="linkPass small" data-toggle="modal" data-target="#staticBackdrop" href="#">Olvide Mi Contraseña!</a>
                  </div>
                  <div class="text-center">
                  </div>
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
  <script src="recursos/js/loginjs.js" ></script>

<!--MODAL PARA RECUPERAR CONTRASEÑA-->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="w-100 row justify-content-center">
        <img class="logof" src="recursos/multimedia/imagenes/logo.jpg" alt="logoFepade"><h1 class="h4 tittleModal my-2 mb-4">Cambiar Contraseña</h1>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="small text-muted">
          <p>Para cambiar la contraseña se enviará un código de confirmación al correo, asegurate
            de llenar correctamente los campos solicitados.
        </div>
        <div>
          <form id="frmRecPass">
            <div class="form-group">
              <label for="txtCorreo" class="text-muted h6">Correo Electronico</label>
              <input type="email" class="form-control" id="txtCorreo" maxlength="50" required>
              <small id="emailHelp" class="form-text text-muted">Debes ingresar tu correo electronico con el que te registraste en el sistema.</small>
              <p class="my-2 p-1 gold" id="labelErrorEmail"></p>
            </div>
              <button id="btnCodigo" type="submit" class="btn btnLogin">Solicitar Código</button>
              <div id="codeContent" class="my-3 form-group my-3">
                <small id="labelInfoEmail" class="h6"></small>
                <small id="txtCodRecPass" class="my-2 text-muted h6">Ingresa El Código:</small>
                <input class="form-control my-2 m-0"  placeholder="Código" type="number" min="0" id="txtCodCorreo">
                <button id="btnValidCodigo" type="button" class="mx-3 my-2 btn btnLogin">Validar</button>
                <p class="my-2 p-1 gold" id="lbCoderror"></p>
            </div>
            <div id="newPasContent" class="my-3 form-group my-3">
                <p id="labelInfoPass" class="my-2 text-muted h6">Ingresa La Nueva Contraseña:</p>
                <input class="form-control my-2 m-0"  maxlength="10" placeholder="contraseña nueva" type="password" id="txtNewPas1">
                <small id="labelInfoPass" class="my-2 text-muted h6">Repite La Contraseña:</small>
                <input class="form-control my-2 m-0"  maxlength="10" placeholder="contraseña nueva" type="password" id="txtNewPas2">
                <p class="my-2 p-1 gold" id="lbFailNewPass"></p>
                <button id="btnChangPass" type="button" class="btn btnLogin">Cambiar Contraseña</button>
            </div>
          </form>
        </div>
      </div>
     <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>-->
    </div>
  </div>
</div>

</body>

</html>
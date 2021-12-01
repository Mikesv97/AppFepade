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

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <img src="recursos/multimedia/imagenes/logo.jpg" alt="logoFepade"><h1 class="h4 text-gray-900 my-2 mb-4">IDENTIFICATE</h1>
                  </div>
                  <form class="user">
                    <div class="form-group">
                      <input type="text" class="form-control"  placeholder="Ingresa Nombre De Usuario">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Recordarme</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <a href="index.html" class="btn btnLogin btn-block">Login</a>
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
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
              <input type="email" class="form-control" id="txtCorreo" required>
              <small id="emailHelp" class="form-text text-muted">Debes ingresar tu correo electronico con el que te registraste en el sistema.</small>
            </div>
              <button id="btnCodigo" type="submit" class="btn btnLogin">Solicitar Código</button>
              <div id="codeContent" class="my-3 form-group my-3">
              <small id="txtCodRecPass" class="text-muted h6">Ingresa El Código:</small>
              <input class="form-control m-0" placeholder="Código" type="text" id="txtCodRecPass">
              <button id="btnValidCodigo" type="button" class="mx-3 btn btnLogin">Validar</button>
              <p id="error"></p>
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
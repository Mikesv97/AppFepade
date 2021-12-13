<?php
session_start();  
    if(isset($_SESSION["usuario"]["usuarioNuevo"]) && isset($_SESSION["usuario"]["usuarioNuevo"])){
        if($_SESSION["usuario"]["usuarioNuevo"] != 1){
            header("Location: ../index.php");
        }
    }else{
        header("Location: ../index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <link href="../recursos/css/primerlogin.css" rel="stylesheet">
    <script src="../Recursos/JS/primerlogin.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Cambio de contraseña - Seguridad</title>
</head>
<body>
    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-md-12">
                <div class="login">
                <div class="login-triangle"></div>
                <h2 class="login-header">
                    <img src="../recursos/multimedia/imagenes/logo.jpg" alt="logoFepade">
                    <span class="text-gray-900">Cambio de contraseña</span>
                </h2>
                    <form class="login-container shadow">
                        <p><input id="usuarioId" name="usuarioId" class="form-control" type="text" placeholder="Usuario id" value="<?=$_SESSION["usuario"]["id"]?>" readonly></p>
                        <p><input name="passOld" id="passOld" class="form-control" type="password" placeholder="Contraseña actual"></p>
                        <p><input name="passNew1" id="passNew1" class="form-control" type="password" placeholder="Contraseña nueva"></p>
                        <p><input  name="passNew2" id="passNew2" class="form-control" type="password" placeholder="Confirmar contraseña nueva"></p>
                        <div class="textLink">
                        <button type="submit" class="btn btn-danger ">Cambiar contraseña</button>
                       <div class="textLink my-2">
                           <a id="cambiarUsuario" class="h6" href=".#">
                               Cambiar usuario
                           </a>
                        <div>
                    </form>
                </div>
            </div>
        </div>   
    </div>
</body>
</html>
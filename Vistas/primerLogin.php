<?php
session_start();  
    if(isset($_SESSION["usuario"]["usuarioNuevo"])){
        if($_SESSION["usuario"]["usuarioNuevo"] != 1){
            header("Location: ../index.php");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
                        <p><input type="password" placeholder="Contraseña actual"></p>
                        <p><input type="password" placeholder="Contraseña nueva"></p>
                        <p><input type="password" placeholder="Confirmar contraseña"></p>
                        
                        <div class="textLink">
                        <button type="submit" class="btn btn-danger ">Cambiar contraseña</button>
                       <div class="textLink my-2">
                           <a class="h6" href="../index.php?s=true">
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
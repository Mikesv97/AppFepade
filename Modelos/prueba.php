<?php

require_once 'usuariosDao.php';

$ud =  new UsuariosDao();

$accion = $ud->validarUsuario();

if($accion){
    echo "funciona";
}else{
    echo "no funciona";
}


?>
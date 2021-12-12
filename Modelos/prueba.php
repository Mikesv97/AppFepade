<?php
include_once 'sendMail.php';
include_once '../Modelos/loginDao.php';
include_once '../Modelos/activoFijoDao.php';
include_once '../Modelos/usuarioNuevoDao.php';
include_once '../Modelos/activoEspecificacionDao.php';
include_once '../Modelos/historialActivoDao.php';

$activoEspe = new activoEspecificacionDao();
$activoHist = new historialActivoDao();
// // $us = new LoginDao();
// $nuser = new UsuarioNuevoDao();

// $user = new UsuarioNuevo();

// $nuser->insertarBitacoraUs("miguelitosv", "Douglas Méndez Admin");

// $idBitacora= $nuser->obtenerIdBitacora();

// $user->setUsuarioId("miguelitosv");
// $user->setUsuarioNombre("miguel méndez");
// $user->setUsuarioClave(password_hash("123",PASSWORD_DEFAULT,array("cost"=>12)));
// $user->setCorreoElectronico("micorreo@algo.com");
// $user->setIdRol("4");  
// $user->setRemember(0);
// $user->setIdBitacora($idBitacora);
// $user->setFotoUsuario("foto98.jpg");
// $user->setUsuarioNuevo(1);


// if($nuser->insertarUsuario($user)){
//     echo "insertado";
// }else{
//     echo "No we, no pude";
// }


$objActivoHistorial = setObjActivoHistorial(
    "247",
    "1",
    "1",
    "Probando que inserte el historial",
    "AEC",
    "1"
);

echo json_encode($activoHist->insertarHistorial($objActivoHistorial));


function setObjActivoHistorial(
    $ActivoId,
    $Estructura31_id,
    $Responsable_id,
    $Historico_comentario,
    $Usuario_id,
    $Estado
){
    $objActivoHistorial = new historial_Activo();
    $objActivoHistorial->setActivoId($ActivoId);
    $objActivoHistorial->setEstructura31Id($Estructura31_id);
    $objActivoHistorial->setResponsableId($Responsable_id);
    $objActivoHistorial->setHistoricoComentario($Historico_comentario);
    $objActivoHistorial->setUsuarioId($Usuario_id);
    $objActivoHistorial->setEstado($Estado);
    return $objActivoHistorial;
}




//SendMail::enviarCodCorreo("alan.castillo20@itca.edu.sv","055645");
//SendMail::enviarCodCorreo("castillo.alan1995@gmail.com","055645");

//$us->actualizarPassUser("douglas123","douglas.figueroa20@itca.edu.sv");
//$us->actualizarPassUser("alan123","alan.castillo20@itca.edu.sv");
/*if($us->validarUsuario("douglasv","douglas123")){
    echo "valido";
}else{
    echo "No valido";
}*/

//var_dump($us->validarDatosCookie("douglasv",'$2y$15$gCY4NN8hJ58n1BwmJyqRq.t5po.6gVfCFVyZciy3Qao5IgyRl5e22'));



/*if($us->validarUsuarioCookie("douglasv",'$2y$15$gCY4NN8hJ58n1BwmJyqRq.t5po.6gVfCFVyZciy3Qao5IgyRl5e22')){
    echo "valido";
}else{
    echo "No valido";
}*/

//$us->validarRemember();

//$us->actualizarRemUser(1, "douglasv");
/*$data = $us->comprobarRememberUs();

if(sizeof($data)!= 0){
   foreach($data as $d){
       echo "Nombre: ".$d["usuario_user"];
   }
}else{
    echo "no";
}*/

/*for($i =0 ; $i<sizeof($resp); $i++){
    echo "nombre: ".$resp[$i]["usuario_user"]."<br>";
    echo "remember: ".$resp[$i]["remember"]."<br>";
}*/

/*foreach($resp as $r){
    echo "nombre: ".$r["usuario_user"]."<br>";
    echo "remember: ".$r["remember"]."<br>";
}*/
//echo $us->validarUsuarioRem("douglasv",'$2y$15$gCY4NN8hJ58n1BwmJyqRq.t5po.6gVfCFVyZciy3Qao5IgyRl5e22');

 //si hay un usuario recordados, validamos datos 
 





/*
$.ajax({
                    url: ,
                    method: "post",
                    dataType: "json",
                    data: { "cod": cod },
                    success: function (r) {
                        
                    },
                    error: function () {
                       
                    }
                });


*/




?>

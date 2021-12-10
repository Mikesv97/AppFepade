<?php
include_once 'sendMail.php';
include_once '../Modelos/loginDao.php';

include_once '../Modelos/activoFijoDao.php';

$us = new LoginDao();

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


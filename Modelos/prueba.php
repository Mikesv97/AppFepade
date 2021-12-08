<?php
include_once 'sendMail.php';
include_once '../Modelos/loginDao.php';

include_once '../Modelos/activoFijoDao.php';

$us = new LoginDao();

//$us->actualizarPassUser("douglas123","raidenprueba75@gmail.com");
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
$data = $us->comprobarRememberUs();

if(sizeof($data)!= 0){
   foreach($data as $d){
       echo "Nombre: ".$d["usuario_user"];
   }
}else{
    echo "no";
}

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
 





?>


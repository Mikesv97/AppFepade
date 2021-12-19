<?php
include_once 'sendMail.php';
include_once '../Modelos/loginDao.php';
include_once '../Modelos/activoFijoDao.php';
include_once '../Modelos/usuarioNuevoDao.php';
include_once '../Modelos/activoEspecificacionDao.php';
include_once '../Modelos/historialActivoDao.php';

// $activoEspe = new activoEspecificacionDao();
// $activoHist = new historialActivoDao();
// // // // $us = new LoginDao();
// $nuser = new UsuarioNuevoDao();

// $l = new LoginDao();

// echo $l->eliminarEstadoNuevoUser("adriana",0);

$activoEspe = new activoEspecificacionDao();

$ObjActivoEspeCompMod = setObjActivoEspeCompMod(
    'Holis312',
    'Holis312',
    'Holis312',
    'Holis312',
    'Holis312',
    'Holis312',
    'Holis312',
    'Holis312',
    'Holis312',
    'Holis312',
    'Holis312',
    'Holis312',
    '1'
);

echo json_decode($activoEspe->modificarActEspCom($ObjActivoEspeCompMod));

function setObjActivoEspeCompMod(
    $Procesador,
    $Generacion,
    $Ram,
    $DiscoDuro,
    $Modelo,
    $SO,
    $Office,
    $IP,
    $TipoRam,
    $CapacidadD1,
    $DiscoDuro2,
    $CapacidadD2,
    $ActivoId
) {
    $ObjActivoEspeCompMod = new Activo_Especificacion();

    $ObjActivoEspeCompMod->setProcesador($Procesador);
    $ObjActivoEspeCompMod->setGeneracion($Generacion);
    $ObjActivoEspeCompMod->setRam($Ram);
    $ObjActivoEspeCompMod->setDiscoDuro($DiscoDuro);
    $ObjActivoEspeCompMod->setModelo($Modelo);
    $ObjActivoEspeCompMod->setSO($SO);
    $ObjActivoEspeCompMod->setOffice($Office);
    $ObjActivoEspeCompMod->setIP($IP);
    $ObjActivoEspeCompMod->setTipoRam($TipoRam);
    $ObjActivoEspeCompMod->setCapacidad_D1($CapacidadD1);
    $ObjActivoEspeCompMod->setDiscoDuro2($DiscoDuro2);
    $ObjActivoEspeCompMod->setCapacidad_D2($CapacidadD2);
    $ObjActivoEspeCompMod->setActivoId($ActivoId);
    return $ObjActivoEspeCompMod;
}



// $ObjHistorico = setObjHistorico(
//     '286',
//     '2021-12-15',
//     '3',
//     '1',
//     'Prueba',
//     'AEC',
//     '2021-12-15',
//     '1'
// );

// echo json_encode($activoHist->insertarNuevoHistorial($ObjHistorico));

// function setObjHistorico(
//     $ActivoId,
//     $Historico_fecha,
//     $Estructura31_id,
//     $Responsable_id,
//     $Historico_comentario,
//     $Usuario_id,
//     $Fecha,
//     $Estado
// ) {
//     $ObjHistorico = new historial_Activo();
//     $ObjHistorico->setActivoId($ActivoId);
//     $ObjHistorico->setHistoricoFecha($Historico_fecha);
//     $ObjHistorico->setEstructura31Id($Estructura31_id);
//     $ObjHistorico->setResponsableId($Responsable_id);
//     $ObjHistorico->setHistoricoComentario($Historico_comentario);
//     $ObjHistorico->setUsuarioId($Usuario_id);
//     $ObjHistorico->setFecha($Fecha);
//     $ObjHistorico->setEstado($Estado);
//     return $ObjHistorico;
// }


//echo $nuser->eliminarBitaUser("asda");
// // $user = new UsuarioNuevo();

// // $nuser->insertarBitacoraUs("miguelitosv", "Douglas Méndez Admin");

// // $idBitacora= $nuser->obtenerIdBitacora();

// // $user->setUsuarioId("miguelitosv");
// // $user->setUsuarioNombre("miguel méndez");
// // $user->setUsuarioClave(password_hash("123",PASSWORD_DEFAULT,array("cost"=>12)));
// // $user->setCorreoElectronico("micorreo@algo.com");
// // $user->setIdRol("4");  
// // $user->setRemember(0);
// // $user->setIdBitacora($idBitacora);
// // $user->setFotoUsuario("foto98.jpg");
// // $user->setUsuarioNuevo(1);


// // if($nuser->insertarUsuario($user)){
// //     echo "insertado";
// // }else{
// //     echo "No we, no pude";
// // }


// $objActivoHistorial = setObjActivoHistorial(
//     "247",
//     "1",
//     "1",
//     "Probando que inserte el historial",
//     "AEC",
//     "1"
// );

// echo json_encode($activoHist->insertarHistorial($objActivoHistorial));


// function setObjActivoHistorial(
//     $ActivoId,
//     $Estructura31_id,
//     $Responsable_id,
//     $Historico_comentario,
//     $Usuario_id,
//     $Estado
// ){
//     $objActivoHistorial = new historial_Activo();
//     $objActivoHistorial->setActivoId($ActivoId);
//     $objActivoHistorial->setEstructura31Id($Estructura31_id);
//     $objActivoHistorial->setResponsableId($Responsable_id);
//     $objActivoHistorial->setHistoricoComentario($Historico_comentario);
//     $objActivoHistorial->setUsuarioId($Usuario_id);
//     $objActivoHistorial->setEstado($Estado);
//     return $objActivoHistorial;
// }



/*
                        //comprobamos cual usuario está con recuerdame en BD
                        $dataRem = $usDao->comprobarRememberUs();
                        //comprobamos no venga vacia la información
                        if(sizeof($dataRem)!= 0){
                            //recorremos
                            foreach($dataRem as $d){
                                if($nombre!=$d["usuario_id"]){
                                    //asigamos recuerdame en BD al usuario ingreado en login
                                   $usDao->actualizarRemUser(0, $d["usuario_id"]);
                                }
                            }
                            //respondemos el resultado
                            echo json_encode( $usDao->actualizarRemUser(1, $nombre));
                        }else{
                            $respRem = $usDao->actualizarRemUser(1, $nombre);
                            echo json_encode($respRem);
                        }
*/

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

<?php
include_once 'sendMail.php';
include_once '../Modelos/loginDao.php';
include_once '../Modelos/activoFijoDao.php';
include_once '../Modelos/usuarioNuevoDao.php';
include_once '../Modelos/activoEspecificacionDao.php';
include_once '../Modelos/historialActivoDao.php';
include_once "reportes.php";
// $activoEspe = new activoEspecificacionDao();
// $activoHist = new historialActivoDao();
// // // // $us = new LoginDao();
// $nuser = new UsuarioNuevoDao();

// $l = new LoginDao();

// // echo $l->eliminarEstadoNuevoUser("adriana",0);
// $t = new ActivoFijoDao();
// $a = $t->reporteTipoActivo(1);
// $fecha = Reportes::obtenerFecha();
// $hora=Reportes::obtenerHora();
// $tiempo= str_replace(":","-",$hora);
// Reportes::reporteTipoActivo($a,$fecha,$tiempo);


try{
    $word = new COM("word.application") or die("No se puede crear la instancia de Word");
    echo "Word cargado, versión {$word->Version}\n";
    
    //traerlo al frente
    $word->Visible = 1;
    
    //abrir un documento vacío
    $word->Documents->Add();
    
    //hacer algunas cosas raras
    $word->Selection->TypeText("Esto es una prueba...");
    $word->Documents[1]->SaveAs("Prueba inutil.doc");
    
    // //cerrando word
    // $word->Quit();
    
    //liberando el objeto
    $word = null;

}catch(Exception $e) {
	echo $e->getMessage() . "\n";
	
}


?>

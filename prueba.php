<?php

include_once 'Modelos/clases/reportesPlantilla.php';
include_once 'Modelos/clasesDao/reportesDao.php';
include_once  'Modelos/clasesDao/activoFijoDao.php';




$rpt = new ReportesDao();



/*function cargarImagen()
{
    $nombreimg = $_FILES["avatar"]["name"];
    if ($nombreimg != null) {
        $archivo = $_FILES["avatar"]["tmp_name"];
        $ruta = "Recursos/Prueba/";
        if (move_uploaded_file($archivo, $ruta . $nombreimg)) {
            return $nombreimg;
        } else {
            return "error de carga de imagen";
        }
    } else {
        $imagenBD = $_POST['imagenBD'];
        return $imagenBD;
    }
}*/

$array = $rpt-> getDataRptTipActAreaTodas();
//var_dump($array);
$rpt->generearRptTipActAreaAll($array); 
?>
<!--<form action="prueba.php" method="POST" enctype="multipart/form-data" >
  <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg"><br>
  <button type="submit" name="b">Enviar</button>
</form>-->

<?php

/*if($_POST){
  if(isset($_POST["b"])){
    $objActivoFijo = new Activo_Fijo();
    $objActivoFijo->setImagen(cargarImagen());

  }
}*/


?>
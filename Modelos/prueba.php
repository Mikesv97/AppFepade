<?php
require  "conexion.php";
include dirname(__DIR__, 1)."/recursos/lib/TCPDF/tcpdf.php";
include_once dirname(__DIR__, 1).'/Modelos/clasesDao/activoFijoDao.php';
$area ="administracion";
$r = new ActivoFijoDao();
 $resp = $r->getDataRpt($area);
 $style="
 <style>
 table{
    white-space:nowrap;
    text-align: center;
    font-size: 11px;
    padding:1px;
 }

 th{
    background-color: red;
    color: gold;
    font-weight: bold;
    text-shadow: 0 0 5px black;
 }

 .w3{

    width: 6%;
    
 }
.w15{
    width: 15%;
}

.w8{
    width: 7%;
}
.w{
    width: 9%;

}

.wt{
    width: 7.8%;
}
.w10{
    width: 12%;
}
 </style>";

 $tablaPC ='<h1>PC</h1>
    <table border="1" style="  " >
    <tr>
        <th class="w3">Código</th>
        <th class="w15">Descripción</th>
        <th class="w10">Responsable</th>
        <th class="w" >IP</th>
        <th class="w8" >Modelo</th>
        <th class="w">Procesador</th>
        <th class="w8">GEN.</th>
        <th class="w8">RAM</th>
        <th class="w8">DD</th>
        <th class="wt">SO</th>
        <th class="w8">Office</th>
        <th class="w8">No. Series</th>
    </tr>';

 $tablaLaptop ='<h1>Laptop</h1>
 <table border="1">
    <tr>
        <th class="w3">Código</th>
        <th class="w15">Descripción</th>
        <th class="w10">Responsable</th>
        <th class="w" >IP</th>
        <th class="w8" >Modelo</th>
        <th class="w">Procesador</th>
        <th class="w8">GEN.</th>
        <th class="w8">RAM</th>
        <th class="w8">DD</th>
        <th class="wt">SO</th>
        <th class="w8">Office</th>
        <th class="w8">No. Series</th>
    </tr>';

 $tablaProyector ='<h1>Proyector</h1>
 <table border="1">
 <tr>
    <th class="w3">Código</th>
    <th class="w15">Descripción</th>
    <th class="w10">Responsable</th>
    <th class="w" >IP</th>
    <th class="w8" >Modelo</th>
    <th class="w">Procesador</th>
    <th class="w8">GEN.</th>
    <th class="w8">RAM</th>
    <th class="w8">DD</th>
    <th class="wt">SO</th>
    <th class="w8">Office</th>
    <th class="w8">No. Series</th>
</tr>';

 $tablaImp ='<h1>Impresora</h1>
 <table border="1">
    <tr>
        <th class="w3">Código</th>
        <th class="w15">Descripción</th>
        <th class="w10">Responsable</th>
        <th class="w" >IP</th>
        <th class="w8" >Modelo</th>
        <th class="w">Procesador</th>
        <th class="w8">GEN.</th>
        <th class="w8">RAM</th>
        <th class="w8">DD</th>
        <th class="wt">SO</th>
        <th class="w8">Office</th>
        <th class="w8">No. Series</th>
    </tr>';

for ($i=0; $i <sizeof($resp) ; $i++) { 
    switch(trim($resp[$i]["tipo_activo_nombre"])){
        case "PC":
            $tablaPC  .='<tr>'
            .'<td class="w3">'.$resp[$i]["Activo_id"].'</td>'
            .'<td class="w15">'.$resp[$i]["Activo_descripcion"].'</td>'
            .'<td class="w10">'.$resp[$i]["Nombre_responsable"].'</td>'
            .'<td class="w">'.$resp[$i]["IP"].'</td>'
            .'<td class="w8">'.$resp[$i]["Modelo"].'</td>'
            .'<td class="w">'.$resp[$i]["Procesador"].'</td>'
            .'<td class="w8">'.$resp[$i]["Generacion"].'</td>'
            .'<td class="w8">'.$resp[$i]["Ram"].'</td>'
            .'<td class="w8">'.$resp[$i]["DiscoDuro"].'</td>'
            .'<td class="wt">'.$resp[$i]["SO"].'</td>'
            .'<td class="w8">'.$resp[$i]["Office"].'</td>'
            .'<td class="w8">'.$resp[$i]["numero_serie"].'</td>'
          .'</tr>';

         
        break;
        case "Laptop":
            $tablaLaptop .='<tr>'
            .'<td class="w3">'.$resp[$i]["Activo_id"].'</td>'
            .'<td class="w15">'.$resp[$i]["Activo_descripcion"].'</td>'
            .'<td class="w10">'.$resp[$i]["Nombre_responsable"].'</td>'
            .'<td class="w">'.$resp[$i]["IP"].'</td>'
            .'<td class="w8">'.$resp[$i]["Modelo"].'</td>'
            .'<td class="w">'.$resp[$i]["Procesador"].'</td>'
            .'<td class="w8">'.$resp[$i]["Generacion"].'</td>'
            .'<td class="w8">'.$resp[$i]["Ram"].'</td>'
            .'<td class="w8">'.$resp[$i]["DiscoDuro"].'</td>'
            .'<td class="wt">'.$resp[$i]["SO"].'</td>'
            .'<td class="w8">'.$resp[$i]["Office"].'</td>'
            .'<td class="w8">'.$resp[$i]["numero_serie"].'</td>'
          .'</tr>';

           
        break;
        case "Impresor":
            $tablaImp .='<tr>'
            .'<td class="w3">'.$resp[$i]["Activo_id"].'</td>'
            .'<td class="w15">'.$resp[$i]["Activo_descripcion"].'</td>'
            .'<td class="w10">'.$resp[$i]["Nombre_responsable"].'</td>'
            .'<td class="w">'.$resp[$i]["IP"].'</td>'
            .'<td class="w8">'.$resp[$i]["Modelo"].'</td>'
            .'<td class="w">'.$resp[$i]["Procesador"].'</td>'
            .'<td class="w8">'.$resp[$i]["Generacion"].'</td>'
            .'<td class="w8">'.$resp[$i]["Ram"].'</td>'
            .'<td class="w8">'.$resp[$i]["DiscoDuro"].'</td>'
            .'<td class="wt">'.$resp[$i]["SO"].'</td>'
            .'<td class="w8">'.$resp[$i]["Office"].'</td>'
            .'<td class="w8">'.$resp[$i]["numero_serie"].'</td>'
          .'</tr>';
        break;
        case "Proyector":
            $tablaProyector .='<tr>'
            .'<td class="w3">'.$resp[$i]["Activo_id"].'</td>'
            .'<td class="w15">'.$resp[$i]["Activo_descripcion"].'</td>'
            .'<td class="w10">'.$resp[$i]["Nombre_responsable"].'</td>'
            .'<td class="w">'.$resp[$i]["IP"].'</td>'
            .'<td class="w8">'.$resp[$i]["Modelo"].'</td>'
            .'<td class="w">'.$resp[$i]["Procesador"].'</td>'
            .'<td class="w8">'.$resp[$i]["Generacion"].'</td>'
            .'<td class="w8">'.$resp[$i]["Ram"].'</td>'
            .'<td class="w8">'.$resp[$i]["DiscoDuro"].'</td>'
            .'<td class="wt">'.$resp[$i]["SO"].'</td>'
            .'<td class="w8">'.$resp[$i]["Office"].'</td>'
            .'<td class="w8">'.$resp[$i]["numero_serie"].'</td>'
          .'</tr>';
        break;
        default:
        break;
    }


}
$tablaImp .="</table>".$style;
$tablaLaptop.="</table>".$style;
$tablaPC.="</table>".$style;
$tablaProyector.="</table>".$style;

$html =$tablaPC.$tablaLaptop.$tablaProyector.$tablaImp;
/*echo $tablaPC."<br><br>";
echo $tablaImp."<br><br>";
echo $tablaLaptop."<br><br>";
echo $tablaProyector."<br><br>";*/


$pdf = new TCPDF("P", "mm", "A3", true, 'UTF-8', false);
$pdf->AddPage();
$pdf->Ln(5);
$pdf->SetFont("","B",20);
$pdf->Cell(80,10,"Área:".$area,0,1,"L");
$pdf->Ln(5);
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output();
?>








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
    font-size: 9.5px;
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

.wr{
    width: 5%;
}
.w{
    width: 9%;

}

.wip{
    width: 11%;
}
.wt{
    width: 7.8%;
}
.w10{
    width: 12%;
}
 </style>";

 $tablaPC ='<h3>PC</h3>
    <table border="1" style="  " >
    <tr>
        <th class="w3">Código</th>
        <th class="w15">Descripción</th>
        <th class="w10">Responsable</th>
        <th class="wip" >IP</th>
        <th class="w8" >Modelo</th>
        <th class="w">Procesador</th>
        <th class="w8">GEN.</th>
        <th class="wr">RAM</th>
        <th class="w8">DD</th>
        <th class="wt">SO</th>
        <th class="w8">Office</th>
        <th class="w8">No. Series</th>
    </tr>';

 $tablaLaptop ='<h3>Laptop</h3>
 <table border="1">
    <tr>
        <th class="w3">Código</th>
        <th class="w15">Descripción</th>
        <th class="w10">Responsable</th>
        <th class="wip" >IP</th>
        <th class="w8" >Modelo</th>
        <th class="w">Procesador</th>
        <th class="w8">GEN.</th>
        <th class="wr">RAM</th>
        <th class="w8">DD</th>
        <th class="wt">SO</th>
        <th class="w8">Office</th>
        <th class="w8">No. Series</th>
    </tr>';

 $tablaProyector ='<h3>Proyector</h3>
 <table border="1">
    <tr>
        <th class="w3">Código</th>
        <th class="w15">Descripción</th>
        <th class="w10">Responsable</th>
        <th class="wip" >IP</th>
        <th class="w8" >Modelo</th>
        <th class="w">Horas Uso</th>
        <th class="w8">Horas Eco.</th>
    </tr>';

 $tablaImp ='<h3>Impresora</h3>
 <table border="1">
    <tr>
        <th class="w3">Código</th>
        <th class="w15">Descripción</th>
        <th class="w10">Responsable</th>
        <th class="wip" >IP</th>
        <th class="w8" >Modelo</th>
        <th class="w8">Toner N</th>
        <th class="w8">Toner M</th>
        <th class="w8">Toner C</th>
        <th class="w8">Toner A</th>
    </tr>';
    /*
                .'<td class="w3">'.$resp[$i]["Activo_id"].'</td>'
            .'<td class="w15">'.$resp[$i]["Activo_descripcion"].'</td>'
            .'<td class="w10">'.$resp[$i]["Nombre_responsable"].'</td>'
            .'<td class="wip">'.$resp[$i]["IP"].'</td>'
            .'<td class="w8">'.$resp[$i]["Modelo"].'</td>'
            .'<td class="w8">'.$resp[$i]["TonerN"].'</td>'
            .'<td class="w8">'.$resp[$i]["TonerM"].'</td>'
            .'<td class="w8">'.$resp[$i]["TonerC"].'</td>'
            .'<td class="w8">'.$resp[$i]["TonerA"].'</td>'*/

for ($i=0; $i <sizeof($resp) ; $i++) { 
    switch(trim($resp[$i]["tipo_activo_nombre"])){
        case "PC":
            $tablaPC  .='<tr>'
            .'<td class="w3">'.$resp[$i]["Activo_id"].'</td>'
            .'<td class="w15">'.$resp[$i]["Activo_descripcion"].'</td>'
            .'<td class="w10">'.$resp[$i]["Nombre_responsable"].'</td>'
            .'<td class="wip">'.$resp[$i]["IP"].'</td>'
            .'<td class="w8">'.$resp[$i]["Modelo"].'</td>'
            .'<td class="w">'.$resp[$i]["Procesador"].'</td>'
            .'<td class="w8">'.$resp[$i]["Generacion"].'</td>'
            .'<td class="wr">'.$resp[$i]["Ram"].'</td>'
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
            .'<td class="wip">'.$resp[$i]["IP"].'</td>'
            .'<td class="w8">'.$resp[$i]["Modelo"].'</td>'
            .'<td class="w">'.$resp[$i]["Procesador"].'</td>'
            .'<td class="w8">'.$resp[$i]["Generacion"].'</td>'
            .'<td class="wr">'.$resp[$i]["Ram"].'</td>'
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
            .'<td class="wip">'.$resp[$i]["IP"].'</td>'
            .'<td class="w8">'.$resp[$i]["Modelo"].'</td>'
            .'<td class="w8">'.$resp[$i]["TonerN"].'</td>'
            .'<td class="w8">'.$resp[$i]["TonerM"].'</td>'
            .'<td class="w8">'.$resp[$i]["TonerC"].'</td>'
            .'<td class="w8">'.$resp[$i]["TonerA"].'</td>'
          .'</tr>';
        break;
        case "Proyector":
            $tablaProyector .='<tr>'
            .'<td class="w3">'.$resp[$i]["Activo_id"].'</td>'
            .'<td class="w15">'.$resp[$i]["Activo_descripcion"].'</td>'
            .'<td class="w10">'.$resp[$i]["Nombre_responsable"].'</td>'
            .'<td class="wip">'.$resp[$i]["IP"].'</td>'
            .'<td class="w8">'.$resp[$i]["Modelo"].'</td>'
            .'<td class="w">'.$resp[$i]["HorasUso"].'</td>'
            .'<td class="w8">'.$resp[$i]["HoraEco"].'</td>'
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

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $this->Image('../Recursos/Multimedia/Imagenes/logoFepadePDF.png', 10, 10, 80);
        $this->Ln(14);
        $this->Cell(278, 5, 'Fundación Empresarial', 0, 1,"R");
        $this->Cell(278, 5, 'Para el desarrollo educativo', 0, 1,"R");
        $this->Cell(278, 5, 'ISO 9001:2015', 0, 1,"R");
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        $this->Ln(28);
        // Title
        $this->Cell(0, 15, 'Reporte De Activos Fijos', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
$pdf = new MYPDF("P", "mm", "A3", true, 'UTF-8', false);
$pdf->AddPage();
$pdf->Ln(60);
$pdf->SetFont("","B",20);
$pdf->Cell(80,10,"Área: ".$area,0,1,"L");
$pdf->Ln(5);
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output();
?>








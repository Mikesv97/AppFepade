<?php
include_once dirname(__DIR__, 2)."/recursos/lib/TCPDF/tcpdf.php";
include_once dirname(__DIR__, 1).'/conexion.php';

//se debe heredar de TCPDF para sobreescribir los metodos header y footer y poder personalizarlos
class ReportesPlantilla extends TCPDF{

    //metodo sobreescrito para setear el encabezado del reporte
    public function Header() {
        // Logo
        $this->Image('../Recursos/Multimedia/Imagenes/logoFepadePDF.png', 10, 10, 50);
        $this->Ln(14);
        $this->SetFont('helvetica', '', 10);
        $this->Cell(278, 5, 'Fundación Empresarial', 0, 1,"R");
        $this->Cell(278, 5, 'Para el desarrollo educativo', 0, 1,"R");
        $this->Cell(278, 5, 'ISO 9001:2015', 0, 1,"R");
        // convert TTF font to TCPDF format and store it on the fonts folder
        $fontname = TCPDF_FONTS::addTTFfont('/path-to-font/Arial.ttf', 'TrueTypeUnicode', '', 96);
        // Set font
        $this->SetFont('helvetica', 'B', 11);
        $this->Ln(3);
        // Title
        $this->Cell(0, 6,'FEPADE', 0, 1,"C");
        $this->Cell(0, 2, 'DETALLE DE ACTIVOS FEPADE', 0, 1,"C");
 
    }

    // Page footer lo mismo que el header solo que el footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 10);
        date_default_timezone_set("America/El_Salvador");
        $fecha = date("d-m-Y H:i: a");
        // Page number
        $this->Cell(0, 10, 'Reporte Generado '.$fecha, 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

    //crea una variable que contiene la etiquete style para el color de fondo
    //ancho de la tabla y columnas de las tablas de los rpt
    //retorna esa variable para ser concatenada con los datos
    public function getEtiquetaStyleRpt(){
    $style=" <style>
        table{
           white-space:nowrap;
           font-family: Arial, Helvetica, sans-serif;
           font-size: 8px;
           padding: 1px;
          
        }
        .noBorder{
            border:none !important;
        }
        .center{
            text-align: center;
        }
        .bgDark{
            background-color: #999999;
            color: black;
            text-shadow: 0 0 5px black;
        }

        .tblResumen{
            padding: 3px;
            font-size: 10px !important;
        }

       td{
        border: 0.2px dashed gray;
       
	    
       }

        th{
           background-color: #999999;
           color: black;
           border: 0.2px dashed gray;
          
        }
       
        .wt{
            width: 100%;
        }
        
       .w3{
        width: 3%;
        }

        .w6{
       
           width: 6%;
           
        }

        .w7{
       
            width: 7%;
            
         }
       .w15{
           width: 15%;
       }
       
       .w7-5{
           width: 7.5%;
       }
       .w5-5{
           width: 5.5%;
       }
       .w9{
           width: 9%;
       
       }

       .w7-8{
           width: 7.8%;
       }
       .w12{
           width: 12%;
       }

       .w20{
           width: 20%;
       }

       
       .w30{
        width: 30%;
        padding: 20px !important;
    }


    </style>";

        return $style;
    }

    //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas
    //para la tabla pc y poder concatenar los respectivos datos en reporteDao
    //retorna esa variable para ser concatenada con los datos
    public function  getHeaderTablaRptPc($boolean){
        
        if($boolean){
            $tablaPC ='<h3>PC</h3>
            <table>
            <tr>
                <th class="w6">Código</th>
                <th class="w15">Descripción</th>
                <th class="w12">Responsable</th>
                <th class="w7 center" >Modelo</th>
                <th class="w6">Procesador</th>
                <th class="w7-5 center">GEN.</th>
                <th class="w5-5 center">RAM</th>
                <th class="w7-5 center">DD</th>
                <th class="w6 center">SO</th>
                <th class="w7-5 center">Office</th>
                <th class="w7-5">No. Series</th>
            </tr>';
        }else{
            $tablaPC ='<h3>PC</h3>
            <table>
            <tr>
                <th class="w6">Código</th>
                <th class="w15">Descripción</th>
                <th class="w12">Responsable</th>
                <th class="w9 center" >IP</th>
                <th class="w7 center" >Modelo</th>
                <th class="w6">Procesador</th>
                <th class="w7-5 center">GEN.</th>
                <th class="w5-5 center">RAM</th>
                <th class="w7-5 center">DD</th>
                <th class="w6 center">SO</th>
                <th class="w7-5 center">Office</th>
                <th class="w7-5">No. Series</th>
            </tr>';
        }

        return $tablaPC;
    }

    
    //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas
    //para la tabla laptop y poder concatenar los respectivos datos en reporteDao
    //retorna esa variable para ser concatenada con los datos
    public function  getHeaderTablaRptLap($boolean){
        if($boolean){
            $tablaPC ='<h3>Laptop</h3>
            <table>
            <tr>
                <th  class="w6">Código</th>
                <th  class="w15">Descripción</th>
                <th  class="w12">Responsable</th>
                <th  class="w7 center">Modelo</th>
                <th  class="w6">Procesador</th>
                <th  class="w7-5 center">GEN.</th>
                <th  class="w5-5 center">RAM</th>
                <th  class="w7-5 center">DD</th>
                <th  class="w6 center">SO</th>
                <th  class="w7-5 center">Office</th>
                <th  class="w7-5">No. Series</th>
            </tr>';
        }else{
            $tablaPC ='<h3>Laptop</h3>
            <table>
            <tr>
                <th class="w6">Código</th>
                <th class="w15">Descripción</th>
                <th class="w12">Responsable</th>
                <th class="w9 center">IP</th>
                <th class="w7 center">Modelo</th>
                <th class="w6">Procesador</th>
                <th class="w7-5 center">GEN.</th>
                <th class="w5-5 center">RAM</th>
                <th class="w7-5 center">DD</th>
                <th class="w6 center">SO</th>
                <th class="w7-5 center">Office</th>
                <th class="w7-5">No. Series</th>
            </tr>';
        }
        return $tablaPC;
    }

    
    //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas
    //para la tabla proyector y poder concatenar los respectivos datos en reporteDao
    //retorna esa variable para ser concatenada con los datos
    public function getHeaderTablaRptProyector($boolean){

        if($boolean){
            $tablaProyector ='<h3>Proyector</h3>
            <table>
               <tr>
                   <th class="w6">Código</th>
                   <th class="w15">Descripción</th>
                   <th class="w12">Responsable</th>
                   <th class="w7 center" >Modelo</th>
                   <th class="7-5">Horas Uso</th>
                   <th class="w7-5">Horas Eco.</th>
               </tr>';
        }else{
            $tablaProyector ='<h3>Proyector</h3>
            <table>
               <tr>
                   <th class="w6">Código</th>
                   <th class="w15">Descripción</th>
                   <th class="w12">Responsable</th>
                   <th class="w9 center" >IP</th>
                   <th class="w7 center" >Modelo</th>
                   <th class="w7-5">Horas Uso</th>
                   <th class="w7-5">Horas Eco.</th>
               </tr>';
        }

        return $tablaProyector;
    }

    
    //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas
    //para la tabla impresor y poder concatenar los respectivos datos en reporteDao
    //retorna esa variable para ser concatenada con los datos
    public function getHeaderTablaRptImpresor($num){
        /*
        0 ---> reporte con cabeceras para reportes de impresoras y toners
        1 ---> reporte con cabeceras con IP 
        2 ---> reporte con cabeceras sin IP         
        */
        switch($num){
            case 0:
                $tablaProyector ='<h3>Impresor</h3>
                <table>
                <tr>
                    <th class="w6">Corr</th>
                    <th class="w15">Descripción</th>
                    <th class="w12">No. IMP</th>
                    <th class="w7-5">Toner N</th>
                    <th class="w7-5">Toner M</th>
                    <th class="w7-5">Toner C</th>
                    <th class="w7-5">Toner A</th>
                </tr>';
            break;
            case 1:
                $tablaProyector ='<h3>Impresor</h3>
                <table>
                <tr>
                    <th class="w6">Código</th>
                    <th class="w15">Descripción</th>
                    <th class="w12">Reponsable</th>
                    <th class="w9 center">IP</th>
                    <th class="w7 center">Modelo</th>
                    <th class="w7-5">Toner N</th>
                    <th class="w7-5">Toner M</th>
                    <th class="w7-5">Toner C</th>
                    <th class="w7-5">Toner A</th>
                </tr>';
            break;
        
            case 2:
            $tablaProyector ='<h3>Impresor</h3>
            <table>
            <tr>
                <th class="w6">Código</th>
                <th class="w15">Descripción</th>
                <th class="w12">Reponsable</th>
                <th class="w7 center">Modelo</th>
                <th class="w7-5">Toner N</th>
                <th class="w7-5">Toner M</th>
                <th class="w7-5">Toner C</th>
                <th class="w7-5">Toner A</th>
            </tr>';
            break;
        }
        return $tablaProyector;
    }

        //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas
    //para la tabla matenimiento de activo poder concatenar los respectivos datos en reporteDao
    //retorna esa variable para ser concatenada con los datos
    public function getHeaderTablaMantenimiento(){      
        
            $tablaMant ='
            <table >
            <tr>
                <th class="w7">Código</th>
                <th class="w15">Equipo</th>
                <th class="w6">Procesador</th>
                <th class="w9 center">Ram</th>
                <th class="w9">Discos Duros</th>
                <th class="w9">Monitor Marca</th>
                <th class="w7-5 center">Código</th>
                <th class="w7-5">Pulgadas</th>
                <th class="w30">Observación</th>
            </tr>';
    
        
        return $tablaMant;
    }

}

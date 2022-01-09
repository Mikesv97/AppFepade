<?php
include_once dirname(__DIR__, 2)."/recursos/lib/TCPDF/tcpdf.php";
include_once dirname(__DIR__, 1).'/conexion.php';

//se debe heredar de TCPDF para sobreescribir los metodos header y footer y poder personalizarlos
class ReportesPlantilla extends TCPDF{

    //metodo sobreescrito para setear el encabezado del reporte
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

    // Page footer lo mismo que el header solo que el footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    //crea una variable que contiene la etiquete style para el color de fondo
    //ancho de la tabla y columnas de las tablas de los rpt
    //retorna esa variable para ser concatenada con los datos
    public function getEtiquetaStyleRpt(){
        $style="
        <style>
        table{
           white-space:nowrap;
           text-align: center;
           font-size: 9.5px;
           padding:1px;
        }
       
        th{
           background-color: #474746;
           color: white;
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

        return $style;
    }

    //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas
    //para la tabla pc y poder concatenar los respectivos datos en reporteDao
    //retorna esa variable para ser concatenada con los datos
    public function  getHeaderTablaRptPc(){
        $tablaPC ='<h3>PC</h3>
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

        return $tablaPC;
    }

    
    //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas
    //para la tabla laptop y poder concatenar los respectivos datos en reporteDao
    //retorna esa variable para ser concatenada con los datos
    public function  getHeaderTablaRptLap(){
        $tablaPC ='<h3>Laptop</h3>
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

        return $tablaPC;
    }

    
    //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas
    //para la tabla proyector y poder concatenar los respectivos datos en reporteDao
    //retorna esa variable para ser concatenada con los datos
    public function getHeaderTablaRptProyector(){

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

        return $tablaProyector;
    }

    
    //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas
    //para la tabla impresor y poder concatenar los respectivos datos en reporteDao
    //retorna esa variable para ser concatenada con los datos
    public function getHeaderTablaRptImpresor(){

        $tablaProyector ='<h3>Impresor</h3>
        <table border="1">
           <tr>
               <th class="w3">Código</th>
               <th class="w15">Descripción</th>
               <th class="w10">Responsable</th>
               <th class="wip" >IP</th>
               <th class="wip" >Modelo</th>
               <th class="w8" >Toner N</th>
               <th class="w8">Toner N</th>
               <th class="w8">Toner C</th>
               <th class="w8">Toner A</th>
           </tr>';

        return $tablaProyector;
    }
}

?>
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
        $this->Ln(5);
        // Title
        $this->Cell(0, 15,'FEPADE', 0, 1,"C");
        $this->Cell(0, 15, 'DETALLE DE ACTIVOS FEPADE', 0, 1,"C");
 
    }

    // Page footer lo mismo que el header solo que el footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 10);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    //crea una variable que contiene la etiquete style para el color de fondo
    //ancho de la tabla y columnas de las tablas de los rpt
    //retorna esa variable para ser concatenada con los datos
    public function getEtiquetaStyleRpt(){
    $style=" <style>
        table{
           white-space:nowrap;
           text-align: center;
           font-size: 9.5px;
           padding:1px;
        }

        .bgDark{
            background-color: #999999;
            color: black;
            text-shadow: 0 0 5px black;
        }

        .tblResumen{
            padding: 10px;
            font-size: 20px !important;
            margin: 0 auto;
        }

       .wt{
           width: 100%;
       }

       td{

        text-align: center;

	    
       }

       p{
        display: block;
        margin: 0 auto;

       }
        th{
           background-color: #999999;
           color: black;
           text-shadow: 0 0 5px black;
        }
       
        .w3{
       
           width: 6%;
           
        }

        .w4{
       
            width: 7%;
            
         }
       .w15{
           width: 15%;
       }
       
       .w8{
           width: 7.5%;
       }
       
       .wr{
           width: 5.5%;
       }
       .w{
           width: 9%;
       
       }
       
       .wip{
           width: 9%;
       }
       .wt{
           width: 7.8%;
       }
       .w10{
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
            <table border="0.3">
            <tr>
                <th class="w3">Código</th>
                <th class="w15">Descripción</th>
                <th class="w10">Responsable</th>
                <th class="w8" >Modelo</th>
                <th class="w">Procesador</th>
                <th class="w8">GEN.</th>
                <th class="wr">RAM</th>
                <th class="w8">DD</th>
                <th class="wt">SO</th>
                <th class="w8">Office</th>
                <th class="w8">No. Series</th>
            </tr>';
        }else{
            $tablaPC ='<h3>PC</h3>
            <table border="0.3">
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
        }

        return $tablaPC;
    }

    
    //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas
    //para la tabla laptop y poder concatenar los respectivos datos en reporteDao
    //retorna esa variable para ser concatenada con los datos
    public function  getHeaderTablaRptLap($boolean){
        if($boolean){
            $tablaPC ='<h3>Laptop</h3>
            <table border="0.3">
            <tr>
                <th class="w3">Código</th>
                <th class="w15">Descripción</th>
                <th class="w10">Responsable</th>
                <th class="w8" >Modelo</th>
                <th class="w">Procesador</th>
                <th class="w8">GEN.</th>
                <th class="wr">RAM</th>
                <th class="w8">DD</th>
                <th class="wt">SO</th>
                <th class="w8">Office</th>
                <th class="w8">No. Series</th>
            </tr>';
        }else{
            $tablaPC ='<h3>Laptop</h3>
            <table border="0.3">
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
        }
        return $tablaPC;
    }

    
    //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas
    //para la tabla proyector y poder concatenar los respectivos datos en reporteDao
    //retorna esa variable para ser concatenada con los datos
    public function getHeaderTablaRptProyector($boolean){

        if($boolean){
            $tablaProyector ='<h3>Proyector</h3>
            <table border="0.3">
               <tr>
                   <th class="w3">Código</th>
                   <th class="w15">Descripción</th>
                   <th class="w10">Responsable</th>
                   <th class="w8" >Modelo</th>
                   <th class="w">Horas Uso</th>
                   <th class="w8">Horas Eco.</th>
               </tr>';
        }else{
            $tablaProyector ='<h3>Proyector</h3>
            <table border="0.3">
               <tr>
                   <th class="w3">Código</th>
                   <th class="w15">Descripción</th>
                   <th class="w10">Responsable</th>
                   <th class="wip" >IP</th>
                   <th class="w8" >Modelo</th>
                   <th class="w">Horas Uso</th>
                   <th class="w8">Horas Eco.</th>
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
                <table border="0.3">
                <tr>
                    <th class="w3">Corr</th>
                    <th class="w15">Descripción</th>
                    <th class="w10">No. IMP</th>
                    <th class="w8">Toner N</th>
                    <th class="w8">Toner M</th>
                    <th class="w8">Toner C</th>
                    <th class="w8">Toner A</th>
                </tr>';
            break;
            case 1:
                $tablaProyector ='<h3>Impresor</h3>
                <table border="0.3">
                <tr>
                    <th class="w3">Código</th>
                    <th class="w15">Descripción</th>
                    <th class="w10">Reponsable</th>
                    <th class="wip">IP</th>
                    <th class="wip">Modelo</th>
                    <th class="w8">Toner N</th>
                    <th class="w8">Toner M</th>
                    <th class="w8">Toner C</th>
                    <th class="w8">Toner A</th>
                </tr>';
            break;
        
            case 2:
            $tablaProyector ='<h3>Impresor</h3>
            <table border="0.3">
            <tr>
                <th class="w3">Código</th>
                <th class="w15">Descripción</th>
                <th class="w10">Reponsable</th>
                <th class="wip">Modelo</th>
                <th class="w8">Toner N</th>
                <th class="w8">Toner M</th>
                <th class="w8">Toner C</th>
                <th class="w8">Toner A</th>
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
            <table border="0.3">
            <tr>
                <th class="w4">Código</th>
                <th class="w15">Equipo</th>
                <th class="w8">Procesador</th>
                <th class="wip">Ram</th>
                <th class="wip">Discos Duros</th>
                <th class="wip">Monitor Marca</th>
                <th class="w8">Código</th>
                <th class="w8">Pulgadas</th>
                <th class="w30">Observación</th>
            </tr>';
    
        
        return $tablaMant;
    }

}

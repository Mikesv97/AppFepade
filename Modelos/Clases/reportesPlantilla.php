<?php
include_once dirname(__DIR__, 2)."/recursos/lib/TCPDF/tcpdf.php";

//se debe heredar de TCPDF para sobreescribir los metodos header y footer y poder personalizarlos
class ReportesPlantilla extends TCPDF{

    //metodo sobreescrito para setear el encabezado del reporte
    public function Header() {
        // Logo
        $this->Image('../Recursos/Multimedia/Imagenes/logoFepadePDF.png', 10, 10, 40,0);
        $this->Ln(10);
        $this->SetFont('helvetica', 'I', 10);
                            //w, h,  x,   y,   textohmtl,  borde, relleno, salto linea, alineado ultima celda centrado, padding 
        $this->writeHTMLCell(90, 0, 100, '', "FEPADE<br>DETALLE DE ACTIVOS FEPADE", 0, 0, 0, true, 'C', true);
        $this->writeHTMLCell(90, 0, 188, '', "Fundación Empresarial<br>Para el desarrollo educativo<br>ISO 9001:2015", 0, 0, 0, true, 'R', true);
        $this->SetMargins(4, PDF_MARGIN_TOP, 4);
        $this->SetAutoPageBreak(TRUE, 20);

    }

    // Page footer lo mismo que el header solo que el footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        $this->SetFooterMargin(10);
        // Set font
        $this->SetFont('helvetica', 'I', 10);
        date_default_timezone_set("America/El_Salvador");
        $fecha = date("d-m-Y H:i: a");
        // Page number
        $this->Cell(80, 10, 'Reporte Generado '.$fecha,0, false, 'L', 0, '', 0, false, 'T', 'M');
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

    //crea una variable que contiene las etiquetas tabla pc y ecabezados de coloumnas
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

    
    //crea una variable que contiene las etiquetas tabla laptop y ecabezados de coloumnas
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

    
    //crea una variable que contiene las etiquetas tabla proyector y ecabezados de coloumnas
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
                   <th class="w7-5">Horas Uso</th>
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


    //crea una variable que contiene las etiquetas tabla telefono y ecabezados de coloumnas
    //retorna esa variable para ser concatenada con los datos
    public function getHeaderTablaRptTelefono($boolean){

        if($boolean){
            $tablaTelefono ='<h3>Teléfono</h3>
            <table>
               <tr>
                   <th class="w6">Código</th>
                   <th class="w15">Descripción</th>
                   <th class="w12">Responsable</th>
                   <th class="w7 center" >Modelo</th>
               </tr>';
        }else{
            $tablaTelefono ='<h3>Teléfono</h3>
            <table>
               <tr>
                   <th class="w6">Código</th>
                   <th class="w15">Descripción</th>
                   <th class="w12">Responsable</th>
                   <th class="w7 center" >Modelo</th>
                   <th class="w9 center" >IP</th>
               </tr>';
        }

        return $tablaTelefono;
    }


    //crea una variable que contiene las etiquetas tabla monitor y ecabezados de coloumnas
    //retorna esa variable para ser concatenada con los datos
    public function getHeaderTablaRptMonitor(){

        $tablaMonitor ='<h3>Monitor</h3>
        <table>
            <tr>
                <th class="w6">Código</th>
                <th class="w15">Descripción</th>
                <th class="w12">Responsable</th>
                <th class="w7 center" >Modelo</th>
            </tr>';

        return $tablaMonitor;
    }

    
    //crea una variable que contiene las etiquetas tabla impresor y ecabezados de coloumnas
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
                    <th class="w6 center">Corr</th>
                    <th class="w15">Descripción</th>
                    <th class="w6 center">No. IMP</th>
                    <th class="w7-5 center">Toner N</th>
                    <th class="w7-5 center">Toner M</th>
                    <th class="w7-5 center">Toner C</th>
                    <th class="w7-5 center">Toner A</th>
                </tr>';
            break;
            case 1:
                $tablaProyector ='<h3>Impresor</h3>
                <table>
                <tr>
                    <th class="w6 center">Código</th>
                    <th class="w15">Descripción</th>
                    <th class="w12">Reponsable</th>
                    <th class="w9 center">IP</th>
                    <th class="w7 center">Modelo</th>
                    <th class="w7-5 center">Toner N</th>
                    <th class="w7-5 center">Toner M</th>
                    <th class="w7-5 center">Toner C</th>
                    <th class="w7-5 center">Toner A</th>
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

    //crea una variable que contiene las etiquetas tabla y ecabezados de coloumnas para mantenimiento
    //retorna esa variable para ser concatenada con los datos
    public function getHeaderTablaMantenimiento(){      
        
            $tablaMant ='
            <table >
            <tr>
                <th class="w9">Código</th>
                <th class="w15">Equipo</th>
                <th class="w6">Procesador</th>
                <th class="w9 center">Ram</th>
                <th class="w9">Discos Duros</th>
                <th class="w9">Monitor Marca</th>
                <th class="w7-5">Pulgadas</th>
                <th class="w30">Observación</th>
            </tr>';
    
        
        return $tablaMant;
    }

}

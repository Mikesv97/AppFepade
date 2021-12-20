<?php
include_once "../Recursos/lib/TCPDF/tcpdf.php";
class Reportes extends TCPDF{
    //Page header
    public function Header() {
        // Logo
        $image_file ='../Recursos/Multimedia/Imagenes/logo.jpg';
        $this->Image($image_file, 20, 10,18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('helvetica', 'B', 15);
        $this->Ln(5);
        $this->Cell(100,5,'FEPADE', 0,1,"C","","","","","M","M");
        $this->Ln(2);
        
        $this->SetFont('helvetica', '', 11);
        $this->Cell(100,5,'Fundación empresarial', 0,1,"C","","","","","M","M");
        $this->Ln(2);
        $this->Cell(100,5,'Para el desarrollo educativo', 0,1,"C","","","","","M","M");
        $this->Ln(2);
        $this->Cell(100,5,'ISO 9901-2015', 0,1,"C","","","","","M","M");
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(420,5,'Sistema Activo Fijo Fepade', 0,1,"C","","","","","M","M");

        
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->SetFont('helvetica', 'I', 8);

        // Page number
        $this->Cell(0, 10, 'Reporte elaborado día '.$this->obtenerFecha());
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    function obtenerFecha(){
        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('America/El_Salvador'));
        $Date = $Object->format("d-m-Y"); 

        return $Date;
    }
    
    function obtenerHora(){
        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('America/El_Salvador'));
        $Time = $Object->format("h:i:s a"); 

        return $Time;
    }
    public static function reporteTipoActivo($datos,$fecha,$hora){
        
        // create new PDF document
        $pdf = new Reportes('p', 'mm', 'A3', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 003');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('times', 'BI', 12);

        // add a page
        $pdf->AddPage();

        // set some text to print
        $html="
        <style>
        .container{
            margin-top:10px;
            width: 90%;
            margin: 0 auto;
        }
        .contentMsj{
            margin-top: 2em;
            margin-bottom: 2em;
        }
        .contentHeader{
        display: flex;
        align-items: center;
        align-content: center;
        }

        .himage{
            width: 200px;
            height: 200px;
        }
        p{


            margin-left: 2em;
        }

        h1{
            text-align: center;
            zi: 20px;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            size:10px;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 5px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        </style>
        </head>
        <body>
        <div class='container'>
        <hr>
        <h1>Reporte tipo activos</h1>";
            

        $html.= $datos;
        $html .="</div>";

        // print a block of text using Write()
        $pdf->writeHTML($html, true, false, true, false, '');
        // ---------------------------------------------------------
        $pdf_string = $pdf->Output('pdf12.pdf', 'S');
        if(file_put_contents('../Recursos/Reportes/reporteTipoActivo_'.$fecha.'_'.$hora.'.pdf', $pdf_string)){
            echo "Reporte generado";
        }else{
            echo "Reporte no generado";
        }
        //Close and output PDF document
      

        //============================================================+
        // END OF FILE
        //============================================================+


    }

}

?>
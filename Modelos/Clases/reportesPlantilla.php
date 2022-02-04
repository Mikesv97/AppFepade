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

    public function headerPcLap($pdf, $boolean){
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(18,2, "Código", 0, 0, "C");
        $pdf->Cell(44, 2, "Descripción", 0, 0, "C");
        $pdf->Cell(38, 2, "Responsable", 0, 0, "C");
        if($boolean){
            $pdf->Cell(26, 2, "IP", 0, 0, "C");
        }
        $pdf->Cell(23, 2, "Modelo", 0, 0, "C");
        $pdf->Cell(20, 2, "Procesador", 0, 0, "C");
        $pdf->Cell(16, 2, "Gen.", 0, 0, "C");
        $pdf->Cell(16, 2, "Ram.", 0, 0, "C");
        $pdf->Cell(16, 2, "DD.", 0, 0, "C");
        $pdf->Cell(16, 2, "SO.", 0, 0, "C");
        $pdf->Cell(16, 2, "Office.", 0, 0, "C");
        $pdf->Cell(28, 2, "No.Serie.", 0, 1, "C");
        $pdf->writeHTMLCell(270, 0, '', '',"<hr>", 0, 1, 0, true, 'L', true);
    }

    public function headerImpresor($pdf, $boolean){
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(18,2, "Código", 0, 0, "C");
        $pdf->Cell(44, 2, "Descripción", 0, 0, "C");
        $pdf->Cell(38, 2, "Responsable", 0, 0, "C");
        if($boolean){
            $pdf->Cell(26, 2, "IP", 0, 0, "C");
        }
        $pdf->Cell(23, 2, "Modelo", 0, 0, "C");
        $pdf->Cell(20, 2, "Toner N.", 0, 0, "C");
        $pdf->Cell(16, 2, "Toner M.", 0, 0, "C");
        $pdf->Cell(16, 2, "Toner C.", 0, 0, "C");
        $pdf->Cell(16, 2, "Toner A.", 0, 0, "C");
        $pdf->Cell(28, 2, "No.Serie.", 0, 1, "C");
        $pdf->writeHTMLCell(270, 0, '', '',"<hr>", 0, 1, 0, true, 'L', true);
    }

    public function headerProyector($pdf, $boolean){
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(18,2, "Código", 0, 0, "C");
        $pdf->Cell(44, 2, "Descripción", 0, 0, "C");
        $pdf->Cell(38, 2, "Responsable", 0, 0, "C");
        if($boolean){
            $pdf->Cell(26, 2, "IP", 0, 0, "C");
        }
        $pdf->Cell(23, 2, "Modelo", 0, 0, "C");
        $pdf->Cell(20, 2, "Horas Uso", 0, 0, "C");
        $pdf->Cell(20, 2, "Horas Eco.", 0, 1, "C");
        $pdf->writeHTMLCell(270, 0, '', '',"<hr>", 0, 1, 0, true, 'L', true);
    }

    public function headerTelMonitor($pdf, $boolean){
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(18,2, "Código", 0, 0, "C");
        $pdf->Cell(44, 2, "Descripción", 0, 0, "C");
        $pdf->Cell(38, 2, "Responsable", 0, 0, "C");
        if($boolean){
            $pdf->Cell(26, 2, "IP", 0, 0, "C");
        }
        $pdf->Cell(23, 2, "Modelo", 0, 1, "C");
        $pdf->writeHTMLCell(270, 0, '', '',"<hr>", 0, 1, 0, true, 'L', true);
    }
}

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
        $this->Cell(80, 10, 'Reporte Generado '.$fecha,0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

    public function headerPcLap($pdf, $boolean){
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(8,0, "Código", 0, 0, "C");
        $pdf->Cell(61, 0, "Descripción", 0, 0, "C");
        $pdf->Cell(41, 0, "Responsable", 0, 0, "C");
        if($boolean){
            $pdf->Cell(26, 2, "IP", 0, 0, "C");
        }
        $pdf->Cell(36, 0, "Modelo", 0, 0, "C");
        $pdf->Cell(16, 0, "Procesador", 0, 0, "C");
        $pdf->Cell(10, 0, "Gen.", 0, 0, "C");
        $pdf->Cell(12, 0, "Ram.", 0, 0, "C");
        $pdf->Cell(18, 0, "DD.", 0, 0, "C");
        $pdf->Cell(19, 0, "SO.", 0, 0, "C");
        $pdf->Cell(12, 0, "Office.", 0, 0, "C");
        $pdf->Cell(30, 0, "No.Serie.", 0, 1, "C");
        $pdf->writeHTMLCell(282, 0, '', '',"<hr>", 0, 1, 0, true, 'L', true);
    }

    public function headerImpresor($pdf, $boolean){
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(8,2, "Código", 0, 0, "C");
        $pdf->Cell(61, 0, "Descripción", 0, 0, "C");
        $pdf->Cell(41, 0, "Responsable", 0, 0, "C");
        if($boolean){
            $pdf->Cell(26, 0, "IP", 0, 0, "C");
        }
        $pdf->Cell(36, 0, "Modelo", 0, 0, "C");
        $pdf->Cell(22, 0, "Toner N.", 0, 0, "L");
        $pdf->Cell(22, 0, "Toner M.", 0, 0, "L");
        $pdf->Cell(22, 0, "Toner C.", 0, 0, "L");
        $pdf->Cell(22, 0, "Toner A.", 0, 0, "L");
        $pdf->Cell(30, 0, "No.Serie.", 0, 1, "L");
        $pdf->writeHTMLCell(270, 0, '', '',"<hr>", 0, 1, 0, true, 'L', true);
    }

    public function headerProyector($pdf, $boolean){
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(8,0, "Código", 0, 0, "C");
        $pdf->Cell(61, 0, "Descripción", 0, 0, "C");
        $pdf->Cell(41, 0, "Responsable", 0, 0, "C");
        if($boolean){
            $pdf->Cell(26, 2, "IP", 0, 0, "C");
        }
        $pdf->Cell(36, 0, "Modelo", 0, 0, "C");
        $pdf->Cell(20, 0, "Horas Uso", 0, 0, "C");
        $pdf->Cell(20, 0, "Horas Eco.", 0, 1, "C");
        $pdf->writeHTMLCell(270, 0, '', '',"<hr>", 0, 1, 0, true, 'L', true);
    }

    public function headerTelMonitor($pdf, $boolean){
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(8,0, "Código", 0, 0, "C");
        $pdf->Cell(61, 0, "Descripción", 0, 0, "C");
        $pdf->Cell(41, 0, "Responsable", 0, 0, "C");
        if($boolean){
            $pdf->Cell(26, 0, "IP", 0, 0, "C");
        }
        $pdf->Cell(36, 0, "Modelo", 0, 1, "C");
        $pdf->writeHTMLCell(270, 0, '', '',"<hr>", 0, 1, 0, true, 'L', true);
    }
}

<?php
include_once dirname(__DIR__, 1) . '/clases/reportesPlantilla.php';
include_once dirname(__DIR__, 1) . '/conexion.php';
include_once "tipoActivoDao.php";

class ReportesDao
{

    public function __construct()
    {
    }

    //PRIMER REPORTE TIPO ACTIVO -- ÁREA
    public function rptTipoActArea($boolean, $numAct, $numArea){
        //creamos el objeto de reporte  
        
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        //$pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Ln(3);

        //establecemos la coneccion
        $con = Conexion::conectar();
        //aca consulta
        $sql ="";

        if($numAct == 0 && $numArea ==100){
            $sql = "select dbo.Activo_Especificacion.DiscoDuro2, dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo,
            dbo.Tipo_Activo.tipo_activo_nombre, dbo.Activo.Activo_referencia, dbo.Activo.Activo_descripcion, dbo.Activo.Activo_factura, dbo.Activo.Activo_fecha_adq, dbo.Activo_responsable.Nombre_responsable, dbo.Activo.Estado,
            dbo.Activo.Activo_eliminado, dbo.Activo_Especificacion.Procesador, dbo.Activo_Especificacion.Generacion, dbo.Activo_Especificacion.Ram, dbo.Activo_Especificacion.DiscoDuro,
            dbo.Activo_Especificacion.Modelo, dbo.Activo_Especificacion.SO, dbo.Activo_Especificacion.Office, dbo.Activo_Especificacion.IP, dbo.Activo_Especificacion.TonerN, dbo.Activo_Especificacion.TonerM,
            dbo.Activo_Especificacion.TonerC, dbo.Activo_Especificacion.TonerA, dbo.Activo_Especificacion.HorasUso, dbo.Activo_Especificacion.HoraEco, dbo.Activo.Estructura2_id,
            dbo.Activo.Empresa_id AS codigo_proyecto, dbo.Activo.numero_serie AS numero_serie, dbo.Activo_Especificacion.Capacidad_D1,dbo.Activo_Especificacion.Capacidad_D2
            FROM dbo.Activo INNER JOIN
            dbo.Activo_responsable ON dbo.Activo.Responsable_codigo = dbo.Activo_responsable.Responsable_codigo INNER JOIN
            dbo.Activo_Especificacion ON dbo.Activo.Activo_id = dbo.Activo_Especificacion.Activo_id INNER JOIN
            dbo.Estructura31 ON dbo.Activo.Estructura3_id = dbo.Estructura31.estructura31_id INNER JOIN
            dbo.Tipo_Activo ON dbo.Activo.Activo_tipo = dbo.Tipo_Activo.tipo_activo_id
            ORDER BY dbo.Estructura31.estructura31_nombre, dbo.Tipo_Activo.tipo_activo_id";
            //ejecutamos la consulta
            $respuesta = $con->query($sql);
        }

        if($numAct !=0 &&  $numArea ==100){
                    
            //establecemos la consulta
            $sql = "
			select dbo.Activo_Especificacion.DiscoDuro2, dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo, 
            dbo.Tipo_Activo.tipo_activo_nombre, dbo.Activo.Activo_referencia, dbo.Activo.Activo_descripcion, dbo.Activo.Activo_factura, dbo.Activo.Activo_fecha_adq, dbo.Activo_responsable.Nombre_responsable, dbo.Activo.Estado, 
            dbo.Activo.Activo_eliminado, dbo.Activo_Especificacion.Procesador, dbo.Activo_Especificacion.Generacion, dbo.Activo_Especificacion.Ram, dbo.Activo_Especificacion.DiscoDuro, 
            dbo.Activo_Especificacion.Modelo, dbo.Activo_Especificacion.SO, dbo.Activo_Especificacion.Office, dbo.Activo_Especificacion.IP, dbo.Activo_Especificacion.TonerN, dbo.Activo_Especificacion.TonerM, 
            dbo.Activo_Especificacion.TonerC, dbo.Activo_Especificacion.TonerA, dbo.Activo_Especificacion.HorasUso, dbo.Activo_Especificacion.HoraEco, dbo.Activo.Estructura2_id,
            dbo.Activo.Empresa_id AS codigo_proyecto, dbo.Activo.numero_serie AS numero_serie
             FROM  dbo.Activo INNER JOIN
            dbo.Activo_responsable ON dbo.Activo.Responsable_codigo = dbo.Activo_responsable.Responsable_codigo INNER JOIN
            dbo.Activo_Especificacion ON dbo.Activo.Activo_id = dbo.Activo_Especificacion.Activo_id INNER JOIN
            dbo.Estructura31 ON dbo.Activo.Estructura3_id = dbo.Estructura31.estructura31_id INNER JOIN
            dbo.Tipo_Activo ON dbo.Activo.Activo_tipo = dbo.Tipo_Activo.tipo_activo_id
            where dbo.Tipo_Activo.tipo_activo_id=?
            ORDER BY dbo.Tipo_Activo.tipo_activo_id, dbo.Estructura31.estructura31_nombre";
            //preparamos la consulta
            $respuesta = $con->prepare($sql);
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$numAct]);
        }

        if($numAct != 0 && $numArea != 100){
            $sql="select dbo.Activo_Especificacion.DiscoDuro2, dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo,
            dbo.Tipo_Activo.tipo_activo_nombre, dbo.Activo.Activo_referencia, dbo.Activo.Activo_descripcion, dbo.Activo.Activo_factura, dbo.Activo.Activo_fecha_adq, dbo.Activo_responsable.Nombre_responsable, dbo.Activo.Estado,
            dbo.Activo.Activo_eliminado, dbo.Activo_Especificacion.Procesador, dbo.Activo_Especificacion.Generacion, dbo.Activo_Especificacion.Ram, dbo.Activo_Especificacion.DiscoDuro,
            dbo.Activo_Especificacion.Modelo, dbo.Activo_Especificacion.SO, dbo.Activo_Especificacion.Office, dbo.Activo_Especificacion.IP, dbo.Activo_Especificacion.TonerN, dbo.Activo_Especificacion.TonerM,
            dbo.Activo_Especificacion.TonerC, dbo.Activo_Especificacion.TonerA, dbo.Activo_Especificacion.HorasUso, dbo.Activo_Especificacion.HoraEco, dbo.Activo.Estructura2_id,
            dbo.Activo.Empresa_id AS codigo_proyecto, dbo.Activo.numero_serie AS numero_serie, dbo.Activo_Especificacion.Capacidad_D1,dbo.Activo_Especificacion.Capacidad_D2
            FROM dbo.Activo INNER JOIN
            dbo.Activo_responsable ON dbo.Activo.Responsable_codigo = dbo.Activo_responsable.Responsable_codigo INNER JOIN
            dbo.Activo_Especificacion ON dbo.Activo.Activo_id = dbo.Activo_Especificacion.Activo_id INNER JOIN
            dbo.Estructura31 ON dbo.Activo.Estructura3_id = dbo.Estructura31.estructura31_id INNER JOIN
            dbo.Tipo_Activo ON dbo.Activo.Activo_tipo = dbo.Tipo_Activo.tipo_activo_id
            where dbo.Tipo_Activo.tipo_activo_id = ? and dbo.Estructura31.estructura31_id= ?
            ORDER BY dbo.Tipo_Activo.tipo_activo_id";

            //preparamos la consulta
            $respuesta = $con->prepare($sql);
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$numAct,$numArea]);
        }

        if($numAct == 0 && $numArea != 100){
            $sql="select dbo.Activo_Especificacion.DiscoDuro2, dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo,
            dbo.Tipo_Activo.tipo_activo_nombre, dbo.Activo.Activo_referencia, dbo.Activo.Activo_descripcion, dbo.Activo.Activo_factura, dbo.Activo.Activo_fecha_adq, dbo.Activo_responsable.Nombre_responsable, dbo.Activo.Estado,
            dbo.Activo.Activo_eliminado, dbo.Activo_Especificacion.Procesador, dbo.Activo_Especificacion.Generacion, dbo.Activo_Especificacion.Ram, dbo.Activo_Especificacion.DiscoDuro,
            dbo.Activo_Especificacion.Modelo, dbo.Activo_Especificacion.SO, dbo.Activo_Especificacion.Office, dbo.Activo_Especificacion.IP, dbo.Activo_Especificacion.TonerN, dbo.Activo_Especificacion.TonerM,
            dbo.Activo_Especificacion.TonerC, dbo.Activo_Especificacion.TonerA, dbo.Activo_Especificacion.HorasUso, dbo.Activo_Especificacion.HoraEco, dbo.Activo.Estructura2_id,
            dbo.Activo.Empresa_id AS codigo_proyecto, dbo.Activo.numero_serie AS numero_serie, dbo.Activo_Especificacion.Capacidad_D1,dbo.Activo_Especificacion.Capacidad_D2
            FROM dbo.Activo INNER JOIN
            dbo.Activo_responsable ON dbo.Activo.Responsable_codigo = dbo.Activo_responsable.Responsable_codigo INNER JOIN
            dbo.Activo_Especificacion ON dbo.Activo.Activo_id = dbo.Activo_Especificacion.Activo_id INNER JOIN
            dbo.Estructura31 ON dbo.Activo.Estructura3_id = dbo.Estructura31.estructura31_id INNER JOIN
            dbo.Tipo_Activo ON dbo.Activo.Activo_tipo = dbo.Tipo_Activo.tipo_activo_id
            where dbo.Estructura31.estructura31_id = ?
            ORDER BY dbo.Tipo_Activo.tipo_activo_id";
            //preparamos la consulta
            $respuesta = $con->prepare($sql);
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$numArea]);
        }

        //convertimos a un arreglo los datos obtenidos de BD
        $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);

        //creamos un array para manejar nombres de áreas.
        $arrayAreas= array();
        //creamos un array para manejar nombres de activos
        $arrayActivos= array();

        //recorremos los datos
        for($i = 0; $i<sizeof($fila); $i++){
            //cargamos nombre área y activo a variables para mejor manejo
            $area = trim($fila[$i]["estructura31_nombre"]);
            $activo = trim($fila[$i]["tipo_activo_nombre"]);
           

            //si el nombre de área actual ya está en el array
            if(in_array($area, $arrayAreas)){

                if(!in_array($activo.$area, $arrayActivos)){
                    $pdf->SetFont('helvetica', 'B', 12);
                    $arrayActivos[$i]=$activo.$area;
                    $pdf->Cell(80, 5, $activo, 0, 1, "L");
                    $this->getHeadersRpt(strtolower($activo), $boolean, $pdf);
                    
                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->writeHTMLCell(18, 0, '', '', strtolower($fila[$i]["Activo_id"]), 0, 0, 0, true, 'C', true);
                    $pdf->writeHTMLCell(44, 20, '', '',  strtolower($fila[$i]["Activo_descripcion"]), 0, 0, 0, true, 'L', true);
                    $pdf->writeHTMLCell(38, 0, '', '', $fila[$i]["Nombre_responsable"], 0, 0, 0, true, 'L', true);
                    
                    if($boolean){
                        $pdf->SetFont('helvetica', '', 8);
                        $pdf->writeHTMLCell(26, 0, '', '', $fila[$i]["IP"], 0,0, 0, true, 'L', true);
                    }
                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->writeHTMLCell(23, 20, '', '',  strtolower($fila[$i]["Modelo"]), 0, 0, 0, true, 'L', true);
                    //aca espesificacione
                    $pdf->Ln(10);
                }else{
                    
                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->writeHTMLCell(18, 0, '', '', $fila[$i]["Activo_id"], 0,0, 0, true, 'C', true);
                    $pdf->writeHTMLCell(44, 20, '', '',  strtolower($fila[$i]["Activo_descripcion"]), 0, 0, 0, true, 'L', true);
                    $pdf->writeHTMLCell(38, 0, '', '', $fila[$i]["Nombre_responsable"], 0, 0, 0, true, 'L', true);
                    if($boolean){
                        $pdf->SetFont('helvetica', '', 8);
                        $pdf->writeHTMLCell(26, 0, '', '', $fila[$i]["IP"], 0, 0, 0, true, 'L', true);
                    }
                    $pdf->SetFont('helvetica', '', 9);
                    //$pdf->writeHTMLCell(23, 0, '', '', $fila[$i]["Modelo"], 0, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(23, 20, '', '',  strtolower($fila[$i]["Modelo"]), 0, 0, 0, true, 'L', true);
                    //aca espesificaciones
                    $pdf->Ln(10);
                }

            }else{
                $pdf->AddPage();
                //si el nombre no está en el array
                //agrego el nombre de area al array
                $arrayAreas[$i]=$area;
                $pdf->SetFont('helvetica', 'B', 12);
                //imprimo el nombre en el pdf
                $pdf->Cell(80, 0, "Área: ".$area, 0, 1, "L");
                
                $arrayActivos[$i]=$activo.$area;
                $pdf->Cell(80, 5, $activo, 0, 1, "L");
                $this->getHeadersRpt(strtolower($activo), $boolean, $pdf);
                $pdf->SetFont('helvetica', '', 9);
                $pdf->writeHTMLCell(18, 0, '', '', $fila[$i]["Activo_id"], 0,0, 0, true, 'C', true);
                $pdf->writeHTMLCell(44, 20, '', '',  strtolower($fila[$i]["Activo_descripcion"]), 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(38, 0, '', '', $fila[$i]["Nombre_responsable"], 0, 0, 0, true, 'L', true);
                if($boolean){
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->writeHTMLCell(26, 0, '', '', $fila[$i]["IP"], 0, 0, 0, true, 'L', true);            
                }
                $pdf->SetFont('helvetica', '', 9);
                $pdf->writeHTMLCell(23, 20, '', '',  strtolower($fila[$i]["Modelo"]), 0, 0, 0, true, 'L', true);
                //aca espesificaciones
                $pdf->Ln(8);

            }
        }

        $pdf->SetAutoPageBreak(TRUE, 20);
        $pdf->Output();
    }

    public function rptTipoAct($numAct, $boolean){
        //creamos el objeto de reporte  
        
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        //$pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Ln(3);

        //establecemos la coneccion
        $con = Conexion::conectar();
        //aca consulta
        $sql ="";

        
        if($numAct ==0){

            $sql="select dbo.Activo_Especificacion.DiscoDuro2, dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo, 
            dbo.Tipo_Activo.tipo_activo_nombre, dbo.Activo.Activo_referencia, dbo.Activo.Activo_descripcion, dbo.Activo.Activo_factura, dbo.Activo.Activo_fecha_adq, dbo.Activo_responsable.Nombre_responsable, dbo.Activo.Estado, 
            dbo.Activo.Activo_eliminado, dbo.Activo_Especificacion.Procesador, dbo.Activo_Especificacion.Generacion, dbo.Activo_Especificacion.Ram, dbo.Activo_Especificacion.DiscoDuro, 
            dbo.Activo_Especificacion.Modelo, dbo.Activo_Especificacion.SO, dbo.Activo_Especificacion.Office, dbo.Activo_Especificacion.IP, dbo.Activo_Especificacion.TonerN, dbo.Activo_Especificacion.TonerM, 
            dbo.Activo_Especificacion.TonerC, dbo.Activo_Especificacion.TonerA, dbo.Activo_Especificacion.HorasUso, dbo.Activo_Especificacion.HoraEco, dbo.Activo.Estructura2_id,
            dbo.Activo.Empresa_id AS codigo_proyecto, dbo.Activo.numero_serie AS numero_serie
             FROM  dbo.Activo INNER JOIN
            dbo.Activo_responsable ON dbo.Activo.Responsable_codigo = dbo.Activo_responsable.Responsable_codigo INNER JOIN
            dbo.Activo_Especificacion ON dbo.Activo.Activo_id = dbo.Activo_Especificacion.Activo_id INNER JOIN
            dbo.Estructura31 ON dbo.Activo.Estructura3_id = dbo.Estructura31.estructura31_id INNER JOIN
            dbo.Tipo_Activo ON dbo.Activo.Activo_tipo = dbo.Tipo_Activo.tipo_activo_id
            ORDER BY dbo.Tipo_Activo.tipo_activo_id";

            $respuesta = $con->query($sql);
        }

        if($numAct !=0){
            $sql ="select dbo.Activo_Especificacion.DiscoDuro2, dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo, 
            dbo.Tipo_Activo.tipo_activo_nombre, dbo.Activo.Activo_referencia, dbo.Activo.Activo_descripcion, dbo.Activo.Activo_factura, dbo.Activo.Activo_fecha_adq, dbo.Activo_responsable.Nombre_responsable, dbo.Activo.Estado, 
            dbo.Activo.Activo_eliminado, dbo.Activo_Especificacion.Procesador, dbo.Activo_Especificacion.Generacion, dbo.Activo_Especificacion.Ram, dbo.Activo_Especificacion.DiscoDuro, 
            dbo.Activo_Especificacion.Modelo, dbo.Activo_Especificacion.SO, dbo.Activo_Especificacion.Office, dbo.Activo_Especificacion.IP, dbo.Activo_Especificacion.TonerN, dbo.Activo_Especificacion.TonerM, 
            dbo.Activo_Especificacion.TonerC, dbo.Activo_Especificacion.TonerA, dbo.Activo_Especificacion.HorasUso, dbo.Activo_Especificacion.HoraEco, dbo.Activo.Estructura2_id,
            dbo.Activo.Empresa_id AS codigo_proyecto, dbo.Activo.numero_serie AS numero_serie
             FROM  dbo.Activo INNER JOIN
            dbo.Activo_responsable ON dbo.Activo.Responsable_codigo = dbo.Activo_responsable.Responsable_codigo INNER JOIN
            dbo.Activo_Especificacion ON dbo.Activo.Activo_id = dbo.Activo_Especificacion.Activo_id INNER JOIN
            dbo.Estructura31 ON dbo.Activo.Estructura3_id = dbo.Estructura31.estructura31_id INNER JOIN
            dbo.Tipo_Activo ON dbo.Activo.Activo_tipo = dbo.Tipo_Activo.tipo_activo_id
            where dbo.Tipo_Activo.tipo_activo_id=?
            ORDER BY dbo.Tipo_Activo.tipo_activo_id";
            //preparamos la consulta
            $respuesta = $con->prepare($sql);
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$numAct]);
        }
        

        //convertimos a un arreglo los datos obtenidos de BD
        $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);

        //creamos un array para manejar nombres de activos
        $arrayActivos= array();

        //recorremos los datos
        for($i = 0; $i<sizeof($fila); $i++){
            //cargamos nombre área y activo a variables para mejor manejo
           
            $activo = trim($fila[$i]["tipo_activo_nombre"]);
           

            //si el nombre de activo actual ya está en el array
            if(!in_array($activo, $arrayActivos)){
                $pdf->AddPage();
                $pdf->SetFont('helvetica', 'B', 12);
                $arrayActivos[$i]=$activo;
                $pdf->Cell(80, 5, $activo, 0, 0, "L");
                $pdf->cell(180,5,"Total: ".$this->contTotalTipAct($fila[$i]["Activo_tipo"]),0,1,"R");
                $this->getHeadersRpt(strtolower($activo), $boolean, $pdf);
                    
                $pdf->SetFont('helvetica', '', 9);
                $pdf->writeHTMLCell(18, 0, '', '', strtolower($fila[$i]["Activo_id"]), 0, 0, 0, true, 'C', true);
                $pdf->writeHTMLCell(44, 20, '', '',  strtolower($fila[$i]["Activo_descripcion"]), 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(38, 0, '', '', $fila[$i]["Nombre_responsable"], 0, 0, 0, true, 'L', true);
                    
                if($boolean){
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->writeHTMLCell(26, 0, '', '', $fila[$i]["IP"], 0,0, 0, true, 'L', true);
                }
                $pdf->SetFont('helvetica', '', 9);
                $pdf->writeHTMLCell(23, 20, '', '',  strtolower($fila[$i]["Modelo"]), 0, 0, 0, true, 'L', true);
                //aca espesificacione
                $pdf->Ln(10);
            }else{
                    
                $pdf->SetFont('helvetica', '', 9);
                $pdf->writeHTMLCell(18, 0, '', '', $fila[$i]["Activo_id"], 0,0, 0, true, 'C', true);
                $pdf->writeHTMLCell(44, 20, '', '',  strtolower($fila[$i]["Activo_descripcion"]), 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(38, 0, '', '', $fila[$i]["Nombre_responsable"], 0, 0, 0, true, 'L', true);
                if($boolean){
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->writeHTMLCell(26, 0, '', '', $fila[$i]["IP"], 0, 0, 0, true, 'L', true);
                }
                $pdf->SetFont('helvetica', '', 9);
                //$pdf->writeHTMLCell(23, 0, '', '', $fila[$i]["Modelo"], 0, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(23, 20, '', '',  strtolower($fila[$i]["Modelo"]), 0, 0, 0, true, 'L', true);
                //aca espesificaciones
                $pdf->Ln(10);
            }

            
        }

        $pdf->SetAutoPageBreak(TRUE, 20);
        $pdf->Output();
    }





    private function getHeadersRpt($tipoActivo, $boolean, $pdf){
        switch($tipoActivo){
            case "pc":
                $pdf->headerPcLap($pdf, $boolean);
            break;
            case "laptop":
                $pdf->headerPcLap($pdf, $boolean);
            break;
            case "impresor":
                $pdf->headerImpresor($pdf, $boolean);
            break;
            case "proyector":
                $pdf->headerProyector($pdf, $boolean);
            break;
            case "monitor":
                $pdf->headerTelMonitor($pdf, $boolean);
            break;
            case "telefono":
                $pdf->headerTelMonitor($pdf, $boolean);
            break;

        }
    }

    private function contTotalTipAct($tipoActivo)
    {
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql = "SELECT count(*) as cantidad from activo where Activo_tipo = ?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try {

            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$tipoActivo]);
            //retornamos la cantidad de registro con el correo ingresado
            //solo puede ser 1 si hay o 0 si no hay
            return $respuesta->fetchColumn();
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

}

?>
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
            dbo.Activo.Empresa_id AS codigo_proyecto, dbo.Activo.numero_serie AS numero_serie, dbo.Activo_Especificacion.Capacidad_D1,dbo.Activo_Especificacion.Capacidad_D2
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
            $pdf->SetAutoPageBreak(TRUE, 40);
            //cargamos nombre área y activo a variables para mejor manejo
            $area = trim($fila[$i]["estructura31_nombre"]);
            $activo = trim($fila[$i]["tipo_activo_nombre"]);
           

            //si el nombre de área actual ya está en el array
            if(in_array($area, $arrayAreas)){
                
                if(!in_array($activo.$area, $arrayActivos)){
                    $pdf->Ln(3);
                    $pdf->SetFont('helvetica', 'B', 9);
                    $arrayActivos[$i]=$activo.$area;
                    $pdf->Cell(80, 5, $activo, 0, 1, "L");
                    $this->getHeadersRpt(strtolower($activo), $boolean, $pdf);
                    
                    $pdf->SetFont('helvetica', '', 7);
                    $pdf->writeHTMLCell(8, 0, '', '', strtolower($fila[$i]["Activo_id"]), 0, 0, 0, true, 'C', true);
                    $pdf->writeHTMLCell(61, 0, '', '',  strtolower($fila[$i]["Activo_descripcion"]), 0, 0, 0, true, 'L', true);
                    $pdf->writeHTMLCell(41, 0, '', '', $fila[$i]["Nombre_responsable"], 0, 0, 0, true, 'L', true);
                    
                    if($boolean){
                        $pdf->writeHTMLCell(26, 0, '', '', $fila[$i]["IP"], 0,0, 0, true, 'L', true);
                    }
                    $pdf->writeHTMLCell(36, 0, '', '',  strtolower($fila[$i]["Modelo"]), 0, 0, 0, true, 'L', true);
                    $this->getEspefAct($activo, $pdf,$i, $fila);
                }else{
                    
                    $pdf->SetFont('helvetica', '', 7);
                    $pdf->writeHTMLCell(8, 0, '', '', $fila[$i]["Activo_id"], 0,0, 0, true, 'C', true);
                    $pdf->writeHTMLCell(61, 0, '', '',  strtolower($fila[$i]["Activo_descripcion"]), 0, 0, 0, true, 'L', true);
                    $pdf->writeHTMLCell(41, 0, '', '', $fila[$i]["Nombre_responsable"], 0, 0, 0, true, 'L', true);
                    if($boolean){
                        $pdf->writeHTMLCell(26, 0, '', '', $fila[$i]["IP"], 0, 0, 0, true, 'L', true);
                    }
                    //$pdf->writeHTMLCell(23, 0, '', '', $fila[$i]["Modelo"], 0, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(36, 0, '', '',  strtolower($fila[$i]["Modelo"]), 0, 0, 0, true, 'L', true);
                    $this->getEspefAct($activo, $pdf,$i, $fila);
                }

            }else{
                $pdf->SetTopMargin(22);
                $pdf->AddPage();
                //si el nombre no está en el array
                //agrego el nombre de area al array
                $arrayAreas[$i]=$area;
                $pdf->SetFont('helvetica', 'B', 9);
                $pdf->writeHTMLCell(0, 0, '', '', "Detalle Activo Fepade", 0,1, 0, true, 'C', true);
                $pdf->Ln(5);
                //imprimo el nombre en el pdf
                $pdf->Cell(80, 0, "Área: ".$area, 0, 1, "L");
                
                $arrayActivos[$i]=$activo.$area;
                $pdf->Cell(80, 5, $activo, 0, 1, "L");
                $this->getHeadersRpt(strtolower($activo), $boolean, $pdf);
                $pdf->SetFont('helvetica', '', 7);
                $pdf->writeHTMLCell(8   , 0, '', '', $fila[$i]["Activo_id"], 0,0, 0, true, 'C', true);
                $pdf->writeHTMLCell(61, 0, '', '',  strtolower($fila[$i]["Activo_descripcion"]), 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(41, 0, '', '', $fila[$i]["Nombre_responsable"], 0, 0, 0, true, 'L', true);
                if($boolean){
                    $pdf->writeHTMLCell(26, 0, '', '', $fila[$i]["IP"], 0, 0, 0, true, 'L', true);            
                }
                $pdf->writeHTMLCell(36, 0, '', '',  strtolower($fila[$i]["Modelo"]), 0, 0, 0, true, 'L', true);
                $this->getEspefAct($activo, $pdf,$i, $fila);

            }
        }


        $pdf->Output();
    }

    public function rptTipoAct($numAct, $boolean){
        //creamos el objeto de reporte  
        
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
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
            dbo.Activo.Empresa_id AS codigo_proyecto, dbo.Activo.numero_serie AS numero_serie, dbo.Activo_Especificacion.Capacidad_D1,dbo.Activo_Especificacion.Capacidad_D2
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
            dbo.Activo.Empresa_id AS codigo_proyecto, dbo.Activo.numero_serie AS numero_serie,dbo.Activo_Especificacion.Capacidad_D1,dbo.Activo_Especificacion.Capacidad_D2
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
            $pdf->SetAutoPageBreak(TRUE, 30);
            $activo = trim($fila[$i]["tipo_activo_nombre"]);
           

            //si el nombre de activo actual ya está en el array
            if(!in_array($activo, $arrayActivos)){
                $pdf->SetTopMargin(22);
                $pdf->AddPage();
                $pdf->SetFont('helvetica', 'B', 9);
                $pdf->writeHTMLCell(0, 0, '', '', "Detalle Activo Fepade", 0,1, 0, true, 'C', true);
                $pdf->Ln(5);
                $arrayActivos[$i]=$activo;
                $pdf->Cell(80, 5, $activo, 0, 0, "L");
                $pdf->cell(180,5,"Total: ".$this->contTotalTipAct($fila[$i]["Activo_tipo"]),0,1,"R");
                $this->getHeadersRpt(strtolower($activo), $boolean, $pdf);
                $pdf->SetFont('helvetica', '', 7);
                $pdf->writeHTMLCell(8, 0, '', '', strtolower($fila[$i]["Activo_id"]), 0, 0, 0, true, 'C', true);
                $pdf->writeHTMLCell(61, 0, '', '',  strtolower($fila[$i]["Activo_descripcion"]), 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(41, 0, '', '', $fila[$i]["Nombre_responsable"], 0, 0, 0, true, 'L', true);
                    
                if($boolean){
                    $pdf->writeHTMLCell(26, 0, '', '', $fila[$i]["IP"], 0,0, 0, true, 'L', true);
                }
                $pdf->writeHTMLCell(36, 0, '', '',  strtolower($fila[$i]["Modelo"]), 0, 0, 0, true, 'L', true);
                $this->getEspefAct($activo, $pdf,$i, $fila);
            }else{
                    
                $pdf->SetFont('helvetica', '', 7);
                $pdf->writeHTMLCell(8, 0, '', '', $fila[$i]["Activo_id"], 0,0, 0, true, 'C', true);
                $pdf->writeHTMLCell(61, 0, '', '',  strtolower($fila[$i]["Activo_descripcion"]), 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(41, 0, '', '', $fila[$i]["Nombre_responsable"], 0, 0, 0, true, 'L', true);
                if($boolean){
                    $pdf->writeHTMLCell(26, 0, '', '', $fila[$i]["IP"], 0, 0, 0, true, 'L', true);
                }
                $pdf->writeHTMLCell(36, 0, '', '',  strtolower($fila[$i]["Modelo"]), 0, 0, 0, true, 'L', true);
                $this->getEspefAct($activo, $pdf,$i, $fila);
            }

            
        }

        
        $pdf->Output();
    }

    public function rptResumenAct(){
        //creamos el objeto de reporte  
                
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->SetFont('helvetica', 'B', 10);
        //establecemos la coneccion
        $con = Conexion::conectar();
        //aca consulta
        $sql ="SELECT  count(a.Activo_tipo) as cantidad, b.tipo_activo_nombre from activo a 
        inner join Tipo_Activo b on a.Activo_tipo = b.tipo_activo_id group by b.tipo_activo_nombre";
        $respuesta = $con->query($sql);
        $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);
        $total=0;
        $pdf->SetTopMargin(22);
        $pdf->AddPage();
        $pdf->writeHTMLCell(0, 5, '', '', "Detalle Activo Fepade", 0,1, 0, true, 'C', true);
        $pdf->Ln(5);
        $pdf->writeHTMLCell(50, 5, 95, '', "Tipo Activo", 0, 0, 0, true, 'C', true);
        $pdf->writeHTMLCell(50, 5, '', '', "Cantidad", 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(100, 5, 95, '',"<hr>", 0, 1, 0, true, 'L', true);

        for($i=0; $i<sizeof($fila); $i++){
            $pdf->writeHTMLCell(50, 5, 95, '', $fila[$i]["tipo_activo_nombre"], 0, 0, 0, true, 'C', true);
            $pdf->writeHTMLCell(50, 5, '', '',  $fila[$i]["cantidad"], 0, 1, 0, true, 'C', true);
            $total += $fila[$i]["cantidad"];
        }

        $pdf->writeHTMLCell(100, 5, 95, '',"<hr>", 0, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(50, 5, 95, '', "Total Activos", 0, 0, 0, true, 'C', true);
        $pdf->writeHTMLCell(50, 5, '', '', $total, 0, 0, 0, true, 'C', true);

        
        $pdf->SetAutoPageBreak(TRUE, 20);
        $pdf->Output();

    }

    public function rptResumenToner(){
        //creamos el objeto de reporte  
                
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        //$pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Ln(3);

        //establecemos la coneccion
        $con = Conexion::conectar();
        //aca consulta
        $sql ="select count(b.Modelo) as cantidadModelo,modelo,Activo_descripcion ,b.TonerN, b.TonerM, b.TonerC, b.TonerA FROM Activo a
        INNER JOIN Activo_Especificacion b ON a.Activo_id = b.Activo_id WHERE Activo_tipo = 3
        group by b.TonerN, b.TonerM, b.TonerC, b.TonerA,Modelo, Activo_descripcion
        order by tonern,modelo";

        $respuesta = $con->query($sql);
        $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);

        $pdf->SetTopMargin(22);
        $pdf->AddPage();
        $pdf->writeHTMLCell(0, 0, '', '', "Detalle De Impresores Activos", 0,1, 0, true, 'C', true);
        $pdf->Ln(5);
        $pdf->Cell(18, 0, "Corr.", 0, 0, "C");
        $pdf->Cell(80, 0, "Descripción.", 0, 0, "C");
        $pdf->Cell(30, 0, "No. IMP", 0, 0, "C");
        $pdf->Cell(30, 0, "Toner N.", 0, 0, "C");
        $pdf->Cell(30, 0, "Toner M.", 0, 0, "C");
        $pdf->Cell(30, 0, "Toner C.", 0, 0, "C");
        $pdf->Cell(30, 0, "Toner A.", 0, 1, "C");
        $pdf->writeHTMLCell(244, 0, '', '',"<hr>", 0, 1, 0, true, 'L', true);


        for($i=0; $i<sizeof($fila); $i++){
            $pdf->SetFont('helvetica', '', 7);
            $pdf->writeHTMLCell(18, 0, '', '', ($i+1), 0, 0, 0, true, 'C', true);
            $pdf->writeHTMLCell(80, 0,'', '', $fila[$i]["Activo_descripcion"], 0, 0, 0, true, 'L', true);
            $pdf->writeHTMLCell(30, 0, '', '', $fila[$i]["cantidadModelo"], 0, 0, 0, true, 'C', true);
            $pdf->writeHTMLCell(30, 0, '', '',  $fila[$i]["TonerN"], 0, 0, 0, true, 'C', true);
            $pdf->writeHTMLCell(30, 0, '', '',  $fila[$i]["TonerM"], 0, 0, 0, true, 'C', true);
            $pdf->writeHTMLCell(30, 0, '', '',  $fila[$i]["TonerC"], 0, 0, 0, true, 'C', true);
            $pdf->writeHTMLCell(30, 0, '', '',  $fila[$i]["TonerA"].'<br>', 0, 1, 0, true, 'C', true);

        }

        $pdf->SetAutoPageBreak(TRUE, 20);
        $pdf->Output();

    }

    public function rptMantenimiento($numAct, $numArea){
        //creamos el objeto de reporte  
        
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false); 
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
            dbo.Activo.Empresa_id AS codigo_proyecto, dbo.Activo.numero_serie AS numero_serie, dbo.Activo_Especificacion.Capacidad_D1,dbo.Activo_Especificacion.Capacidad_D2
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
            $pdf->SetAutoPageBreak(TRUE, 30);
            $area = trim($fila[$i]["estructura31_nombre"]);
            $activo = trim($fila[$i]["tipo_activo_nombre"]);
           

            //si el nombre de área actual ya está en el array
            if(in_array($area, $arrayAreas)){

                if(!in_array($activo.$area, $arrayActivos)){
                    $pdf->SetFont('helvetica', 'B', 9);
                    $arrayActivos[$i]=$activo.$area;

                    $pdf->Cell(0, 0, $activo, 0, 1, "L");
                    $pdf->Ln(4);
                    $this->getHeadersRpt(strtolower("mantenimiento"), false, $pdf);
                    $pdf->Ln(4);
                    $pdf->SetFont('helvetica', '', 7);
                    $pdf->writeHTMLCell(38, 0, '', '', ($i+1)."<hr>", 0, 0, 0, true, 'L', true);
                    $pdf->writeHTMLCell(55, 0, '', '',$fila[$i]["numero_serie"]." ".$fila[$i]["Modelo"]." ".$fila[$i]["Procesador"] 
                    ." ".$fila[$i]["Generacion"]." ".$fila[$i]["Ram"]." ".$fila[$i]["DiscoDuro"]." ".$fila[$i]["Capacidad_D1"]
                    ." ".$fila[$i]["DiscoDuro2"]." ".$fila[$i]["Capacidad_D2"], 0, 0, 0, true, 'L', true);
                    $pdf->writeHTMLCell(0, 0, '', '', " <hr><br>", 0, 1, 0, true, 'L', true);
                    $pdf->writeHTMLCell(0, 0, '', '', "<br>", 0, 1, 0, true, 'L', true);
                }else{
                    $pdf->SetFont('helvetica', '', 7);
                    $pdf->writeHTMLCell(38, 0, '', '', ($i+1)."<hr>", 0, 0, 0, true, 'L', true);
                    $pdf->writeHTMLCell(55, 0, '', '',$fila[$i]["numero_serie"]." ".$fila[$i]["Modelo"]." ".$fila[$i]["Procesador"] 
                    ." ".$fila[$i]["Generacion"]." ".$fila[$i]["Ram"]." ".$fila[$i]["DiscoDuro"]." ".$fila[$i]["Capacidad_D1"]
                    ." ".$fila[$i]["DiscoDuro2"]." ".$fila[$i]["Capacidad_D2"], 0, 0, 0, true, 'L', true);
                    $pdf->writeHTMLCell(0, 0, '', '', " <hr><br>", 0, 1, 0, true, 'L', true);
                    $pdf->writeHTMLCell(0, 0, '', '', "<br>", 0, 1, 0, true, 'L', true);
                }

            }else{
                $pdf->SetTopMargin(22);
                $pdf->AddPage();
                //si el nombre no está en el array
                //agrego el nombre de area al array
                $arrayAreas[$i]=$area;
                $pdf->SetFont('helvetica', 'B', 9);
                $pdf->writeHTMLCell(0, 0, '', '', "Detalle Activo Fepade", 0,1, 0, true, 'C', true);
                
                $arrayActivos[$i]=$activo.$area;

                $pdf->Cell(0, 0, "Mantenimiento Preventivo De Recursos TI", 0,1, "L");
                $pdf->Cell(70, 0, "Departamento: ".$area, 0,0, "L"); 
                $pdf->Cell(130, 0, "Gerente / Jefe: ___________________________________", 0,0, "C");
                $pdf->Cell(68, 0, "Fecha: ___________________", 0, 1, "R");
                $pdf->Ln(3);
                $pdf->Cell(0, 0, $activo, 0, 1, "L");
                $pdf->Ln(4);
                $this->getHeadersRpt(strtolower("mantenimiento"), false, $pdf);
                $pdf->Ln(4);
                $pdf->SetFont('helvetica', '', 7);
                $pdf->writeHTMLCell(38, 0, '', '', ($i+1)."<hr>", 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(55, 0, '', '',$fila[$i]["numero_serie"]." ".$fila[$i]["Modelo"]." ".$fila[$i]["Procesador"] 
                ." ".$fila[$i]["Generacion"]." ".$fila[$i]["Ram"]." ".$fila[$i]["DiscoDuro"]." ".$fila[$i]["Capacidad_D1"]
                ." ".$fila[$i]["DiscoDuro2"]." ".$fila[$i]["Capacidad_D2"], 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(0, 0, '', '', " <hr><br>", 0, 1, 0, true, 'L', true);
                $pdf->writeHTMLCell(0, 0, '', '', "<br>", 0, 1, 0, true, 'L', true);

            }
        }
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
            case "mantenimiento":
                $pdf->SetFont('helvetica', '', 8);
                $pdf->Cell(38, 2, "Usuario", 1, 0, "C");
                $pdf->Cell(55, 2, "Equipo", 1, 0, "C");
                $pdf->Cell(55, 2, "Observación.", 1, 0, "C");
                $pdf->Cell(30, 2, "Tipo De Ram", 1, 0, "C");
                $pdf->Cell(30, 2, "Monitor Marca", 1, 0, "C");
                $pdf->Cell(30, 2, "Código", 1, 0, "C");
                $pdf->Cell(30, 2, "Pulgadas", 1, 1, "C");
                $pdf->writeHTMLCell(270, 0, '', '',"<hr>", 0, 1, 0, true, 'L', true);
            break;
            default:
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

    private function getEspefAct($tipoActivo, $pdf,$i, $fila){
        switch(strtolower($tipoActivo)){
            case "pc":
                
                $pdf->writeHTMLCell(18, 0, '', '', strtolower($fila[$i]["Procesador"]), 0,0, 0, true, 'L', true);
                $pdf->writeHTMLCell(10, 0, '', '', $fila[$i]["Generacion"], 0, 0, 0, true, 'C', true);
                $pdf->writeHTMLCell(12, 0, '', '', $fila[$i]["Ram"], 0, 0, 0, true, 'L', true);
                $pdf->SetFont('helvetica', '', 6);
                $pdf->writeHTMLCell(19, 0, '', '', $fila[$i]["Capacidad_D1"]." / ".$fila[$i]["Capacidad_D2"], 0,0, 0, true, 'C', true);
                $pdf->SetFont('helvetica', '', 7);
                $pdf->writeHTMLCell(18, 0, '', '',$fila[$i]["SO"], 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(12, 0, '', '', $fila[$i]["Office"], 0, 0, 0, true, 'C', true);
                $pdf->writeHTMLCell(30, 0, '', '', $fila[$i]["numero_serie"].'<br>', 0, 1, 0, true, 'L', true);
            break;
            case "laptop":
                $pdf->writeHTMLCell(18, 0, '', '', strtolower($fila[$i]["Procesador"]) , 0,0, 0, true, 'L', true);
                $pdf->writeHTMLCell(10, 0, '', '', $fila[$i]["Generacion"], 0, 0, 0, true, 'C', true);
                $pdf->writeHTMLCell(12, 0, '', '', $fila[$i]["Ram"], 0, 0, 0, true, 'L', true);
                $pdf->SetFont('helvetica', '', 6);
                $pdf->writeHTMLCell(19, 0, '', '', $fila[$i]["Capacidad_D1"]." / ".$fila[$i]["Capacidad_D2"], 0,0, 0, true, 'C', true);
                $pdf->SetFont('helvetica', '', 7);
                $pdf->writeHTMLCell(18, 0, '', '',$fila[$i]["SO"], 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(12, 0, '', '', $fila[$i]["Office"], 0, 0, 0, true, 'C', true);
                $pdf->writeHTMLCell(30, 0, '', '', $fila[$i]["numero_serie"].'<br>', 0, 1, 0, true, 'L', true);
            break;
            case "impresor":
                $pdf->writeHTMLCell(22, 0, '', '', $fila[$i]["TonerN"], 0,0, 0, true, 'L', true);
                $pdf->writeHTMLCell(22, 0, '', '', $fila[$i]["TonerM"], 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(22, 0, '', '', $fila[$i]["TonerC"], 0, 0, 0, true, 'L', true);
                $pdf->writeHTMLCell(22, 0, '', '', $fila[$i]["TonerA"], 0,0, 0, true, 'L', true);
                $pdf->writeHTMLCell(30, 0,'', '', $fila[$i]["numero_serie"].'<br>', 0, 1, 0, true, 'L', true);
            break;
            case "proyector":
                $pdf->writeHTMLCell(20, 0, '', '', $fila[$i]["HorasUso"], 0,0, 0, true, 'C', true);
                $pdf->writeHTMLCell(20, 0, '', '', $fila[$i]["HoraEco"].'<br>', 0, 1, 0, true, 'C', true);
            break;
            default:

            $pdf->writeHTMLCell(0, 0, '', '', '<br><br>', 0, 1, 0, true, 'L', true);

            break;


        }
    }


}

?>
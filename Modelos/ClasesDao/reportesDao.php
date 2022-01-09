<?php
include_once dirname(__DIR__, 1).'/clases/reportesPlantilla.php';
include_once dirname(__DIR__, 1).'/conexion.php';

class ReportesDao
{

    public function __construct()
    {
    }

    //función que solicita los datos de la BD para generar tablas para los reportes
    //recibe el área para filtrar por área
    public function getDataRptActivosArea($area){

        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();
        //obtenemos la maqueta de headers de las tablas para cada tipo de activo
        $tablaPC = $rpt->getHeaderTablaRptPc();
        $tablaLaptop = $rpt->getHeaderTablaRptPc();
        $tablaProyector = $rpt->getHeaderTablaRptProyector();
        $tablaImp = $rpt->getHeaderTablaRptImpresor();

        //establecemos la coneccion
        $con = Conexion::conectar();

        //establecemos la consulta
        $sql="select TOP (100) PERCENT dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo, 
        dbo.Tipo_Activo.tipo_activo_nombre, dbo.Activo.Activo_referencia, dbo.Activo.Activo_descripcion, dbo.Activo.Activo_factura, dbo.Activo.Activo_fecha_adq, dbo.Activo_responsable.Nombre_responsable, dbo.Activo.Estado, 
        dbo.Activo.Activo_eliminado, dbo.Activo_Especificacion.Procesador, dbo.Activo_Especificacion.Generacion, dbo.Activo_Especificacion.Ram, dbo.Activo_Especificacion.DiscoDuro, 
        dbo.Activo_Especificacion.Modelo, dbo.Activo_Especificacion.SO, dbo.Activo_Especificacion.Office, dbo.Activo_Especificacion.IP, dbo.Activo_Especificacion.TonerN, dbo.Activo_Especificacion.TonerM, 
        dbo.Activo_Especificacion.TonerC, dbo.Activo_Especificacion.TonerA, dbo.Activo_Especificacion.HorasUso, dbo.Activo_Especificacion.HoraEco, dbo.Activo.Estructura2_id,
        ISNULL(dbo.Activo.Empresa_id, '') AS codigo_proyecto, ISNULL(dbo.Activo.numero_serie, '') AS numero_serie
         FROM  dbo.Activo INNER JOIN
        dbo.Activo_responsable ON dbo.Activo.Responsable_codigo = dbo.Activo_responsable.Responsable_codigo INNER JOIN
        dbo.Activo_Especificacion ON dbo.Activo.Activo_id = dbo.Activo_Especificacion.Activo_id INNER JOIN
        dbo.Estructura31 ON dbo.Activo.Estructura3_id = dbo.Estructura31.estructura31_id INNER JOIN
        dbo.Tipo_Activo ON dbo.Activo.Activo_tipo = dbo.Tipo_Activo.tipo_activo_id
        where dbo.Estructura31.estructura31_id=?
        ORDER BY dbo.Activo.Estructura2_id";

        //preparamos la consulta
        $respuesta = $con->prepare($sql);

        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$area]);
            //convertimos a un arreglo los datos obtenidos de BD
            $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);
            //recorremos y creamos las respectivas tablas
                for ($i=0; $i <sizeof($fila) ; $i++) { 
                    switch(trim($fila[$i]["tipo_activo_nombre"])){
                        case "PC":
                            //si tipo activo nombre es pc concatenamos valores a tabla pc
                            $tablaPC  .='<tr>'
                            .'<td class="w3">'.$fila[$i]["Activo_id"].'</td>'
                            .'<td class="w15">'.$fila[$i]["Activo_descripcion"].'</td>'
                            .'<td class="w10">'.$fila[$i]["Nombre_responsable"].'</td>'
                            .'<td class="wip">'.$fila[$i]["IP"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Modelo"].'</td>'
                            .'<td class="w">'.$fila[$i]["Procesador"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Generacion"].'</td>'
                            .'<td class="wr">'.$fila[$i]["Ram"].'</td>'
                            .'<td class="w8">'.$fila[$i]["DiscoDuro"].'</td>'
                            .'<td class="wt">'.$fila[$i]["SO"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Office"].'</td>'
                            .'<td class="w8">'.$fila[$i]["numero_serie"].'</td>'
                          .'</tr>';
                
                         
                        break;
                        case "Laptop":
                            //si tipo activo nombre es laptop concatenamos valores a tabla latop
                            $tablaLaptop .='<tr>'
                            .'<td class="w3">'.$fila[$i]["Activo_id"].'</td>'
                            .'<td class="w15">'.$fila[$i]["Activo_descripcion"].'</td>'
                            .'<td class="w10">'.$fila[$i]["Nombre_responsable"].'</td>'
                            .'<td class="wip">'.$fila[$i]["IP"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Modelo"].'</td>'
                            .'<td class="w">'.$fila[$i]["Procesador"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Generacion"].'</td>'
                            .'<td class="wr">'.$fila[$i]["Ram"].'</td>'
                            .'<td class="w8">'.$fila[$i]["DiscoDuro"].'</td>'
                            .'<td class="wt">'.$fila[$i]["SO"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Office"].'</td>'
                            .'<td class="w8">'.$fila[$i]["numero_serie"].'</td>'
                          .'</tr>';
                
                           
                        break;
                        case "Impresor":
                            //si tipo activo nombre es impresora concatenamos valores a tabla impresora
                            $tablaImp .='<tr>'
                            .'<td class="w3">'.$fila[$i]["Activo_id"].'</td>'
                            .'<td class="w15">'.$fila[$i]["Activo_descripcion"].'</td>'
                            .'<td class="w10">'.$fila[$i]["Nombre_responsable"].'</td>'
                            .'<td class="wip">'.$fila[$i]["IP"].'</td>'
                            .'<td class="wip">'.$fila[$i]["Modelo"].'</td>'
                            .'<td class="w8">'.$fila[$i]["TonerN"].'</td>'
                            .'<td class="w8">'.$fila[$i]["TonerM"].'</td>'
                            .'<td class="w8">'.$fila[$i]["TonerC"].'</td>'
                            .'<td class="w8">'.$fila[$i]["TonerA"].'</td>'
                          .'</tr>';
                        break;
                        case "Proyector":
                            //si tipo activo nombre es proyector concatenamos valores a tabla proyector
                            $tablaProyector .='<tr>'
                            .'<td class="w3">'.$fila[$i]["Activo_id"].'</td>'
                            .'<td class="w15">'.$fila[$i]["Activo_descripcion"].'</td>'
                            .'<td class="w10">'.$fila[$i]["Nombre_responsable"].'</td>'
                            .'<td class="wip">'.$fila[$i]["IP"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Modelo"].'</td>'
                            .'<td class="w">'.$fila[$i]["HorasUso"].'</td>'
                            .'<td class="w8">'.$fila[$i]["HoraEco"].'</td>'
                          .'</tr>';
                        break;
                    }

                }


            //cerramos las respectivas tablas de cada tipo
            $tablaImp .="</table>";
            $tablaLaptop.="</table>";
            $tablaPC.="</table>";
            $tablaProyector.="</table>";

            //concatemos cada tabla más la etiqueta style que tiene sus estilos
            $html =$tablaPC.$tablaLaptop.$tablaProyector.$tablaImp.$rpt->getEtiquetaStyleRpt(); 

            //retornamos todas las tablas juntas con estilos para imprimir por tcpdf
            return $html;
            
        }catch(PDOException $error){
            echo $error->getMessage();
        }
     
    }

    public function getDataRptActivosTipo($tipoActivo){
        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();

        //establecemos la coneccion
        $con = Conexion::conectar();

        //establecemos la consulta
        $sql="select TOP (100) PERCENT dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo, 
        dbo.Tipo_Activo.tipo_activo_nombre, dbo.Activo.Activo_referencia, dbo.Activo.Activo_descripcion, dbo.Activo.Activo_factura, dbo.Activo.Activo_fecha_adq, dbo.Activo_responsable.Nombre_responsable, dbo.Activo.Estado, 
        dbo.Activo.Activo_eliminado, dbo.Activo_Especificacion.Procesador, dbo.Activo_Especificacion.Generacion, dbo.Activo_Especificacion.Ram, dbo.Activo_Especificacion.DiscoDuro, 
        dbo.Activo_Especificacion.Modelo, dbo.Activo_Especificacion.SO, dbo.Activo_Especificacion.Office, dbo.Activo_Especificacion.IP, dbo.Activo_Especificacion.TonerN, dbo.Activo_Especificacion.TonerM, 
        dbo.Activo_Especificacion.TonerC, dbo.Activo_Especificacion.TonerA, dbo.Activo_Especificacion.HorasUso, dbo.Activo_Especificacion.HoraEco, dbo.Activo.Estructura2_id,
        ISNULL(dbo.Activo.Empresa_id, '') AS codigo_proyecto, ISNULL(dbo.Activo.numero_serie, '') AS numero_serie
         FROM  dbo.Activo INNER JOIN
        dbo.Activo_responsable ON dbo.Activo.Responsable_codigo = dbo.Activo_responsable.Responsable_codigo INNER JOIN
        dbo.Activo_Especificacion ON dbo.Activo.Activo_id = dbo.Activo_Especificacion.Activo_id INNER JOIN
        dbo.Estructura31 ON dbo.Activo.Estructura3_id = dbo.Estructura31.estructura31_id INNER JOIN
        dbo.Tipo_Activo ON dbo.Activo.Activo_tipo = dbo.Tipo_Activo.tipo_activo_id
        where dbo.Tipo_Activo.tipo_activo_nombre=?
        ORDER BY dbo.Activo.Estructura2_id";

        //preparamos la consulta
        $respuesta = $con->prepare($sql);

        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$tipoActivo]);
            $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);
            //recorremos y creamos las respectivas tablas
                for ($i=0; $i <sizeof($fila) ; $i++) { 
                    switch(trim($fila[$i]["tipo_activo_nombre"])){
                        case "PC":
                            $tabla = $rpt->getHeaderTablaRptPc();
                            $tabla  .='<tr>'
                            .'<td class="w3">'.$fila[$i]["Activo_id"].' '.$fila[$i]["Activo_id"].'</td>'
                            .'<td class="w15">'.$fila[$i]["Activo_descripcion"].'</td>'
                            .'<td class="w10">'.$fila[$i]["Nombre_responsable"].'</td>'
                            .'<td class="wip">'.$fila[$i]["IP"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Modelo"].'</td>'
                            .'<td class="w">'.$fila[$i]["Procesador"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Generacion"].'</td>'
                            .'<td class="wr">'.$fila[$i]["Ram"].'</td>'
                            .'<td class="w8">'.$fila[$i]["DiscoDuro"].'</td>'
                            .'<td class="wt">'.$fila[$i]["SO"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Office"].'</td>'
                            .'<td class="w8">'.$fila[$i]["numero_serie"].'</td>'
                          .'</tr>';
                            $tabla.="</table>";
                         
                        break;
                        case "Laptop":
                            $tabla = $rpt->getHeaderTablaRptPc();
                            $tabla .='<tr>'
                            .'<td class="w3">'.$fila[$i]["Activo_id"].'</td>'
                            .'<td class="w15">'.$fila[$i]["Activo_descripcion"].'</td>'
                            .'<td class="w10">'.$fila[$i]["Nombre_responsable"].'</td>'
                            .'<td class="wip">'.$fila[$i]["IP"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Modelo"].'</td>'
                            .'<td class="w">'.$fila[$i]["Procesador"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Generacion"].'</td>'
                            .'<td class="wr">'.$fila[$i]["Ram"].'</td>'
                            .'<td class="w8">'.$fila[$i]["DiscoDuro"].'</td>'
                            .'<td class="wt">'.$fila[$i]["SO"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Office"].'</td>'
                            .'<td class="w8">'.$fila[$i]["numero_serie"].'</td>'
                          .'</tr>';
                          $tabla.="</table>";
                           
                        break;
                        case "Impresor":
                            $tabla = $rpt->getHeaderTablaRptImpresor();
                            $tabla .='<tr>'
                            .'<td class="w3">'.$fila[$i]["Activo_id"].'</td>'
                            .'<td class="w15">'.$fila[$i]["Activo_descripcion"].'</td>'
                            .'<td class="w10">'.$fila[$i]["Nombre_responsable"].'</td>'
                            .'<td class="wip">'.$fila[$i]["IP"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Modelo"].'</td>'
                            .'<td class="w8">'.$fila[$i]["TonerN"].'</td>'
                            .'<td class="w8">'.$fila[$i]["TonerM"].'</td>'
                            .'<td class="w8">'.$fila[$i]["TonerC"].'</td>'
                            .'<td class="w8">'.$fila[$i]["TonerA"].'</td>'
                          .'</tr>';
                          $tabla .="</table>";
                        break;
                        case "Proyector":
                            $tabla = $rpt->getHeaderTablaRptProyector();
                            $tabla .='<tr>'
                            .'<td class="w3">'.$fila[$i]["Activo_id"].'</td>'
                            .'<td class="w15">'.$fila[$i]["Activo_descripcion"].'</td>'
                            .'<td class="w10">'.$fila[$i]["Nombre_responsable"].'</td>'
                            .'<td class="wip">'.$fila[$i]["IP"].'</td>'
                            .'<td class="w8">'.$fila[$i]["Modelo"].'</td>'
                            .'<td class="w">'.$fila[$i]["HorasUso"].'</td>'
                            .'<td class="w8">'.$fila[$i]["HoraEco"].'</td>'
                          .'</tr>';
                          $tabla.="</table>";
                        break;
                    }

                }            

            //concatemos cada tabla más la etiqueta style que tiene sus estilos
            $html =$tabla.$rpt->getEtiquetaStyleRpt(); 

            //retornamos todas las tablas juntas con estilos para imprimir por tcpdf
            return $html;
        }catch(PDOException $error){
            echo $error->getMessage();
        }

    }

    public function generarReportePdf2($html,$tipoActivo){
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(60);
        $pdf->SetFont("","B",20);
        $pdf->Cell(80,10,"Área: ".$tipoActivo,0,1,"L");
        $pdf->Ln(5);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output();

    }

    public function generarReportePdf($html,$area){
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(60);
        $pdf->SetFont("","B",20);
        $pdf->Cell(80,10,"Área: ".$area,0,1,"L");
        $pdf->Ln(5);
        $pdf->writeHTML($html, true, false, true, false, '');
        var_dump(array(
            "data" => "demo"
        ));
        ob_end_clean();
        $pdf->Output();

    }
}

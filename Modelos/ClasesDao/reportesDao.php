<?php
include_once dirname(__DIR__, 1).'/clases/reportesPlantilla.php';
include_once dirname(__DIR__, 1).'/conexion.php';

class ReportesDao
{

    public function __construct()
    {
    }

/*   -------    INICIAN FUNCIONES PARA SOLICITAR DATOS A LA BASE DE DATOS -------
     -------         SEGÚN LOS FILTROS SELECCIONADOS POR EL USUARIO       -------         */


    //solicita los datos de la BD para generar tablas filtrado por área
    public function getDataRptActivosArea($area){
        //variables auxliares
        $countPC = 0;
        $countLap = 0;
        $countProyec=0;
        $countImp=0;
        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();
        //obtenemos la maqueta de headers de las tablas para cada tipo de activo
        $tablaPC = $rpt->getHeaderTablaRptPc();
        $tablaLaptop = $rpt->getHeaderTablaRptLap();
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
                
                         $countPC++;
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
                
                           $countLap++;
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

                          $countImp++;
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
                          $countProyec++;
                        break;
                    }

                }
            
            //creamos una fila para cuando no hay datos
            $tr='<tr>'
            .'<td colspan="12">No hay datos según los filtros seleccionados</td>'
            .'</tr>';

            //evaluamos en cual tipo de activo no hay datos
            //y concatenamos la fila "no hay datos"
            if($countPC==0 ){
                $tablaPC.=$tr;
            }
            
            if($countLap==0){
                $tablaLaptop.=$tr;
            }

            if($countProyec==0){
                $tablaProyector.=$tr;
            }
            
            
            if($countImp==0){
                $tablaImp .=$tr;
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

    //solicita los datos de la BD para generar tablas filtrado por área y tipo activo
    public function getDataRptTipActArea($area, $tipAct){
        //variables auxliares
        $countPC = 0;
        $countLap = 0;
        $countProyec=0;
        $countImp=0;
        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();
        //obtenemos la maqueta de headers de las tablas para cada tipo de activo
        $tablaPC = $rpt->getHeaderTablaRptPc();
        $tablaLaptop = $rpt->getHeaderTablaRptLap();
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
        FROM dbo.Activo INNER JOIN
        dbo.Activo_responsable ON dbo.Activo.Responsable_codigo = dbo.Activo_responsable.Responsable_codigo INNER JOIN
        dbo.Activo_Especificacion ON dbo.Activo.Activo_id = dbo.Activo_Especificacion.Activo_id INNER JOIN
        dbo.Estructura31 ON dbo.Activo.Estructura3_id = dbo.Estructura31.estructura31_id INNER JOIN
        dbo.Tipo_Activo ON dbo.Activo.Activo_tipo = dbo.Tipo_Activo.tipo_activo_id
        where dbo.Tipo_Activo.tipo_activo_id = ? and dbo.Estructura31.estructura31_id= ?
        ORDER BY dbo.Activo.Estructura2_id";

        //preparamos la consulta
        $respuesta = $con->prepare($sql);

        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$tipAct,$area]);
            //convertimos a un arreglo los datos obtenidos de BD
            $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);


            //evaluamos si hay datos de la consulta
            if(sizeof($fila)==0){
                //si no hay
                //creamos una fila para cuando no hay datos
                $tr='<tr>'
                .'<td colspan="12">No hay datos según los filtros seleccionados</td>'
                .'</tr>';
                
                //evaluamos en cual tipo de activo es seleccionado por usuario
                //concatenamos fila no hay datos + estilos
                //se debe agregar un if o un switch en caso gusten así para evaluar
                //cada tipo activo en BD
                if($tipAct==1 ){
                    $tablaPC.=$tr;
                    $tablaPC.="</table>";
                    $html =$tablaPC.$rpt->getEtiquetaStyleRpt();
                }
                            
                if($tipAct==2){
                    $tablaLaptop.=$tr;
                    $tablaLaptop.="</table>";
                    $html =$tablaLaptop.$rpt->getEtiquetaStyleRpt();
                }
                
                if($tipAct==3){
                    $tablaProyector.=$tr;
                    $tablaProyector.="</table>";
                    $html =$tablaProyector.$rpt->getEtiquetaStyleRpt();
                }
                            
                            
                if($tipAct==4){
                    $tablaImp .=$tr;
                    $tablaImp .="</table>";
                    $html = $tablaImp.$rpt->getEtiquetaStyleRpt();
                }

                return $html;
            }else{
                //si los hay
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
                
                         $countPC++;
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
                
                           $countLap++;
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

                          $countImp++;
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
                          $countProyec++;
                        break;
                    }

                }
            
            //cerramos las respectivas tablas de cada tipo
            $tablaImp .="</table>";
            $tablaLaptop.="</table>";
            $tablaPC.="</table>";
            $tablaProyector.="</table>";

            $html ="";

            //evaluamos en cual tipo de activo  hay datos
            //y concatenamos la tabla con dato y el estilo para retornarlo junto"
            if($countPC>0 ){
                $html =$tablaPC.$rpt->getEtiquetaStyleRpt(); 
            }
            
            if($countLap>0){
                $html =$tablaLaptop.$rpt->getEtiquetaStyleRpt(); 
            }

            if($countProyec>0){
                $html =$tablaProyector.$rpt->getEtiquetaStyleRpt(); 
            }
            
            
            if($countImp>0){
                $html =$tablaImp.$rpt->getEtiquetaStyleRpt(); 
            }

            //retornamos todas las tablas juntas con estilos para imprimir por tcpdf
            return $html;
            }

        }catch(PDOException $error){
            echo $error->getMessage();
        }
     
    }

    //FUNCION QUE CUENTA LA CANTIDAD TOTAL DE TIPO DE ACTIVO SELECICONADO
    public function contTotalTipAct($tipoActivo){
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="SELECT count(*) as cantidad from activo where Activo_tipo = ?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{

            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$tipoActivo]);
            //retornamos la cantidad de registro con el correo ingresado
            //solo puede ser 1 si hay o 0 si no hay
            return $respuesta->fetchColumn();

        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }

    //solicita los datos de la BD para generar tablas filtrado por tipo activo
    public function getDataRptActivosTipo($tipoActivo){
        //variables auxliares
        $countPC = 0;
        $countLap = 0;
        $countProyec=0;
        $countImp=0;
        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();
        //obtenemos la maqueta de headers de las tablas para cada tipo de activo
        $tablaPC = $rpt->getHeaderTablaRptPc();
        $tablaLaptop = $rpt->getHeaderTablaRptLap();
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
        where dbo.Tipo_Activo.tipo_activo_id=?
        ORDER BY dbo.Activo.Estructura2_id";

        //preparamos la consulta
        $respuesta = $con->prepare($sql);

        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$tipoActivo]);
            //convertimos a un arreglo los datos obtenidos de BD
            $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);

            if(sizeof($fila)==0){
                //si no hay
                //creamos una fila para cuando no hay datos
                $tr='<tr>'
                .'<td colspan="12">No hay datos según los filtros seleccionados</td>'
                .'</tr>';
               
                //evaluamos en cual tipo de activo es seleccionado por usuario
                //concatenamos fila no hay datos + estilos
                //se debe agregar un if o un switch en caso gusten así para evaluar
                //cada tipo activo en BD
                if($tipoActivo==1 ){
                    $tablaPC.=$tr;
                    $tablaPC.="</table>";
                    $html =$tablaPC.$rpt->getEtiquetaStyleRpt();
                }
                           
                if($tipoActivo==2){
                    $tablaLaptop.=$tr;
                    $tablaLaptop.="</table>";
                    $html =$tablaLaptop.$rpt->getEtiquetaStyleRpt();
                }
               
                if($tipoActivo==3){
                    $tablaProyector.=$tr;
                    $tablaProyector.="</table>";
                    $html =$tablaProyector.$rpt->getEtiquetaStyleRpt();
                }
                           
                           
                if($tipoActivo==4){
                    $tablaImp .=$tr;
                    $tablaImp .="</table>";
                    $html = $tablaImp.$rpt->getEtiquetaStyleRpt();
                }
                return $html;
            }
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
                
                         $countPC++;
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
                
                           $countLap++;
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

                          $countImp++;
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
                          $countProyec++;
                        break;
                    }

                }
            
            //cerramos las respectivas tablas de cada tipo
            $tablaImp .="</table>";
            $tablaLaptop.="</table>";
            $tablaPC.="</table>";
            $tablaProyector.="</table>";

            $html ="";
            //evaluamos en cual tipo de activo no hay datos
            //y concatenamos la fila "no hay datos"
            if($countPC>0 ){
                $html =$tablaPC.$rpt->getEtiquetaStyleRpt(); 
            }
            
            if($countLap>0){
                $html =$tablaLaptop.$rpt->getEtiquetaStyleRpt(); 
            }

            if($countProyec>0){
                $html =$tablaProyector.$rpt->getEtiquetaStyleRpt(); 
            }
            
            
            if($countImp>0){
                $html =$tablaImp.$rpt->getEtiquetaStyleRpt(); 
            }

            //retornamos todas las tablas juntas con estilos para imprimir por tcpdf
            return $html;
            
        }catch(PDOException $error){
            echo $error->getMessage();
        }

    }












    /*   ------- INICIAN FUNCIONES PARA GENERAR LOS REPORTES QUE SE IMPRIMEN EN EL NAVEGADOR -------
     -------         SEGÚN LOS DATOS GENERADOS DE LA BD      -------         */


     //genera reporte <<activo>> filtrado solamente por <<tipo activo>>
    public function generarRptPdfTipAct($html,$tipoActivo,$cantActivo){
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(60);
        $pdf->SetFont("","B",20);
        $pdf->Cell(80,10,"Tipo De Activo: ".$tipoActivo,0,0,"L");
        $pdf->Cell(196,10,"Cantidad: ".$cantActivo,0,1,"R");
        $pdf->Ln(5);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output();

    }


    //genera reporte de <<activo>> filtrado por <<área>> y <<tipo activo>>
    public function generarRptPdfActArea($html,$area){
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(60);
        $pdf->SetFont("","B",20);
        $pdf->Cell(80,10,"Área: ".$area,0,1,"L");
        $pdf->Ln(5);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output();

    }

    //genera reporte de <<activo>> 
    public function generarRptPdf($html,$area){
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(60);
        $pdf->SetFont("","B",20);
        $pdf->Cell(80,10,"Área: ".$area,0,1,"L");
        $pdf->Ln(5);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output();
    
    }
}

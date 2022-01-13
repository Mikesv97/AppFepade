<?php
include_once dirname(__DIR__, 1) . '/clases/reportesPlantilla.php';
include_once dirname(__DIR__, 1) . '/conexion.php';
include_once "tipoActivoDao.php";

class ReportesDao
{

    public function __construct()
    {
    }

    /*   -------    INICIAN FUNCIONES PARA SOLICITAR DATOS A LA BASE DE DATOS -------
     -------         SEGÚN LOS FILTROS SELECCIONADOS POR EL USUARIO       -------         */


    //solicita los datos de la BD para generar tablas filtrado por área
    //retorna el hmtl para la función que genera el reporte
    public function getDataRptActivosArea($area, $boolean, $num)
    {
        //si boolean es falso ocupamos las cabeceras normales con IP de las tablas
        //si es verdadero ocupamos las cabeceras sin IP
        
        //variables auxliares
        $countPC = 0;
        $countLap = 0;
        $countProyec = 0;
        $countImp = 0;
        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();
        //obtenemos la maqueta de headers de las tablas para cada tipo de activo
        $tablaPC = $rpt->getHeaderTablaRptPc($boolean);
        $tablaLaptop = $rpt->getHeaderTablaRptLap($boolean);
        $tablaProyector = $rpt->getHeaderTablaRptProyector($boolean);
        $tablaImp = $rpt->getHeaderTablaRptImpresor($num);

        //establecemos la coneccion
        $con = Conexion::conectar();

        //establecemos la consulta
        $sql = "select TOP (100) PERCENT dbo.Activo_Especificacion.DiscoDuro2,dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo, 
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

        try {
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$area]);
            //convertimos a un arreglo los datos obtenidos de BD
            $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);
            //recorremos y creamos las respectivas tablas
            for ($i = 0; $i < sizeof($fila); $i++) {
                switch (trim($fila[$i]["tipo_activo_nombre"])) {
                    case "PC":
                        //si tipo activo nombre es pc concatenamos valores a tabla pc
                        if($boolean){
                            $tablaPC  .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w7 center">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $fila[$i]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $fila[$i]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["DiscoDuro"] .
                            "<br>".$fila[$i]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $fila[$i]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Office"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["numero_serie"] . '</td>'
                            . '</tr>';
                        }else{
                            $tablaPC  .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7 center">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $fila[$i]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $fila[$i]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["DiscoDuro"] .
                            "<br>".$fila[$i]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $fila[$i]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Office"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["numero_serie"] . '</td>'
                            . '</tr>';
                        }

                        $countPC++;
                        break;
                    case "Laptop":
                        //si tipo activo nombre es laptop concatenamos valores a tabla latop
                        if($boolean){
                            $tablaLaptop .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w7 center">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $fila[$i]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $fila[$i]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["DiscoDuro"] .
                            "<br>".$fila[$i]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $fila[$i]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Office"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["numero_serie"] . '</td>'
                            . '</tr>';
                        }else{
                            $tablaLaptop .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7 center">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $fila[$i]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $fila[$i]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["DiscoDuro"] .
                            "<br>".$fila[$i]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $fila[$i]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Office"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["numero_serie"] . '</td>'
                            . '</tr>';
                        }

                        $countLap++;
                        break;
                    case "Impresor":
                        //si tipo activo nombre es impresora concatenamos valores a tabla impresora
                        if($boolean){
                            $tablaImp .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w7">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerN"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerM"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerC"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerA"] . '</td>'
                            . '</tr>';
                        }else{
                            $tablaImp .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerN"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerM"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerC"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerA"] . '</td>'
                            . '</tr>';
                        }

                        $countImp++;
                        break;
                    case "Proyector":
                        //si tipo activo nombre es proyector concatenamos valores a tabla proyector
                        if($boolean){
                            $tablaProyector .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w7">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="7-5">' . $fila[$i]["HorasUso"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["HoraEco"] . '</td>'
                            . '</tr>';
                        }else{
                            $tablaProyector .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["HorasUso"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["HoraEco"] . '</td>'
                            . '</tr>';
                        }
                        $countProyec++;
                        break;
                }
            }

            //cerramos las respectivas tablas de cada tipo
            $tablaImp .= "</table>";
            $tablaLaptop .= "</table>";
            $tablaPC .= "</table>";
            $tablaProyector .= "</table>";
            $html = "";

            //evaluamos en cual tipo de activo no hay datos
            //y concatenamos la fila "no hay datos"
            if ($countPC > 0) {
                //concatemos cada tabla más la etiqueta style que tiene sus estilos
                $html .= $tablaPC;
            }

            if ($countLap > 0) {
                //concatemos cada tabla más la etiqueta style que tiene sus estilos
                $html .= $tablaLaptop;
            }

            if ($countProyec > 0) {
                //concatemos cada tabla más la etiqueta style que tiene sus estilos
                $html .= $tablaProyector;
            }


            if ($countImp > 0) {
                //concatemos cada tabla más la etiqueta style que tiene sus estilos
                $html .= $tablaImp;
            }

            //retornamos todas las tablas juntas con estilos para imprimir por tcpdf
            return $html . $rpt->getEtiquetaStyleRpt();
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    //solicita los datos de la BD para generar tablas filtrado por área y tipo activo
    //retorna el hmtl para la función que genera el reporte
    public function getDataRptTipActArea($area, $tipAct)
    {
        //variables auxliares
        $countPC = 0;
        $countLap = 0;
        $countProyec = 0;
        $countImp = 0;
        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();
        //obtenemos la maqueta de headers de las tablas para cada tipo de activo
        $tablaPC = $rpt->getHeaderTablaRptPc(false);
        $tablaLaptop = $rpt->getHeaderTablaRptLap(false);
        $tablaProyector = $rpt->getHeaderTablaRptProyector(false);
        $tablaImp = $rpt->getHeaderTablaRptImpresor(1);

        //establecemos la coneccion
        $con = Conexion::conectar();

        //establecemos la consulta
        $sql = "select TOP (100) PERCENT dbo.Activo_Especificacion.DiscoDuro2, dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo,
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

        try {
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$tipAct, $area]);
            //convertimos a un arreglo los datos obtenidos de BD
            $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);

            //si los hay
            //recorremos y creamos las respectivas tablas
            for ($i = 0; $i < sizeof($fila); $i++) {
                switch (trim($fila[$i]["tipo_activo_nombre"])) {
                    case "PC":
                        //si tipo activo nombre es pc concatenamos valores a tabla pc
                        $tablaPC  .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7 center">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $fila[$i]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $fila[$i]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["DiscoDuro"] .
                            "<br>".$fila[$i]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $fila[$i]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Office"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["numero_serie"] . '</td>'
                            . '</tr>';

                        $countPC++;
                        break;
                    case "Laptop":
                        //si tipo activo nombre es laptop concatenamos valores a tabla latop
                        $tablaLaptop .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7 center">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $fila[$i]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $fila[$i]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["DiscoDuro"] .
                            "<br>".$fila[$i]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $fila[$i]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Office"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["numero_serie"] . '</td>'
                            . '</tr>';

                        $countLap++;
                        break;
                    case "Impresor":
                        //si tipo activo nombre es impresora concatenamos valores a tabla impresora
                        $tablaImp .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerN"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerM"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerC"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerA"] . '</td>'
                            . '</tr>';

                        $countImp++;
                        break;
                    case "Proyector":
                        //si tipo activo nombre es proyector concatenamos valores a tabla proyector
                        $tablaProyector .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["HorasUso"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["HoraEco"] . '</td>'
                            . '</tr>';
                        $countProyec++;
                        break;
                }
            }

            //cerramos las respectivas tablas de cada tipo
            $tablaImp .= "</table>";
            $tablaLaptop .= "</table>";
            $tablaPC .= "</table>";
            $tablaProyector .= "</table>";

            $html = "";

            //evaluamos en cual tipo de activo  hay datos
            //y concatenamos la tabla con dato y el estilo para retornarlo junto"
            if ($countPC > 0) {
                $html = $tablaPC . $rpt->getEtiquetaStyleRpt();
            }

            if ($countLap > 0) {
                $html = $tablaLaptop . $rpt->getEtiquetaStyleRpt();
            }

            if ($countProyec > 0) {
                $html = $tablaProyector . $rpt->getEtiquetaStyleRpt();
            }


            if ($countImp > 0) {
                $html = $tablaImp . $rpt->getEtiquetaStyleRpt();
            }

            //retornamos todas las tablas juntas con estilos para imprimir por tcpdf
            return $html;
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    //FUNCION QUE CUENTA LA CANTIDAD TOTAL DE TIPO DE ACTIVO SELECICONADO
    //retorna el hmtl para la función que genera el reporte
    public function contTotalTipAct($tipoActivo)
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

    //solicita los datos de la BD para generar tablas filtrado por tipo activo
    //retorna el hmtl para la función que genera el reporte
    public function getDataRptActivosTipo($tipoActivo)
    {
        //variables auxliares
        $countPC = 0;
        $countLap = 0;
        $countProyec = 0;
        $countImp = 0;
        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();
        //obtenemos la maqueta de headers de las tablas para cada tipo de activo
        $tablaPC = $rpt->getHeaderTablaRptPc(false);
        $tablaLaptop = $rpt->getHeaderTablaRptLap(false);
        $tablaProyector = $rpt->getHeaderTablaRptProyector(false);
        $tablaImp = $rpt->getHeaderTablaRptImpresor(1);

        //establecemos la coneccion
        $con = Conexion::conectar();

        //establecemos la consulta
        $sql = "select TOP (100) PERCENT dbo.Activo_Especificacion.DiscoDuro2, dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo, 
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

        try {
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$tipoActivo]);
            //convertimos a un arreglo los datos obtenidos de BD
            $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);
            //recorremos y creamos las respectivas tablas
            for ($i = 0; $i < sizeof($fila); $i++) {
                switch (trim($fila[$i]["tipo_activo_nombre"])) {
                    case "PC":
                        //si tipo activo nombre es pc concatenamos valores a tabla pc
                        $tablaPC  .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7 center">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $fila[$i]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $fila[$i]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["DiscoDuro"] .
                            "<br>".$fila[$i]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $fila[$i]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Office"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["numero_serie"] . '</td>'
                            . '</tr>';

                        $countPC++;
                        break;
                    case "Laptop":
                        //si tipo activo nombre es laptop concatenamos valores a tabla latop
                        $tablaLaptop .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7 center">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $fila[$i]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $fila[$i]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["DiscoDuro"] .
                            "<br>".$fila[$i]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $fila[$i]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $fila[$i]["Office"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["numero_serie"] . '</td>'
                            . '</tr>';

                        $countLap++;
                        break;
                    case "Impresor":
                        //si tipo activo nombre es impresora concatenamos valores a tabla impresora
                        $tablaImp .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerN"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerM"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerC"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["TonerA"] . '</td>'
                            . '</tr>';

                        $countImp++;
                        break;
                    case "Proyector":
                        //si tipo activo nombre es proyector concatenamos valores a tabla proyector
                        $tablaProyector .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["IP"] . '</td>'
                            . '<td class="w7">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["HorasUso"] . '</td>'
                            . '<td class="w7-5">' . $fila[$i]["HoraEco"] . '</td>'
                            . '</tr>';
                        $countProyec++;
                        break;
                }
            }

            //cerramos las respectivas tablas de cada tipo
            $tablaImp .= "</table>";
            $tablaLaptop .= "</table>";
            $tablaPC .= "</table>";
            $tablaProyector .= "</table>";

            $html = "";
            //evaluamos en cual tipo de activo no hay datos
            //y concatenamos la fila "no hay datos"
            if ($countPC > 0) {
                $html = $tablaPC . $rpt->getEtiquetaStyleRpt();
            }

            if ($countLap > 0) {
                $html = $tablaLaptop . $rpt->getEtiquetaStyleRpt();
            }

            if ($countProyec > 0) {
                $html = $tablaProyector . $rpt->getEtiquetaStyleRpt();
            }


            if ($countImp > 0) {
                $html = $tablaImp . $rpt->getEtiquetaStyleRpt();
            }

            //retornamos todas las tablas juntas con estilos para imprimir por tcpdf
            return $html;
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    //genera la estructura de html para retornarla y pasarla a la función que
    //genera el reporte
    public function getDataRptResTipAct()
    {
        //creamos objeto tipo activo dao para acceder a la función que cuenta
        //cuantos activos hay según el ID pasado como parametos
        $objTA = new TipoActivoDao();
        //llamamos la funcion para contar cuantos hay del tipo ID 1-->PC
        $totalPc = $objTA->countTipActivo(1);
        //llamamos la funcion para contar cuantos hay del tipo ID 2-->Laptop
        $totalLap = $objTA->countTipActivo(2);
        //llamamos la funcion para contar cuantos hay del tipo ID 3-->Impresor
        $totalImp = $objTA->countTipActivo(3);
        //llamamos la funcion para contar cuantos hay del tipo ID 4-->Proyector
        $totalPro = $objTA->countTipActivo(4);

        //preparamos el html para retornarlo
        $html = '
        <table  style="width:100%">
            <tr>
                <td class="noBorder" style="width:25%"></td>
                <td class="noBorder" style="width:50%">
                    <!--INICIO TABLA-->
                    <table class="tblResumen"  align="center" border="1">
                        <tr>
                            <th>Tipo activo</th>
                            <th>Cantidad</th>
                        </tr>
                        <tr>
                            <td>PC</td>
                            <td>' . $totalPc . '</td>
                        </tr>
                        <tr>
                            <td>Laptop</td>
                            <td>' . $totalLap . '</td>
                        </tr>
                        <tr>
                            <td>Impresor</td>
                            <td>' . $totalImp . '</td>
                        </tr>
                        <tr>
                            <td>Proyector</td>
                            <td>' . $totalPro . '</td>
                        </tr>
                        <tr>
                            <td class="bgDark">Total</td>
                            <td class="bgDark">' . ($totalPc + $totalLap + $totalImp + $totalPro) . '</td>
                        </tr>
                    </table>
                    <!--FIN TABLA-->
                </td>
                <td class="noBorder" style="width:25%"></td>
            </tr>
        </table>';




        //retornamos html con estilos
        $rpt = new ReportesPlantilla();
        return $html . $rpt->getEtiquetaStyleRpt();
    }

    //solicita los datos de la BD para generar tablas filtrado por impresora
    //retorna el hmtl para la función que genera el reporte
    public function getDataRptTipoActivoImp()
    {
        $tipoActivoD = new tipoActivoDao();
        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();
        //obtenemos la maqueta de headers de las tablas para cada tipo de activo
        $tablaImp = $rpt->getHeaderTablaRptImpresor(0);

        //establecemos la coneccion
        $con = Conexion::conectar();

        //establecemos la consulta
        $sql = "select count(b.Modelo) as cantidadModelo,modelo , b.TonerN, b.TonerM, b.TonerC, b.TonerA FROM Activo a
        INNER JOIN Activo_Especificacion b ON a.Activo_id = b.Activo_id WHERE Activo_tipo = ?
        group by b.TonerN, b.TonerM, b.TonerC, b.TonerA,Modelo
        order by tonern,modelo";

        //preparamos la consulta
        $respuesta = $con->prepare($sql);

        try {
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([3]);
            //convertimos a un arreglo los datos obtenidos de BD
            $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);
            //recorremos y creamos las respectivas tablas
            for ($i = 0; $i < sizeof($fila); $i++) {

                $tablaImp .= '<tr>'
                    . '<td class="w6">' . ($i+1) . '</td>'
                    . '<td class="w15">' . $fila[$i]["modelo"] . '</td>'
                    . '<td class="w6 center">' . $fila[$i]["cantidadModelo"] . '</td>'
                    . '<td class="w7-5 center">' . $fila[$i]["TonerN"] . '</td>'
                    . '<td class="w7-5 center">' . $fila[$i]["TonerM"] . '</td>'
                    . '<td class="w7-5 center">' . $fila[$i]["TonerC"] . '</td>'
                    . '<td class="w7-5 center">' . $fila[$i]["TonerA"] . '</td>'
                    . '</tr>';
            }
            //cerramos las respectivas tablas de cada tipo
            $tablaImp .= "</table>";

            //concatemos cada tabla más la etiqueta style que tiene sus estilos
            $html = $tablaImp . $rpt->getEtiquetaStyleRpt();

            //retornamos todas las tablas juntas con estilos para imprimir por tcpdf
            return $html;
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    //solicita los datos de la BD para generar tablas filtrado por área y tipo activo
    //retorna el hmtl para la función que genera el reporte
    public function getDataRptMantenimiento($area)
    {
        $tblaCount=0;
        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();
        //obtenemos la maqueta de headers de las tablas para cada tipo de activo
        $tabla = $rpt->getHeaderTablaMantenimiento();
        //establecemos la coneccion
        $con = Conexion::conectar();

        //establecemos la consulta
        $sql = "select TOP (100) PERCENT dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo,
        dbo.Tipo_Activo.tipo_activo_nombre, dbo.Activo.Activo_referencia, dbo.Activo.Activo_descripcion, dbo.Activo.Activo_factura, dbo.Activo.Activo_fecha_adq, dbo.Activo_responsable.Nombre_responsable, dbo.Activo.Estado,
        dbo.Activo.Activo_eliminado, dbo.Activo_Especificacion.Procesador, dbo.Activo_Especificacion.Generacion, dbo.Activo_Especificacion.Ram, dbo.Activo_Especificacion.DiscoDuro, dbo.Activo_Especificacion.Capacidad_D1,
		dbo.Activo_Especificacion.DiscoDuro2,dbo.Activo_Especificacion.Capacidad_D2, dbo.Activo_Especificacion.Modelo, dbo.Activo_Especificacion.SO, dbo.Activo_Especificacion.Office, dbo.Activo_Especificacion.IP, dbo.Activo_Especificacion.TonerN, dbo.Activo_Especificacion.TonerM,
        dbo.Activo_Especificacion.TonerC, dbo.Activo_Especificacion.TonerA, dbo.Activo_Especificacion.HorasUso, dbo.Activo_Especificacion.HoraEco, dbo.Activo.Estructura2_id,
        ISNULL(dbo.Activo.Empresa_id, '') AS codigo_proyecto, ISNULL(dbo.Activo.numero_serie, '') AS numero_serie
        FROM dbo.Activo INNER JOIN
        dbo.Activo_responsable ON dbo.Activo.Responsable_codigo = dbo.Activo_responsable.Responsable_codigo INNER JOIN
        dbo.Activo_Especificacion ON dbo.Activo.Activo_id = dbo.Activo_Especificacion.Activo_id INNER JOIN
        dbo.Estructura31 ON dbo.Activo.Estructura3_id = dbo.Estructura31.estructura31_id INNER JOIN
        dbo.Tipo_Activo ON dbo.Activo.Activo_tipo = dbo.Tipo_Activo.tipo_activo_id
        where dbo.Estructura31.estructura31_id= ? 
        ORDER BY dbo.Tipo_Activo.tipo_activo_id";

        //preparamos la consulta
        $respuesta = $con->prepare($sql);

        try {
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$area]);
            //convertimos a un arreglo los datos obtenidos de BD
            $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);

            //si los hay
            //recorremos y creamos las respectivas tablas
            for ($i = 0; $i < sizeof($fila); $i++) {

                $activo = trim($fila[$i]["tipo_activo_nombre"]);

                if($activo == "Impresor" || $activo == "Proyector"){
                    $tabla .= 
                    '<tr>'
                        . '<td class="w7"><br><br>' . ($i+1)." ".$fila[$i]["numero_serie"]. '</td>'
                        . '<td class="w15"><br><br>'.$fila[$i]["tipo_activo_nombre"] ." ". $fila[$i]["Modelo"] . '</td>'
                        . '<td class="w6 center"><br><br>N/A</td>'
                        . '<td class="w9 center"><br><br>N/A</td>'
                        . '<td class="w9 center"><br><br>N/A</td>'
                        . '<td class="w9 center"></td>'
                        . '<td class="w7-5 center"></td>'
                        . '<td class="w7-5 center"></td>'
                        . '<td class="w30"><br><br><br><br></td>'
                        . '</tr>';
                }else{
                    $tabla .= 
                    '<tr>'
                        . '<td class="w7"><br><br>' . ($i+1)." ".$fila[$i]["numero_serie"]. '</td>'
                        . '<td class="w15"><br><br>'.$fila[$i]["tipo_activo_nombre"] ." " . $fila[$i]["Modelo"] . '</td>'
                        . '<td class="w6 center"><br><br>' . $fila[$i]["Procesador"]." G.".$fila[$i]["Generacion"] . '</td>'
                        . '<td class="w9 center"><br><br>' ."RAM ". $fila[$i]["Ram"] . '</td>'
                        . '<td class="w9 center"><br><br>' .$fila[$i]["DiscoDuro"]." ".$fila[$i]["Capacidad_D1"]
                        ." <br>".$fila[$i]["DiscoDuro2"]." ".$fila[$i]["Capacidad_D2"]. '</td>'
                        . '<td class="w9"></td>'
                        . '<td class="w7-5"></td>'
                        . '<td class="w7-5"></td>'
                        . '<td class="w30"><br><br><br><br></td>'
                        . '</tr>';
                }
                $tblaCount++;
                
            }

            //cerramos las respectivas tablas de cada tipo
            $tabla.= "</table>";

            $html = "";

            //evaluamos en cual tipo de activo  hay datos
            //y concatenamos la tabla con dato y el estilo para retornarlo junto"
            if ($tblaCount> 0) {
                $html = $tabla. $rpt->getEtiquetaStyleRpt();
            }

            //retornamos todas las tablas juntas con estilos para imprimir por tcpdf
            return $html;
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }











    /*   ------- INICIAN FUNCIONES PARA GENERAR LOS REPORTES QUE SE IMPRIMEN EN EL NAVEGADOR -------
     -------         SEGÚN LOS DATOS GENERADOS DE LA BD      -------         */


    //genera reporte <<activo>> filtrado solamente por <<tipo activo>>
    public function generarRptPdfTipAct($html, $tipoActivo, $cantActivo)
    {
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(38);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(80, 10, "Tipo De Activo: " . $tipoActivo, 0, 0, "L");
        $pdf->Cell(196, 10, "Cantidad: " . $cantActivo, 0, 1, "R");
        $pdf->Ln(3);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output();
    }


    //genera reporte de <<activo>> filtrado por <<área>> y <<tipo activo>>
    public function generarRptPdfActArea($html, $area)
    {
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(35);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(80, 10, "Área: " . $area, 0, 1, "L");
        $pdf->Ln(5);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output();
    }

    //genera reporte de <<resumen de activos>> 
    public function generarRptPdfResTipAct($html)
    {
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Ln(30);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output();
    }

    //genera reporte de <<impresora y toners>> 
    public function generarRptPdfResImpToner($html)
    {
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(29);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 15, 'DETALLE DE IMPRESORES', 0, 1,"C");
        $pdf->Ln(5);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output();
    }

        //genera reporte de <<mantenimiento>> 
        public function generarRptPdfMantenimiento($html, $areaNombre)
        {
            $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
            $pdf->AddPage();
            $pdf->Ln(40);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(0, 5, 'Mantenimiento Preventivo de Recursos de TI', 0, 1,"L");
            $pdf->Cell(0, 3, 'Departamento: '.$areaNombre, 0, 1,"L");
            $pdf->Ln(5);
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output();
        }
}

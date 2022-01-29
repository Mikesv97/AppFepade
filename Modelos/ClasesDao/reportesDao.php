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

    //solicita los datos de la BD para generar tablas según tipo activo y áreas
    public function getDataRptTipActAreaTodas($tipoActivo, $area, $bandGte,$mantenimiento)
    {
        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();

        if($mantenimiento){

            //obtenemos la maqueta de headers de las tablas para cada tipo de activo
            $tablaPC = $rpt->getHeaderTablaMantenimiento();
            $tablaLaptop =$rpt->getHeaderTablaMantenimiento();
            $tablaProyector = $rpt->getHeaderTablaMantenimiento();
            $tablaImp = $rpt->getHeaderTablaMantenimiento();
            $tablaTel = $rpt->getHeaderTablaMantenimiento();
            $tablaMonitor = $rpt->getHeaderTablaMantenimiento(); 
            $estiloTbl = $rpt->getEtiquetaStyleRpt();

        }else{

            //obtenemos la maqueta de headers de las tablas para cada tipo de activo
            $tablaPC = $rpt->getHeaderTablaRptPc($bandGte);
            $tablaLaptop = $rpt->getHeaderTablaRptLap($bandGte);
            $tablaProyector = $rpt->getHeaderTablaRptProyector($bandGte);

            if($bandGte){
                $tablaImp = $rpt->getHeaderTablaRptImpresor(2);
            }else{
                $tablaImp = $rpt->getHeaderTablaRptImpresor(1);
            }

            $tablaTel = $rpt->getHeaderTablaRptTelefono($bandGte);
            $tablaMonitor = $rpt->getHeaderTablaRptMonitor();
            $estiloTbl = $rpt->getEtiquetaStyleRpt();
        }


        //obtenemos la maqueta de headers de las tablas para cada tipo de activo
        //para reporte mantenimiento
        $htmlManAdmon = "";
        $htmlManNula = "";
        $htmlManCampLi = "";
        $htmlManCapa = "";
        $htmlManCompe = "";
        $htmlManComuni = "";

        //creamos variable para manejar la respuesta
        $respuesta ="";

        //creamos variable auxiliares para área admon
        $admonPc =  $tablaPC;
        $admonLap = $tablaLaptop;
        $admonImp = $tablaImp;
        $admonPro = $tablaProyector;
        $admonTel = $tablaTel;
        $admonMoni = $tablaMonitor;

        $contAdmonPc=0;
        $contAdmonLap=0;
        $contAdmonImp=0;
        $contAdmonPro=0;
        $contAdmonTel =0;
        $contAdmonMoni = 0;

        //creamos variables auxiliares para área nula
        $nulaPc =$tablaPC;
        $nulaLap =$tablaLaptop;
        $nulaImp =$tablaImp;
        $nulaPro =$tablaProyector; 
        $nulaTel = $tablaTel;
        $nulaMoni = $tablaMonitor;

        $contNulaPc=0;
        $contNulaLap=0;
        $contNulaImp=0;
        $contNulaPro=0;
        $contNulaTel=0;
        $contNulaMoni=0;

        //creamos variables auxiliares para área campaña libro
        $campaPc =$tablaPC;
        $campaLap =$tablaLaptop;
        $campaImp =$tablaImp;
        $campaPro =$tablaProyector;
        $campaTel = $tablaTel;
        $campaMoni = $tablaMonitor;
        
        $contCampaPc=0;
        $contCampaLap=0;
        $contCampaImp=0;
        $contCampaPro=0;
        $contCampaTel =0;
        $contCampaMoni=0;

        //creamos variables auxiliares para área capacitación
        $capaPc =$tablaPC;
        $capaLap =$tablaLaptop;
        $capaImp =$tablaImp;
        $capaPro =$tablaProyector;
        $capaTel = $tablaTel;
        $capaMoni = $tablaMonitor;

        $contCapaPc=0;
        $contCapaLap=0;
        $contCapaImp=0;
        $contCapaPro=0;
        $contCapaTel =0;
        $contCapaMoni=0;

       //creamos variables auxiliares para área competencias
        $compePc =$tablaPC;
        $compeLap =$tablaLaptop;
        $compeImp =$tablaImp;
        $compePro =$tablaProyector;  
        $compeTel = $tablaTel;
        $compeMoni = $tablaMonitor;

        $contCompePc=0;
        $contCompeLap=0;
        $contCompeImp=0;
        $contCompePro=0;
        $contCompeTel =0;
        $contCompeMoni=0;

        //creamos variables auxiliares para área comunicaciones
        $comuniPc =$tablaPC;      
        $comuniLap =$tablaLaptop;
        $comuniImp =$tablaImp;
        $comuniPro =$tablaProyector;
        $comuniTel = $tablaTel;
        $comuniMoni = $tablaMonitor;

        $contComuniPc=0;
        $contComuniLap=0;
        $contComuniImp=0;
        $contComuniPro=0;
        $contComuniTel =0;
        $contComuniMoni =0;

        //creamos variables auxiliares para crear el array
        $htmlAdmon = "";
        $htmlNula ="";
        $htmlCampLi ="";
        $htmlCapa ="";
        $htmlCompe = "";
        $htmlComuni = "";

        //establecemos la coneccion
        $con = Conexion::conectar();

        $sql ="";
        if($tipoActivo == 0 && $area == 100){
            //establecemos la consulta
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
            ORDER BY dbo.Estructura31.estructura31_nombre";

            //ejecutamos la consulta
            $respuesta = $con->query($sql);
        }

        if($tipoActivo != 0 && $area==100){
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
            where tipo_activo_id = ?
            ORDER BY dbo.Estructura31.estructura31_nombre";

            //preparamos consulta
            $respuesta = $con->prepare($sql);
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$tipoActivo]);
        }

        if($tipoActivo !=0 && $area != 100){
            $sql= "select dbo.Activo_Especificacion.DiscoDuro2, dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo,
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

            //preparamos consulta
            $respuesta = $con->prepare($sql);
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$tipoActivo, $area]);
        }        

        if($tipoActivo == 0 && $area!=100){
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
            ORDER BY dbo.Tipo_Activo.tipo_activo_nombre";

            //preparamos consulta
            $respuesta = $con->prepare($sql);
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$area]);
        }

        try {
            //convertimos a un arreglo los datos obtenidos de BD
            $fila =  $respuesta->fetchAll(PDO::FETCH_ASSOC);

            //si los hay
            //recorremos y creamos las respectivas tablas
            for ($i = 0; $i < sizeof($fila); $i++) {
                $area = trim($fila[$i]["estructura31_nombre"]);
                switch (strtolower($area)) {
                    case "administracion":
                        $tipo  = trim($fila[$i]["tipo_activo_nombre"]);

                        if(strtolower($tipo) == "pc"){
                            $admonPc .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contAdmonPc++;
                                    
                        }

                        if(strtolower($tipo) == "laptop"){
                            $admonLap .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contAdmonLap++;
                        }

                        if(strtolower($tipo) == "impresor"){
                            $admonImp .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contAdmonImp++;
                        }

                        if(strtolower($tipo) == "proyector"){
                            $admonPro .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contAdmonPro++;
                        }

                        if(strtolower($tipo) == "telefono"){
                            $admonTel .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contAdmonTel++;
                        }

                        if(strtolower($tipo) == "monitor"){
                            $admonMoni .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contAdmonMoni++;
                        }

                    break;
                    case "nula": 
                        $tipo  = trim($fila[$i]["tipo_activo_nombre"]);

                        if(strtolower($tipo) == "pc"){
                            $nulaPc .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contNulaPc++;
                        }

                        if(strtolower($tipo) == "laptop"){
                            $nulaLap .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contNulaLap++;
                        }

                        if(strtolower($tipo) == "impresor"){
                            $nulaImp .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contNulaImp++;
                        }

                        if(strtolower($tipo) == "proyector"){
                            $nulaPro .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contNulaPro++;
                        }

                        
                        if(strtolower($tipo) == "telefono"){
                            $nulaTel .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contNulaTel++;
                        }

                        if(strtolower($tipo) == "monitor"){
                            $nulaMoni .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contNulaMoni++;
                        }

                    break;
                    case "campaña de libro":
                        $tipo  = trim($fila[$i]["tipo_activo_nombre"]);

                        if(strtolower($tipo) == "pc"){
                            $campaPc .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCampaPc++;
                        }

                        if(strtolower($tipo) == "laptop"){
                            $campaLap .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCampaLap++;
                        }

                        if(strtolower($tipo) == "impresor"){
                            $campaImp .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCampaImp++;
                        }

                        if(strtolower($tipo) == "proyector"){
                            $campaPro .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCampaPro++;
                        }

                        
                        if(strtolower($tipo) == "telefono"){
                            $campaTel .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCampaTel++;
                        }

                        if(strtolower($tipo) == "monitor"){
                            $campaMoni .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCampaMoni++;
                        }

                    break;
                    case "capacitacion": 
                        $tipo  = trim($fila[$i]["tipo_activo_nombre"]);

                        if(strtolower($tipo) == "pc"){
                            $capaPc .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCapaPc++;
                           
                        }

                        if(strtolower($tipo) == "laptop"){
                            $capaLap .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCapaLap++;
                            
                        }

                        if(strtolower($tipo) == "impresor"){
                            $capaImp .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCapaImp++;
                        }

                        if(strtolower($tipo) == "proyector"){
                            $capaPro .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCapaPro++;
                        }
                        
                        
                        if(strtolower($tipo) == "telefono"){
                            $capaTel .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCapaTel++;
                        }

                        if(strtolower($tipo) == "monitor"){
                            $capaMoni .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCapaMoni++;
                        }
                    break;
                    case "competencias":
                        $tipo  = trim($fila[$i]["tipo_activo_nombre"]);

                        if(strtolower($tipo) == "pc"){
                            $compePc .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCompePc++;
                        }

                        if(strtolower($tipo) == "laptop"){
                            $compeLap .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCompeLap++;
                        }

                        if(strtolower($tipo) == "impresor"){
                            $compeImp .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCompeImp++;
                        }

                        if(strtolower($tipo) == "proyector"){
                            $compePro .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCompePro++;
                        }     
                        
                        
                        if(strtolower($tipo) == "telefono"){
                            $compeTel .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCompeTel++;
                        }

                        if(strtolower($tipo) == "monitor"){
                            $compeMoni .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contCompeMoni++;
                        }
                    break;
                    case "comunicaciones": 
                        $tipo  = trim($fila[$i]["tipo_activo_nombre"]);

                        if(strtolower($tipo) == "pc"){
                            $comuniPc .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contComuniPc++;
                           
                        }

                        if(strtolower($tipo) == "laptop"){
                            $comuniLap .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contComuniLap++;
                        }

                        if(strtolower($tipo) == "impresor"){
                            $comuniImp .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contComuniImp++;
                        }

                        if(strtolower($tipo) == "proyector"){
                            $comuniPro .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contComuniPro++;
                        }
                        
                        if(strtolower($tipo) == "telefono"){
                            $comuniTel .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contComuniTel++;
                        }

                        if(strtolower($tipo) == "monitor"){
                            $comuniMoni .= $this->setHtmlByAreaTip($tipo,$i, $fila, $bandGte, $mantenimiento);
                            $contComuniMoni++;
                        }              
                    break;
                }
            }

            
            //concatenamos el cierre de tablas por área
            $admonPc .=  "</table>";
            $admonLap .= "</table>";
            $admonImp .= "</table>";
            $admonPro .= "</table>";
            $admonTel .= "</table>";
            $admonMoni .= "</table>";

            $nulaPc .= "</table>";
            $nulaLap .= "</table>";
            $nulaImp .= "</table>";
            $nulaPro .= "</table>";
            $nulaTel .= "</table>";
            $nulaMoni .= "</table>"; 
    
            $campaPc .= "</table>" ;
            $campaLap .= "</table>";
            $campaImp .= "</table>";
            $campaPro .= "</table>";
            $campaTel .= "</table>";
            $campaMoni .= "</table>";

            $capaPc .= "</table>";
            $capaLap .= "</table>";
            $capaImp .= "</table>";
            $capaPro .= "</table>";
            $capaTel .= "</table>";
            $capaMoni .= "</table>";
      
            $compePc .= "</table>";
            $compeLap .= "</table>";
            $compeImp .= "</table>";
            $compePro .= "</table>";
            $compeTel .= "</table>";
            $compeMoni .= "</table>";  

            $comuniPc .= "</table>";      
            $comuniLap .= "</table>";
            $comuniImp .= "</table>";
            $comuniPro .= "</table>";
            $comuniTel .= "</table>";
            $comuniMoni .= "</table>";  
   
            //creamos el array
            $arrayData = array();

            //concatenamos para crear array para reporte tablas a sus áreas
            //según las tablas con datos
            if($mantenimiento){
                //--------ÁREA ADMON----------
                if($contAdmonPc > 0){
                    $htmlManAdmon .= "<h3>PC</h3>".$admonPc;
                }

                if($contAdmonLap>0){
                    $htmlManAdmon .= "<h3>Laptop</h3>".$admonLap;
                }

                if($contAdmonImp>0){
                    $htmlManAdmon .="<h3>Impresor</h3>".$admonImp;
                }

                if($contAdmonPro>0){
                    $htmlManAdmon .="<h3>Proyector</h3>".$admonPro;
                }

                if($contAdmonTel>0){
                    $htmlManAdmon .="<h3>Telefono</h3>".$admonTel;
                }

                if($contAdmonMoni>0){
                    $htmlManAdmon .="<h3>Monitor</h3>".$admonMoni;
                }

                //--------ÁREA NULA----------
                if($contNulaPc > 0){
                    $htmlManNula .="<h3>PC</h3>".$nulaPc;
                }

                if($contNulaLap>0){
                    $htmlManNula .="<h3>Laptop</h3>". $nulaLap;
                }

                if($contNulaImp>0){
                    $htmlManNula .="<h3>Impresor</h3>".$nulaImp;
                }

                if($contNulaPro>0){
                    $htmlManNula .="<h3>Proyector</h3>".$nulaPro;
                }

                if($contNulaTel>0){
                    $htmlManNula .="<h3>Telefono</h3>".$nulaTel;
                }

                if($contNulaMoni>0){
                    $htmlManNula .="<h3>Monitor</h3>".$nulaMoni;
                }

                //--------ÁREA CAMPAÑA LIBRO----------
                if($contCampaPc > 0){
                    $htmlManCampLi .="<h3>PC</h3>". $campaPc;
                }

                if($contCampaLap>0){
                    $htmlManCampLi .="<h3>Laptop</h3>". $campaLap;
                }

                if($contCampaImp>0){
                    $htmlManCampLi .="<h3>Impresor</h3>".$campaImp;
                }

                if($contCampaPro>0){
                    $htmlManCampLi .="<h3>Proyector</h3>".$campaPro;
                }

                if($contCampaTel>0){
                    $htmlManCampLi .="<h3>Telefono</h3>".$campaTel;
                }

                if($contCampaMoni>0){
                    $htmlManCampLi .="<h3>Monitor</h3>".$campaMoni;
                }
                //--------ÁREA  CAPACITACION----------

                if($contCapaPc > 0){
                    $htmlManCapa .= "<h3>PC</h3>".$capaPc;
                }

                if($contCapaLap>0){
                    $htmlManCapa .="<h3>Laptop</h3>".$capaLap;
                }

                if($contCapaImp>0){
                    $htmlManCapa .="<h3>Impresor</h3>".$capaImp;
                }

                if($contCapaPro>0){
                    $htmlManCapa .="<h3>Proyector</h3>".$capaPro;
                }

                if($contCapaTel>0){
                    $htmlManCapa .="<h3>Telefono</h3>". $capaTel;
                }

                if($contCapaMoni>0){
                    $htmlManCapa .= "<h3>Monitor</h3>".$capaMoni;
                }

                //--------ÁREA COMPETENCIAS----------

                if($contCompePc > 0){
                    $htmlManCompe .= "<h3>PC</h3>".$compePc;
                }

                if($contCompeLap>0){
                    $htmlManCompe .= "<h3>Laptop</h3>".$compeLap;
                }

                if($contCompeImp>0){
                    $htmlManCompe .="<h3>Impresor</h3>".$compeImp;
                }

                if($contCompePro>0){
                    $htmlManCompe .="<h3>Proyector</h3>".$compePro;
                }

                if($contCompeTel>0){
                    $htmlManCompe .="<h3>Telefono</h3>".$compeTel;
                }

                if($contCompeMoni>0){
                    $htmlManCompe .="<h3>Monitor</h3>".$compeMoni;
                }

                //--------ÁREA COMUNICACIONES----------


                if($contComuniPc > 0){
                    $htmlManComuni .="<h3>PC</h3>". $comuniPc;
                }

                if($contComuniLap>0){
                    $htmlManComuni .= "<h3>Laptop</h3>".$comuniLap;
                }

                if($contComuniImp>0){
                    $htmlManComuni .="<h3>Impresor</h3>".$comuniImp;
                }

                if($contComuniPro>0){
                    $htmlManComuni .="<h3>Proyector</h3>".$comuniPro;
                }

                if($contComuniTel>0){
                    $htmlManComuni .="<h3>Telefono</h3>".$comuniTel;
                }

                if($contComuniMoni>0){
                    $htmlManComuni .="<h3>Monitor</h3>".$comuniMoni;
                }   
                
                //llenamos el array 
                if(strlen($htmlManAdmon)>0){
                    $arrayData["Administración"] = $htmlManAdmon.$estiloTbl;
                }
                    
                if(strlen($htmlManNula)>0){
                    $arrayData["Nula"] = $htmlManNula.$estiloTbl;
                }
                    
                if(strlen($htmlManCampLi)>0){
                    $arrayData["Campaña de libro"] = $htmlManCampLi.$estiloTbl;
                }
                    
                if(strlen($htmlManCapa)>0){
                    $arrayData["Capacitación"] = $htmlManCapa.$estiloTbl;
                }
                    
                if(strlen($htmlManCompe)>0){
                        $arrayData["Competencias"] = $htmlManCompe.$estiloTbl;
                }    
                    
                if(strlen($htmlManComuni)>0){
                    $arrayData["Comunicaciones"] = $htmlManComuni.$estiloTbl;
                } 


            }else{

                //--------ÁREA ADMON----------
                if($contAdmonPc > 0){
                    $htmlAdmon .=$admonPc;
                }

                if($contAdmonLap>0){
                    $htmlAdmon .= $admonLap;
                }

                if($contAdmonImp>0){
                    $htmlAdmon .=$admonImp;
                }

                if($contAdmonPro>0){
                    $htmlAdmon .=$admonPro;
                }
                
                if($contAdmonTel>0){
                    $htmlAdmon .=$admonTel;
                }

                if($contAdmonMoni>0){
                    $htmlAdmon .=$admonMoni;
                }
                //--------ÁREA NULA----------
                if($contNulaPc > 0){
                    $htmlNula .= $nulaPc;
                }

                if($contNulaLap>0){
                    $htmlNula .= $nulaLap;
                }

                if($contNulaImp>0){
                    $htmlNula .=$nulaImp;
                }

                if($contNulaPro>0){
                    $htmlNula .=$nulaPro;
                }

                if($contNulaTel>0){
                    $htmlNula .=$nulaTel;
                }

                if($contNulaMoni>0){
                    $htmlNula .=$nulaMoni;
                }

                //--------ÁREA CAMPAÑA LIBRO----------
                if($contCampaPc > 0){
                    $htmlCampLi .= $campaPc;
                }

                if($contCampaLap>0){
                    $htmlCampLi .= $campaLap;
                }

                if($contCampaImp>0){
                    $htmlCampLi .=$campaImp;
                }

                if($contCampaPro>0){
                    $htmlCampLi .=$campaPro;
                }

                if($contCampaTel>0){
                    $htmlCampLi .=$campaTel;
                }

                if($contCampaMoni>0){
                    $htmlCampLi .=$campaMoni;
                }
                //--------ÁREA CAPACITACION----------

                if($contCapaPc > 0){
                    $htmlCapa .= $capaPc;
                }

                if($contCapaLap>0){
                    $htmlCapa .= $capaLap;
                }

                if($contCapaImp>0){
                    $htmlCapa .=$capaImp;
                }

                if($contCapaPro>0){
                    $htmlCapa .=$capaPro;
                }

                if($contCapaTel>0){
                    $htmlCapa .= $capaTel;
                }

                if($contCapaMoni>0){
                    $htmlCapa .= $capaMoni;
                }

                //--------ÁREA COMPETENCIAS----------

                if($contCompePc > 0){
                    $htmlCompe .= $compePc;
                }

                if($contCompeLap>0){
                    $htmlCompe .= $compeLap;
                }

                if($contCompeImp>0){
                    $htmlCompe .=$compeImp;
                }

                if($contCompePro>0){
                    $htmlCompe .=$compePro;
                }

                if($contCompeTel>0){
                    $htmlCompe .=$compeTel;
                }

                if($contCompeMoni>0){
                    $htmlCompe .=$compeMoni;
                }

                //--------ÁREA COMUNICACIONES----------


                if($contComuniPc > 0){
                    $htmlComuni .= $comuniPc;
                }

                if($contComuniLap>0){
                    $htmlComuni .= $comuniLap;
                }

                if($contComuniImp>0){
                    $htmlComuni .=$comuniImp;
                }

                if($contComuniPro>0){
                    $htmlComuni .=$comuniPro;
                }

                if($contComuniTel>0){
                    $htmlComuni .=$comuniTel;
                }

                if($contComuniMoni>0){
                    $htmlComuni .=$comuniMoni;
                }

                //llenamos el array para reporte tipo y áreas 
                if(strlen($htmlAdmon)>0){
                $arrayData["Administración"] = $htmlAdmon.$estiloTbl;
                }

                if(strlen($htmlNula)>0){
                    $arrayData["Nula"] = $htmlNula.$estiloTbl;
                }

                if(strlen($htmlCampLi)>0){
                    $arrayData["Campaña de libro"] = $htmlCampLi.$estiloTbl;
                }

                if(strlen($htmlCapa)>0){
                    $arrayData["Capacitación"] = $htmlCapa.$estiloTbl;
                }

                if(strlen($htmlCompe)>0){
                    $arrayData["Competencias"] = $htmlCompe.$estiloTbl;
                }

                if(strlen($htmlComuni)>0){
                    $arrayData["Comunicaciones"] = $htmlComuni.$estiloTbl;
                }
            }
                        
            //retornamos array
            return $arrayData;

        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

   
    //cuenta la cantidad total de tipo de activos seteado como parametro
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
    public function getDataRptActivosTipo($tipoActivo)
    {
        //variables auxliares
        $countPC = 0;
        $countLap = 0;
        $countProyec = 0;
        $countImp = 0;
        $countTel =0;
        $countMoni = 0;

        //creamos el objeto de la plantilla html de rpt
        $rpt = new ReportesPlantilla();

        //obtenemos la maqueta de headers de las tablas para cada tipo de activo
        $tablaPC = $rpt->getHeaderTablaRptPc(false);
        $tablaLaptop = $rpt->getHeaderTablaRptLap(false);
        $tablaProyector = $rpt->getHeaderTablaRptProyector(false);
        $tablaImp = $rpt->getHeaderTablaRptImpresor(1);
        $tablaTel = $rpt->getHeaderTablaRptTelefono(false);
        $tablaMonitor = $rpt->getHeaderTablaRptMonitor();

        //establecemos la coneccion
        $con = Conexion::conectar();
        $sql ="";

        if($tipoActivo ==0){
            //establecemos la consulta
            $sql = "select dbo.Activo_Especificacion.DiscoDuro2, dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo, 
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

            //ejecutamos la consulta
            $respuesta = $con->query($sql);
        }

        if($tipoActivo != 0){
                    
            //establecemos la consulta
            $sql = "select dbo.Activo_Especificacion.DiscoDuro2, dbo.Activo.Activo_id, dbo.Activo.Estructura1_id, dbo.Activo.Estructura2_id, dbo.Activo.Estructura3_id, dbo.Estructura31.estructura31_nombre, dbo.Activo.Activo_tipo, 
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
            $respuesta->execute([$tipoActivo]);
        }

        try {

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
                    case "Telefono":
                        //si tipo activo nombre es proyector concatenamos valores a tabla proyector
                        $tablaTel .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $fila[$i]["Modelo"] . '</td>'
                            . '<td class="w7">' . $fila[$i]["IP"] . '</td>'
                            . '</tr>';
                        $countTel++;
                    break;
                    case "Monitor":
                        //si tipo activo nombre es proyector concatenamos valores a tabla proyector
                        $tablaMonitor .= '<tr>'
                            . '<td class="w6">' . $fila[$i]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $fila[$i]["Activo_descripcion"] . '</td>'
                            . '<td class="w12">' . $fila[$i]["Nombre_responsable"] . '</td>'
                            . '<td class="w7">' . $fila[$i]["Modelo"] . '</td>'
                            . '</tr>';
                        $countMoni++;
                    break;
                }
            }

            //cerramos las respectivas tablas de cada tipo
            $tablaImp .= "</table>";
            $tablaLaptop .= "</table>";
            $tablaPC .= "</table>";
            $tablaProyector .= "</table>";
            $tablaTel .= "</table>";
            $tablaMonitor .= "</table>";


            $html = "";

            if($tipoActivo ==0){
                $htmlArray = array();
                
                //evaluamos en cual tipo de activo no hay datos
                //y concatenamos la fila "no hay datos"
                if ($countPC > 0) {
                    $htmlArray[0] = $tablaPC.$rpt->getEtiquetaStyleRpt();
                }

                if ($countLap > 0) {
                    $htmlArray[1]  = $tablaLaptop.$rpt->getEtiquetaStyleRpt();
                }

                if ($countProyec > 0) {
                    $htmlArray[3]  = $tablaProyector.$rpt->getEtiquetaStyleRpt();
                }


                if ($countImp > 0) {
                    $htmlArray[2]  = $tablaImp.$rpt->getEtiquetaStyleRpt();
                }

                if ($countTel > 0) {
                    $htmlArray[4]  = $tablaTel.$rpt->getEtiquetaStyleRpt();
                }

                if ($countMoni > 0) {
                    $htmlArray[5]  = $tablaMonitor.$rpt->getEtiquetaStyleRpt();
                }

                return $htmlArray;

            }else{
                //evaluamos en cual tipo de activo no hay datos
                //y concatenamos la fila "no hay datos"
                if ($countPC > 0) {
                    $html = $tablaPC;
                }

                if ($countLap > 0) {
                    $html = $tablaLaptop;
                }

                if ($countProyec > 0) {
                    $html = $tablaProyector;
                }


                if ($countImp > 0) {
                    $html = $tablaImp;
                }

                if ($countTel > 0) {
                    $html = $tablaTel;
                }

                if ($countMoni > 0) {
                    $html = $tablaMonitor;
                }

                //retornamos todas las tablas juntas con estilos para imprimir por tcpdf
                return $html.$rpt->getEtiquetaStyleRpt();
            }

        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    //genera la estructura de html para retornarla y pasarla a la función que
    //genera el reporte de total de activos por tipos
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
        //llamamos la funcion para contar cuantos hay del tipo ID 5-->Telefono
        $totalTel = $objTA->countTipActivo(5);
        //llamamos la funcion para contar cuantos hay del tipo ID 6-->Monitor
        $totalMoni = $objTA->countTipActivo(6);


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
                            <td>Telefono</td>
                            <td>' . $totalTel . '</td>
                        </tr>
                        <tr>
                            <td>Monitor</td>
                            <td>' . $totalMoni . '</td>
                        </tr>
                        <tr>
                            <td class="bgDark">Total</td>
                            <td class="bgDark">' . ($totalPc + $totalLap + $totalImp + $totalPro + $totalTel + $totalMoni) . '</td>
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

    //solicita los datos de la BD para generar tablas para reporte toners
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

  


    /*   ------- INICIAN FUNCIONES PARA GENERAR LOS REPORTES QUE SE IMPRIMEN EN EL NAVEGADOR -------
     -------         SEGÚN LOS DATOS GENERADOS DE LA BD      -------         */

    //genera reporte <<activo>> filtrado solamente por <<tipo activo>>
    public function generarRptPdfTipAct($html, $tipoActivo, $tipoActivoNombre)
    {
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', 'B', 10);

        if(is_array($html)){
            $i =0;
            foreach($tipoActivo as $key => $value){
                $pdf->Cell(80, 10, "Tipo De Activo: " . $key, 0, 0, "L");
                $pdf->Cell(188, 10, "Cantidad: " . $value, 0, 1, "R");
                $pdf->Ln(3);
                $pdf->writeHTML($html[$i], true, false, true, false, '');
                $i++;
            }
        }else{
            $pdf->Cell(80, 10, "Tipo De Activo: " . $tipoActivoNombre, 0, 0, "L");
            $pdf->Cell(188, 10, "Cantidad: " . $tipoActivo[$tipoActivoNombre], 0, 1, "R");
            $pdf->Ln(3);
            $pdf->writeHTML($html, true, false, true, false, '');
        }

        $pdf->Output();
    }


    //genera reporte de <<activo>> filtrado por <<área>> y <<tipo activo>>
    public function generarRptPdfActArea($htmlArray, $area, $areaNombre)
    {
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);

        if($area ==100){
            foreach($htmlArray as $key => $value){
                $pdf->AddPage();
                $pdf->Ln(2);
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(80, 10, "Área: " . $key, 0, 1, "L");
                $pdf->Ln(3);
                $pdf->writeHTML($value, true, false, true, false, '');
            }
            
        }else{
            foreach($htmlArray as $key => $value){
                $pdf->AddPage();
                $pdf->Ln(2);
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(80, 10, "Área: " . $areaNombre, 0, 1, "L");
                $pdf->Ln(3);
                $pdf->writeHTML($value, true, false, true, false, '');
            }
            
        }

        $pdf->Output();
    }

    //genera reporte de <<resumen de activos>> 
    public function generarRptPdfResTipAct($html)
    {
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->Cell(0, 10, "Resumen de activos totales", 0, 1, "C");
        $pdf->Ln(3);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output();
    }

    //genera reporte de <<impresora y toners>> 
    public function generarRptPdfResImpToner($html)
    {
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 15, 'DETALLE DE IMPRESORES', 0, 1,"C");
        $pdf->Ln(3);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output();
    }

    //genera reporte de <<mantenimiento>> 
    public function generarRptPdfMantenimiento($htmlArray, $area)
    {
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);
        
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 10);

        if(!is_array($htmlArray)){
            $pdf->AddPage();
            $pdf->Ln(5);
            $pdf->Cell(0, 5, 'Mantenimiento Preventivo de Recursos de TI', 0, 1,"L");
            $pdf->Cell(70, 5, 'Departamento: '.$area, 0, 0,"L");
            $pdf->Cell(145, 5, 'Gerente|Jefe: ______________________________ ', 0, 0,"C");
            $pdf->Cell(60, 5, 'Fecha: ____________________ ', 0, 1,"L");
            
            foreach($htmlArray as $key => $value){
                $pdf->Ln(3);
                $pdf->writeHTML($value, true, false, true, false, '');
            }

        }else{
            $i =0;
            foreach($htmlArray as $key =>$value){
                $pdf->AddPage();
                $pdf->Ln(5);
                $pdf->Cell(0, 5, 'Mantenimiento Preventivo de Recursos de TI', 0, 1,"L");
                $pdf->Cell(70, 5, 'Departamento: '.$key, 0, 0,"L");
                $pdf->Cell(145, 5, 'Gerente|Jefe: ______________________________ ', 0, 0,"C");
                $pdf->Cell(60, 5, 'Fecha: ____________________ ', 0, 1,"L");
                $pdf->Ln(3);
                $pdf->writeHTML($value, true, false, true, false, '');
                $i++;
            }

        }

        $pdf->Output();
    }

    //genera reporte de <<activo>> por <<área>> y <<tipo activo>> sin filtro
    public function generearRptTipActAreaAll($htmlArray)
    {
        $pdf = new ReportesPlantilla("P", "mm", "A3", true, 'UTF-8', false);

        foreach ($htmlArray as $key => $value) {
            $pdf->AddPage();
            $pdf->Ln(15);
            $pdf->SetFont('helvetica', 'B', 15);
            $pdf->Ln(0);
            $pdf->Cell(80, 0, "Área: ".$key, 0, 1, "L");
            $pdf->Ln(2);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->writeHTML($value, true, false, true, false, '');
            $pdf->SetAutoPageBreak(TRUE, 34);
        
        }

        $pdf->Output();
    }


    //Función que prepara la estructura hmtl del reporte por área y tipo
    //recibe el tipo de activo, posición del recorrido de la iteración al momento de llamar la función,
    //el arreglo con los datos de la consulta -> base de datos, el reporte es para gerencia o no (booleano)
    //y si el reporte es para mantenimiento o no (booleano)
    public function setHtmlByAreaTip($tipoActivo,$posicion, $arregloBd, $bandGte, $mantenimiento){        
            //evaluamos que área está de valor pasando a minuscula para evitar Admon != admon
            switch (strtolower($tipoActivo)) {
                case 'pc':
                    $fpc="";
                    if(!$mantenimiento){
                        if($bandGte){
                            $fpc.= '<tr>'
                            . '<td class="w6">' . $arregloBd[$posicion]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $arregloBd[$posicion]["Activo_descripcion"] .'<br>'.'</td>'
                            . '<td class="w12">' . $arregloBd[$posicion]["Nombre_responsable"] . '</td>'
                            . '<td class="w7 center">' . $arregloBd[$posicion]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $arregloBd[$posicion]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $arregloBd[$posicion]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["DiscoDuro"] .
                            "<br>".$arregloBd[$posicion]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $arregloBd[$posicion]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["Office"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["numero_serie"] . '</td>'
                            . '</tr>';
                        }else{
                            $fpc.= '<tr>'
                            . '<td class="w6">' . $arregloBd[$posicion]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $arregloBd[$posicion]["Activo_descripcion"] .'<br>'.'</td>'
                            . '<td class="w12">' . $arregloBd[$posicion]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $arregloBd[$posicion]["IP"] . '</td>'
                            . '<td class="w7 center">' . $arregloBd[$posicion]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $arregloBd[$posicion]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $arregloBd[$posicion]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["DiscoDuro"] .
                            "<br>".$arregloBd[$posicion]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $arregloBd[$posicion]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["Office"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["numero_serie"] . '</td>'
                            . '</tr>';
                        }

                        return $fpc;
                    }

                    $fpc ='<tr>'
                    . '<td class="w9"><br><br>' . ($posicion+1)." ".$arregloBd[$posicion]["numero_serie"]. '</td>'
                    . '<td class="w15"><br><br>'.$arregloBd[$posicion]["tipo_activo_nombre"] ." " . $arregloBd[$posicion]["Modelo"] . '</td>'
                    . '<td class="w6 center"><br><br>' . $arregloBd[$posicion]["Procesador"]."<br>G.".$arregloBd[$posicion]["Generacion"] . '</td>'
                    . '<td class="w9 center"><br><br>' ."RAM ". $arregloBd[$posicion]["Ram"] . '</td>'
                    . '<td class="w9 center"><br><br>' .$arregloBd[$posicion]["DiscoDuro"]." ".$arregloBd[$posicion]["Capacidad_D1"]
                    ." <br>".$arregloBd[$posicion]["DiscoDuro2"]." ".$arregloBd[$posicion]["Capacidad_D2"]. '</td>'
                    . '<td class="w9 center">N/A</td>'
                    . '<td class="w7-5 center">N/A</td>'
                    . '<td class="w30"><br><br><br><br></td>'
                    . '</tr>';

                 return $fpc;

                break;
                case 'laptop':
                    $laptop="";
                    if(!$mantenimiento){
                        if($bandGte){
                            $laptop .= '<tr>'
                            . '<td class="w6">' . $arregloBd[$posicion]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $arregloBd[$posicion]["Activo_descripcion"] .'<br>'.'</td>'
                            . '<td class="w12">' . $arregloBd[$posicion]["Nombre_responsable"] . '</td>'
                            . '<td class="w7 center">' . $arregloBd[$posicion]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $arregloBd[$posicion]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $arregloBd[$posicion]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["DiscoDuro"] .
                            "<br>".$arregloBd[$posicion]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $arregloBd[$posicion]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["Office"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["numero_serie"] . '</td>'
                            . '</tr>';  
                        }else{
                            $laptop .= '<tr>'
                            . '<td class="w6">' . $arregloBd[$posicion]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $arregloBd[$posicion]["Activo_descripcion"] .'<br>'.'</td>'
                            . '<td class="w12">' . $arregloBd[$posicion]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $arregloBd[$posicion]["IP"] . '</td>'
                            . '<td class="w7 center">' . $arregloBd[$posicion]["Modelo"] . '</td>'
                            . '<td class="w6 center">' . $arregloBd[$posicion]["Procesador"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["Generacion"] . '</td>'
                            . '<td class="w5-5 center">' . $arregloBd[$posicion]["Ram"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["DiscoDuro"] .
                            "<br>".$arregloBd[$posicion]["DiscoDuro2"]. '</td>'
                            . '<td class="w6 center">' . $arregloBd[$posicion]["SO"] . '</td>'
                            . '<td class="w7-5 center">' . $arregloBd[$posicion]["Office"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["numero_serie"] . '</td>'
                            . '</tr>';  
                        }

                        return $laptop;
                    }

                    $laptop ='<tr>'
                    . '<td class="w9"><br><br>' . ($posicion+1)." ".$arregloBd[$posicion]["numero_serie"]. '</td>'
                    . '<td class="w15"><br><br>'.$arregloBd[$posicion]["tipo_activo_nombre"] ." " . $arregloBd[$posicion]["Modelo"] . '</td>'
                    . '<td class="w6 center"><br><br>' . $arregloBd[$posicion]["Procesador"]."<br>G.".$arregloBd[$posicion]["Generacion"] . '</td>'
                    . '<td class="w9 center"><br><br>' ."RAM ". $arregloBd[$posicion]["Ram"] . '</td>'
                    . '<td class="w9 center"><br><br>' .$arregloBd[$posicion]["DiscoDuro"]." ".$arregloBd[$posicion]["Capacidad_D1"]
                    ." <br>".$arregloBd[$posicion]["DiscoDuro2"]." ".$arregloBd[$posicion]["Capacidad_D2"]. '</td>'
                    . '<td class="w9 center">N/A</td>'
                    . '<td class="w7-5 center">N/A</td>'
                    . '<td class="w30"><br><br><br><br></td>'
                    . '</tr>';

                 return $laptop;               
                break; 
                case 'impresor':
                   $impresor ="";
                    if(!$mantenimiento){
                        if($bandGte){
                            $impresor .= '<tr>'
                            . '<td class="w6">' . $arregloBd[$posicion]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $arregloBd[$posicion]["Activo_descripcion"] .'<br>'.'</td>'
                            . '<td class="w12">' . $arregloBd[$posicion]["Nombre_responsable"] . '</td>'
                            . '<td class="w7">' . $arregloBd[$posicion]["Modelo"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["TonerN"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["TonerM"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["TonerC"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["TonerA"] . '</td>'
                            . '</tr>';
                           }else{
                            $impresor .= '<tr>'
                            . '<td class="w6">' . $arregloBd[$posicion]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $arregloBd[$posicion]["Activo_descripcion"] .'<br>'.'</td>'
                            . '<td class="w12">' . $arregloBd[$posicion]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $arregloBd[$posicion]["IP"] . '</td>'
                            . '<td class="w7">' . $arregloBd[$posicion]["Modelo"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["TonerN"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["TonerM"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["TonerC"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["TonerA"] . '</td>'
                            . '</tr>';
                           }

                        return $impresor;
                    }

                    $impresor='<tr>'
                    . '<td class="w9"><br><br>' . ($posicion+1)." ".$arregloBd[$posicion]["numero_serie"]. '</td>'
                    . '<td class="w15"><br><br>'.$arregloBd[$posicion]["tipo_activo_nombre"] ." ". $arregloBd[$posicion]["Modelo"] . '</td>'
                    . '<td class="w6 center"><br><br>N/A</td>'
                    . '<td class="w9 center"><br><br>N/A</td>'
                    . '<td class="w9 center"><br><br>N/A</td>'
                    . '<td class="w9 center">N/A</td>'
                    . '<td class="w7-5 center">N/A</td>'
                    . '<td class="w30"><br><br><br><br></td>'
                    . '</tr>';
                    
                   return $impresor;
                break;
                case 'proyector':
                    $proyector="";
                    if(!$mantenimiento){
                        if($bandGte){
                            $proyector .= '<tr>'
                            . '<td class="w6">' . $arregloBd[$posicion]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $arregloBd[$posicion]["Activo_descripcion"] .'<br>'.'</td>'
                            . '<td class="w12">' . $arregloBd[$posicion]["Nombre_responsable"] . '</td>'
                            . '<td class="w7">' . $arregloBd[$posicion]["Modelo"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["HorasUso"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["HoraEco"] . '</td>'
                            . '</tr>';
                        }else{
                            $proyector .= '<tr>'
                            . '<td class="w6">' . $arregloBd[$posicion]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $arregloBd[$posicion]["Activo_descripcion"] .'<br>'.'</td>'
                            . '<td class="w12">' . $arregloBd[$posicion]["Nombre_responsable"] . '</td>'
                            . '<td class="w9">' . $arregloBd[$posicion]["IP"] . '</td>'
                            . '<td class="w7">' . $arregloBd[$posicion]["Modelo"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["HorasUso"] . '</td>'
                            . '<td class="w7-5">' . $arregloBd[$posicion]["HoraEco"] . '</td>'
                            . '</tr>';
                        }
                        
                        return $proyector;
                    }
                    
                    $proyector ='<tr>'
                    . '<td class="w9"><br><br>' . ($posicion+1)." ".$arregloBd[$posicion]["numero_serie"]. '</td>'
                    . '<td class="w15"><br><br>'.$arregloBd[$posicion]["tipo_activo_nombre"] ." ". $arregloBd[$posicion]["Modelo"] . '</td>'
                    . '<td class="w6 center"><br><br>N/A</td>'
                    . '<td class="w9 center"><br><br>N/A</td>'
                    . '<td class="w9 center"><br><br>N/A</td>'
                    . '<td class="w9 center">N/A</td>'
                    . '<td class="w7-5 center">N/A</td>'
                    . '<td class="w30"><br><br><br><br></td>'
                    . '</tr>';

                    return $proyector;
                break;
                case 'telefono':
                    $tel="";
                    if(!$mantenimiento){
                        if($bandGte){
                            $tel .= '<tr>'
                            . '<td class="w6">' . $arregloBd[$posicion]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $arregloBd[$posicion]["Activo_descripcion"] .'<br>'.'</td>'
                            . '<td class="w12">' . $arregloBd[$posicion]["Nombre_responsable"] . '</td>'
                            . '<td class="w7">' . $arregloBd[$posicion]["Modelo"] . '</td>'
                            . '</tr>';
                            
                        }else{
                            $tel .= '<tr>'
                            . '<td class="w6">' . $arregloBd[$posicion]["Activo_id"] . '</td>'
                            . '<td class="w15">' . $arregloBd[$posicion]["Activo_descripcion"] .'<br>'.'</td>'
                            . '<td class="w12">' . $arregloBd[$posicion]["Nombre_responsable"] . '</td>'
                            . '<td class="w7">' . $arregloBd[$posicion]["Modelo"] . '</td>'
                            . '<td class="w9">' . $arregloBd[$posicion]["IP"] . '</td>'
                            . '</tr>';    
                        }
                        return $tel;
                    }

                    $tel='<tr>'
                    . '<td class="w9"><br><br>' . ($posicion+1)." ".$arregloBd[$posicion]["numero_serie"]. '</td>'
                    . '<td class="w15"><br><br>'.$arregloBd[$posicion]["tipo_activo_nombre"]." ".$arregloBd[$posicion]["Activo_descripcion"]
                    ." ". $arregloBd[$posicion]["Modelo"] . '</td>'
                    . '<td class="w6 center"><br><br>N/A</td>'
                    . '<td class="w9 center"><br><br>N/A</td>'
                    . '<td class="w9 center"><br><br>N/A</td>'
                    . '<td class="w9 center">N/A</td>'
                    . '<td class="w7-5 center">N/A</td>'
                    . '<td class="w30"><br><br><br><br></td>'
                    . '</tr>';

                    return $tel;
                break;
                case 'monitor':
                    $moni="";
                    if(!$mantenimiento){
                        $moni .= '<tr>'
                        . '<td class="w6">' . $arregloBd[$posicion]["Activo_id"] . '</td>'
                        . '<td class="w15">' . $arregloBd[$posicion]["Activo_descripcion"] .'<br>'.'</td>'
                        . '<td class="w12">' . $arregloBd[$posicion]["Nombre_responsable"] . '</td>'
                        . '<td class="w7">' . $arregloBd[$posicion]["Modelo"] . '</td>'
                        . '</tr>';

                        return $moni;
                    }
                    
                    $moni ='<tr>'
                    . '<td class="w9"><br><br>' . ($posicion+1)." ".$arregloBd[$posicion]["numero_serie"]. '</td>'
                    . '<td class="w15"><br><br>'.$arregloBd[$posicion]["tipo_activo_nombre"]." ".$arregloBd[$posicion]["Activo_descripcion"].'</td>'
                    . '<td class="w6 center"><br><br>N/A</td>'
                    . '<td class="w9 center"><br><br>N/A</td>'
                    . '<td class="w9 center"><br><br>N/A</td>'
                    . '<td class="w9 center">'.$arregloBd[$posicion]["Modelo"].'</td>'
                    . '<td class="w7-5 center"></td>'
                    . '<td class="w30"><br><br><br><br></td>'
                    . '</tr>';

                    return $moni;
                break;
            }       
    }


}




?>
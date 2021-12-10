<?php
include 'activoFijo.php';

class activoFijoDAO{
    private $con;

    public function __construct(){
    }

    public function conectar(){
        $serverName = "DESKTOP-CO34HBA\SQLEXPRESS";
        $basedatos="ACTIVO";
        try{
           
            //DECLARANDO CANEDA DE CONEXION
            $this->con = new PDO("sqlsrv:Server=$serverName;Database=$basedatos","","");
            
            //preparamos a la libreria PDO para mandar
            //excepsiones en caso de errores
            $this->con->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }catch(PDOException $error){
            //MOSTRANDO ERROR
            echo $error->getMessage();
        }
    
    }

    public function desconectar($respuesta){
        $this->con=null;
        $respuesta->closeCursor();//dependiendo de la lib es obligatorio o no.
        $respuesta=null;

    }

    public function insertarActivoFijo($referencia,$codContabi,$codPro,$serie,$fechaAdq,$factura,$tipoAct,$descripcion,$departamentom,$ff,$area,$usuario,$fecha,$fechaCat,$fechacomp,
                                       $activoEliminado,$estado,$responsable,$imagen){
        $this->conectar();
        $sql = "INSERT INTO Activo(Activo_referencia,PartidaCta,Empresa_id,numero_serie,Activo_fecha_adq,Activo_factura,Activo_tipo,Activo_descripcion,
        Estructura1_id,Estructura2_id,Estructura3_id,Usuario_id,fecha,Activo_fecha_caduc,fecha_compra,Activo_eliminado,Estado,Responsable_codigo,Imagen) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute([$referencia,$codContabi,$codPro,$serie,$fechaAdq,$factura,$tipoAct,$descripcion,$departamentom,$ff,$area,$usuario,$fecha,$fechaCat,$fechacomp,
            $estado,$activoEliminado,$responsable,$imagen]);
            $datos = $respuesta->rowCount();
            if($datos > 0){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $error){
            return $error->getMessage();
        }   
    }

    public function comboTipoActivo(){
        $this->conectar();
        $sql = "SELECT tipo_activo_id, tipo_activo_nombre FROM Tipo_activo";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute();
            $data = array();
            while($fila = $respuesta->fetch(PDO::FETCH_ASSOC)){
                $data[$fila["tipo_activo_id"]]=$fila["tipo_activo_nombre"];
            }
            return $data;
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function comboDapartamento(){
        $this->conectar();
        $sql = "SELECT estructura11_id, estructura11_nombre FROM Qry_Estructura11";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute();
            $data = array();
            while($fila = $respuesta->fetch(PDO::FETCH_ASSOC)){
                $data[$fila["estructura11_id"]]=$fila["estructura11_nombre"];
            }
            return $data;
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function comboFondos(){
        $this->conectar();
        $sql = "SELECT estructura21_id, estructura21_nombre FROM Qry_Estructura21";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute();
            $data = array();
            while($fila = $respuesta->fetch(PDO::FETCH_ASSOC)){
                $data[$fila["estructura21_id"]]=$fila["estructura21_nombre"];
            }
            return $data;
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function comboArea(){
        $this->conectar();
        $sql = "SELECT estructura31_id, estructura31_nombre FROM Qry_Estructura31";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute();
            $data = array();
            while($fila = $respuesta->fetch(PDO::FETCH_ASSOC)){
                $data[$fila["estructura31_id"]]=$fila["estructura31_nombre"];
            }
            return $data;
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function comboResponsable(){
        $this->conectar();
        $sql = "SELECT Responsable_codigo, Nombre_responsable FROM Activo_responsable";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute();
            $data = array();
            while($fila = $respuesta->fetch(PDO::FETCH_ASSOC)){
                $data[$fila["Responsable_codigo"]]=$fila["Nombre_responsable"];
            }
            return $data;
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function mostrarActivoFijo(){
        $this->conectar();
        $sql = "SELECT * FROM Activo";
        $respuesta = $this->con->prepare($sql);
        $tabla = "
        <table id='activoTabla' name='activoTabla' class='table table-striped dt-responsive nowrap' style='width:100%; text-align: center'>
        <thead>
            <tr>
                <th>Id</th>
                <th>Empresa</th>
                <th>Departamento</th>
                <th>F.F.</th>
                <th>Área</th>
                <th>Tipo de activo</th>
                <th>Referencia</th>
                <th>Serie</th>
                <th>Descripción</th>
                <th>Responsable</th>
                <th>Fecha de compra</th>
                <th>Fecha de adquisición</th>
                <th>Fecha de caducación</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        ";
        try{
            $respuesta->execute();
            while($fila = $respuesta->fetch(PDO::FETCH_ASSOC)){
                $tabla .= "<tr>";
                $tabla .= "<td>".$fila["Activo_id"]."</td>";
                $tabla .= "<td>".$fila["Empresa_id"]."</td>";
                $tabla .= "<td>".$fila["Estructura1_id"]."</td>";
                $tabla .= "<td>".$fila["Estructura2_id"]."</td>";
                $tabla .= "<td>".$fila["Estructura3_id"]."</td>";
                $tabla .= "<td>".$fila["Activo_tipo"]."</td>";
                $tabla .= "<td>".$fila["Activo_referencia"]."</td>";
                $tabla .= "<td>".$fila["numero_serie"]."</td>";
                $tabla .= "<td>".$fila["Activo_descripcion"]."</td>";
                $tabla .= "<td>".$fila["Responsable_codigo"]."</td>";
                $tabla .= "<td>".$fila["fecha_compra"]."</td>";
                $tabla .= "<td>".$fila["Activo_fecha_adq"]."</td>";
                $tabla .= "<td>".$fila["Activo_fecha_caduc"]."</td>";
                $tabla .= "<td>".
                                "<button type='button' class='btn btn-info'>Modificar 
                                <span class='btn-icon-right'><i class='fa fa-pencil'></i></span>
                                </button>"." ".
                                "<button type='button' class='btn btn-success'>Historial 
                                <span class='btn-icon-right'><i class='fa fa-history'></i></span>
                                </button>"." ".
                                "<button type='button' class='btn btn-danger'>Eliminar 
                                <span class='btn-icon-right'><i class='fa fa-close'></i></span>
                                </button>"
                        ."</td>";
                $tabla .= "</tr>";
            }
            $tabla .= "
            </tbody>
            <tfoot>
                <tr>
                <th>Id</th>
                <th>Empresa</th>
                <th>Departamento</th>
                <th>F.F.</th>
                <th>Área</th>
                <th>Tipo de activo</th>
                <th>Referencia</th>
                <th>Serie</th>
                <th>Descripción</th>
                <th>Responsable</th>
                <th>Fecha de compra</th>
                <th>Fecha de adquisición</th>
                <th>Fecha de caducación</th>
                <th>Opciones</th>
                </tr>                             
            </tfoot>
            </table>
            ";
            return $tabla;
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }




}

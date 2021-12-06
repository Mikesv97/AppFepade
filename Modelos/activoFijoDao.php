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

    public function insertarActivoFijo($referencia,$codContabi,$codPro,$serie,$fechaAdq,$factura,$tipoAct,$descripcion,$departamentom,$ff,$area,$usuario,$fecha,$fechaCat){
        $this->conectar();
        $sql = "INSERT INTO Activo(Activo_referencia,PartidaCta,Empresa_id,numero_serie,Activo_fecha_adq,Activo_factura,Activo_tipo,Activo_descripcion,
        Estructura1_id,Estructura2_id,Estructura3_id,Usuario_id,fecha,Activo_fecha_caduc) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute([$referencia,$codContabi,$codPro,$serie,$fechaAdq,$factura,$tipoAct,$descripcion,$departamentom,$ff,$area,$usuario,$fecha,$fechaCat]);
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
        $sql = "SELECT estructura11_id, estructura11_nombre FROM Estructura11";
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
        $sql = "SELECT estructura21_id, estructura21_nombre FROM Estructura21";
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
        $sql = "SELECT estructura31_id, estructura31_nombre FROM Estructura31";
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

    public function comboUsuario(){
        $this->conectar();
        $sql = "SELECT usuario_id, usuario_nombre FROM Usuario";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute();
            $data = array();
            while($fila = $respuesta->fetch(PDO::FETCH_ASSOC)){
                $data[$fila["usuario_id"]]=$fila["usuario_nombre"];
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
    }




}

?>
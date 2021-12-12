<?php
include 'activoFijo.php';

class Activo_fijo_informacion{
    private $con;

    public function __construct(){
    }

    public function conectar(){
        $serverName = "DESKTOP-VAIT65I\SQLEXPRESS";
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

    public function tablaActivoFijo(){
        $this->conectar();
        $sql = "SELECT *FROM Activo";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute();
            $data = $respuesta->fetchAll(PDO::FETCH_ASSOC);
            return $data;
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

    

}

?>
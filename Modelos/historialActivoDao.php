<?php
include_once "historialActivo.php";

class historialActivoDao{

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

    public function insertarHistorial($activoId,$historicoFecha,$estructura31_id,$responsable_id,$comentario,$usuario,$fecha,$estado){
        $this->conectar();
        $sql = "INSERT INTO Historico(Activo_id,Historico_fecha,Estructura31_id,Responsable_id,Historico_comentario,Usuario_id,fecha,Estado) VALUES (?,?,?,?,?,?,?,?)";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute([$activoId,$historicoFecha,$estructura31_id,$responsable_id,$comentario,$usuario,$fecha,$estado]);
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

}


?>
<?php
include_once "historialActivo.php";

class historialActivoDao{

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

    public function insertarHistorial($objeto){
        $ah = $objeto;
        $this->conectar();
        $sql = "INSERT INTO Historico(
            Activo_id,
            Historico_fecha,
            Estructura31_id,
            Responsable_id,
            Historico_comentario,
            Usuario_id,
            fecha,
            Estado) 
            VALUES (?,CURRENT_TIMESTAMP,?,?,?,?,CURRENT_TIMESTAMP,?)";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute([
                $ah->getActivoId(),
                $ah->getEstructura31Id(),
                $ah->getResponsableId(),
                $ah->getHistoricoComentario(),
                $ah->getUsuarioId(),
                $ah->getEstado()
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }  
    }

}


?>
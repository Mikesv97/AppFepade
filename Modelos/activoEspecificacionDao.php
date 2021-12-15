<?php
include 'activoEspe.php';
include_once 'conexion.php';
class activoEspecificacionDao{

    public function __construct(){
    }

<<<<<<< HEAD
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

=======
>>>>>>> 12675ab167f5e3a0119e525652df9af6412433fe
    public function obtenerId(){
       $con = Conexion::conectar();
        $sql = "SELECT MAX(Activo_id) AS id FROM Activo";
        $respuesta = $con->prepare($sql);
        try{

            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute();
            //retornamos la cantidad de registro con el correo ingresado
            //solo puede ser 1 si hay o 0 si no hay
            return $respuesta->fetchColumn();

        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function insertarActEspCom($objeto)
    {
        $ae = $objeto;
        $con = Conexion::conectar();
        $sql = "INSERT INTO Activo_Especificacion(
            Activo_id,
            Procesador,
            Generacion,
            Ram,
            TipoRam,
            DiscoDuro,
            Capacidad_D1,
            DiscoDuro2,
            Capacidad_D2,
            SO,
            Office,
            Modelo,
            IP)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $ae->getActivoId(),
                $ae->getProcesador(),
                $ae->getGeneracion(),
                $ae->getRam(),
                $ae->getTipoRam(),
                $ae->getDiscoDuro(),
                $ae->getCapacidad_D1(),
                $ae->getDiscoDuro2(),
                $ae->getCapacidad_D2(),
                $ae->getSO(),
                $ae->getOffice(),
                $ae->getModelo(),
                $ae->getIP()
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }  
    }

    public function insertarActEspImp($objeto){
        $aei = $objeto;
        $con = Conexion::conectar();
        $sql = "INSERT INTO Activo_Especificacion(
            Activo_id,
            Procesador,
            Generacion,
            Ram,
            DiscoDuro,
            Modelo,
            SO,
            IP,
            TonerN,
            TonerM,
            TonerC,
            TonerA,
            tambor,
            fusor) 
            VALUES (?,'','','','',?,'','',?,?,?,?,?,?)";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $aei->getActivoId(),
                $aei->getModelo(),
                $aei->getTonerN(),
                $aei->getTonerM(),
                $aei->getTonerC(),
                $aei->getTonerA(),
                $aei->getTambor(),
                $aei->getFusor()
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        } 
    }

    public function insertarActEspProy($objeto){
        $ae = $objeto;
        $con = Conexion::conectar();
        $sql = "INSERT INTO Activo_Especificacion(
            Activo_id,
            Procesador,
            Generacion,
            Ram,
            DiscoDuro,
            Modelo,
            SO,
            IP,
            HorasUso,
            HoraEco) 
            VALUES (?,'','','','',?,'','',?,?)";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $ae->getActivoId(),
                $ae->getModelo(),
                $ae->getHorasUso(),
                $ae->getHoraEco(),
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        } 
    }
}
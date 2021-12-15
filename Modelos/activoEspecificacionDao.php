<?php
include 'activoEspe.php';
include_once 'conexion.php';
class activoEspecificacionDao{
    private $con;

    public function __construct(){
    }

    public function obtenerId(){
        $this->con = Conexion::conectar();
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
        $this->con = Conexion::conectar();
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
        $this->con = Conexion::conectar();
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
        $this->con = Conexion::conectar();
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
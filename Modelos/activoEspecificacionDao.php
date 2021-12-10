<?php
include 'activoEspecificacion';

class activoEspecificacionDao{
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

    public function obtenerId(){
        $this->conectar();
        $sql = "SELECT MAX(Activo_id) AS id FROM Activo";
        $respuesta = $this->con->prepare($sql);
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

    public function insertarActEspCom($activoId,$procesador,$generacion,$ram,$tipoRam,$discoDuro,$so,$office,$modelo,$ip,$capacidad1,$discoDuro2,$capacidad2){
        $this->conectar();
        $sql = "INSERT INTO Activo_Especificacion(Activo_id,Procesador,Generacion,Ram,TipoRam,DiscoDuro,SO,Office,Modelo,IP,Capacidad_D1,DiscoDuro2,Capacidad_D2) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute([$activoId,$procesador,$generacion,$ram,$tipoRam,$discoDuro,$so,$office,$modelo,$ip,$capacidad1,$discoDuro2,$capacidad2]);
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

    public function insertarActEspImp($activoId,$modelo,$ip,$tonerN,$toneM,$tonerC,$tonerA,$tambor,$fusor){
        $this->conectar();
        $sql = "INSERT INTO Activo_Especificacion(Activo_id,Modelo,IP,TonerN,TonerM,TonerC,TonerA,tambor,fusor,Procesador,Generacion,Ram,TipoRam,DiscoDuro,SO) 
                VALUES (?,?,?,?,?,?,?,?,?,'','','','','','')";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute([$activoId,$modelo,$ip,$tonerN,$toneM,$tonerC,$tonerA,$tambor,$fusor]);
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

    public function insertarActEspProy($activoId,$modelo,$horasUso,$horasEco){
        $this->conectar();
        $sql = "INSERT INTO Activo_Especificacion(Activo_id,Modelo,IP,HorasUso,HoraEco,Procesador,Generacion,Ram,TipoRam,DiscoDuro,SO) 
                VALUES (?,?,'',?,?,'','','','','','')";
        $respuesta = $this->con->prepare($sql);
        try{
            $respuesta->execute([$activoId,$modelo,$horasUso,$horasEco]);
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
<?php 

class Conexion{

    public static function conectar(){
        $serverName = "DESKTOP-VAIT65I\SQLEXPRESS";
        $basedatos="ACTIVORPT";
        $usuario="";
        $passord="";
        try{
           
            //DECLARANDO CANEDA DE CONEXION
            $con = new PDO("sqlsrv:Server=$serverName;Database=$basedatos",$usuario,$passord);
            
            //preparamos a la libreria PDO para mandar
            //excepsiones en caso de errores
            $con->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $con;
        }catch(PDOException $error){
            //MOSTRANDO ERROR
            echo $error->getMessage();
        }
    
    }

    public static function desconectar($respuesta){
       
        $respuesta->closeCursor();
       

    }

    
}


?>
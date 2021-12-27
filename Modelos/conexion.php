<?php 

class Conexion{

    public static function conectar(){
<<<<<<< HEAD
        $serverName = "DESKTOP-DLGTVHJ\SQLEXPRESS";
=======
        $serverName = "DESKTOP-VAIT65I\SQLEXPRESS";
>>>>>>> d19ec4de0b204579961a05b99ba4d9f631db4824
        $basedatos="ACTIVO";
        try{
           
            //DECLARANDO CANEDA DE CONEXION
            $con = new PDO("sqlsrv:Server=$serverName;Database=$basedatos","","");
            
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
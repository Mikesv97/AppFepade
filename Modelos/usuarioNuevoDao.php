<?php
include "usuarioNuevo.php";

class UsuarioNuevoDao{
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
       
        $respuesta->closeCursor();//dependiendo del driver es obligatorio o no.
       

    }


    public function insertarUsuario($objeto){
        $usuario = new UsuarioNuevo();
        $usuario = $objeto;
        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="insert into usuario values (?,?,?,CURRENT_TIMESTAMP,?,?,?, ?,?,?)";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([
                $usuario->getUsuarioId(),
                $usuario->getUsuarioClave(),
                $usuario->getUsuarioNombre(),
                $usuario->getCorreoElectronico(),
                $usuario->getIdRol(),
                $usuario->getRemember(),
                $usuario->getIdBitacora(),
                $usuario->getFotoUsuario(),
                $usuario->getUsuarioNuevo()
            ]);


            //evaluamos cuantas filas fueron afectadas
            if($respuesta->rowCount() > 0){
                //cerramos conexion
                $this->desconectar($respuesta);
                //si se afectaron más de 0
                return true;                 
            }else{
                return false;
            }
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function insertarBitacoraUs($usuario, $responsable){
        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="insert into bitacora_usuarios values (?,?)";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$usuario,$responsable]);


            //evaluamos cuantas filas fueron afectadas
            if($respuesta->rowCount() > 0){
                //cerramos conexion
                $this->desconectar($respuesta);
                //si se afectaron más de 0
                return true;                 
            }else{
                return false;
            }
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function obtenerIdBitacora(){
        $this->conectar();
        $sql = "select max(id_bitacora) as id from bitacora_usuarios";
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
}
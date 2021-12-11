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

    public function obtenerUsuarios(){     
        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="select a.usuario_id, a.usuario_nombre, a.usuario_fecha, a.correo_electronico, b.rol_nombre, c.usuario_responsable
        from usuario a inner join roles b on a.id_rol = b.id_rol inner join bitacora_usuarios c on a.id_bitacora = c.id_bitacora";
        try{
            //ejecutamos la consulta 
            $respuesta = $this->con->query($sql);

            //retornamos el arreglo
            return $respuesta->fetchAll();
           
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }
}
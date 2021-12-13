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
       
        $respuesta->closeCursor();
       

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

    public function eliminarUsuario($id){
        //evaluamos si el usuario a eliminar no tiene sesión activa
        $usSesion=$this->getSesionEstUsuario($id);
        //si el retorno es diferente a nullId significa que el ID es valido
        if($usSesion!="nullId"){
            //evaluamos que no tenga sesión activa
            if(!$usSesion != 0){
                //si su sesión es diferente a 1 significa esta off y se puede
                //eliminar, caso contrario tiene sesión activa y no se puede borrar.

                //establecemos la coneccion
                $this->conectar();
                //establecemos la consulta
                $sql="delete from usuario where usuario_id = ?";
                //preparamos la consulta
                $respuesta = $this->con->prepare($sql);
                try{
                    //ejecutamos la consulta y seteamos parametros 
                    $respuesta->execute([$id]);
                    //evaluamos cuantas filas fueron afectadas
                    if($respuesta->rowCount() > 0){
                        if($this->eliminarBitaUser($id)!=0){//elimamos bitacora del usuario
                            //si se afecta filas es que se elimino
                            //cerramos conexion
                            $this->desconectar($respuesta);
                            //si se afectaron más de 0
                            return true; 
                        }else{
                            return "userSesOn";
                        }
                    }else{
                        return false;
                    }
                }catch(PDOException $error){
                    return $error->getMessage();
                }
            }else{//como tiene sesión activa retornamos clave para error en alerta.
                return "userSesOn";
            }
        }else{
            //retornamos el valor de retorno al evaluar el ID y su sesión
            //con getSesUser()
            return $usSesion;
        }
        
    }

    //funcion que retorna el valor de la sesión del usuario a eliminar
    //1 si está logueado, 0 si está off.
    public function getSesionEstUsuario($id){
        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="select estado_sesion from usuario where usuario_id = ?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$id]);
            $dato = $respuesta->fetchall(PDO::FETCH_COLUMN, 0);
            if(sizeof($dato)>0){
                $this->desconectar($respuesta); 
                return $dato[0]; 
                
               
            }else{
                $this->desconectar($respuesta); 
                return "nullId";
            }
                        
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }
    
    //funcion que elimina el registro de bitacora usuario
    //retorna el número de filas afectadas
    public function eliminarBitaUser($id){
        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="delete from bitacora_usuarios where usuario_id = ?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$id]);
            return $respuesta->rowCount();
                        
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }
}
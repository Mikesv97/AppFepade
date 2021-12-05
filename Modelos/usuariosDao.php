<?php
session_start();
include 'usuarios.php';

class UsuariosDao{
    private $con;
    private $codGenerado;

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
        $respuesta->closeCursor();//dependiendo del driver es obligatorio o no.
        $respuesta=null;

    }

    /*
    Funcion que valida al usuario al hacer click en iniciar sesion
    recibe su nombre de usuario y su contraseña para prosesar y
    validar contra la base de datos
    */
    public function validarUsuario($nombre,$clave){
        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="select a.usuario_nombre, a.usuario_id, a.correo_electronico, b.rol_nombre
        from usuario a inner join roles b on a.id_rol = b.id_rol where  a.usuario_user=? and a.usuario_clave=?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros
            $respuesta->execute([$nombre, $clave]);
            //convertimos a un arrreglo 
            $datos = $respuesta->fetchall();
    
            //consultamos el tamaño del arreglo para controlar si hay resultados o no
            if(sizeof($datos)>0){
                //si es mayor a 0, es que si hay, recorremos los datos
                foreach($datos as $d){
                    //creamos sesion
                    $_SESSION["usuario"]["nombre"]= $d["usuario_nombre"];
                    $_SESSION["usuario"]["id"]= $d["usuario_id"];
                    $_SESSION["usuario"]["correo"]= $d["correo_electronico"];
                    $_SESSION["usuario"]["rol"]= $d["rol_nombre"];
                }
                //cerramos conexion
                $this->desconectar($respuesta);
                //retornamos verdadero
                return true;

            }

        }catch(PDOException $error){
            return $error->getMessage();
        }
        
    }

    //funcion para actualizar el token de cada usuario en cada login
    public function setUserToken($nombre,$token){

        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="update usuario set token = ? where  usuario_user=?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{

            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$token,$nombre]);
            //evaluamos cuantas filas fueron afectadas
            if($respuesta->rowCount() > 0){
                //cerramos conexion
                $this->desconectar($respuesta);
                //si se afectaron más de 0
                return true;                 
            }
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //funcion para validar que los datos de las cookies sean correctos
    function validarDatosCookie($nombre, $token){
        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="select usuario_nombre, token from usuario where  usuario_user=? and token=?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros
            $datosValidos=$respuesta->execute([$nombre, $token]);
            //vemos si tiene filas la consulta
            if($datosValidos){
                //si tiene fila es que son validos los datos de la cookie
                //regresamos los datos en un array
                $data= array(
                    "nombre" => $nombre,
                    "token" => $token,
                );
                //cerramos conexion
                $this->desconectar($respuesta);
                echo json_encode($data);
            }else{
                echo json_encode(false);
            }
        }catch(PDOException $error){
            return $error->getMessage();
        }

      

    }


    /*
    Funcion que valida al usuario al hacer click en iniciar sesion
    cuando hay cookies de recuerdame
    */
    public function validarUsuarioCookie($nombre,$clave){
        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="select  a.usuario_nombre, a.usuario_id, a.correo_electronico, b.rol_nombre
        from usuario a inner join roles b on a.id_rol = b.id_rol where  a.usuario_user=? and a.token=? or a.usuario_clave=?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros
            $respuesta->execute([$nombre, $clave,$clave]);
            //convertimos a un arrreglo 
            $datos = $respuesta->fetchall();
   
            //consultamos el tamaño del arreglo para controlar si hay resultados o no
            if(sizeof($datos)>0){
                //si es mayor a 0, es que si hay, recorremos los datos
                foreach($datos as $d){
                //creamos sesion
                    $_SESSION["usuario"]["nombre"]= $d["usuario_nombre"];
                    $_SESSION["usuario"]["id"]= $d["usuario_id"];
                    $_SESSION["usuario"]["correo"]= $d["correo_electronico"];
                    $_SESSION["usuario"]["rol"]= $d["rol_nombre"];
                }
                
                //cerramos conexion
                $this->desconectar($respuesta);
                //retornamos verdadero
                return true;
            }

        }catch(PDOException $error){
            return $error->getMessage();
        }

        
        
    }

    //funcion para generar "token" numero al azar
    public function generarToken(){
        $numero_aleatorio = mt_rand(1000000,999999999);
        $token = ($numero_aleatorio +1);
        $this->codGenerado = $token;
        return $token;
    }
    public function getTokenGenerado(){
        return $this->codGenerado;
    }
    //funcion para validar correo cambio contraseña
    public function validarCorreo($correo){

        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="select count(correo_Electronico) from usuario where correo_electronico = ?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{

            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$correo]);
            //retornamos la cantidad de registro con el correo ingresado
            //solo puede ser 1 si hay o 0 si no hay
            return $respuesta->fetchColumn();

        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

}

?>
<?php
session_start();
include 'usuarios.php';

class UsuariosDao{
    private $con;

    public function __construct(){

        
    }

    public function conectar(){
        $serverName = "DESKTOP-DLGTVHJ\SQLEXPRESS";
        $basedatos="ACTIVO";
        try{
            //DECLARANDO CANEDA DE CONEXION
            $this->con = new PDO("sqlsrv:Server=$serverName;Database=$basedatos","","");

        }catch(PDOException $error){
            //MOSTRANDO ERROR
            echo $error->getMessage();
        }
    
    }

    public function desconectar(){
        if(sqlsrv_close($this->con)){
            return true;
        }else{
            return false;
        }
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
        from usuario a inner join roles b on a.id_rol = b.id_rol where usuario_nombre=? and usuario_clave=?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
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
            //retornamos verdadero
            return true;
        }else{
            //caso contrario no hay, retornamos false
            return false;
        }
    }

    //funcion para actualizar el token de cada usuario en cada login
    public function setUserToken($nombre,$token){

        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="update usuario set token = ? where usuario_nombre = ?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        //ejecutamos la consulta y seteamos parametros 
        $respuesta->execute([$token,$nombre]);

        //evaluamos cuantas filas fueron afectadas
        if($respuesta->rowCount() > 0)
            {
                //si se afectaron más de 0
                return true;
            
            }else{
               //caso contrario algo fallo
                print_r($respuesta->errorInfo());
                return false;
            }

    }

    //funcion para validar que los datos de las cookies sean correctos
    function validarDatosCookie($nombre, $token){
        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="select usuario_nombre, token from usuario where usuario_nombre=? and token=?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        //ejecutamos la consulta y seteamos parametros ?
        $respuesta->execute([$nombre, $token]);
        $datosValidos=$respuesta->execute([$nombre, $token]);
        //vemos si tiene filas la consulta
        if($datosValidos){
            //si tiene fila es que son validos los datos de la cookie
            //regresamos los datos en un array
            $data= array(
                "nombre" => $nombre,
                "token" => $token,
            );
            echo json_encode($data);
        }else{
            echo json_encode(false);
        }
      

    }






}

?>
<?php
session_start();
include_once 'conexion.php';

class LoginDao{
    private $codGenerado;

    public function __construct(){

        
    }


    /*Funcion que valida al usuario al hacer click en iniciar sesion*/
    public function validarUsuario($nombre,$clave){

        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="select a.usuario_nuevo, a.usuario_clave , a.usuario_nombre, a.usuario_id, a.correo_electronico, b.rol_nombre
        from usuario a inner join roles b on a.id_rol = b.id_rol where  a.usuario_id=?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros
            $respuesta->execute([$nombre]);
            //convertimos a un arrreglo 
            $datos = $respuesta->fetchall();
    
            //consultamos el tamaño del arreglo para controlar si hay resultados o no
            if(sizeof($datos)>0){
                //si es mayor a 0, es que si hay, recorremos los datos
                foreach($datos as $d){
                    //validamos si la clave coinciden o no

                    $resp= password_verify($clave,$d["usuario_clave"]);
                    if($resp){
                        //creamos sesion
                        $_SESSION["usuario"]["nombre"]= $d["usuario_nombre"];
                        $_SESSION["usuario"]["id"]= $d["usuario_id"];
                        $_SESSION["usuario"]["correo"]= $d["correo_electronico"];
                        $_SESSION["usuario"]["rol"]= $d["rol_nombre"];
                        $_SESSION["usuario"]["usuarioNuevo"]= $d["usuario_nuevo"];

                    }else  if($clave == $d["usuario_clave"]){
                        //creamos sesion
                        $_SESSION["usuario"]["nombre"]= $d["usuario_nombre"];
                        $_SESSION["usuario"]["id"]= $d["usuario_id"];
                        $_SESSION["usuario"]["correo"]= $d["correo_electronico"];
                        $_SESSION["usuario"]["rol"]= $d["rol_nombre"];
                        $_SESSION["usuario"]["usuarioNuevo"]= $d["usuario_nuevo"];
                        
                    }else{
                        return false;
                    }

                }
                //cerramos conexion
                Conexion::desconectar($respuesta);
                //retornamos verdadero
                return true;

            }else{
                return false;
            }

        }catch(PDOException $error){
            return $error->getMessage();
        }
        
    }

    //funcion para verificar y cargar campos en caso exista usuario con recuerdame
    function validarRemember($usuario, $clave){
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="select usuario_id, usuario_clave from usuario where usuario_id =?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros
            //$respuesta->execute([$usuario]);
           $respuesta->execute([$usuario]);
            //convertimos a un array asociativo la respuesta
            $datosBD = $respuesta->fetchall(PDO::FETCH_ASSOC);
            //cerramos puntero
            Conexion::desconectar($respuesta);
            //imprimimos el arreglo.
            echo json_encode($datosBD);            

           
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }

    //actualizar estado de la sessión del usuario activa/off
    function actualizarEstadoUser($valor, $usuario){
                //establecemos la coneccion
                $con = Conexion::conectar();
                //establecemos la consulta
                $sql="update usuario set estado_sesion = ? where  usuario_id=? or usuario_nombre =?";
                //preparamos la consulta
                $respuesta = $con->prepare($sql);
                try{
        
                    //ejecutamos la consulta y seteamos parametros 
                    $respuesta->execute([$valor,$usuario,$usuario]);
                    //evaluamos cuantas filas fueron afectadas
                    if($respuesta->rowCount() > 0){
                        //cerramos conexion
                        Conexion::desconectar($respuesta);
                        //si se afectaron más de 0
                        return true;                 
                    }else{
                        return false;
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

    //funcion que retorna el token generado para el cod del correo
    public function getTokenGenerado(){
        return $this->codGenerado;
    }

    //funcion para validar correo para cambio contraseña
    public function validarCorreo($correo){

        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="select count(correo_Electronico) from usuario where correo_electronico = ?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
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
    
    //funcion para actualizar cambio de contraseña en caso de olvidarla
    public function actualizarPassUser($pass,$correo){
        //encryptamos password
        $passHash= password_hash($pass,PASSWORD_DEFAULT,array("cost"=>12));

        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="update usuario set usuario_clave = ? where  correo_electronico=?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{

            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$passHash,$correo]);
            //evaluamos cuantas filas fueron afectadas
            if($respuesta->rowCount() > 0){
                //cerramos conexion
                Conexion::desconectar($respuesta);
                //si se afectaron más de 0
                return true;                 
            }else{
                echo "noActPass";
            }
        }catch(PDOException $error){
           echo $error->getMessage();
        }
    }

    //funcion que valida la contraseña default en el primer cambio de pass
    public function validarPassOld($passOld, $usuario){

        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="select usuario_clave from usuario where usuario_id =?";
        //preparamos la consulta a ejecutar
        $respuesta = $con->prepare($sql);
        try{

            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$usuario]);
            
            $passDB=$respuesta->fetchColumn();
            Conexion::desconectar($respuesta);
            if(empty($passDB)){
                echo "invalidPassOld";
            }else{
                if(!password_verify($passOld,$passDB)){
                    echo"invalidPassOld";
                }else{
                    echo true;
                }
            }   
           
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }

    //funcion que actualiza la pass en el primer cambio de contraseña del usuario
    public function primerCambioPassUser($pass,$usuario){
        //encryptamos password
        $passHash= password_hash($pass,PASSWORD_DEFAULT,array("cost"=>12));

        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="update usuario set usuario_clave = ? where  usuario_id=?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{

            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$passHash,$usuario]);
            //evaluamos cuantas filas fueron afectadas
            $filas =$respuesta->rowCount();
            Conexion::desconectar($respuesta);

            return $filas;
            
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }

        //funcion que actualiza el campo usuarioNuevo en BD
    public function eliminarEstadoNuevoUser($usuario, $valor){
        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="update usuario set usuario_nuevo = ? where  usuario_id=?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{

            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$valor,$usuario]);
            //evaluamos cuantas filas fueron afectadas
            $filas =$respuesta->rowCount();
            //cerramos conexion
            Conexion::desconectar($respuesta);
            //si se afectaron más de 0
            return $filas;

        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }


    
}

<?php
session_start();
include_once 'conexion.php';

class LoginDao{
    private $con;
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
        //declaramos variable recordar en 1

        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="select usuario_id, usuario_clave from usuario where usuario_id =?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros
            $respuesta->execute([$usuario]);
            $datosBD = $respuesta->fetchall();            

            foreach($datosBD as $d){

                if($clave ==$d["usuario_clave"] || password_verify($clave,$d["usuario_clave"])){
                    $datos = array(
                        'nombre' => $d["usuario_id"],
                        'clave'=>$d["usuario_clave"]
                    );

                    echo json_encode($datos);
                }else{
                    return 'noRemUser';
                }
            }
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //actualizar remember en la BD del usuario que hace login
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
    
    //funcion para actualizar cambio de contraseña
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
                echo json_encode("no se actualizo");
            }
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //funcion que retorna un array con los usuarios que tienen 1 
    //en campo remember para cambiar al ultimo que pide ser recordado
    public function comprobarRememberUs(){
        $reme=1;
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="select usuario_id, remember from usuario where  remember =?";
        //preparamos la consulta
        $respuesta = $con->prepare($sql);
        try{
            //ejecutamos la consulta
            if($respuesta->execute([$reme])){
                //si tiene exito retornamos datos
               
                return  $respuesta->fetchall();
               
                
            }else{
                Conexion::desconectar($respuesta);
                return false;
                
            }
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function validarPassOld($passOld){

        //establecemos la coneccion
        $con = Conexion::conectar();
        //establecemos la consulta
        $sql="select count(correo_Electronico) from usuario where correo_electronico = ?";
        //preparamos la consulta a ejecutar
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
}

?>
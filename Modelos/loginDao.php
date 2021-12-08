<?php
session_start();


class LoginDao{
    private $con;
    private $codGenerado;

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

    /*Funcion que valida al usuario al hacer click en iniciar sesion*/
    public function validarUsuario($nombre,$clave){

        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="select a.usuario_clave , a.usuario_nombre, a.usuario_id, a.correo_electronico, b.rol_nombre
        from usuario a inner join roles b on a.id_rol = b.id_rol where  a.usuario_id=?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
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

                    }else  if($clave == $d["usuario_clave"]){
                        //creamos sesion
                        $_SESSION["usuario"]["nombre"]= $d["usuario_nombre"];
                        $_SESSION["usuario"]["id"]= $d["usuario_id"];
                        $_SESSION["usuario"]["correo"]= $d["correo_electronico"];
                        $_SESSION["usuario"]["rol"]= $d["rol_nombre"];
                        
                    }else{
                        return false;
                    }

                }
                //cerramos conexion
                $this->desconectar($respuesta);
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
    function validarRemember(){
        //declaramos variable recordar en 1
        $remember = 1;
        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="select usuario_id, usuario_clave from usuario where  remember =?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{
            //ejecutamos la consulta y seteamos parametros
            
            //vemos si tiene filas la consulta
            $respuesta->execute([$remember]);
            $datosBD = $respuesta->fetchall();
    
            //consultamos el tamaño del arreglo para controlar si hay resultados o no
            if(sizeof($datosBD)>0){
                //si es mayor a 0, es que si hay, recorremos los datos
                foreach($datosBD as $d){
                   $datos = array(
                       'nombre' => $d["usuario_id"],
                       'clave'=>$d["usuario_clave"]);
                }

                //retornamos datos
                echo json_encode($datos);
                //cerramos conexion
                $this->desconectar($respuesta);
            }else{
                $this->desconectar($respuesta);
                echo json_encode("noRemUser");
            }
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //actualizar remember en la BD del usuario que hace login
    function actualizarRemUser($valor, $usuario){
                //establecemos la coneccion
                $this->conectar();
                //establecemos la consulta
                $sql="update usuario set remember = ? where  usuario_id=?";
                //preparamos la consulta
                $respuesta = $this->con->prepare($sql);
                try{
        
                    //ejecutamos la consulta y seteamos parametros 
                    $respuesta->execute([$valor,$usuario]);
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
    
    //funcion para actualizar cambio de contraseña
    public function actualizarPassUser($pass,$correo){
        //encryptamos password
        $passHash= password_hash($pass,PASSWORD_DEFAULT,array("cost"=>15));

        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="update usuario set usuario_clave = ? where  correo_electronico=?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{

            //ejecutamos la consulta y seteamos parametros 
            $respuesta->execute([$passHash,$correo]);
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

    //funcion que retorna un array con los usuarios que tienen 1 
    //en campo remember para cambiar al ultimo que pide ser recordado
    public function comprobarRememberUs(){
        $reme=1;
        $this->conectar();
        //establecemos la consulta
        $sql="select usuario_id, remember from usuario where  remember =?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        try{
            //ejecutamos la consulta
            if($respuesta->execute([$reme])){
                //si tiene exito retornamos datos
               
                return  $respuesta->fetchall();
               
                
            }else{
                $this->desconectar();
                return false;
                
            }
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }
}

?>
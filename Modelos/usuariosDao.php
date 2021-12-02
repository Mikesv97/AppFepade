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
    Public function validarUsuario($nombre,$clave){
        //establecemos la coneccion
        $this->conectar();
        //establecemos la consulta
        $sql="select a.usuario_nombre, a.usuario_id, a.correo_electronico, b.rol_nombre
        from usuario a inner join roles b on a.id_rol = b.id_rol where usuario_nombre=? and usuario_clave=?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        //ejecutamos la consulta y seteamos parametros ?
        $respuesta->execute([$nombre, $clave]);
        //convertimos a un arrreglo 
        $datos = $respuesta->fetchall();
   
        //consultamos el tamaño del arreglo para controlar si hay resultados o no
        if(sizeof($datos)>0){
            //si es mayor a 0, es que si hay, recorremos los datos
            foreach($datos as $d){

                $_SESSION["usuario"]["nombre"]= $d["usuario_nombre"];
                $_SESSION["usuario"]["id"]= $d["usuario_id"];
                $_SESSION["usuario"]["correo"]= $d["correo_electronico"];
                $_SESSION["usuario"]["rol"]= $d["rol_nombre"];


  
            }

            return true;
        }else{
            //caso contrario no hay, mandamos respuesta error
            return false;
        }
    }




}

?>
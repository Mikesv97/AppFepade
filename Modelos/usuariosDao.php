<?php
include 'usuarios.php';

class UsuariosDao{
    private $con;

    public function __construct(){

        
    }

    public function conectar(){
        $serverName = "DESKTOP-VAIT65I\SQLEXPRESS";
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
        $sql="Select * from usuario where usuario_nombre=? and usuario_clave=?";
        //preparamos la consulta
        $respuesta = $this->con->prepare($sql);
        //ejecutamos la consulta y seteamos parametros ?
        $respuesta->execute([$nombre, $clave]);
        //convertimos a un arrreglo 
        $datos = $respuesta->fetchall();

        //consultamos el tamaño del arreglo para controlar si hay resultados o no
        if(sizeof($datos)>0){
            //si es mayor a 0, es que si hay
            return true;
        }else{
            //caso contrario no hay, mandamos respuesta error
            return false;
        }
    }




}
    
?>
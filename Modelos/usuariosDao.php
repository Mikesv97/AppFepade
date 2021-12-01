<?php
include 'usuarios.php';

class UsuariosDao{
    private $con;

    public function __construct(){

        
    }

    public function conectar(){
        $serverName = "DESKTOP-VAIT65I\SQLEXPRESS";
        $connectionInfo = array( "Database"=>"ACTIVO");
        try{
    
            $this->con = sqlsrv_connect( $serverName, $connectionInfo);
        

            if(!$this->con){
                die( print_r( sqlsrv_errors(), true));
            }

            return $this->con;
        }catch(Exception $error){
            echo $error->getTraceAsString();
        }
    
    }

    public function desconectar(){
        if(sqlsrv_close($this->con)){
            return true;
        }else{
            return false;
        }
    }

    Public function validarUsuario(){
       return $this->conectar();
       
       $sql = "select * from usuario 
       where usuario_nombre=? AND usuario_clave=?";
        

    }




}
    
?>
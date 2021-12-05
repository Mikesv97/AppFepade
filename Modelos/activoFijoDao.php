<?php
include 'activoFijo.php';

class activoFijoDAO{
    private $con;

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
        $respuesta->closeCursor();//dependiendo de la lib es obligatorio o no.
        $respuesta=null;

    }

    public function insertarActivoFijo($referencia,$codContabi,$codPro,$serie,$fechaAdq,$factura,$tipoAct,$descripcion,$departamentom,$ff,$area,$usuario,$fecha,$fechaCat){
        $this->conectar();
        $sql = "INSERT INTO Activo(Activo_referencia,PartidaCta,Empresa_id,numero_serie,Activo_fecha_adq,Activo_factura,Activo_tipo,Activo_descripcion,
        Estructura1_id,Estructura2_id,Estructura3_id,Usuario_id,fecha,Activo_fecha_caduc) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $respuesta = $this->con->prepare($sql);
        try{
            var_dump($respuesta->execute([$referencia,$codContabi,$codPro,$serie,$fechaAdq,$factura,$tipoAct,$descripcion,$departamentom,$ff,$area,$usuario,$fecha,$fechaCat]));
            die;
            $datos = $respuesta->rowCount();
            if($datos > 0){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $error){
            return $error->getMessage();
        }
        
    }
}

?>
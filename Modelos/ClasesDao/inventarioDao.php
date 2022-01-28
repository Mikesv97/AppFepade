<?php
include dirname(__DIR__, 1)."/clases/inventario.php";
include_once dirname(__DIR__, 1).'/conexion.php';

class inventarioDao{

    public function __construct()
    {
    }

    public function insertarInventario($objeto){
        $r = $objeto;
        $con = Conexion::conectar();
        $sql = "INSERT INTO Inventario(
            codigo_barras,
            fecha_inventario)
            VALUES (?,?)";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $r->getCodigoBarra(),
                $r->getFechaInventario()
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }
}

?>
<?php
include 'activoFijo.php';
include_once 'conexion.php';

class activoFijoDAO
{

    public function __construct()
    {
    }

    public function insertarActivoFijo($objeto)
    {
        $a = $objeto;
        $con = Conexion::conectar();
        $sql = "INSERT INTO Activo(
        Activo_referencia,
        PartidaCta,
        Empresa_id,
        numero_serie,
        Activo_fecha_adq,
        Activo_factura,
        Activo_tipo,
        Activo_descripcion,
        Estructura1_id,
        Estructura2_id,
        Estructura3_id,
        Usuario_id,
        fecha,
        Activo_fecha_caduc,
        fecha_compra,
        Activo_eliminado,
        Estado,
        Responsable_codigo,
        Imagen) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP,?,?,?,?,?,?)";
        $respuesta = $con->prepare($sql);
        try {
            $respuesta->execute([
                $a->getActivoReferencia(),
                $a->getPartidaCta(),
                $a->getEmpresaId(),
                $a->getNumeroSerie(),
                date_create($a->getActivoFechaAdq())->format('d/m/y'),
                $a->getActivoFactura(),
                $a->getActivoTipo(),
                $a->getActivoDescripcion(),
                $a->getEstructura1Id(),
                $a->getEstructura2Id(),
                $a->getEstructura3Id(),
                $a->getUsuarioId(),
                date_create($a->getActivoFechaCaduc())->format('d/m/y'),
                date_create($a->getActivoFechaAdq())->format('d/m/y'),
                $a->getActivoEliminado(),
                $a->getEstado(),
                $a->getResponsableCodigo(),
                $a->getImagen()
            ]);
            return $respuesta->rowCount();
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function comboTipoActivo()
    {
        $con = Conexion::conectar();
        $sql = "SELECT tipo_activo_id, tipo_activo_nombre FROM Tipo_activo";
        $respuesta = $con->prepare($sql);
        try {
            $respuesta->execute();
            $data = array();
            while ($fila = $respuesta->fetch(PDO::FETCH_ASSOC)) {
                $data[$fila["tipo_activo_id"]] = $fila["tipo_activo_nombre"];
            }
            return $data;
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function comboDapartamento()
    {
        $con = Conexion::conectar();
        $sql = "SELECT estructura11_id, estructura11_nombre FROM Qry_Estructura11";
        $respuesta = $con->prepare($sql);
        try {
            $respuesta->execute();
            $data = array();
            while ($fila = $respuesta->fetch(PDO::FETCH_ASSOC)) {
                $data[$fila["estructura11_id"]] = $fila["estructura11_nombre"];
            }
            return $data;
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function comboFondos()
    {
        $con = Conexion::conectar();
        $sql = "SELECT estructura21_id, estructura21_nombre FROM Qry_Estructura21";
        $respuesta = $con->prepare($sql);
        try {
            $respuesta->execute();
            $data = array();
            while ($fila = $respuesta->fetch(PDO::FETCH_ASSOC)) {
                $data[$fila["estructura21_id"]] = $fila["estructura21_nombre"];
            }
            return $data;
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function comboArea()
    {
        $con = Conexion::conectar();
        $sql = "SELECT estructura31_id, estructura31_nombre FROM Qry_Estructura31";
        $respuesta = $con->prepare($sql);
        try {
            $respuesta->execute();
            $data = array();
            while ($fila = $respuesta->fetch(PDO::FETCH_ASSOC)) {
                $data[$fila["estructura31_id"]] = $fila["estructura31_nombre"];
            }
            return $data;
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function comboResponsable()
    {
        $con = Conexion::conectar();
        $sql = "SELECT Responsable_codigo, Nombre_responsable FROM Activo_responsable";
        $respuesta = $con->prepare($sql);
        try {
            $respuesta->execute();
            $data = array();
            while ($fila = $respuesta->fetch(PDO::FETCH_ASSOC)) {
                $data[$fila["Responsable_codigo"]] = $fila["Nombre_responsable"];
            }
            return $data;
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function tablaActivoFijo(){
        $con = Conexion::conectar();
        $sql = "SELECT a.*,convert(varchar,a.Activo_fecha_adq,23) as FechaAdquisicion,convert(varchar,a.Activo_fecha_adq,23) as FechaCaducacion,b.*,c.Nombre_Responsable as Responsable, d.usuario_nombre as Usuario, e.* 
        FROM Activo a 
        INNER JOIN Tipo_Activo b 
        ON a.Activo_tipo = b.tipo_activo_id
        INNER JOIN  Activo_responsable c 
        ON a.Responsable_codigo = c.Responsable_codigo
        INNER JOIN Usuario d
        ON a.Usuario_id = d.usuario_id
        INNER JOIN Activo_Especificacion e
        ON a.Activo_id = e.Activo_id";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute();
            $data = $respuesta->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //FUNCION QUE SOLAMENTE HACE UN UPDATE AL ESTADO DE LA TABLA ACTIVO 
    public function updateEstado($objeto){
        $a = $objeto;
        $con = Conexion::conectar();
        $sql = "UPDATE Activo SET Estado = ? WHERE Activo_id = ?";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $a->getEstado(),
                $a->getActivoId()
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function modificarActivoFijo($objeto){
        $a = $objeto;
        $con = Conexion::conectar();
        $sql = "UPDATE Activo SET
        Activo_referencia = ?,
        PartidaCta = ?,
        Empresa_id = ?,
        numero_serie = ?,
        Activo_fecha_adq = ?,
        Activo_factura = ?,
        Activo_tipo = ?,
        Activo_descripcion = ?,
        Estructura1_id = ?,
        Estructura2_id = ?,
        Estructura3_id = ?,
        Usuario_id = ?,
        fecha = CURRENT_TIMESTAMP,
        Activo_fecha_caduc = ?,
        fecha_compra = ?,
        Activo_eliminado = ?,
        Estado = ?,
        Responsable_codigo = ?,
        Imagen = ?
        WHERE Activo_id = ?";
        $respuesta = $con->prepare($sql);
        try {
            $respuesta->execute([
                $a->getActivoReferencia(),
                $a->getPartidaCta(),
                $a->getEmpresaId(),
                $a->getNumeroSerie(),
                date_create($a->getActivoFechaAdq())->format('d/m/y'),
                $a->getActivoFactura(),
                $a->getActivoTipo(),
                $a->getActivoDescripcion(),
                $a->getEstructura1Id(),
                $a->getEstructura2Id(),
                $a->getEstructura3Id(),
                $a->getUsuarioId(),
                date_create($a->getActivoFechaCaduc())->format('d/m/y'),
                date_create($a->getActivoFechaAdq())->format('d/m/y'),
                $a->getActivoEliminado(),
                $a->getEstado(),
                $a->getResponsableCodigo(),
                $a->getImagen(),
                $a->getActivoId()
            ]);
            return $respuesta->rowCount();
        } catch (PDOException $error) {
            return $error->getMessage();
        }
    }

    public function reporteTipoActivo($tipoActivo){
        $con = Conexion::conectar();
        $sql ="select * from activo where activo_tipo =?";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([$tipoActivo]);
            $dato= $respuesta->fetchAll(PDO::FETCH_ASSOC);
            $table ="
            <table>
                <tr>
                    <td>Activo referencia</td>
                    <td>Empresa ID</td>
                    <td>Estructura1 id</td>
                    <td>Estructura2 id</td>
                    <td>Estructura3 id</td>
                    <td>Activo tipo</td>
                    <td>Fecha compra</td>
                    <td>Fecha Caducación</td>
                    <td>Estado</td>
                </tr>
            ";
            foreach($dato as $d){
                $table .= "
                <tr>
                    <td>".$d["Activo_referencia"]."</td>
                    <td>".$d["Empresa_id"]."</td>
                    <td>".$d["Estructura1_id"]."</td>
                    <td>".$d["Estructura2_id"]."</td>
                    <td>".$d["Estructura3_id"]."</td>
                    <td>".$d["Activo_tipo"]."</td>
                    <td>".$d["fecha_compra"]."</td>
                    <td>".$d["Activo_fecha_caduc"]."</td>
                    <td>".$d["Estado"]."</td>
                </tr>
                ";
            }

            $table.="</table>
            </div>";
            return $table;
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

}

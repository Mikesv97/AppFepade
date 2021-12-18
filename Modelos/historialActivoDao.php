<?php
include_once "historialActivo.php";
include_once 'conexion.php';

class historialActivoDao{



    public function __construct(){
    }

    public function insertarHistorial($objeto){
        $ah = $objeto;
        $con = Conexion::conectar();
        $sql = "INSERT INTO Historico(
            Activo_id,
            Historico_fecha,
            Estructura31_id,
            Responsable_id,
            Historico_comentario,
            Usuario_id,
            fecha,
            Estado) 
            VALUES (?,CURRENT_TIMESTAMP,?,?,?,?,CURRENT_TIMESTAMP,?)";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $ah->getActivoId(),
                $ah->getEstructura31Id(),
                $ah->getResponsableId(),
                $ah->getHistoricoComentario(),
                $ah->getUsuarioId(),
                $ah->getEstado()
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }  
    }

    public function insertarNuevoHistorial($objeto){
        $ah = $objeto;
        $con = Conexion::conectar();
        $sql = "INSERT INTO Historico(
            Activo_id,
            Historico_fecha,
            Estructura31_id,
            Responsable_id,
            Historico_comentario,
            Usuario_id,
            fecha,
            Estado) 
            VALUES (?,?,?,?,?,?,CURRENT_TIMESTAMP,?)";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $ah->getActivoId(),
                date_create($ah->getHistoricoFecha())->format('d/m/y'),
                $ah->getEstructura31Id(),
                $ah->getResponsableId(),
                $ah->getHistoricoComentario(),
                $ah->getUsuarioId(),
                $ah->getEstado()
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }  
    }

    public function mostrarHistorial($id){
        $con = Conexion::conectar();
        $sql = "SELECT a.*, b.Activo_descripcion as Descripcion, c.Nombre_Responsable as Responsable, d.estructura31_nombre,
        b.Activo_referencia, convert(varchar,a.Historico_fecha,127) as fechaHistorico
        FROM Historico a
        INNER JOIN Activo b 
        ON a.Activo_id = b.Activo_id 
        INNER JOIN Activo_responsable c
        ON c.Responsable_codigo = a.Responsable_id
        INNER JOIN Qry_Estructura31 d
        ON a.Estructura31_id = d.estructura31_id
        WHERE a.Activo_id = ? ORDER BY Historico_fecha DESC";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([$id]);
            $data = $respuesta->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    public function eliminarHistorial($id){
        $con = Conexion::conectar();
        $sql = "DELETE FROM Historico WHERE Historico_id = ?";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([$id]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        }  
    }

    public function modificarHistorial($objeto){
        $ah = $objeto;
        $con = Conexion::conectar();
        $sql = "UPDATE Historico SET 
            Historico_fecha = ?, 
            Estructura31_id = ?, 
            Responsable_id = ?, 
            Historico_comentario = ?,
            Usuario_id = ?,
            Fecha = CURRENT_TIMESTAMP,
            Estado = ? 
            WHERE Historico_id = ?";
        $respuesta = $con->prepare($sql);
        try{
            $respuesta->execute([
                $ah->getHistoricoFecha(),
                $ah->getEstructura31Id(),
                $ah->getResponsableId(),
                $ah->getHistoricoComentario(),
                $ah->getUsuarioId(),
                $ah->getEstado(),
                $ah->getHistoricoId(),              
            ]);
            return $respuesta->rowCount();
        }catch(PDOException $error){
            return $error->getMessage();
        } 
    }

}


?>
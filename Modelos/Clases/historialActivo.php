<?php

class historial_Activo{

    private $Historico_id;
    private $Activo_id;
    private $Historico_fecha;
    private $Estructura31_id;
    private $Responsable_id;
    private $Historico_comentario;
    private $Usuario_id;
    private $fecha;
    private $Estado;

    public function __construct()
    {
    }

    public function getHistoricoId()
    {
        return $this->Historico_id;
    }

    public function setHistoricoId($Historico_id)
    {
        $this->Historico_id = $Historico_id;
    }

    public function getActivoId()
    {
        return $this->Activo_id;
    }

    public function setActivoId($Activo_id)
    {
        $this->Activo_id = $Activo_id;
    }

    public function getHistoricoFecha()
    {
        return $this->Historico_fecha;
    }

    public function setHistoricoFecha($Historico_fecha)
    {
        $this->Historico_fecha = $Historico_fecha;
    }

    public function getEstructura31Id()
    {
        return $this->Estructura31_id;
    }

    public function setEstructura31Id($Estructura31_id)
    {
        $this->Estructura31_id = $Estructura31_id;
    }

    public function getResponsableId()
    {
        return $this->Responsable_id;
    }

    public function setResponsableId($Responsable_id)
    {
        $this->Responsable_id = $Responsable_id;
    }

    public function getHistoricoComentario()
    {
        return $this->Historico_comentario;
    }

    public function setHistoricoComentario($Historico_comentario)
    {
        $this->Historico_comentario = $Historico_comentario;
    }

    public function getUsuarioId()
    {
        return $this->Usuario_id;
    }

    public function setUsuarioId($Usuario_id)
    {
        $this->Usuario_id = $Usuario_id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getEstado()
    {
        return $this->Estado;
    }

    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
    }

}


?>
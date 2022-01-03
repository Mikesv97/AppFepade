<?php

class tipo_Activo{

    private $tipoActivoId;
    private $tipoActivoNombre;
    private $usuarioId;
    private $fecha;

    public function __construct()
    {
    }

    public function getTipoActivoId(){
        return $this->tipoActivoId;
    }

    public function setTipoActivoId($tipoActivoId){
        $this->tipoActivoId = $tipoActivoId ;
    }

    public function getTipoActivoNombre(){
        return $this->tipoActivoNombre;
    }

    public function setTipoActivoNombre($tipoActivoNombre){
        $this->tipoActivoNombre = $tipoActivoNombre ;
    }

    public function getUsuarioId(){
        return $this->usuarioId;
    }

    public function setUsuarioId($usuarioId){
        $this->usuarioId = $usuarioId ;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha ;
    }

}

?>
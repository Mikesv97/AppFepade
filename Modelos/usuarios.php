<?php

class Usuarios {

    private $usuarioId;
    private $usuarioClave;
    private $usuarioNombre;
    private $usuarioFecha;
    private $usuarioCorreo;

    public function __construct($usuarioId, $usuarioClave,$usuarioNombre,$usuarioFecha,$usuarioCorreo){
        $this->usuarioId = $usuarioId;
        $this->usuarioClave = $usuarioClave;
        $this->usuarioNombre = $usuarioNombre;
        $this->usuarioFecha = $usuarioFecha;        
        $this->usuarioCorreo = $usuarioCorreo;
    }

    public function getUsuarioId(){
        return $this->usuarioId;
    }

    public function setUsuarioId($usuarioId){
        $this->usuarioId = $usuarioId;
    }

    public function getUsuarioClave(){
        return $this->getUsuarioClave;
    }

    public function setUsuarioClave($usuarioClave){
        $this->usuarioClave = $usuarioClave;
    }


    public function getUsuarioNombre(){
        return $this->usuarioNombre;
    }

    public function setUsuarioNombre($usuarioNombre){
        $this->usuarioNombre = $usuarioNombre;
    }

    public function getUsuarioFecha(){
        return $this->usuarioFecha;
    }

    public function setUsuarioFecha($usuarioFecha){
        $this->usuarioFecha = $usuarioFecha;
    }


    public function getUsuarioCorreo(){
        return $this->usuarioCorreo;
    }

    public function setUsuarioCorreo($usuarioCorreo){
        $this->usuarioCorreo = $usuarioCorreo;
    }
}
?>
<?php

class Roles {

    private $idRol;
    private $nombreRol;
    private $descripcionRol;


    public function __construct()
    {
    }

    public function getIdRol()
    {
        return $this->idRol;
    }

    public function setIdRol($idRol)
    {
        $this->idRol = $idRol;
    }

    public function getNombreRol()
    {
        return $this->nombreRol;
    }

    public function setNombreRol($nombreRol)
    {
        $this->nombreRol = $nombreRol;
    }

    public function getDescripcionRol()
    {
        return $this->descripcionRol;
    }

    public function setDescripcionRol($descripcionRol)
    {
        $this->descripcionRol = $descripcionRol;
    }
}
?>
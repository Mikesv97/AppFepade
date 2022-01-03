<?php

class RolAcciones {

    private $idRol;
    private $idAccion;


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

    public function getIdAccion()
    {
        return $this->idAccion;
    }

    public function setIdAccion($idAccion)
    {
        $this->idAccion = $idAccion;
    }

}
?>
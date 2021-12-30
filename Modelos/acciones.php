<?php

class Acciones {

    private $idAccion;
    private $nombreAccion;


    public function __construct()
    {
    }

    public function getIdAccion()
    {
        return $this->idAccion;
    }

    public function setIdAcion($idAccion)
    {
        $this->idAccion = $idAccion;
    }

    public function getNombreAccion()
    {
        return $this->nombreAccion;
    }

    public function setNombreAccion($nombreAccion)
    {
        $this->nombreAccion = $nombreAccion;
    }

}
?>
<?php

class responsable_Activo{

    private $Responsable_codigo;
    private $Codigo_responsable;
    private $Nombre_Responsable;
    private $Estado;

    public function __construct()
    {
    }

    public function getResponsableCodigo(){
        return $this->Responsable_codigo;
    }

    public function setResponsableCodigo($Responsable_codigo){
        $this->Responsable_codigo = $Responsable_codigo ;
    }

    public function getCodigoResponsable(){
        return $this->Codigo_responsable;
    }

    public function setCodigoResponsable($Codigo_responsable){
        $this->Codigo_responsable = $Codigo_responsable;
    }

    public function getNombreResponsable(){
        return $this->Nombre_Responsable;
    }

    public function setNombreResponsable($Nombre_Responsable){
        $this->Nombre_Responsable = $Nombre_Responsable;
    }

    public function getEstado(){
        return $this->Estado;
    }

    public function setEstado($Estado){
        $this->Estado = $Estado;
    }

}

?>
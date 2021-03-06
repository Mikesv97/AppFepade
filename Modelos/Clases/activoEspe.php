<?php
class Activo_Especificacion{

    private $Activo_id;
    private $Procesador;
    private $Generacion;
    private $Ram;
    private $DiscoDuro;
    private $Capacidad_D1;
    private $DiscoDuro2;
    private $Capacidad_D2;
    private $Modelo;
    private $SO;
    private $office;
    private $IP;
    private $TonerN;
    private $TonerM;
    private $TonerC;
    private $TonerA;
    private $HorasUso;
    private $HoraEco;
    private $TipoRam;
    private $tambor;
    private $fusor;

    public function __construct()
    {
    }

    public function getCapacidad_D1()
    {
        return $this->Capacidad_D1;
    }

    public function setCapacidad_D1($Capacidad_D1)
    {
        $this->Capacidad_D1 = $Capacidad_D1;
    }

    public function getDiscoDuro2()
    {
        return $this->DiscoDuro2;
    }

    public function setDiscoDuro2($DiscoDuro2)
    {
        $this->DiscoDuro2 = $DiscoDuro2;
    }

    public function getCapacidad_D2()
    {
        return $this->Capacidad_D2;
    }

    public function setCapacidad_D2($Capacidad_D2)
    {
        $this->Capacidad_D2 = $Capacidad_D2;
    }

    public function getActivoId()
    {
        return $this->Activo_id;
    }

    public function setActivoId($Activo_id)
    {
        $this->Activo_id = $Activo_id;
    }

    public function getProcesador()
    {
        return $this->Procesador;
    }

    public function setProcesador($Procesador)
    {
        $this->Procesador = $Procesador;
    }

    public function getGeneracion()
    {
        return $this->Generacion;
    }

    public function setGeneracion($Generacion)
    {
        $this->Generacion = $Generacion;
    }

    public function getRam()
    {
        return $this->Ram;
    }

    public function setRam($Ram)
    {
        $this->Ram = $Ram;
    }

    public function getDiscoDuro()
    {
        return $this->DiscoDuro;
    }

    public function setDiscoDuro($DiscoDuro)
    {
        $this->DiscoDuro = $DiscoDuro;
    }

    public function getModelo()
    {
        return $this->Modelo;
    }

    public function setModelo($Modelo)
    {
        $this->Modelo = $Modelo;
    }

    public function getSO()
    {
        return $this->SO;
    }

    public function setSO($SO)
    {
        $this->SO = $SO;
    }

    public function getOffice()
    {
        return $this->office;
    }

    public function setOffice($office)
    {
        $this->office = $office;
    }

    public function getIP()
    {
        return $this->IP;
    }

    public function setIP($IP)
    {
        $this->IP = $IP;
    }

    public function getTonerN()
    {
        return $this->TonerN;
    }

    public function setTonerN($TonerN)
    {
        $this->TonerN = $TonerN;
    }

    public function getTonerM()
    {
        return $this->TonerM;
    }

    public function setTonerM($TonerM)
    {
        $this->TonerM = $TonerM;
    }

    public function getTonerC()
    {
        return $this->TonerC;
    }

    public function setTonerC($TonerC)
    {
        $this->TonerC = $TonerC;
    }

    public function getTonerA()
    {
        return $this->TonerA;
    }

    public function setTonerA($TonerA)
    {
        $this->TonerA = $TonerA;
    }

    public function getHorasUso()
    {
        return $this->HorasUso;
    }

    public function setHorasUso($HorasUso)
    {
        $this->HorasUso = $HorasUso;
    }

    public function getHoraEco()
    {
        return $this->HoraEco;
    }

    public function setHoraEco($HoraEco)
    {
        $this->HoraEco = $HoraEco;
    }

    public function getTipoRam()
    {
        return $this->TipoRam;
    }

    public function setTipoRam($TipoRam)
    {
        $this->TipoRam = $TipoRam;
    }

    public function getTambor()
    {
        return $this->tambor;
    }

    public function setTambor($tambor)
    {
        $this->tambor = $tambor;
    }

    public function getFusor()
    {
        return $this->fusor;
    }

    public function setFusor($fusor)
    {
        $this->fusor = $fusor;
    }


}

?>
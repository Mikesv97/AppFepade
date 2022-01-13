<?php

class Inventario {

    private $codigo_barra;
    private $fecha_inventario;


    public function __construct()
    {
    }

    public function getCodigoBarra()
    {
        return $this->codigo_barra;
    }

    public function setCodigoBarra($codigo_barra)
    {
        $this->codigo_barra = $codigo_barra;
    }

    public function getFechaInventario()
    {
        return $this->fecha_inventario;
    }

    public function setFechaInventario($fecha_inventario)
    {
        $this->fecha_inventario = $fecha_inventario;
    }

}
?>
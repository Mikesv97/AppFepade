<?php
class Activo_Fijo{

    private $Activo_id;
    private $Empresa_id;
    private $Estructura1_id;
    private $Estructura2_id;
    private $Estructura3_id;
    private $Activo_tipo;
    private $Activo_referencia;
    private $Activo_descripcion;
    private $Responsable_codigo;
    private $Activo_factura;
    private $Activo_fecha_adq;
    private $Activo_fecha_caduc;
    private $Activo_eliminado;
    private $PartidaCta;
    private $fecha_compra;
    private $Estado;
    private $numero_serie;
    private $Usuario_id;
    private $fecha;
    private $Imagen;

    public function __construct()
    {
    }

    public function getImagen(){
        return $this->Imagen;
    }

    public function setImagen($Imagen){
        $this->Imagen = $Imagen;
    }

    public function getActivoId()
    {
        return $this->Activo_id;
    }

    public function setActivoId($Activo_id)
    {
        $this->Activo_id = $Activo_id;
    }

    public function getEmpresaId()
    {
        return $this->Empresa_id;
    }

    public function setEmpresaId($Empresa_id)
    {
        $this->Empresa_id = $Empresa_id;
    }

    public function getEstructura1Id()
    {
        return $this->Estructura1_id;
    }

    public function setEstructura1Id($Estructura1_id)
    {
        $this->Estructura1_id = $Estructura1_id;
    }

    public function getEstructura2Id()
    {
        return $this->Estructura2_id;
    }

    public function setEstructura2Id($Estructura2_id)
    {
        $this->Estructura2_id = $Estructura2_id;
    }

    public function getEstructura3Id()
    {
        return $this->Estructura3_id;
    }

    public function setEstructura3Id($Estructura3_id)
    {
        $this->Estructura3_id = $Estructura3_id;
    }

    public function getActivoTipo()
    {
        return $this->Activo_tipo;
    }

    public function setActivoTipo($Activo_tipo)
    {
        $this->Activo_tipo = $Activo_tipo;
    }

    public function getActivoReferencia()
    {
        return $this->Activo_referencia;
    }

    public function setActivoReferencia($Activo_referencia)
    {
        $this->Activo_referencia = $Activo_referencia;
    }

    public function getActivoDescripcion()
    {
        return $this->Activo_descripcion;
    }

    public function setActivoDescripcion($Activo_descripcion)
    {
        $this->Activo_descripcion = $Activo_descripcion;
    }

    public function getResponsableCodigo()
    {
        return $this->Responsable_codigo;
    }

    public function setResponsableCodigo($Responsable_codigo)
    {
        $this->Responsable_codigo = $Responsable_codigo;
    }

    public function getActivoFactura()
    {
        return $this->Activo_factura;
    }

    public function setActivoFactura($Activo_factura)
    {
        $this->Activo_factura = $Activo_factura;
    }

    public function getActivoFechaAdq()
    {
        return $this->Activo_fecha_adq;
    }

    public function setActivoFechaAdq($Activo_fecha_adq)
    {
        $this->Activo_fecha_adq = $Activo_fecha_adq;
    }

    public function getActivoFechaCaduc()
    {
        return $this->Activo_fecha_caduc;
    }

    public function setActivoFechaCaduc($Activo_fecha_caduc)
    {
        $this->Activo_fecha_caduc = $Activo_fecha_caduc;
    }

    public function getActivoEliminado()
    {
        return $this->Activo_eliminado;
    }

    public function setActivoEliminado($Activo_eliminado)
    {
        $this->Activo_eliminado = $Activo_eliminado;
    }

    public function getPartidaCta()
    {
        return $this->PartidaCta;
    }

    public function setPartidaCta($PartidaCta)
    {
        $this->PartidaCta = $PartidaCta;
    }

    public function getFechaCompra()
    {
        return $this->fecha_compra;
    }

    public function setFechaCompra($fecha_compra)
    {
        $this->fecha_compra = $fecha_compra;
    }

    public function getEstado()
    {
        return $this->Estado;
    }

    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
    }

    public function getNumeroSerie()
    {
        return $this->numero_serie;
    }

    public function setNumeroSerie($numero_serie)
    {
        $this->numero_serie = $numero_serie;
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

}


?>
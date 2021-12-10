<?php

Class UsuarioNuevo {

    private $usuarId;
    private $usuarioClave;
    private $usuarioNombre;
    private $usuarioFecha;
    private $correoElectronico;
    private $idRol;
    private $remember;
    private $idBitacora;
    private $fotoUsuario;
    private $usuarioNuevo;


    public function __construct()
    {
    
    }

    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId= $usuarioId;
    }

    public function getUsuarioClave()
    {
        return $this->usuarioClave;
    }

    public function setUsuarioClave($usuarioClave)
    {
        $this->usuarioClave = $usuarioClave;
    }

    public function getUsuarioNombre()
    {
        return $this->usuarioNombre;
    }

    public function setUsuarioNombre($usuarioNombre)
    {
        $this->usuarioNombre = $usuarioNombre;
    }

    public function getUsuarioFecha()
    {
        return $this->usuarioFecha;
    }

    public function setUsuarioFecha($usuarioFecha)
    {
        $this->usuarioFecha= $usuarioFecha;
    }

    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
    }

    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico= $correoElectronico;
    }

    public function getIdRol()
    {
        return $this->idRol;
    }

    public function setIdRol($idRol)
    {
        $this->idRol= $idRol;
    }
    public function getRemember()
    {
        return $this->remember;
    }

    public function setRemember($remember)
    {
        $this->remember= $remember;
    }

    /** */
    public function getIdBitacora()
    {
        return $this->idBitacora;
    }

    public function setIdBitacora($idBitacora)
    {
        $this->idBitacora= $idBitacora;
    }

    public function getFotoUsuario()
    {
        return $this->fotoUsuario;
    }

    public function setFotoUsuario($fotoUsuario)
    {
        $this->fotoUsuario= $fotoUsuario;
    }
    public function getUsuarioNuevo()
    {
        return $this->usuarioNuevo;
    }

    public function setUsuarioNuevo($usuarioNuevo)
    {
        $this->usuarioNuevo= $usuarioNuevo;
    }

    
}
?>
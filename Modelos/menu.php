<?php

class Menu {

    private $idMenu;
    private $nombreMenu;
    private $direccionWeb;
    private $menuPadre;


    public function __construct()
    {
    }

    public function getIdMenu()
    {
        return $this->idMenu;
    }

    public function setIdMenu($idMenu)
    {
        $this->idMenu = $idMenu;
    }

    public function getNombreMenu()
    {
        return $this->nombreMenu;
    }

    public function setNombreMenu($nombreMenu)
    {
        $this->nombreMenu = $nombreMenu;
    }
    public function getDireccionWeb()
    {
        return $this->direccionWeb;
    }

    public function setDireccionWeb($direccionWeb)
    {
        $this->direccionWeb = $direccionWeb;
    }
    public function getMenuPadre()
    {
        return $this->menuPadre;
    }

    public function setMenuPadre($menuPadre)
    {
        $this->menuPadre = $menuPadre;
    }


}
?>
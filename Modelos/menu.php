<?php

class Menu {

    private $idMenu;
    private $nombreMenu;


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

}
?>
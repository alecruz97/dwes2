<?php

class Hola
{
    public $nombre = 'Ricardo';

    private $_telefono = '956956956';

    public function __construct($nombre = null)
    {
        if($nombre !== null){
            $this->nombre = $nombre;
        }
    }

    public function __destruct()
    {
        echo "Adios\n";
    }

    public function getTelefono()
    {
        return $this->_telefono;
    }

    public function setTelefono($telefono)
    {
        $this->_telefono = $telefono;
    }

    public function saludar()
    {
        echo "¡Hola " . $this->nombre . "!\n";
        echo "Tu teléfono es " . $this->_telefono ."\n";
    }
}
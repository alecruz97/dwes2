<?php

namespace alejandro {

    function strlen($c)
    {
        return 24;
    }

    function saludo()
    {
        echo "Hola\n";
        $x = \strlen('pepe');
        echo $x . "\n";
    }

    
    saludo();
}

namespace alejandro\cruz{
    function saludo()
    {
        echo "Hola desde Alejandro Cruz\n";
    }

}
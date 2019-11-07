<?php

// try{
//     echo intdiv(1, 0);
// }catch(DivisionByZeroError $e){
//     echo "Ha llegado al catch.\n";
// }

set_error_handler('exception_error_handler');

function exception_error_handler($severidad, $mensaje, $fichero, $linea)
{
    if(!(error_reporting() & $severidad)){
        //Este código de error no está incluido en error_reporting
        return;
    }
    throw new ErrorException($mensaje, 0, $severidad, $fichero, $linea);
}

try {
    echo $pepe;
} catch (ErrorException | Exception $e) {
    echo "Se ha capturado.\n";
}
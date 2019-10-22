<?php

/**
 * Imprime por la salida la tabla de multiplicar del número
 * que se pasa como parámetro.
 *
 * @param int $m
 * @return void
 */
function dibujar_tabla($m = 5)
{
    for ($i = 0; $i<=10; $i++){
        echo "$m x $i = " . $m * $i . "\n";
    }   
}
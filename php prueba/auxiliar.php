<?php

/**
 * Imprime por la salida la tabla de multiplicar del número
 * que se pasa como parámetro.
 *
 * @param  int      $m
 * @return void
 */
function dibujar_tabla($m = 5)
{
    for ($i = 0; $i<=10; $i++){
        echo "$m x $i = " . $m * $i . "\n";
    }   
}

/**
 * Esta función suma dos números.
 *
 * @param   integer     $x
 * @param   integer     $y
 * @return  integer
 */
function suma(int $x, int $y): int
{
    return $x + $y;
}
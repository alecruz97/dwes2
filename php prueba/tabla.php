<?php

/**
 * @author Alejandro Cruz <alecruz230497@gmail.com>
 * @copyright 2019 Alejandro Cruz
 * @license GPL
 */

require __DIR__ . 'auxiliar.php';

if ($argc < 2){
    echo "Sintaxis: {$argv[0]} <número>\n";
    exit(1);
}

$n = $argv[1];

function prueba ()
{
    global $n;
    echo $n;
}

if (!ctype_digit($n)){
    echo "Error: el <número> debe ser un número entero y positivo.\n";
    exit(2);
}

if($n < 0 || $n > 10) {
    echo "Error: el <número> debe estar comprendido entre 0 y 10.\n";
    exit(3);
}

dibujar_tabla($n);
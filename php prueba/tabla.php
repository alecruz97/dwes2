<?php

function dibujar_tabla($m)
{
    for ($i = 0; $i<=10; $i++){
        echo "$m x $i = " . $m * $i . "\n";
    }   
}

if ($argc < 2){
    echo "Sintaxis: {$argv[0]} <número>\n";
    exit(1);
}

$n = $argv[1];

if (!ctype_digit($n)){
    echo "Error: el <número> debe ser un número entero y positivo.\n";
    exit(2);
}

if($n < 0 || $n > 10) {
    echo "Error: el <número> debe estar comprendido entre 0 y 10.\n";
    exit(3);
}

dibujar_tabla($n);
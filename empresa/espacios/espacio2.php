<?php

namespace espacio2;

require __DIR__ . '/espacio3.php';

use espacio3\Prueba as Pru;
use Exception;

$p = new Pru;

$p->saluda();

$e = new Exception();
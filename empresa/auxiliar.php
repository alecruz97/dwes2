<?php

function comprobarParametros($par, &$errores)
{    
    $res = $par;
    if (!empty($_GET)) {
        if (empty(array_diff_key($par,$_GET)) && 
            empty(array_diff_key($_GET, $par))) {
                $res = array_map('trim', $_GET);
        } else{
            $errores[] = 'Los parámetros recibidos no son los correctos.';
        }
    }
    return $res;
}

function comprobarValores($args, &$errores)
{
    extract($args);

    if ($num_dep !== '') {
        if (!ctype_digit($num_dep)) {
            $errores['num_dep'] = 'El número de departamento debe ser un número.';
        } elseif (mb_strlen($num_dep) > 2) {
            $errores['num_dep'] = 'El número no puede tener más de dos dígitos.';
        }
    }

    if ($dnombre !== '') {
        if (mb_strlen($dnombre) > 255){
            $errores['dnombre'] = 'El nombre del departamento no puede tener más de 255 caractéres.';
        }
    }

    comprobarErrores($errores);
}

function mensajeError($campo, $errores)
{
    if(isset($errores[$campo])){
        return <<<EOT
        <div class="invalid-feedback">
            {$errores[$campo]}
        </div>
        EOT;
    }else{
        return '';
    }
}

function comprobarErrores($errores)
{
    if (empty($_GET) || !empty($errores)) {
        throw new Exception();
    }
}

function selected ($op, $o)
{
    return $op == $o ? 'selected' : '';
}

function valido($campo, $errores)
{
    if(isset($errores[$campo])){
        return 'is-invalid';
    } else if(!empty($_GET)){
        return 'is-valid';
    } else{
        return '';
    }
}

function dibujarFormulario($args, $errores)
{ 
    extract($args);
    ?>

    <form action="" method="get">
        <div class="form-group">
            <label for="num_dep">Número:</label>
                <input type="text" class="form-control <?= valido('num_dep', $errores) ?>"
                 name="num_dep" id="num_dep">
            <?= mensajeError('num_dep', $errores) ?>
        </div>

        <div class="form-group">
            <label for="dnombre">Nombre:</label>
                <input type="text" class="form-control <?= valido('dnombre', $errores) ?>"
                 name="dnomre" id="dnombre">
            <?= mensajeError('dnombre', $errores) ?>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
        <button type="reset" class="btn btn-secondary">Limpiar</button>
    </form>
    <?php
}
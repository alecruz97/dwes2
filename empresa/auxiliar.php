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

    if($num_dep === ''){
        $errores['num_dep'] = 'El campo número es obligatorio.';
    }elseif(!ctype_digit($$num_dep)){
        $errores['num_dep'] = 'El número de departamento debe ser un número.';
    }elseif(mb_strlen($num_dep) > 2){
        $errores['num_dep'] = 'El número no puede tener más de dos dígitos.';
    }

    comprobarErrores($errores);
}
/**
 * Vuelca por la salida un mensaje de error.
 *
 * @param string $m
 * @return void
 */
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
            <label for="num_dep">Número</label>
                <input type="text" <?= valido('num_dep', $errores) ?> name="num_dep" id="num_dep" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
    <?php
}
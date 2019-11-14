<?php

function comprobarParametros($par, &$errores)
{    
    // $res = $par;

    $res = [];

    foreach($par as $k => $v){
        if(isset($v['def'])){
            $res[$k] = $v['def'];
        }
    }

    if (!empty($_GET)) {
        if (empty(array_diff_key($res,$_GET)) && 
            empty(array_diff_key($_GET, $res))) {
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

    if (!empty($errores)){
        return;
    }

    if (isset($args['num_dep']) && $num_dep !== '') {
        if (!ctype_digit($num_dep)) {
            $errores['num_dep'] = 'El número de departamento debe ser un número.';
        } elseif (mb_strlen($num_dep) > 2) {
            $errores['num_dep'] = 'El número no puede tener más de dos dígitos.';
        }
    }

    if (isset($args['dnombre']) && $dnombre !== '') {
        if (mb_strlen($dnombre) > 255){
            $errores['dnombre'] = 'El nombre del departamento no puede tener más de 255 caractéres.';
        }
    }

    if (isset($args['localidad']) && $localidad !== '') {
        if (mb_strlen($localidad) > 255){
            $errores['localidad'] = 'El nombre de la localidad no puede tener más de 255 caractéres.';
        }
    }

    // comprobarErrores($errores);
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

    <div class="row mt-3">
        <div class="col-4 offset-4">
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
        </div>
    </div>

    <?php if ($count == 0):?>
        
        <div class="row mt-3">
            <div class="col-8 offset-2">
                <div class="alert alert-danger" role="alert">
                    No se ha encontrado la fila.
                </div>
            </div>
        </div>
        
        <?php elseif (isset($errores[0])): ?>
        <div class="row mt-3">
            <div class="col-8 offset-2">
                <div class="alert alert-danger" role="alert">
                    <?=$errores[0]?>
                </div>
            </div>
        </div>
        
        <?php else: ?>
        <div class="row mt-4">
            <div class="col-8 offset-2">
                <table class="table">
                    <thead>
                        <th scope="col">Número</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Localidad</th>
                    </thead>
                    <tbody>
                        <?php foreach ($stmt as $fila):?>
                            <tr scope="row">
                                <td><?= $fila['num_dep'] ?></td>
                                <td><?= $fila['dnombre'] ?></td>
                                <td><?= $fila['localidad'] ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
            </div>
        </div>
        <?php endif ?>
        

    <?php
}

function insertarFiltro(&$sql, &$execute, $campo, $args, $par, $errores)
{
    if ($args[$campo] !== '' && !isset($errores[$campo])){
        if(){
            $sql .= " AND $campo = :$campo";
            $execute[$campo] = $args[$campo];

        }else{

        }
    }
}

function ejecutarConsulta($ql, $execute, $pdo)
{
    $stmt = $pdo->prepare("SELECT COUNT (*) $sql");
    $stmt -> execute($execute);
    $count = $stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT * $sql");
    $stmt -> execute($execute);

    return

}

function alert($mensaje, $tipo)
{
    ?>
    <div class="row">
        <div class="col-8 offset-2">
            <div class="alert alert-<?= $tipo ?>" role="alert">
                <?= $mensaje ?>            
            </div>
        </div>
    </div>
    <?php
}

function conectar()
{
    return new PDO('pgsql:host=localhost;dbname=datos', 'usuario', 'usuario');
}

function peticion()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET'
}
<?php
function calcular(&$op1, $op2, $op)
{
    switch ($op) {
        case '+':
            $op1 += $op2;
            break;
        
        case '-':
            $op1 -= $op2;
            break;
        case '*':
            $op1 *= $op2;
            break;
        case '/':
            $op1 /= $op2;
            break;
    }
}
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
function comprobarValores($op1, $op2, $op, $ops, &$errores)
{
    if(!is_numeric($op1)){
        $errores[]= 'El primer operando no es un número.';
    }
    if(!is_numeric($op2)){
        $errores[]= 'El segundo operando no es un número.';
    }
    if(!in_array($op, $ops)){
        $errores[]= 'El operador no es correcto.';
    }
    if($op == 2 && $op == '/'){
        $errores[] = 'No se puede dividir por 0.';
    }
    comprobarErrores($errores);
}
/**
 * Vuelca por la salida un mensaje de error.
 *
 * @param string $m
 * @return void
 */
function mensajeError(string $m): void
{ ?>
    <div class="error"><?= $m ?></div><?php
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

function dibujarFormulario($op1, $op2, $op, $ops)
{ 
    ?>
    <form action="" method="get">
        <label for="op1">Primer operando:</label>
        <input type="text" id="op1" name="op1" value="<?= $op1 ?>">
        <br>
        <label for="op2">Segundo operando:</label>
        <input type="text" id="op2" name="op2" value="<?= $op2 ?>">
        <br>
        <label for="op">Operación:</label>
        <select name="op">
            <?php foreach ($ops as $o): ?>
            <option value="<?= $o?>" <?= selected($op, $o) ?>><?= $o?></option>
            <?php endforeach ?>
        </select>
        <br>
        <button type="submit">Calcular</button>
    </form>
    <?php
}

function mostrarErrores($errores)
{
    foreach ($errores as $error) {
        mensajeError($error);
    }
}
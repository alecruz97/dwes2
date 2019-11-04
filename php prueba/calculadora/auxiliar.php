<?php
/**
 * Devuelve el valor de un parámetro GET, o cadena vacía
 * si no existe.
 *
 * @param string $p
 * @return string
 */
function param(string $p): string
{
    return isset($_GET[$p]) ? trim($_GET[$p]) : '';
}
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
function comprobarParametros(&$errores)
{
    $par = ['op1', 'op2', 'op'];
    if (!empty($_GET)) {
        if (!(empty(array_diff($par, array_keys($_GET))) &&
            empty(array_diff(array_keys($_GET), $par)))) {
            $errores[] = 'Los parámetros recibidos no son los correctos.';
        }
    }
}
function comprobarValores($op1, $op2, $op, $ops, $errores)
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
    return is_numeric($op1) && is_numeric($op2) && in_array($op, $ops);
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

function dibujarFormulario($op1, $op2, $op)
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
        <input type="text" id="op" name="op" value="<?= $op ?>">
        <br>
        <button type="submit">Calcular</button>
    </form>
    <?php
}
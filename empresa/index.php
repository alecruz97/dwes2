<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    <div class="container">
        <?php
        require __DIR__ . '/auxiliar.php';

        const TIPO_ENTERO = 0;
        const TIPO_CADENA = 1;

        const PAR = ['num_dep' =>[
                        'def'  => '',
                        'tipo' => TIPO_ENTERO,
                        'etiqueta' => 'Número'
                    ],
                    'dnombre' =>[
                        'def'  => '',
                        'tipo' => TIPO_CADENA,
                        'etiqueta' => 'Departamento'
                    ],
                    'localidad' =>[
                        'etiqueta' => 'Localidad'
                    ],
        ];

        $errores = [];
        $pdo = conectar();

        if (isset($_POST['id'])){
            $id = trim($_POST['id']);
            if (isset($_POST['op']) && $_POST['op'] == 'borrar'){
                $stmt = $pdo->prepare('DELETE
                                       FROM departamentos
                                       WHERE id = :id');
                $stmt->execute(['id' => $id]);
                if($stmt->rowCount() === 1):
                    alert('Se ha borrado con exito.', 'success');
                endif;
                    
            }
        }

        $args = comprobarParametros(PAR, $errores);
        comprobarValores($args, $errores);
                    
        dibujarFormulario($args, $errores);
        
        $sql = 'FROM departamentos WHERE true';
        $execute = [];
        foreach(PAR as $k => $v){
            insertarFiltro($sql, $execute, $k, $args, PAR, $errores);
        }

        [$stmt, $count] = ejecutarConsulta($sql, $execute, $pdo);

        ?>

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
    </div>
            
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de usuarios</title>
    <link rel="stylesheet" href="./assets/bootstrap5.3.3/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <?php
    require "../configuracion.php";

    $datos = darDatosSubmitted();

    $obj = new ABMUsuario();
    $lista = $obj->buscar(null);
    ?>

    <h2 class="text-center">Lista de usuarios</h2>

    <div class="table-responsive">
        <table class="table table-striped border border-secondary mt-3">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Deshabilitado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($lista) > 0) {
                    foreach ($lista as $objTabla) {
                        echo '<tr>';
                        echo '<td>' . $objTabla->getIdUsuario() . '</td>';
                        echo '<td>' . $objTabla->getUsNombre() . '</td>';
                        echo '<td>' . $objTabla->getUsMail() . '</td>';
                        echo '<td>' . $objTabla->getUsDeshabilitado() . '</td>';
                        echo '<td>';
                        echo '<a class="btn btn-primary me-1" role="button" href="accion/editar.php?accion=editar&idusuario=' . $objTabla->getIdUsuario() . '">Editar</a>';
                        echo '<a class="btn btn-primary" role="button" href="accion/editar.php?accion=borrar&idusuario='.$objTabla->getIdUsuario().'">Borrar</a></td></tr>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>


    <?php
    if (isset($datos) && isset($datos['msg']) && $datos['msg'] != null) {
        echo $datos['msg'];
    }
    ?>

    <script src="./assets/bootstrap5.3.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>
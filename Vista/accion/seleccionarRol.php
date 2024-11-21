<?php
require "../../configuracion.php";
$datos = darDatosSubmitted();
$session = new Session();
$roles = $session->getRol();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $rolSeleccionado = false;
    
    if (isset($datos['rol'])) {
        $rolSeleccionado = $datos['rol'];
    } else {
        $error = "No se seleccionó ningún rol.";
    }

    if ($rolSeleccionado) {
        $rolValido = false;
        foreach ($roles as $rol) {
            if ($rol->getIdRol() == $rolSeleccionado) {
                $rolValido = true;
                break;
            }
        }

        if ($rolValido) {
            $session->setRol($rolSeleccionado);
            header("Location: " . match ($rolSeleccionado) {
                1 => "../home/home.php",
                2 => "../administracion/admin.php",
                3 => "../deposito/depo.php",
                default => "../home/home.php",
            });
            exit();
        } else {
            $error = "Rol seleccionado no es válido.";
        }
    } else {
        $error = "No se seleccionó ningún rol.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Rol</title>
    <link rel="stylesheet" href="../assets/bootstrap5.3.3/css/bootstrap.min.css">
</head>

<body>
    <div class="d-flex justify-content-center align-items-center mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <h4>Tiene más de un rol, elija con cuál ingresar</h4>
                <br><br><br><br>
                <div class="col-md-4 col-sm-8 bg-white p-4 rounded shadow">
                    <form method="POST" action="">
                        <div class="form-group mb-3">
                            <label for="rol">Seleccione el rol:</label>
                            <br><br>
                            <select class="form-control" id="rol" name="rol">
                                <option value="">Seleccione...</option>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?php echo $rol->getIdRol(); ?>"><?php echo $rol->getRoDescripcion(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/bootstrap5.3.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
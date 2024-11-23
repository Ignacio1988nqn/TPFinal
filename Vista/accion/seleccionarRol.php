<?php
require "../../configuracion.php";

$session = new Session();
$roles = $session->getRol();
if (!$roles || count($roles) == 0) {
    echo "No se han encontrado roles para este usuario.";
    exit;
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
                    <form id="formRol">
                        <div class="form-group mb-3">
                            <label for="rol">Seleccione el rol:</label>
                            <select class="form-control" id="rol" name="rol">
                                <option value="">Seleccione...</option>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?php echo $rol->getIdRol(); ?>"><?php echo $rol->getRoDescripcion(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary w-100" id="submitRol">Entrar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="../assets/bootstrap5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('submitRol').addEventListener('click', async function () {
        const select = document.getElementById('rol');
        const rol = select.value;

        if (rol === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Rol no seleccionado',
                text: 'Debe seleccionar un rol antes de continuar.',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        const response = await fetch('./procesarRol.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ rol }),
        });

        const result = await response.json();

        if (result.success) {
            window.location.href = result.redirect;
        } else {
            alert(result.message);
        }
    });
</script>

</body>

</html>
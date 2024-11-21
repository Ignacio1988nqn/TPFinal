<?php

require "../../configuracion.php";

$datos = darDatosSubmitted();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/bootstrap5.3.3/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">

    <div class="d-flex justify-content-center align-items-center mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 col-sm-8 bg-white p-4 rounded shadow">
                    <h2 class="mb-4">Iniciar sesion</h2>
                    <form method="POST" action="../accion/verificarLogin.php" name="form-login" id="form-login" class="needs-validation" novalidate>
                        <div class="form-group mb-3">
                            <label for="usnombre">Nombre de usuario:</label>
                            <input type="text" class="form-control" id="usnombre" name="usnombre" required>
                            <div class="invalid-feedback">Ingrese nombre de usuario.</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="uspass">Contraseña:</label>
                            <input type="password" class="form-control" name="uspass" id="uspass" required>
                            <div class="invalid-feedback">Ingrese una contraseña.</div>
                        </div>

                        <span id="mensajeError"></span>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">Iniciar sesion</button>
                    </form>

                    <p>Si no tenes una cuenta, <a class="link-offset-2 link-underline link-underline-opacity-0 " href="../registro/registro.php">registrate</a>.</p>

                </div>
            </div>
        </div>
    </div>

    <script src="../assets/bootstrap5.3.3/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/JsJQuery/jquery-3.7.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

    <script src="../assets/js/validarLogin.js"></script>

</body>

</html>
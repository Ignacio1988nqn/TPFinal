<?php

require "../../configuracion.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="../assets/bootstrap5.3.3/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">


    <div class="d-flex justify-content-center align-items-center mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 col-sm-8 bg-white p-4 rounded shadow">
                    <h2 class="mb-4">Registrarse</h2>
                    <form method="POST" action="../accion/verificarRegistro.php" name="form-registro" id="form-registro" novalidate>
                        <div class="form-group mb-3">
                            <label for="usnombre" class="form-label">Nombre de usuario:</label>
                            <input type="text" class="form-control" id="usnombre" name="usnombre" placeholder="Min. 5 caracteres." required>
                            <div class="invalid-feedback">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="uspass" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" name="uspass" id="uspass" placeholder="Min. 8 caracteres." required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="uspass">Email:</label>
                            <input type="text" class="form-control" name="usmail" id="usmail" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código de verificación:</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Ingrese el texto de la imagen" required>
                            <div class="invalid-feedback" id="error-codigo"></div>
                        </div>

                        <div class="mb-3">
                            <img src="../../Utils/generador_captcha.php" alt="Código de verificación" id="img-codigo">
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="regenera">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z" />
                                </svg>
                            </button>
                            &nbsp;
                            Generar
                        </div>
                        <span id="mensajeError"></span>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Registrarse</button>
                    </form>

                    <p>Si tenes una cuenta, <a class="link-offset-2 link-underline link-underline-opacity-0 " href="../login/login.php">inicia sesion</a>.</p>

                </div>
            </div>
        </div>
    </div>

    <!-- script para generar un codigo cada vez que se clickea el boton -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imgCodigo = document.getElementById('img-codigo');
            const btnGenera = document.getElementById('regenera');

            if (imgCodigo && btnGenera) {
                btnGenera.addEventListener('click', generaCodigo);
            }

            /**
             * Función que realiza una solicitud fetch para obtener una imagen generada.
             * La imagen se asigna dinámicamente a la propiedad 'src' de la imagen en el documento.
             */
            function generaCodigo() {
                let url = '../../Utils/generador_captcha.php';

                fetch(url)
                    .then(response => response.blob())
                    .then(data => {
                        if (data) {
                            imgCodigo.src = URL.createObjectURL(data);
                        }
                    });
            }
        });
    </script>

    <script src="../assets/bootstrap5.3.3/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/JsJQuery/jquery-3.7.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

    <script src="../assets/js/validarRegistro.js"></script>

</body>

</html>
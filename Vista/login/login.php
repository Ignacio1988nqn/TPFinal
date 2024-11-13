<?php

require "../../configuracion.php";

session_start();

// si el usuario ya esta logueado, lo redirecciona a la pagina principal
if (isset($_SESSION['idususario'])) {
    header("Location: index.php");
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/bootstrap5.3.3/css/bootstrap.min.css">
</head>

<body class="bg-light">


    <div class="d-flex justify-content-center align-items-center mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 col-sm-8 bg-white p-4 rounded shadow">
                    <form method="POST" action="../accion/verificarLogin.php" name="form-login" id="form-login">
                        <div class="form-group mb-3">
                            <label for="usuario">Nombre de usuario:</label>
                            <input type="text" class="form-control" id="usnombre" name="usnombre" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="contraseña">Contraseña:</label>
                            <input type="password" class="form-control" name="uspass" id="uspass" required>
                        </div>

                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código de verificación:</label>
                            <input type="text" name="codigo" class="form-control" placeholder="Ingresa el texto de la imagen">
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

                        <input type="button" class="btn btn-primary w-100 mb-3" value="Validar" onclick="formSubmit()">
                    </form>
                    
                    <?php
                    // Mensajes de error
                    if (isset($_GET['error'])) {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Datos incorrectos, vuelva a intentar.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>'.$_GET['error'] ;
                    }

                    if ($mensaje = getFlashData('error')) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?php echo $mensaje; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php }
                    ?>

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
                let url = '../Utils/generador_captcha.php';

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

    
    <!-- scripts para hashear/encriptar la contraseña con MD5 -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

    <script>
        function formSubmit() {
            var password = document.getElementById("uspass").value;
            //console.log(password);
            var passhash = CryptoJS.MD5(password).toString();

            
            // console.log(passhash);
            document.getElementById("uspass").value = passhash;

            setTimeout(function() {
                document.getElementById("form-login").submit();

            }, 500);
        }
    </script>


    <script src="./assets/bootstrap5.3.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>
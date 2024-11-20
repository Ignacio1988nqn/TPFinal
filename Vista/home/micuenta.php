<?php
include_once("../../estructura/header.php");
include_once("../../estructura/sidebar.php");

if (!$session->validar()) {
    header('Location: ../login/login.php');
    exit;
}

$usuario = $session->getUsuario();


$datos = darDatosSubmitted();
$id =  $session->getUsuario()->getIdUsuario();

?>
<section class="home-section">
    <div id="container" style="margin:50px 75px;height: 87vh;">
        <div class="bd" style="background-color: white; padding: 60px;border-radius: 10px">
            <div class="mb-3 row">
                <h4>Mi Cuenta</h4>

                <form id="miCuentaForm">
                    <div class="mb-3 row">
                        <label for="usuario" class="col-sm-2 col-form-label">Usuario</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="usuario" name="usuario"
                                value="<?php echo $session->getUsuario()->getUsNombre(); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo $session->getUsuario()->getUsMail(); ?>">
                            <div class="invalid-feedback">Ingrese un correo electrónico válido</div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nuevaPsw" class="col-sm-2 col-form-label">Nueva Contraseña</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="nuevaPsw" name="nuevaPsw">
                            <div class="invalid-feedback">Minimo 8 caracteres</div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="repetirPsw" class="col-sm-2 col-form-label">Repetir Nueva Contraseña</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="repetirPsw" name="repetirPsw">
                            <div class="invalid-feedback">Las contraseñas deben coincidir</div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary" onclick="guardarCambios()"
                        style="margin-top: 20px;margin-left: 220px;">Guardar Cambios</button>
                </form>

            </div>
        </div>
    </div>
</section>

<?php
include_once("../../estructura/footer.php");
?>

</html>

<script src="../assets/js/JsJQuery/jquery-3.7.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

<script src="../assets/js/cambiarDatosUs.js"></script>
<link rel="stylesheet" href="../assets/bootstrap5.3.3/css/bootstrap.min.css">

<?php
require "../../configuracion.php";
$datos = darDatosSubmitted();

$objC = new ABMUsuario();
$obj = NULL;
if (isset($datos['idusuario']) && $datos['idusuario'] <> -1) {
    $listaTabla = $objC->buscar($datos);
    if (count($listaTabla) == 1) {
        $obj = $listaTabla[0];
    }
}
?>

<div class="d-flex justify-content-center align-items-center mt-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-8 bg-white p-4 rounded shadow">

                <form method="post" action="actualizarLogin.php" name="formulario" id="formulario">
                    <input id="idusuario" name="idusuario" type="hidden" value="<?php echo ($obj != null) ? $obj->getIdUsuario() : "-1" ?>" readonly required>
                    <input id="accion" name="accion" value="<?php echo ($datos['accion'] != null) ? $datos['accion'] : "" ?>" type="hidden">


                    <div class="row mb-3">
                        <div class="col-l-3 ">
                            <div class="form-group has-feedback">
                                <label for="nombre" class="control-label">Nombre:</label>
                                <div class="input-group">
                                    <input id="usnombre" name="usnombre" type="text" class="form-control" value="<?php echo ($obj != null) ? $obj->getUsNombre() : "" ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-l-3">
                            <div class="form-group has-feedback">
                                <label for="uspass" class="control-label">Contraseña:</label>
                                <div class="input-group">
                                    <input id="uspass" name="uspass" type="password" class="form-control" value="<?php echo ($obj != null) ? $obj->getUsPass() : "" ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-l-3">
                            <div class="form-group has-feedback">
                                <label for="usmail" class="control-label">Correo:</label>
                                <div class="input-group">
                                    <input id="usmail" name="usmail" type="text" class="form-control" value="<?php echo ($obj != null) ? $obj->getUsMail() : "" ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-l-3 ">
                            <div class="form-group has-feedback">
                                <label for="usdeshabilitado" class="control-label">Desabilitado:</label>
                                <div class="input-group">
                                    <input id="usdeshabilitado" name="usdeshabilitado" type="datetime-local" class="form-control" value="<?php echo ($obj != null) ? $obj->getUsDeshabilitado() : "" ?>">
                                </div>
                            </div>
                        </div>
                    </div>




                    <input type="button" class="btn btn-primary btn-block w-100" value="<?php echo ($datos['accion'] != null) ? $datos['accion'] : "" ?>" onclick="formSubmit()">
                </form>
                <a class="btn btn-primary w-100" href="../listarUsuario.php">Volver</a>

            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

<script>
    function formSubmit() {
        var password = document.getElementById("uspass").value;
        var passhash = CryptoJS.MD5(password).toString();
        document.getElementById("uspass").value = passhash;

        setTimeout(function() {
            document.getElementById("formulario").submit();

        }, 500);


    }
</script>

<script src="./assets/bootstrap5.3.3/js/bootstrap.bundle.min.js"></script>
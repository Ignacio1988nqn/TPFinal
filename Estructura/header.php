<?php
require "../../configuracion.php";

$session = new Session();
$val = 9;
$rolSelec = $session->getRolSelec();
if ($session->validar()) {
    if ($rolSelec !== null) {
        $val = $rolSelec;
    } else {
        foreach ($session->getRol() as $rol) {
            $val = $rol->getIdRol();
        }
    }
}

$btn1 = "Ingresá";
$btn1Link = "../login/login.php";
$btn2 = "Creá tu cuenta";
$btn2Link = "../registro/registro.php";
$btnCarrito = "Carrito";
$btnCarritoLink = "../carrito/carrito.php";
if ($val != 9) {
    $btn1 = "Log Out";
    $btn1Link = "../logout/logout.php";
}

?>
<!DOCTYPE html>
<html lang="es">

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Amazon Libre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Boxiocns CDN Link -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.js"></script>
    <script src="../assets/bootstrap-5.1.3-dist/js/docs.min.js"></script>
    <script src="../assets/bootstrap5.3.3/js/bootstrap.bundle.min.js"></script>

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="../assets/js/JsJQuery/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/JsJQuery/jquery.validate.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <header class="py-3 mb-3" style="height: 100px;">
        <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
            <img src="../assets/image/logo/imagotipo-png.png" style="float: left;width: 220px;">
            <div class="d-flex align-items-center">
                <div class="col-md-3 text-end" style="margin-top: 20px;margin-right: 100px;position: absolute;right: 0px;">
                    <?php if ($rolSelec !== null): ?>
                        <a type="button" href="../accion/seleccionarRol.php" class="btn btn-outline-primary me-2">Cambiar rol</a>
                    <?php endif; ?>
                    <?php if ($val == 1): ?>
                        <a type="button" href="<?php echo $btnCarritoLink ?>" class="btn btn-outline-primary me-2"><?php echo $btnCarrito ?></a>
                    <?php endif; ?>
                    <a type="button" href="<?php echo $btn1Link ?>" class="btn btn-outline-primary me-2"><?php echo $btn1 ?></a>
                    <?php if ($val == 9): ?>
                        <a type="button" href="<?php echo $btn2Link ?>" class="btn btn-primary"><?php echo $btn2 ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="mensajeapp" id="mensajeapp" name="mensajeapp" class="col-md-4 col-sm-12 mb-30"
            style="opacity : 0;z-index: 1; right: 40px; top: 100px; position: fixed;">
            <div class="card text-white bg-success card-box">
                <div class="card-header">Amazon Libre</div>
                <hr style="margin: 1px; margin-left: -55px;">
                <div class="card-body">
                    <h5 id="mensajestr" class="card-title text-white"></h5>
                </div>
            </div>
        </div>
    </header>

    <div id="mainContainer" style="display: flex;">
        <div id=spinner style="background-color: gainsboro; width: 100%;height: 100%; position: absolute;opacity: 0.5;display:none">
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status" style="margin-top: 250px;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
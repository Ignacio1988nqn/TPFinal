<?php
require "../../configuracion.php";

$session = new Session();
$val = 0;
if ($session->validar()) {
    foreach ($session->getRol() as $rol) {
        $val = $rol->getIdRol();
    }
}
$btn1 = "Ingresá";
$btn1Link = "../login/login.php";
$btn2 = "Creá tu cuenta";
$btn2Link = "../registro/registro.php";
if ($val != 0) {
    $btn1 = "Mi Cuenta";
    $btn1Link = "../home/micuenta.php";
    $btn2 = "Log Out";
    $btn2Link = "../logout/logout.php";
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
                <!-- <form class="w-100 me-3">
                    <input type="search" class="form-control" placeholder="Search..." aria-label="Search"
                        style="width: 640px;margin-left: -87px;margin-top: 20px;">
                </form> -->
                <div class="col-md-3 text-end" style="margin-top: 20px;margin-right: 100px;position: absolute;right: 0px;">
                    <a type="button" href="<?php echo $btn1Link ?>" class="btn btn-outline-primary me-2"><?php echo $btn1 ?></a>
                    <a type="button" href="<?php echo $btn2Link ?>" class="btn btn-primary"><?php echo $btn2 ?></a>
                </div>
            </div>
        </div>
        <div class="mensajeapp" id="mensajeapp" name="mensajeapp" class="col-md-4 col-sm-12 mb-30"
            style="opacity : 0;z-index: 1; right: 40px; top: 30px; position: fixed;">
            <div class="card text-white bg-success card-box">
                <div class="card-header">Amazon Libre</div>
                <hr style="width: 140%; margin-left: -55px;">
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
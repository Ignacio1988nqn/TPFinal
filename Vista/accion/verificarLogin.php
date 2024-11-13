<?php

session_start();

require "../../configuracion.php";

$datos = darDatosSubmitted();
$resp = false;


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreUsuario = $datos["usnombre"];
    $password = $datos["uspass"];
    $codigo = $datos["codigo"];

    if (empty($nombreUsuario) || empty($password) || empty($codigo)) {
        setFlashData('error', 'Debe llenar todos los datos');
        redirect('../login/login.php');
    }

    $captcha = md5($codigo);
    $codigoVerificacion = isset($_SESSION['codigo_verificacion']) ? $_SESSION['codigo_verificacion'] : '';

    if ($codigoVerificacion !== $captcha) {
        $_SESSION['codigo_verificacion'] = '';
        setFlashData('error', 'El código de verificación es incorrecto');
        redirect('../login/login.php');
    }

    $session = new Session();
    // Intentar iniciar sesión
    $resp = $session->iniciar($nombreUsuario, $password);

    if ($resp) {
        foreach ($session->getRol() as $rol) {
            $val = $rol->getIdRol();
        }
        if ($val == 1) {
            header("Location: ../home/home.php");
        } else {
            header("Location: ../administracion/admin.php");
        }

        exit;
    } else {
        setFlashData('error', 'Datos incorrectos, vuelva a intentar');
        redirect('../login/login.php');
    }
}

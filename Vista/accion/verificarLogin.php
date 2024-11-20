<?php

require "../../configuracion.php";

$datos = darDatosSubmitted();

if (isset($datos["usnombre"]) && isset($datos["uspass"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreUsuario = $datos["usnombre"];
    $passwordHash = $datos["uspass"]; // contraseña hasheada

    $session = new Session();

    $session->iniciar($nombreUsuario, $passwordHash);
  
    if ($session->validar()) {
        $usuario = $session->getUsuario(); 
        if (($usuario->getUsDeshabilitado()) !== "" || $usuario->getUsDeshabilitado() !==null ){
            header("Location: ../login/login.php?error=2");
            exit; 
        } 
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
        header("Location: ../login/login.php?error=1");
        exit;
    }
}

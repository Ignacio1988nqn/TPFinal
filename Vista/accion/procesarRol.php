<?php
include_once "../../configuracion.php";

$datos = darDatosSubmitted(); 
$session = new Session();
$roles = $session->getRol(); 

if (!$roles || count($roles) == 0) {
    echo "No se han encontrado roles para este usuario.";
    exit();
}
$rolSel = $datos['rol'] ?? null;

if ($rolSel) {
    $session->setRol($rolSel);
    switch ($rolSel) {
        case 1:
            header("Location: ../home/home.php");
            break;
        case 2:
            header("Location: ../administracion/admin.php");
            break;
        case 3:
            header("Location: "); //agregar ruta deposito 
            break;
        default:
            echo "Rol desconocido.";
            break;
    }
} else {
    echo "No se seleccionó un rol.";
    exit();
}



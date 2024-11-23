<?php
require "../../configuracion.php";

$datos = darDatosSubmittedJSON();
$session = new Session();

$response = [
    "success" => false,
    "message" => "",
    "redirect" => null,
];

if (isset($datos["rol"])) {
    $rolSeleccionado = (int)$datos["rol"];
    $roles = $session->getRol();

    $rolValido = false;
    foreach ($roles as $rol) {
        if ($rol->getIdRol() == $rolSeleccionado) {
            $rolValido = true;
            break;
        }
    }

    if ($rolValido) {
        $session->setRol($rolSeleccionado);

        $response = [
            "success" => true,
            "redirect" => match ($rolSeleccionado) {
                1 => "../home/home.php",
                2 => "../administracion/admin.php",
                3 => "../deposito/depo.php",
                default => null,
            },
            "message" => "Rol seleccionado correctamente.",
        ];
    } else {
        $response["message"] = "Rol inválido seleccionado.";
    }
} else {
    $response["message"] = "No se recibió ningún rol.";
}

header("Content-Type: application/json");
echo json_encode($response);
exit();

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
    $response = $session->procesarRol($rolSeleccionado); // Delegar la lógica al método de la clase Session
} else {
    $response["message"] = "No se recibió ningún rol.";
}

header("Content-Type: application/json");
echo json_encode($response);
exit();

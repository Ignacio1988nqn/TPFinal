<?php
header('Content-Type: application/json; charset=utf-8');

include_once("../../configuracion.php");

$datos = darDatosSubmittedJSON();

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $session->actualizarDatosUsuario($datos);
    echo json_encode($response);
    exit;
}

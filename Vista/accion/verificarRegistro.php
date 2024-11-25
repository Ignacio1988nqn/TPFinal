<?php

require "../../configuracion.php";

$datos = darDatosSubmitted();
$session = new Session();
$response = $session->verificarRegistroUsuario($datos);
echo json_encode($response);

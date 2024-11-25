<?php

require "../../configuracion.php";

$datos = darDatosSubmittedJSON();
$session = new Session();

$response = $session->verificarLoginUsuario($datos);

header("Content-Type: application/json");
echo json_encode($response);
exit();

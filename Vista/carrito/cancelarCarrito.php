<?php

include_once "../../configuracion.php";
$datos = darDatosSubmitted();

$idcompra = $datos['idcompra'];
$abmCarrito = new AbmCarrito();
$abmCarrito->cancelarCarrito($idcompra);

echo json_encode(['success' => true]);

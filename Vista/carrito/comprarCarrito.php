<?php

include_once "../../configuracion.php";
$datos = darDatosSubmitted();
$listacomprar = $datos['lista'];

$abmCarrito = new AbmCarrito();
$abmCarrito->comprarCarrito($listacomprar);

echo json_encode(['success' => true]);
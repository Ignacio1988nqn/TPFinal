<?php

include_once "../../configuracion.php";
$datos = darDatosSubmitted();

$listacomprar = $datos['lista'];
$abmCarrito = new AbmCarrito();
$abmCarrito->vaciarTodoCarrito($listacomprar);

echo json_encode(['success' => true]);

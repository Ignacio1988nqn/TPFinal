<?php
include_once "../../../configuracion.php";
$datos = darDatosSubmitted();

$abmRol = new ABMRol();
$param['idrol'] = $datos['rol'];
$abmRol->baja($param);

echo json_encode(['success' => true]);
?>
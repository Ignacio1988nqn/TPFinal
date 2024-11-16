<?php 
include_once "../../../configuracion.php";
$datos = darDatosSubmitted();

if (isset($datos['descripcion'])) {
    $param['rodescripcion'] = $datos['descripcion']; 
} else {
    echo json_encode(['error' => 'Descripción no proporcionada.']);
    exit;
}

$abmRol = new ABMRol();
$abmRol->alta($param);  
echo json_encode(['success' => true]);


?>
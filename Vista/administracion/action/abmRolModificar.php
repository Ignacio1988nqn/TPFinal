<?php
include_once "../../../configuracion.php";
$datos = darDatosSubmitted();

if (isset($datos['idrol'])) {
    $param['idrol'] = $datos['idrol'];
    $param['rodescripcion'] = $datos['descripcion'];
    
    $abmRol = new ABMRol();
    $res = $abmRol->modificacion($param);  
    if ($res){
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
    
} else {
    echo json_encode(['error' => 'Faltan datos para modificar']);
}
?>

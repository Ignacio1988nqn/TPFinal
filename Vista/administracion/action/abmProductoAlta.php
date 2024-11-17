<?php 

include_once "../../../configuracion.php";
$datos = darDatosSubmitted(); 
if (isset($datos['nombre']) && isset($datos['detalle']) && isset($datos['stock'])){
    $objP = new AbmProducto();
    $param['pronombre'] = $datos['nombre'];
    $param['prodetalle'] = $datos['detalle']; 
    $param['procantstock'] = $datos['stock']; 
    
    if ($objP->alta($param)){ 
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => true]);

    }
} else { 
    echo json_encode(['error' => true]);
}
?>
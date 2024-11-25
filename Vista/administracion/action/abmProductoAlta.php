<?php

include_once "../../../configuracion.php";
$datos = darDatosSubmitted();
if (isset($datos['nombre']) && isset($datos['detalle']) && isset($datos['stock'])) {
    $objP = new AbmProducto();
    $param['pronombre'] = $datos['nombre'];
    $param['prodetalle'] = $datos['detalle'];
    $param['procantstock'] = $datos['stock'];
    $param['tipo'] = $datos['tipo'];

    if ($objP->alta($param)) {
        //maneja la subida del archivo 
        if (isset($_FILES['imagen'])) {
            $imagen = new Imagen();
            $ultimoId = $objP->getLastInsertedID();
            $nombreImagen = $ultimoId . '.jpg';
            $resultadoImagen = $imagen->subirImagen($_FILES['imagen'], $nombreImagen);

            if ($resultadoImagen['success']) {
                $resp = ['success' => true, 'nombre_imagen' => $resultadoImagen['nombre']];
            } 
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => true]);
        }
    } else {
        echo json_encode(['error' => true]);
    }
}
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

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $dir = __DIR__ . '/../../assets/image/';
            $archivo = basename($objP->getLastInsertedID().".jpg");
            $destinp = $dir . $archivo;
            $extPer = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
            $permitido = false;
            foreach ($extPer as $ext) {
                if ($extension === $ext) {
                    $permitido = true;
                }
            }
            if ($permitido) {
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destinp)) {
                    $resp['success'] = true;
                    $resp['nombre'] = $archivo;
                } else {
                    $resp['error'] = 'Error al mover el archivo.';
                }
            } else {
                $resp['error'] = 'Extensión no permitida.';
            }
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => true]);
    }
} else {
    echo json_encode(['error' => true]);
}

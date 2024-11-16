<?php 
include_once "../../../configuracion.php"; 

$resp = ['success' => false];

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $dir = __DIR__ . '/../../assets/image/';
    $archivo = basename($_FILES['imagen']['name']);
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
} else {
    $resp['error'] = 'No se recibió ningún archivo o ocurrió un error.';
}

echo json_encode($resp);
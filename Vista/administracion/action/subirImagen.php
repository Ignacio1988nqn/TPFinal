<?php 
include_once "../../../configuracion.php"; 
$resp = ['success' => false];
if (isset($_FILES['imagen'])) {
    $imagen = new Imagen();
    $resultado = $imagen->subirImagen($_FILES['imagen']);
    if ($resultado['success']) {
        $resp = $resultado; 
    } 
} else {
    $resp['error'] = 'No se recibió ningún archivo.';
}
echo json_encode($resp);
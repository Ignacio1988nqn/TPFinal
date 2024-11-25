<?php

class Imagen {
    private $dirBase;

    public function __construct($rutaBase = null) {
        $this->dirBase = $rutaBase ?: (__DIR__ . '/../Vista/assets/image/'); 
    }

    public function subirImagen($archivo, $nombreArchivo = null) {
        $resp = ['success' => false];
        if (isset($archivo) && $archivo['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $nombreArchivo ?: basename($archivo['name']);
            $destino = $this->dirBase . $nombreArchivo;
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
            $permitido = false;
            foreach ($extensionesPermitidas as $ext) {
                if ($extension === $ext) {
                    $permitido = true;
                    break;
                }
            }
            if ($permitido) {
                if (move_uploaded_file($archivo['tmp_name'], $destino)) {
                    $resp['success'] = true;
                    $resp['nombre'] = $nombreArchivo;
                } else {
                    $resp['error'] = 'Error al mover el archivo.';
                }
            } else {
                $resp['error'] = 'Extensión no permitida.';
            }
        } else {
            $resp['error'] = 'No se recibió ningún archivo o ocurrió un error.';
        }
        return $resp;
    } 

}

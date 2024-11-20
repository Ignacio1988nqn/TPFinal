<?php
header('Content-Type: application/json; charset=utf-8');

include_once("../../configuracion.php");

$datos = darDatosSubmittedJSON();

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usNombre = $datos['usuario'] ?? null;
    $email = $datos['email'] ?? null;
    $passwordHash = $datos['password'] ?? null;
    $repetirPasswordHash = $datos['repetirPassword'] ?? null;

    // verifica si faltan datos
    if (!$email || !$passwordHash || !$repetirPasswordHash) {
        echo json_encode(["success" => false, "message" => "Faltan datos requeridos."]);
        exit;
    }
    
    // verifica si coinciden
    if ($passwordHash !== $repetirPasswordHash) {
        echo json_encode(["success" => false, "message" => "Las contraseñas no coinciden."]);
        exit;
    }

    $usuario = $session->getUsuario();

    $usuarioObj = new Usuario();

    $usuarioObj->setIdUsuario($usuario->getIdUsuario());
    if (!$usuarioObj->buscar()) {
        echo json_encode(["success" => false, "message" => "Usuario no encontrado en la base de datos."]);
        exit;
    }

    // se setean los nuevos datos
    $usuarioObj->setUsMail($email);
    $usuarioObj->setUsPass($passwordHash);

    if ($usuarioObj->modificar()) {
        echo json_encode(["success" => true, "message" => "Datos actualizados con éxito."]);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar: " . $usuarioObj->getMensajeOperacion()]);
        exit;
    }
          
}

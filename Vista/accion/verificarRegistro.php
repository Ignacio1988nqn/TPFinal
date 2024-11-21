<?php

require "../../configuracion.php";

$datos = darDatosSubmitted();

$response = [
    "success" => false,
    "mensaje" => ""
];

if (isset($datos["usnombre"]) && isset($datos["usmail"]) && isset($datos["uspass"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreUsuario = $datos["usnombre"];
    $password = $datos["uspass"];
    $mail = $datos["usmail"];
    $codigo = $datos["codigo"];

    if (empty($codigo)) {
        $response["mensaje"] = "Codigo de verificacion incorrecto.";
        echo json_encode($response);
        exit;
    }

    // min 8 caracteres para la contraseña y 5 para el usuario
    if (strlen($password) < 8) {
        $response["mensaje"] = "La contraseña debe tener al menos 8 caracteres.";
        echo json_encode($response);
        exit;
    }

    if (strlen($nombreUsuario) < 5) {
        $response["mensaje"] = "El usuario debe tener al menos 5 caracteres.";
        echo json_encode($response);
        exit;
    }

    // verificar si ya existe un usuario con ese nombre
    $usuarioExistente = new ABMUsuario();
    $usuarioEncontrado = $usuarioExistente->buscar(['usnombre' => $nombreUsuario]);

    if (!empty($usuarioEncontrado)) {
        $response["mensaje"] = "El nombre de usuario ya está registrado. Por favor elige otro.";
        echo json_encode($response);
        exit;
    }

    // lo mismo con el mail
    $mailUsEncontrado = $usuarioExistente->buscar(['usmail' => $mail]);
    if (!empty($mailUsEncontrado)) {
        $response["mensaje"] = "El mail ya está registrado. Por favor elige otro.";
        echo json_encode($response);
        exit;
    }

    $session = new Session();

    // codigo captcha
    $captcha = md5($codigo);
    $codigoVerificacion = $session->getCodVerif('codigo_verificacion');

    if ($codigoVerificacion !== $captcha) {
        $session->remover('codigo_verificacion');
        $response["mensaje"] = "Código de verificación incorrecto.";
        echo json_encode($response);
        exit;
    }

    $session->cerrar();
    
    $datos['accion'] = 'nuevo';
    $datos['usdeshabilitado'] = null;

    $nuevoUsuario = new ABMUsuario();
    $resp = $nuevoUsuario->abm($datos);

    if ($resp) {
        $ultimoUsuario = $nuevoUsuario->buscar(['usnombre' => $datos['usnombre']]);
        if (!empty($ultimoUsuario)) {
            $idUsuario = $ultimoUsuario[0]->getIdUsuario(); // obtener el id del ultimo usuario

            $datosRol = [
                'accion' => 'asignar_rol',
                'idusuario' => $idUsuario,
                'idrol' => 1, // rol predeterminado "cliente"
            ];

            $rolAsignado = $nuevoUsuario->abm($datosRol);

            if ($rolAsignado) {
                $response["success"] = true;
                $response["mensaje"] = "Registro exitoso. Será redirigido al login.";
                $response["redirect"] = "../login/login.php";
                echo json_encode($response);
                exit;
            } else {
                $response["mensaje"] = "No se pudo asignar el rol, intente nuevamente.";
                echo json_encode($response);
                exit;
            }
        } else {
            $response["mensaje"] = "Usuario no disponible. Intente nuevamente.";
            echo json_encode($response);
            exit;
        }
    } else {
        $response["mensaje"] = "Error al registrar usuario.";
        echo json_encode($response);
        exit;
    }
} else {
    $response["mensaje"] = "Error. Verifique los datos.";
    echo json_encode($response);
    exit;
}

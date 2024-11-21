<?php

require "../../configuracion.php";

$datos = darDatosSubmittedJSON();

$response = [
    "success" => false,
    "message" => ""
];


if (isset($datos["usnombre"]) && isset($datos["uspass"]) && $_SERVER["REQUEST_METHOD"] === "POST") {

    $nombreUsuario = $datos["usnombre"];
    $passwordHash = $datos["uspass"];

    $session = new Session();

    if ($session->iniciar($nombreUsuario, $passwordHash)) {
        $usuario = $session->getUsuario();

        if ($usuario->getUsDeshabilitado()) {
            $response["message"] = "Usuario deshabilitado, no puede iniciar sesión.";
        } else {
            $roles = $session->getRol();
            $cantidadRoles = count($roles);

            if ($cantidadRoles > 1) {
                $response = [
                    "success" => true,
                    "redirect" => "../accion/seleccionarRol.php",
                    "message" => "Inicio de sesión exitoso. Seleccione un rol."
                ];
            } elseif ($cantidadRoles === 1) {
                $rol = $roles[0]->getIdRol();
                $response = [
                    "success" => true,
                    "redirect" => match ($rol) {
                        1 => "../home/home.php",
                        2 => "../administracion/admin.php",
                        3 => "../deposito/depo.php",
                        default => "../home/home.php",
                    },
                    "message" => "Inicio de sesión exitoso.",
                ];
                echo json_encode($response);
                exit();

            } else {
                $response["message"] = "No se han encontrado roles para este usuario.";
            }
        }
    } else {
        $response["message"] = "Usuario o contraseña incorrectos.";
        echo json_encode($response);
        exit();
    }
} else {
    $response["message"] = "Datos invalidos.";
}

header("Content-Type: application/json");
echo json_encode($response);
exit();

<?php

session_start();

require "../../configuracion.php";

$datos = darDatosSubmitted();
$resp = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreUsuario = $datos["usnombre"];
    $password = $datos["uspass"];
    $mail = $datos["usmail"];
    $codigo = $datos["codigo"];

    if (empty($nombreUsuario) || empty($password) || empty($mail) || empty($codigo)) {
        setFlashData('error', 'Debe llenar todos los datos');
        redirect('../registro/registro.php');
    }

    $captcha = md5($codigo);
    $codigoVerificacion = isset($_SESSION['codigo_verificacion']) ? $_SESSION['codigo_verificacion'] : '';

    if ($codigoVerificacion !== $captcha) {
        $_SESSION['codigo_verificacion'] = '';
        setFlashData('error', 'El código de verificación es incorrecto');
        redirect('../registro/registro.php');
    }

    $datos['accion'] = 'nuevo';
    $datos['usdeshabilitado'] = null;

    $nuevoUsuario = new ABMUsuario();
    $resp = $nuevoUsuario->abm($datos);

    if ($resp) {
        $ultimoUsuario = $nuevoUsuario->buscar(['usnombre' => $datos['usnombre']]);
        if (!empty($ultimoUsuario)) {
            $idUsuario = $ultimoUsuario[0]->getIdUsuario();
            // asignar rol  al usuario
            $datosRol = [
                'accion' => 'asignar_rol',
                'idusuario' => $idUsuario,
                'idrol' => 1 // rol predeterminado "cliente"
            ];
    
            $rolAsignado = $nuevoUsuario->abm($datosRol);
    
            if ($rolAsignado) {
                // redirige al login para validar el usuario
                $_SESSION['mensajeRegistro'] = "Usuario registrado exitosamente. Debe validar su sesion.";

                header("Refresh: 1; url=../login/login.php");
                echo $_SESSION['mensajeRegistro'];
                exit;
            } else {
                setFlashData('error', 'Datos incorrectos, vuelva a intentar');
                redirect('../registro/registro.php');
            }
        } else {
            setFlashData('error', 'El usuario no se encuentra disponible.');
            redirect('../registro/registro.php');
        }
    }
}



?>
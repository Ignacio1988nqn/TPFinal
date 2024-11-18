<?php

session_start();

require "../../configuracion.php";

$datos = darDatosSubmitted();
$resp = false;


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreUsuario = $datos["usnombre"];
    $password = $datos["uspass"];
    $codigo = $datos["codigo"];

    if (empty($nombreUsuario) || empty($password) || empty($codigo)) {
        setFlashData('error', 'Debe llenar todos los datos');
        redirect('../login/login.php');
    }

    $captcha = md5($codigo);
    $codigoVerificacion = isset($_SESSION['codigo_verificacion']) ? $_SESSION['codigo_verificacion'] : '';

    if ($codigoVerificacion !== $captcha) {
        $_SESSION['codigo_verificacion'] = '';
        setFlashData('error', 'El código de verificación es incorrecto');
        redirect('../login/login.php');
    }

    $session = new Session();
    // Intentar iniciar sesión
    $resp = $session->iniciar($nombreUsuario, $password);

    if ($resp) {
        //controla los roles
        $abmUsuarioRol = new ABMUsuarioRol(); 
        $idUsuario = $session->getUsuario()->getIdUsuario(); 
        $roles = $abmUsuarioRol->buscar(['idusuario' => $idUsuario]); 
        if (count($roles) > 1 ){                       //si tiene mas de un rol, lo redirecciona a la seleccion de ingreso de rol
            $session->setRoles($roles) ;
            header("Location: /TPFinal/Vista/accion/seleccionarRol.php"); 
            exit(); 
        } else {
            $rol = $roles[0]->getRol()->getIdRol();
            $mapaRoles = [
                1 => '../home/home.php',      
                2 => '../administracion/admin.php', 
                3 => '',                 //agregar pag de rol deposito, si es que tiene 
            ];
            if (isset($mapaRoles[$rol])) {
                header("Location: " . $mapaRoles[$rol]);
            } else {
                echo "Rol no válido o desconocido.";
                exit();
            }
    
            exit;
        }
        
    } else {
        setFlashData('error', 'Datos incorrectos, vuelva a intentar');
        redirect('../login/login.php');
    }
}

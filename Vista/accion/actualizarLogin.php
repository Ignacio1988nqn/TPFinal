<?php
require "../../configuracion.php";
$datos = darDatosSubmitted();
$resp = false;
$objTrans = new ABMUsuario();

if (isset($datos['accion'])) {
    if (isset($datos['accion'])) {
        $resp = $objTrans->abm($datos);
        if ($resp) {
            $mensaje = "La accion " . $datos['accion'] . " se realizo correctamente.";
        } else {
            $mensaje = "La accion " . $datos['accion'] . " no pudo concretarse.";
        }
        echo $mensaje;
        //echo("<script>location.href = '../../index.php?msg=$mensaje';</script>");
    }


    //echo $mensaje;
    //header('Location: ../listarUsuario.php ');
    echo ("<script>location.href = '../listarUsuario.php?msg=$mensaje';</script>");
}

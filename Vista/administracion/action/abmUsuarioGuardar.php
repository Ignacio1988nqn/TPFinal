<?php

include_once "../../../configuracion.php";
$datos = darDatosSubmitted();
$abmusuario = new ABMUsuario();
$resp = $abmusuario->modificarUsuario($datos); 
echo json_encode($resp);

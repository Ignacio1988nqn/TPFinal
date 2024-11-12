<?php 
/*
header('Content-Type: text/html; charset=utf-8');
header ("Cache-Control: no-cache, must-revalidate ");
*/

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////


$PROYECTO ='TPFinal';

//variable que almacena el directorio del proyecto
$ROOT = $_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";

include_once($ROOT.'Utils/funciones.php');

// Variable que define la pagina de autenticacion del proyecto
$INICIO = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/Vista/login.php";

// variable que define la pagina principal del proyecto (menu principal)
$PRINCIPAL = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/menu/index.php";

$_SESSION['ROOT'] = $ROOT;

?>
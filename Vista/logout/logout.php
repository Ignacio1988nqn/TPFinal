<?php

require_once('../../configuracion.php');

$session = new Session();

if($session->validar()){
    $session->cerrar();
    header("Location: ../home/home.php");
}else{
    header("Location: ../login/login.php");
}
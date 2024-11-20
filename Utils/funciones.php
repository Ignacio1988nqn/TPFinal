<?php 
function darDatosSubmitted(){
    $datos = [];
   
    foreach($_GET as $key => $value){
        if($value != null){
            $datos[$key] = $value;
        }
    }
    foreach($_POST as $key => $value){
        if ($value !=null){
        $datos[$key] = $value;
        }
    }

    if ($datos != null){
        $datos = $datos; 
    } else {
        $datos = null; 
    }

    return $datos;
}

function darDatosSubmittedJSON()
{

    $datos = [];

    foreach ($_GET as $key => $value) {
        if (!empty($value)) {
            $datos[$key] = $value;
        }
    }

    foreach ($_POST as $key => $value) {
        if (!empty($value)) {
            $datos[$key] = $value;
        }
    }

    // Procesar datos enviados como JSON, en este caso solicitudes AJAX
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, true);
    if (is_array($input)) {
        foreach ($input as $key => $value) {
            if (!empty($value)) {
                $datos[$key] = $value;
            }
        }
    }

    return !empty($datos) ? $datos : null;
}

function verEstructura($e){
    echo "<pre>";
    print_r($e);
    echo "</pre>"; 
}

spl_autoload_register(function ($class_name){
    //echo "class ".$class_name ;
    $directorys = array(
        $GLOBALS['ROOT'].'Modelo/',
        $GLOBALS['ROOT'].'Modelo/conector/',
        $GLOBALS['ROOT'].'Control/',
        $GLOBALS['ROOT'].'Utils/',
    );
    //print_object($directorys) ;
    
    foreach($directorys as $directory){
        if(file_exists($directory.$class_name . '.php')){
            // echo "se incluyo".$directory.$class_name . '.php';
            require_once($directory.$class_name . '.php');
            return;
        }
    }
    
    /* debug por si falla la inclusion
    foreach($directorys as $directory) {
        $file = $directory . $class_name . '.php';
        echo "Buscando en: " . $file . "<br>"; // Depurar la ruta
        if(file_exists($file)) {
            echo "Cargando: " . $file . "<br>"; // Confirmar la inclusión
            require_once($file);
            return;
        }
    }
    echo "No se encontró la clase " . $class_name . "<br>";
    */
    

});


?>
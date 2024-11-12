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


// funciones para mensajes del captcha

if (!function_exists('setFlashData')) {
    /**
     * Establecer un mensaje flash en la sesión.
     *
     * @param string $indice Nombre de la clave de sesión.
     * @param strign $valor Valor del mensaje
     *
     * @return string|null
     */
    function setFlashData($indice, $valor)
    {
        $_SESSION[$indice] = $valor;
    }
}

if (!function_exists('getFlashData')) {
    /**
     * Obtener y eliminar un mensaje flash de la sesión.
     *
     * @param string $indice Nombre de la clave de sesión.
     *
     * @return string|null
     */
    function getFlashData($indice)
    {
        if (isset($_SESSION[$indice])) {
            $valor = $_SESSION[$indice];
            unset($_SESSION[$indice]);
            return $valor;
        }
        return null;
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirecciona a una URL
     *
     * @param string $url URL de destino
     *
     * @return void
     */
    function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}

?>
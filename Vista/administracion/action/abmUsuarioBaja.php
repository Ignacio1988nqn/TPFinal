<?php 

include_once "../../../configuracion.php"; 
$datos = darDatosSubmitted(); 

if (isset($datos['id'])){
    $abmUsuarioRol = new ABMUsuarioRol() ; //primero eliminamos la relacion

    $abmUsuario = new ABMUsuario(); 
    $param['idusuario'] = $datos['id']; 
    $colRoles = $abmUsuarioRol->buscar($param); 
    foreach ($colRoles as $uno){
        $uno->eliminar(); 
    }
    if ($abmUsuario->bajaElimina($param)){
        echo json_encode(['success' => true]); 
    } else {
        echo json_encode(['error' => true]);
    }
}  else {
    echo json_encode(['error' => true]);
}


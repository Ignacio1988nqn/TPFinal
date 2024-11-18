<?php

class Session
{

    public function __construct()
    {
        if (!self::activa()) {
            session_start();
        }
    }


    public function iniciar($nombreUsuario, $psw)
    {
        $resp = false;
        $obj = new ABMUsuario();

        $param['usnombre'] = $nombreUsuario;
        $param['uspass'] = $psw;
        $param['usdeshabilitado'] = null;

        $resultado = $obj->buscar($param);
        if (count($resultado) > 0) {
            $usuario = $resultado[0];
            $_SESSION['idusuario'] = $usuario->getIdUsuario();
            //maneja los roles en caso de que sean dos o mas 
            
            $abmUsuarioRol = new ABMUsuarioRol();
            $idUsuario = $_SESSION['idusuario']; 
            $roles = $abmUsuarioRol->buscar(['idusuario' => $idUsuario]);
            if (count($roles)>1){
                //var_dump($roles);
                $_SESSION['roles'] = $roles; 
                header("Location: /TPFinal/Vista/accion/seleccionarRol.php");
                exit();
            } 
            $resp = true;
        } else {
            $this->cerrar();
        }
        return $resp;
    }


    public function validar()
    {
        $resp = false;
        if ($this->activa() && isset($_SESSION['idusuario']))
            $resp = true;
        return $resp;
    }


    public static function activa()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }


    public function getUsuario()
    {
        $usuario = null;

        if ($this->validar()) {
            $obj = new ABMUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $resultado = $obj->buscar($param);
            if (count($resultado) > 0) {
                $usuario = $resultado[0];
            }
        }
        return $usuario;
    }


    public function getRol()
    {
        $list_rol = null;
        if ($this->validar()) {
            $obj = new ABMUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $resultado = $obj->darRoles($param);
            if (count($resultado) > 0) {
                $list_rol = $resultado;
            }
        }
        return $list_rol;
    }


    public function cerrar()
    {
        $resp = true;
        session_destroy();
        //$_SESSION['idusuario']=null;
        return $resp;
    }

    public function setRoles($roles) {
        $_SESSION['roles'] = $roles;
    }

    //setea en caso de mas de un rol seleccionado 
    public function setRol($rol){
        $_SESSION['rolSelec'] = $rol; 
    }

    //obtiene el valor de un rol seleccionado en caso de mas de un rol
    public function getRolSelec(){
        $rol = null; 
        if (isset($_SESSION['rolSelec'])){
            $rol = $_SESSION['rolSelec']; 
        }
        return $rol; 
    }
}

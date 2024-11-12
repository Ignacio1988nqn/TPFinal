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
}

<?php
class ABMUsuario
{

    public function abm($datos)
    {
        $resp = false;
        if ($datos['accion'] == 'editar') {
            if ($this->modificacion($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'borrar') {
            if ($this->baja($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'nuevo') {
            if ($this->alta($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'quitar_rol') {
            if ($this->quitar_rol($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'asignar_rol') {
            if ($this->asignar_rol($datos)) {
                $resp = true;
            }
        }
        return $resp;
    }


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Usuario
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        if (
            array_key_exists('idusuario', $param)  and array_key_exists('usnombre', $param) and array_key_exists('uspass', $param)
            and array_key_exists('usmail', $param) and array_key_exists('usdeshabilitado', $param)
        ) {
            $obj = new Usuario();
            $obj->cargar($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
        }
        return $obj;
    }




    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Tabla
     */

    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idusuario'])) {
            $obj = new Usuario();
            $obj->cargar($param['idusuario'], null, null, null, null);
        }
        return $obj;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */


    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idusuario']))
            $resp = true;
        return $resp;
    }


    public function alta($param)
    {
        $resp = false;
        $param['idusuario'] = null;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            $resp = true;
        }
        return $resp;
    }


    public function quitar_rol($param)
    {
        $resp = false;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $elObjtTabla = new UsuarioRol();
            $rol = new Rol();
            $rol->setIdRol($param['idrol']);
            $elObjtTabla->setRol($rol);
            $usuario = new Usuario();
            $usuario->setIdUsuario($param['idusuario']);
            $elObjtTabla->setUsuario($usuario);
            $resp = $elObjtTabla->eliminar();
        }

        return $resp;
    }


    public function asignar_rol($param)
    {
        $resp = false;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $elObjtTabla = new UsuarioRol();
            $rol = new Rol();
            $rol->setIdRol($param['idrol']);
            $elObjtTabla->setRol($rol);
            $usuario = new Usuario();
            $usuario->setIdUsuario($param['idusuario']);
            $elObjtTabla->setUsuario($usuario);
            $resp = $elObjtTabla->insertar();
        }

        return $resp;
    }


    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */

    public function bajaElimina($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null and $elObjtTabla->eliminar()) {
                $resp = true;
            }
        }

        return $resp;
    }
    

    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            
            $elObjtTabla = $this->cargarObjetoConClave($param);

            if ($elObjtTabla != null) {
                // Establecer la fecha y hora actual para marcar al usuario como deshabilitado
                $elObjtTabla->setUsDeshabilitado(date('Y-m-d H:i:s'));

                if ($elObjtTabla->modificar()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }



    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null and $elObjtTabla->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }



    /**
     * Devuelve un arreglo de objetos rol del idusuario pasado por parametro. como arreglo asociativo
     */
    public function darRoles($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idusuario']))
                $where .= " and idusuario =" . $param['idusuario'];
            if (isset($param['idrol']))
                $where .= " and idrol ='" . $param['idrol'] . "'";
        }
        $obj = new UsuarioRol();
        $arreglo = $obj->listar($where);

        $arreglo_obj_roles = array();
        foreach ($arreglo as $obj) {
            $rol = new Rol();
            $rol->setIdRol($obj->getRol()->getIdRol());
            $rol->buscar();
            array_push($arreglo_obj_roles, $rol);
        }

        return $arreglo_obj_roles;
    }


    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idusuario']))
                $where .= " and idusuario =" . $param['idusuario'];
            if (isset($param['usnombre']))
                $where .= " and usnombre ='" . $param['usnombre'] . "'";
            if (isset($param['usmail']))
                $where .= " and usmail ='" . $param['usmail'] . "'";
            if (isset($param['uspass']))
                $where .= " and uspass ='" . $param['uspass'] . "'";
            if (isset($param['usdeshabilitado']))
                $where .= " and usdeshabilitado is null";
        }
        $obj = new Usuario();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    public function modificarUsuario($datos) {
        $param['idusuario'] = $datos['id'];
        $usuario = $this->buscar($param); 
        $retorno = ['success' => false];
        if (count($usuario) > 0) {
            $usuario = $usuario[0]; 
            $habilitado = isset($datos['habilitado']) && $datos['habilitado'] == 1 ? null : date('Y-m-d H:i:s');
            $usuario->setUsDeshabilitado($habilitado); 
            if ($usuario->modificar()) { 
                $abmusuariorol = new ABMUsuarioRol();
                $userrol = $abmusuariorol->buscar($param); //busca los roles actuales
    
                //elimina los roles antiguos
                foreach ($userrol as $us) {
                    $us->eliminar();
                }
    
                //asigna los nuevos roles
                if (isset($datos['roles'])) {
                    foreach ($datos['roles'] as $idrol) {
                        $param['idrol'] = $idrol;
                        $abmrol = new ABMRol();
                        $rol = $abmrol->buscar($param); 
                        if (count($rol) > 0) {
                            $paramUsuarioRol['idusuario'] = $usuario->getIdUsuario();
                            $paramUsuarioRol['idrol'] = $rol[0]->getIdRol();
                            $abmusuariorol->alta($paramUsuarioRol);
                        }
                    }
                }
                if (isset($datos['selectRol'])) {
                    $param['idrol'] = $datos['selectRol'];
                    $rol = $abmrol->buscar($param);
                    if (count($rol) > 0) {
                        $userrol[0]->setIdRol($rol[0]);
                        $userrol[0]->modificar(); 
                    }
                }
                $retorno = ['success' => true]; 
            }
        }
        return $retorno;
    }
    
}

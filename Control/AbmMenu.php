<?php 

class AbmMenu {
    /**
     * Espera como parametro un arreglo asociativo donde las claves coincidmenuen con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Menu
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('idmenu',$param) and array_key_exists('menombre',$param) 
            and array_key_exists('medescripcion', $param) and array_key_exists('idpadre',$param) and array_key_exists('medeshabilitado',$param)){
            $obj = new Menu();
            $objMenuPadre = null; 
             if ($param['idpadre'] == null){
                $objMenuPadre = null;
            }else{
                $objMenuPadre = new Menu();
                $objMenuPadre->setIdMenu($param['idpadre']);
                $objMenuPadre->cargar();
            }
            if ($param['medeshabilitado'] == 'null'){
                $medeshabilitado = null;
            }else{
                $medeshabilitado = $param['medeshabilitado'];
            }
            $obj->setear($param['idmenu'], $param['menombre'], $param['medescripcion'], $objMenuPadre, $medeshabilitado);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coincidmenuen con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Menu
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['idmenu']) ){
            $obj = new Menu();
            $obj->setear($param['idmenu'], null, null, null, null);
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idmenu']))
            $resp = true;
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idmenu'] =null;
        $elObjtMenu = $this->cargarObjeto($param);
//        //verEstructura($elObjtMenu);
        if ($elObjtMenu!=null and $elObjtMenu->insertar()){
            $resp = true;
        }
        return $resp;
        
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtMenu = $this->cargarObjetoConClave($param);
            if ($elObjtMenu!=null and $elObjtMenu->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        //echo "Estoy en modificacion";
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtMenu = $this->cargarObjeto($param);
            if($elObjtMenu!=null and $elObjtMenu->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idmenu']))
                $where.=" and idmenu = ".$param['idmenu'];
            if  (isset($param['menombre']))
                 $where.=" and menombre = '".$param['menombre']."'";
            if  (isset($param['medescripcion']))
                $where.=" and medescripcion = '".$param['medescripcion']."'";
            if  (isset($param['idpadre']))
                $where.=" and idpadre = '".$param['idpadre']."'";
            if  (isset($param['medeshabilitado']))
                $where.=" and medeshabilitado = '".$param['medeshabilitado'] ."'";
        }
        $arreglo = Menu::listar($where);  
        return $arreglo;
    }

    //funcion para abmMenuBuscar
    public function buscarInfo($idmenu){ 
        $param['idmenu'] = $idmenu; 
        $menu = $this->buscar($param); 
        $retorno = []; 
        if ($menu){
            $menuObj = $menu[0];
            //devuelve los datos 
            $retorno['idmenu'] = $menuObj->getIdMenu();
            $retorno['menombre'] = $menuObj->getMeNombre();
            $retorno['medescripcion'] = $menuObj->getMeDescripcion();
            $medeshabilitado = $menuObj->getMeDeshabilitado();
            if ($medeshabilitado == '0000-00-00 00:00:00' || $medeshabilitado==null) {
                $retorno['medeshabilitado'] = null; 
            } else {
                $retorno['medeshabilitado'] = $medeshabilitado;
            }
            //roles asociados al menú
            $abmMenuRol = new AbmMenuRol();
            $rolesAsociados = $abmMenuRol->buscar(['idmenu' => $idmenu]);
            //colecciona los roles asociados para mostrarlos en el check 
            $retorno['roles'] = [];
            foreach ($rolesAsociados as $menuRol) {
            $retorno['roles'][] = $menuRol->getIdRol()->getIdRol(); 
            }
            
            //si hay id padre, lo muestra, si no lo deja vacio. 
            $menuPadre = $menuObj->getIdPadre();
            if ($menuPadre) {
                $retorno['idpadre'] = $menuPadre->getIdMenu();
            } else {
                $retorno['idpadre'] = null;
            }
        } else {
            $retorno['error'] = 'Menú no encontrado';
        }
        return $retorno; 
    }

    //funcion pra simplificar el modificar 
    public function modificarMenu($datos){
        $idmenu = $datos['idmenu'];
        $menus = $this->buscar(['idmenu' => $idmenu]); 
        if (count($menus)>0){
            $param = [
                'idmenu' => $idmenu,
                'menombre' => $datos['menombre'],
                'medescripcion' => $datos['medescripcion'],
                'idpadre' => isset($datos['idpadre']) && $datos['idpadre'] !== '' ? $datos['idpadre'] : null,
                'medeshabilitado' => isset($datos['medeshabilitado']) && $datos['medeshabilitado'] == 'on' ? null : date('Y-m-d H:i:s'),
            ];
            $this->modificacion($param); 
            $abmMenuRol = new AbmMenuRol(); 
            $abmMenuRol->eliminarRoles($idmenu); 
            $abmRol = new ABMRol(); 
            if (isset($datos['idmenu'])){
                foreach($datos['roles'] as $idrol){
                    $rol = $abmRol->buscar(['idrol' => $idrol]); 
                    if (count($rol)>0){
                        $abmMenuRol->asignarRoles($idmenu, $rol[0]->getIdRol()); 
                    }
                }
            }
            if (isset($datos['selectRol'])){
                $rol = $abmRol->buscar(['idrol'=> $datos['selectRol']]); 
                if (count($rol)>0){
                    $abmMenuRol->actualizarRol($idmenu, $rol[0]); 
                }
            }
            $retorno = ['success' => true]; 
        } else {
            $retorno = ['success'=>false]; 
        }
        return $retorno; 
    }

    public function altaMenuYRol($datos){
        $abmMenuRol = new AbmMenuRol();  
        if (isset($datos['menombre']) && isset($datos['medescripcion'])){
            //tomamos los nuevos datos para dar el alta y mandarlos a la funcion
             $idpadre = isset($datos['idpadre']) && $datos['idpadre'] !== "" ? $datos['idpadre'] : NULL;
             $param['menombre'] = $datos['menombre'];
             $param['medescripcion'] = $datos['medescripcion'];
             $param['idpadre'] = $idpadre ;
             $param['medeshabilitado'] = isset($datos['medeshabilitado']) ? $datos['medeshabilitado'] : 0;
             //var_dump($param);
             if ($this->alta($param)){
                //relacion con roles 
                $ultimoId = $this->buscar(['menombre' => $param['menombre']])[0]->getIdMenu();
                foreach ($datos['roles'] as $rolId) {
                    $paramMR = ['idmenu' => $ultimoId, 'idrol' => $rolId];
                    if (!$abmMenuRol->alta($paramMR)) {
                        $resp = (['success' => false, 'message' => 'Error al asignar un rol al menú']);
                        exit;
                    }
                }
                $resp = (['success' => true]);
                exit; 
            }
        }else {
            $resp = (['success' => false, 'message' => 'Datos incompletos']);
        }
        return $resp; 
    }
}
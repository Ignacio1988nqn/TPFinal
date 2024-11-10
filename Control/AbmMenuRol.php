<?php 

class AbmMenuRol {
    /**
     * Espera como parametro un arreglo asociativo donde las claves coincidmenuen con los nombres de las variables instancias del objeto
     * @param array $param
     * @return MenuRol
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('idmenu',$param) and array_key_exists('idrol',$param)){
            $obj = new MenuRol();
            $objMenu = new Menu(); 
            $objMenu->setIdMenu($param['idmenu']);
            $objMenu->cargar(); 
            $objRol = new Rol(); 
            $objRol->setIdRol($param['idrol']); 
            $objRol->cargar();
            $obj->setear($objMenu, $objRol);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coincidmenuen con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return MenuRol
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['idmenu']) && isset($param['idrol']) ){
            $obj = new MenuRol();
            $objMenu = new Menu(); 
            $objMenu->setIdMenu($param['idmenu']);
            $objMenu->cargar(); 
            $objRol = new Rol(); 
            $objRol->setIdRol($param['idrol']); 
            $objRol->cargar();
            $obj->setear($objMenu,$objRol);
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
        if (isset($param['idmenu']) && isset($param['idrol']))
            $resp = true;
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        //$param['idmenu'] =null;
        //$param['idrol'] = null ;
        $elObjtMenuRol = $this->cargarObjeto($param);
//        verEstructura($elObjtMenuRol);
        if ($elObjtMenuRol!=null and $elObjtMenuRol->insertar()){
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
            $elObjtMenuRol = $this->cargarObjetoConClave($param);
            if ($elObjtMenuRol!=null and $elObjtMenuRol->eliminar()){
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
            $elObjtMenuRol = $this->cargarObjeto($param);
            if($elObjtMenuRol!=null and $elObjtMenuRol->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idmenu']))
                $where.=" and idmenu = ".$param['idmenu'];
            if  (isset($param['idrol']))
                 $where.=" and idrol = '".$param['idrol']."'";
        }
        $arreglo = MenuRol::listar($where);  
        return $arreglo;
    }
}
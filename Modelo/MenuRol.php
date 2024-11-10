<?php 

class MenuRol {

    private $idmenu; 
    private $idrol; 
    private $mensajeOperacion; 

    public function __construct()
    {
        $this->idmenu = ""; 
        $this->idrol ="";
    }

    public function getIdMenu(){
		return $this->idmenu;
	}

	public function setIdMenu($idmenu){
		$this->idmenu = $idmenu;
	}

	public function getIdRol(){
		return $this->idrol;
	}

	public function setIdRol($idrol){
		$this->idrol = $idrol;
	}

	public function getMensajeOperacion(){
		return $this->mensajeOperacion;
	}

	public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion = $mensajeOperacion;
	}

    public function setear($idmenu,$idrol){
        $this->setIdMenu($idmenu); 
        $this->setIdRol($idrol);
    }

    
    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM menurol WHERE idmenu = ".$this->getIdMenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idmenu'], $row['idrol']);
                }
            }
        } else {
            $this->setMensajeOperacion("MenuRol->listar: ".$base->getError());
        }
        return $resp;
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO menurol (idmenu, idrol)  VALUES(".$this->getIdMenu()->getIdMenu().", ".$this->getIdRol()->getIdrol().")";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("MenuRol->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE menurol SET idrol='".$this->getIdRol()->getIdRol()."' WHERE id=".$this->getIdMenu()->getIdMenu(). "";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("MenuRol->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM menurol WHERE idmenu =".$this->getIdMenu()->getIdMenu()." AND idrol=" . $this->getIdRol()->getIdRol()."";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("MenuRol->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM menurol ";
        if ($parametro!="") {
            $sql.=' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new MenuRol();
                    $objMenu = new Menu(); 
                    $objMenu->setIdMenu($row['idmenu']); 
                    $objMenu->cargar();
                    $objRol = new Rol(); 
                    $objRol->setIdRol($row['idrol']); 
                    $objRol->cargar();
                    $obj->setear($objMenu, $objRol);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            self::setMensajeOperacion("MenuRol->listar: ".$base->getError());
        }
 
        return $arreglo;
    }
    
}
<?php 

class Menu {

    private $idmenu; 
    private $menombre; 
    private $medescripcion; 
    private $idpadre; //Referencia al id del menu que es subitem, osea una ref a un obj menu
    private $medeshabilitado ; 
    private $mensajeOperacion; 

    public function __construct()
    {
        $this->idmenu =""; 
        $this->menombre =""; 
        $this->medescripcion =""; 
        $this->idpadre = null; 
        $this->medeshabilitado = null;
    }

    public function getIdMenu(){
		return $this->idmenu;
	}

	public function setIdMenu($idmenu){
		$this->idmenu = $idmenu;
	}

	public function getMeNombre(){
		return $this->menombre;
	}

	public function setMeNombre($menombre){
		$this->menombre = $menombre;
	}

	public function getMeDescripcion(){
		return $this->medescripcion;
	}

	public function setMeDescrpcion($medescripcion){
		$this->medescripcion = $medescripcion;
	}

	public function getIdPadre(){
		return $this->idpadre;
	}

	public function setIdPadre($idpadre){
		$this->idpadre = $idpadre;
	}

	public function getMeDeshabilitado(){
		return $this->medeshabilitado;
	}

	public function setMeDeshabilitado($medeshabilitado){
		$this->medeshabilitado = $medeshabilitado;
	}

	public function getMensajeOperacion(){
		return $this->mensajeOperacion;
	}

	public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion = $mensajeOperacion;
	}

    public function setear($idmenu, $menombre, $medescripcion, $idpadre, $medeshabilitado){
        $this->setIdMenu($idmenu);
        $this->setMeNombre($menombre); 
        $this->setMeDescrpcion($medescripcion);
        $this->setIdPadre($idpadre); 
        $this->setMeDeshabilitado($medeshabilitado);
    }

    
    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM menu WHERE idmenu = ".$this->getIdMenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $objMenuP = null; 
                    if ($row['idpadre'] !=null){
                        $objMenuP = new Menu();
                        $objMenuP->setIdMenu($row['idpadre']);
                        $objMenuP->cargar();
                    }
                    $this->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $objMenuP, $row['medeshabilitado']);
                }
            }
        } else {
            $this->setMensajeOperacion("Menu->listar: ".$base->getError());
        }
        return $resp;
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO menu (menombre, medescripcion, idpadre, medeshabilitado)  VALUES('".$this->getMeNombre()."','". $this->getMeDescripcion(). "','". $this->getIdPadre()->getIdMenu(). "','". $this->getMeDeshabilitado(). "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdMenu($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $deshabilitado = "'".$this->getMeDeshabilitado()."'"; 
        if ($this->getMeDeshabilitado() == null) {
            $deshabilitado = 'NULL';
        }
        $sql = "UPDATE menu SET menombre= '".$this->getMeNombre()."', medescripcion = '".$this->getMeDescripcion()."' 
        ,idpadre = '".$this->getIdPadre()->getIdMenu()."',medeshabilitado = ".$deshabilitado." WHERE idmenu = ".$this->getIdMenu()."";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM menu WHERE idmenu = ".$this->getIdMenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("Menu->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM menu ";
        if ($parametro!="") {
            $sql.=' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Menu();
                    $objPadre = null; 
                    if($row['idpadre']!=null){
                        $objPadre = new Menu();
                        $objPadre->setIdMenu($row['idpadre']);
                        $objPadre->cargar();
                    }
                    $obj->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $objPadre, $row['medeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            self::setMensajeOperacion("Menu->listar: ".$base->getError());
        }
        return $arreglo;
    }
    
}

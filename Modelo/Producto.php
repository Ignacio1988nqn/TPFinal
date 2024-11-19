<?php 

class Producto {
    private $idproducto; 
    private $pronombre ; 
    private $prodetalle; 
    private $procantstock ;
    private $tipo ;
    private $mensajeOperacion; 

    public function __construct()
    {
        $this->idproducto= ""; 
        $this->pronombre = ""; 
        $this->prodetalle = ""; 
        $this->procantstock = ""; 
        $this->tipo = ""; 
    }

    public function getIdProducto(){
		return $this->idproducto;
	}

	public function setIdProducto($idproducto){
		$this->idproducto = $idproducto;
	}
    public function getTipo(){
		return $this->tipo;
	}

	public function setTipo($tip){
		$this->tipo = $tip;
	}

	public function getProNombre(){
		return $this->pronombre;
	}

	public function setProNombre($pronombre){
		$this->pronombre = $pronombre;
	}

	public function getProDetalle(){
		return $this->prodetalle;
	}

	public function setProDetalle($prodetalle){
		$this->prodetalle = $prodetalle;
	}

	public function getProCantStock(){
		return $this->procantstock;
	}

	public function setProCantStock($procantstock){
		$this->procantstock = $procantstock;
	}

	public function getMensajeOperacion(){
		return $this->mensajeOperacion;
	}

	public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion = $mensajeOperacion;
	}

    public function setear($idproducto,$pronombre,$prodetalle,$procantstock,$tipo){
        $this->setIdProducto($idproducto);
        $this->setProNombre($pronombre); 
        $this->setProDetalle($prodetalle); 
        $this->setProCantStock($procantstock);
        $this->setTipo($tipo);
    }
    
    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM producto WHERE idproducto = ".$this->getIdProducto(). "";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock'], $row['tipo']);
                    
                }
            }
        } else {
            $this->setMensajeOperacion("Producto->listar: ".$base->getError());
        }
        return $resp;
    
        
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO producto (pronombre, prodetalle, procantstock,tipo)  VALUES('".$this->getProNombre(). "','". $this->getProDetalle(). "','". $this->getProCantStock() . "','". $this->getTipo(). "')" ;
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdProducto($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Producto->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE producto SET pronombre='".$this->getProNombre()."', prodetalle = '". $this->getProDetalle(). "', procantstock = '" . $this->getProCantStock(). "' WHERE idproducto = '".$this->getIdProducto(). "' ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Producto->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM producto WHERE idproducto = ".$this->getIdProducto() ."";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("Producto->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM producto ";
        if ($parametro!="") {
            $sql.=' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Producto();
                    $obj->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock'], $row['tipo']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            self::setMensajeOperacion("Producto->listar: ".$base->getError());
        }
 
        return $arreglo;
    }
}
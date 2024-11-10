<?php 

class CompraItem {

    private $idcompraitem ; 
    private $idproducto ; //ref obj Producto 
    private $idcompra ;   //ref Obj Compra 
    private $cicantidad; 
    private $mensajeOperacion;     

    public function __construct()
    {
        $this->idcompraitem = "";
        $this->idproducto = new Producto(); 
        $this->idcompra = new Compra(); 
        $this->cicantidad = ""; 
    }

    public function getIdCompraItem(){
		return $this->idcompraitem;
	}

	public function setIdCompraItem($idCompraItem){
		$this->idcompraitem = $idCompraItem;
	}

	public function getIdProducto(){
		return $this->idproducto;
	}

	public function setIdProducto($idProducto){
		$this->idproducto = $idProducto;
	}

	public function getIdCompra(){
		return $this->idcompra;
	}

	public function setIdCompra($idCompra){
		$this->idcompra = $idCompra;
	}

	public function getCiCantidad(){
		return $this->cicantidad;
	}

	public function setCiCantidad($ciCantidad){
		$this->cicantidad = $ciCantidad;
	}

	public function getMensajeOperacion(){
		return $this->mensajeOperacion;
	}

	public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion = $mensajeOperacion;
	}

    public function setear($idcompraitem,$idproducto,$idcompra,$cicantidad){
        $this->setIdCompraItem($idcompraitem);
        $this->setIdProducto($idproducto); 
        $this->setIdCompra($idcompra);
        $this->setCiCantidad($cicantidad);
    }

   
    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM compraitem WHERE idcompraitem = ".$this->getIdCompraItem(). "";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();

                    $objProducto = new Producto(); 
                    $objProducto->setIdProducto($row['idproducto']);
                    $objProducto->cargar();
                    $objCompra = new Compra();
                    $objCompra->setIdCompra($row['idcompra']); 
                    $objCompra->cargar();

                    $this->setear($row['idcompraitem'], $objProducto, $objCompra , $row['cicantidad']);
                }
            }
        } else {
            $this->setMensajeOperacion("CompraItem->listar: ".$base->getError());
        }
        return $resp;
    
        
    }
    
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO compraitem (idproducto, idcompra, cicantidad)  VALUES('".$this->getIdProducto()->getIdProducto(). "', '" . $this->getIdCompra()->getIdCompra(). "', '" . $this->getCiCantidad(). "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdCompraItem($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraItem->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "UPDATE compraitem 
        SET idproducto = " . $this->getIdProducto()->getIdProducto() . ", 
            idcompra = " . $this->getIdCompra()->getIdCompra() . ", 
            cicantidad = " . $this->getCiCantidad() . " 
        WHERE idcompraitem = " . $this->getIdCompraItem() . " ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraItem->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM compraitem WHERE idcompraitem = ".$this->getIdCompraItem(). "";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("CompraItem->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM compraitem ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new CompraItem();
                    $objProducto = new Producto(); 
                    $objProducto->setIdProducto($row['idproducto']);
                    $objProducto->cargar();
                    $objCompra = new Compra(); 
                    $objCompra->setIdCompra($row['idcompra']); 
                    $objCompra->cargar();

                    $obj->setear($row['idcompraitem'], $objProducto, $objCompra, $row['cicantidad']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            self::setMensajeOperacion("CompraItem->listar: ".$base->getError());
        }
 
        return $arreglo;
    }
}
<?php

class Compra
{
    private $idcompra;
    private $cofecha;
    private $idusuario; //ref a objusuario
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idcompra = "";
        $this->cofecha = "";
        $this->idcompra = new Usuario(); //falta el obj usuario
    }

    public function getIdCompra()
    {
        return $this->idcompra;
    }

    public function setIdCompra($idcompra)
    {
        $this->idcompra = $idcompra;
    }

    public function getCoFecha()
    {
        return $this->cofecha;
    }

    public function setCoFecha($cofecha)
    {
        $this->cofecha = $cofecha;
    }

    public function getIdUsuario()
    {
        return $this->idusuario;
    }

    public function setIdUsuario($idusuario)
    {
        $this->idusuario = $idusuario;
    }
    public function getMensajeOperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeoperacion = $mensajeOperacion;
    }

    public function setear($idcompra, $cofecha, $idusuario)
    {
        $this->setIdCompra($idcompra);
        $this->setCoFecha($cofecha);
        $this->setIdUsuario($idusuario);
    }

    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra WHERE idcompra = " . $this->getIdCompra();

        // echo $sql;

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();

                    $objUsuario = new Usuario();
                    // if ($objUsuario->buscar($row['idusuario'])) {  //agregar metodo en usuario
                        $objUsuario->setIdUsuario($row['idusuario']);
                        $objUsuario->buscar();
                    // } else {
                    //     $objUsuario = null;
                    // }
                    $this->setear($row['idcompra'], $row['cofecha'], $objUsuario);
                }
            }
        } else {
            $this->setMensajeOperacion("Compra->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compra (cofecha,idusuario) VALUES ('" . $this->getCoFecha() . "', '" . $this->getIdUsuario()->getIdUsuario() . "')";
        if ($base->Iniciar()) {
            if ($elId = $base->Ejecutar($sql)) {
                $this->setIdCompra($elId);
                $resp =  $base->lastInsertId();
            } else {
                $this->setMensajeOperacion("Compra->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compra->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compra SET cofecha = '" . $this->getCoFecha() . "', idusuario = '" . $this->getIdUsuario()->getIdUsuario() . "' WHERE idcompra = '" . $this->getIdCompra() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Compra->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compra->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compra WHERE idcompra = " . $this->getIdCompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("Compra->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compra->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                while ($row = $base->Registro()) {
                    $obj = new Compra();
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objUsuario->buscar();

                    $obj->setear($row['idcompra'], $row['cofecha'], $objUsuario);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            self::setmensajeoperacion("Compra->listar: " . $base->getError());
        }
        return $arreglo;
    }

    public static function getLastInsertId()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "select max(idcompra) idcompra FROM compra";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            $row = $base->Registro();
            return $row['idcompra'];
        }
    }
}

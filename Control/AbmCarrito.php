<?php

class AbmCarrito
{

    public function agregarProductoAlCarrito($idProducto, $idUsuario)
    {
        // verifica si existe el producto antes de agregarlo
        $producto = Producto::listar("idproducto = $idProducto");
        if (empty($producto)) {
            echo json_encode(array("estado" => false, "mensaje" => "El producto no existe"));
            exit;
        }

        // verifica si hay stock
        $stockDisponible = $producto[0]->getProCantStock();

        // buscar un carrito activo del usuario
        $compra = Compra::listar("idusuario = $idUsuario");

        if (empty($compra)) {
            $nuevaCompra = new Compra();
            $nuevaCompra->setIdUsuario($idUsuario);
            $nuevaCompra->setCofecha(date("Y-m-d H:i:s"));
            $nuevaCompra->insertar();
            $idCompra = $nuevaCompra->getIdCompra();
            $compra = Compra::listar("idcompra = $idCompra");
        } else {
            $compra = $compra[0];
        }

        // verificar si ya existe una compraestado con idcompraestadotipo = 5
        $compraEstado = CompraEstado::listar("idcompra = " . $compra->getIdCompra() . " AND idcompraestadotipo = 5");

        if (empty($compraEstado)) {
            $nuevaCompraEstado = new CompraEstado();
            $nuevaCompraEstado->setIdCompra($compra->getIdCompra());
            $nuevaCompraEstado->setIdCompraEstadoTipo(5);
            $nuevaCompraEstado->setCefechaini(date("Y-m-d H:i:s"));
            $nuevaCompraEstado->insertar();
        }

        $compraItemExistente = CompraItem::listar("idproducto = $idProducto AND idcompra = " . $compra->getIdCompra());
        $cantidadEnCarrito = !empty($compraItemExistente) ? $compraItemExistente[0]->getCicantidad() : 0;

        if ($cantidadEnCarrito >= $stockDisponible) {
            echo json_encode(["estado" => false, "mensaje" => "Límite de stock."]);
            exit;
        }

        if (!empty($compraItemExistente)) {
            $compraItem = $compraItemExistente[0];
            $compraItem->setCicantidad($cantidadEnCarrito + 1);
            $compraItem->modificar();
        } else {
            $compraItem = new CompraItem();
            $compraItem->setIdproducto($idProducto);
            $compraItem->setIdCompra($compra->getIdCompra());
            $compraItem->setCicantidad(1);
            $compraItem->insertar();
        }

        return true;
    }



    public function eliminarProductoDelCarrito($idCompraItem)
    {
        try {
            $compraItem = CompraItem::listar("idcompraitem = $idCompraItem");
            if (!empty($compraItem)) {
                $compraItem = $compraItem[0];
                $cantidadActual = $compraItem->getCiCantidad();

                if ($cantidadActual > 1) {
                    $compraItem->setCiCantidad($cantidadActual - 1);
                    $compraItem->modificar();
                } else {
                    // se elimina ya que la cantidad es 1
                    $compraItem->eliminar();
                }
                return true;
            }
        } catch (Exception $e) {
            error_log("Error al eliminar producto del carrito: " . $e->getMessage());
        }
        return false;
    }



    public function actualizarCantidadProductoCarrito($idCompraItem, $cantidad)
    {
        $compraItem = CompraItem::listar("idcompraitem = $idCompraItem");
        if (!empty($compraItem)) {
            $compraItem = $compraItem[0];
            $compraItem->setCiCantidad($cantidad);
            $compraItem->modificar();
            return true;
        }
        return false;
    }

    public function obtenerCantidadProductoEnCarrito($idUsuario, $idProducto)
    {
        $compraItems = CompraItem::listar("idusuario = $idUsuario AND idproducto = $idProducto");
        if (!empty($compraItems)) {
            return $compraItems[0]->getCiCantidad();
        }
        return 0;
    }

    public function vaciarCarrito($idUsuario)
    {
        // busca la compra con estado 5 del usuario
        $compra = Compra::listar("idusuario = $idUsuario");

        if (!empty($compra)) {
            foreach ($compra as $c) {
                $compraEstado = CompraEstado::listar("idcompra = " . $c->getIdCompra() . " AND idcompraestadotipo = 5");
                if (!empty($compraEstado)) {
                    $compraItems = CompraItem::listar("idcompra = " . $c->getIdCompra());

                    foreach ($compraItems as $compraItem) {
                        $compraItem->eliminar();
                    }
                }
            }
            return [
                "estado" => true,
                "mensaje" => "Vaciaste el carrito."
            ];
        }
        return [
            "estado" => false,
            "mensaje" => "No hay productos en el carrito."
        ];
    }



    public function verCarrito($idUsuario)
    {
        $db = new BaseDatos();
        $sql = "SELECT 
                    ci.idcompraitem AS id,
                    p.pronombre AS nombre,
                    p.prodetalle AS detalle,
                    p.procantstock AS stock,
                    ci.cicantidad AS cantidad
                FROM compra c
                JOIN compraitem ci ON c.idcompra = ci.idcompra
                JOIN producto p ON ci.idproducto = p.idproducto
                JOIN compraestado ce ON c.idcompra = ce.idcompra
                WHERE c.idusuario = :idUsuario
                AND ce.idcompraestadotipo = 5"; // Estado 5 = "carrito"

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute([':idUsuario' => $idUsuario]);
            return [
                "estado" => true,
                "carrito" => $stmt->fetchAll(PDO::FETCH_ASSOC)
            ];
        } catch (PDOException $e) {
            return [
                "estado" => false,
                "mensaje" => "Error al cargar el carrito: " . $e->getMessage()
            ];
        }
    }

    public function comprarCarrito($listacomprar)
    {
        $abmcompraestado = new AbmCompraEstado();
        $abmcompraitem = new AbmCompraItem();

        foreach ($listacomprar as $item) {

            $param['cefechaini'] = null;
            $param['idcompraestadotipo'] = null;
            $param['idcompra'] =  $item[4];
            $param['cefechafin'] = "NULL";
            $compraestadoitem = $abmcompraestado->buscar($param);
            $compraestadoitem[0]->setCeFechaFin(date('Y-m-d H:i:s'));
            $compraestadoitem[0]->modificar();
            $param['idcompra'] = $item[4];
            $param['idcompraestadotipo'] = 1;
            $param['cefechaini'] = date('Y-m-d H:i:s');
            $abmcompraestado->alta($param);
        }
    }

    public function cancelarCarrito($idcompra)
    {
        $abmcompraestado = new AbmCompraEstado();
        $param['cefechafin'] = "NULL";
        $param['idcompra'] = $idcompra;
        $compraestadoitem = $abmcompraestado->buscar($param);

        $compraestadoitem[0]->setCeFechaFin(date('Y-m-d H:i:s'));
        $compraestadoitem[0]->modificar();
    }

    public function vaciarTodoCarrito($listacomprar)
    {

        $abmcompraestado = new AbmCompraEstado();
        $abmcompraitem = new AbmCompraItem();

        foreach ($listacomprar as $item) {

            $param['cefechaini'] = null;
            $param['idcompraestadotipo'] = null;
            $param['idcompra'] =  $item[4];
            $param['cefechafin'] = "NULL";
            $compraestadoitem = $abmcompraestado->buscar($param);
            $compraestadoitem[0]->setCeFechaFin(date('Y-m-d H:i:s'));
            $compraestadoitem[0]->modificar();
        }
    }

    public function addProducto($idProducto,$cantidad)
    {
        $session = new Session();
        if (!$session->validar()) {
            $retorno['estado'] = false;
        } else {
            $retorno['estado'] = true;
            $retorno['insert'] = false;

            $abmcompra = new AbmCompra();

            $param['idusuario'] = $session->getUsuario()->getIdUsuario();
            $param['cofecha'] = date('Y-m-d H:i:s');

            if ($abmcompra->alta($param)) {

                $idcompra = $abmcompra->getLastInsertedID();
                $abmcompraitem = new AbmCompraItem();
                $param['idproducto'] = $idProducto;
                $param['idcompra'] = $idcompra;
                $param['cicantidad'] = $cantidad;

                if ($abmcompraitem->alta($param)) {

                    $abmcompraestado = new AbmCompraEstado();
                    $param['idcompraestadotipo'] = 5;
                    $param['idcompra'] = $idcompra;
                    $param['cefechaini'] = date('Y-m-d H:i:s');

                    if ($abmcompraestado->alta($param)) {
                        $retorno['insert'] = true;
                    }
                }
            }
        }
        return $retorno;
    }
}

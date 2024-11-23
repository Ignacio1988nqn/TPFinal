<?php

class AbmDeposito
{

    public function actualizarVenta($idcompra)
    {

        $abmcompraestado = new AbmCompraEstado();
        $abmcompraitem = new AbmCompraItem();
        $abmproducto = new AbmProducto();
        $abmcompra = new AbmCompra();
        $abmusuario = new ABMUsuario();

        // $retorno['insert'] = true;

        // $bool = true;

        $param['cefechafin'] = "NULL";
        $param['idcompra'] = $idcompra;

        $compra = $abmcompra->buscar($param);
        $compraestadoitem = $abmcompraestado->buscar($param);
        $compraitem = $abmcompraitem->buscar($param);

        $param['idproducto'] = $compraitem[0]->getIdProducto()->getIdProducto();
        $producto = $abmproducto->buscar($param);
        $estado = $compraestadoitem[0]->getIdCompraEstadoTipo()->getIdCompraEstadoTipo();

        $param['idusuario'] = $compra[0]->getIdUsuario()->getIdUsuario();
        $usuario = $abmusuario->buscar($param);

        if ($estado == 1) {
            if ($producto[0]->getProCantStock() >= $compraitem[0]->getCiCantidad()) {
                $nuevoestado = 2;
                $producto[0]->setProCantStock($producto[0]->getProCantStock() - $compraitem[0]->getCiCantidad());
                $producto[0]->modificar();
                $subject = "Estamos preparando tu pedido!";
                $message = "Hola, " . $usuario[0]->getUsNombre() . " tu pedido ya esta siendo preparado!";
            } else {
                // $retorno['insert'] = false;
                // echo json_encode($retorno);
                return false;
            }
        } elseif ($estado == 2) {
            $nuevoestado = 3;
            $subject = "Tu pedido ya esta en camino!";
            $message = "Hola, " . $usuario[0]->getUsNombre() . " tu pedido ya esta en camino!";
        } elseif ($estado == 3) {
            $nuevoestado = 6;
            $subject = "Compra finalizada";
            $message = "Muchas gracias " . $usuario[0]->getUsNombre() . " por tu compra, te invitamos a seguir conociendo nuestras ofertas!";
        }

        $compraestadoitem[0]->setCeFechaFin(date('Y-m-d H:i:s'));
        $compraestadoitem[0]->modificar();
        $param['idcompra'] = $idcompra;
        $param['idcompraestadotipo'] = $nuevoestado;
        $param['cefechaini'] = date('Y-m-d H:i:s');
        $abmcompraestado->alta($param);

        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "ignacio.araya@est.fi.uncoma.edu.ar";
        $to = $usuario[0]->getUsMail();
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);

        return true;
    }

    public function cancelarVenta($idcompra)
    {
        $abmcompraestado = new AbmCompraEstado();
        $abmcompraitem = new AbmCompraItem();
        $abmproducto = new AbmProducto();
        $abmcompra = new AbmCompra();
        $abmusuario = new ABMUsuario();

        $param['cefechafin'] = "NULL";
        $param['idcompra'] = $idcompra;
        $copraitem = $abmcompraitem->buscar($param);

        $compra = $abmcompra->buscar($param);
        $compraestadoitem = $abmcompraestado->buscar($param);

        $param['idusuario'] = $compra[0]->getIdUsuario()->getIdUsuario();
        $usuario = $abmusuario->buscar($param);

        $estado = $compraestadoitem[0]->getIdCompraEstadoTipo()->getIdCompraEstadoTipo();
        $cant = $copraitem[0]->getCiCantidad();

        $compraestadoitem[0]->setCeFechaFin(date('Y-m-d H:i:s'));
        $compraestadoitem[0]->modificar();
        $param['idcompra'] = $idcompra;
        $param['idcompraestadotipo'] = 4;
        $param['cefechaini'] = date('Y-m-d H:i:s');
        $abmcompraestado->alta($param);

        if ($estado != 1) {
            $productoitem = $abmproducto->buscar($copraitem[0]->getIdProducto()->getIdProducto());
            $productoitem[0]->setProCantStock($productoitem[0]->getProCantStock() + $cant);
            $productoitem[0]->modificar();
        }

        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "ignacio.araya@est.fi.uncoma.edu.ar";
        $to = $usuario[0]->getUsMail();
        $subject = "Su compra ha sido cancelada";
        $message = "Hola, " . $usuario[0]->getUsNombre() . " tu pedido ha sido cancelado";
        $headers = "From:" . $from;
        mail($to, $subject, $message, $headers);
    }

    public function misPedidos()
    {
        $session = new Session();
        $datos = darDatosSubmitted();
        $id =  $session->getUsuario()->getIdUsuario();
        $abmcompra = new AbmCompra();
        $param['idusuario'] = $id;
        $compras =  $abmcompra->buscar($param);
        $abmcompraestado = new AbmCompraEstado();

        $listacompras = array();

        foreach ($compras as $item) {

            $param['idcompra'] = $item->getIdCompra();
            $param['cefechafin'] = "NULL";
            $itemcompra = $abmcompraestado->buscar($param);
            if ($itemcompra) {
                if ($itemcompra[0]->getIdCompraEstadoTipo() != '5') {
                    array_push($listacompras, $itemcompra[0]);
                }
            }
        }
        $abmcompraitem = new AbmCompraItem();
        $abmproducto = new AbmProducto();
        $abmestadotipo = new AbmCompraEstadoTipo();
        $listatabla = array();

        foreach ($listacompras as $item) {

            $idcompra = $item->getIdCompra()->getIdCompra();
            $param['idcompra'] = $idcompra;
            $param['idproducto'] = null;
            $compraitem = $abmcompraitem->buscar($param);
            $param['idproducto'] = $compraitem[0]->getIdProducto()->getIdProducto();
            $producto = $abmproducto->buscar($param);
            $param['idcompraestadotipo'] = $item->getIdCompraEstadoTipo()->getIdCompraEstadoTipo();
            $estado = $abmestadotipo->buscar($param);

            array_push($listatabla, [$producto[0]->getProNombre(), $estado[0]->getCetDescripcion(), $item->getCeFechaIni(), $estado[0]->getIdCompraEstadoTipo(), $idcompra]);
        }

        return $listatabla;
    }

    public function getVentas()
    {
        $abmcompraestado = new AbmCompraEstado();
        $abmcompraitem = new AbmCompraItem();
        $abmproducto = new AbmProducto();
        $abmestadotipo = new AbmCompraEstadoTipo();

        $listacompras = array();
        $listatabla = array();

        $param['cefechafin'] = "NULL";
        $itemcompra = $abmcompraestado->buscar($param);
        if ($itemcompra) {
            foreach ($itemcompra as $item) {
                if ($item->getIdCompraEstadoTipo()->getIdCompraEstadoTipo() != '5') {
                    array_push($listacompras, $item);
                }
            }
        }

        foreach ($listacompras as $item) {

            $idcompra = $item->getIdCompra()->getIdCompra();
            $param['idcompra'] = $idcompra;
            $param['idproducto'] = null;
            $compraitem = $abmcompraitem->buscar($param);
            $param['idproducto'] = $compraitem[0]->getIdProducto()->getIdProducto();
            $producto = $abmproducto->buscar($param);
            $param['idcompraestadotipo'] = $item->getIdCompraEstadoTipo()->getIdCompraEstadoTipo();
            $estado = $abmestadotipo->buscar($param);

            array_push($listatabla, [$producto[0]->getProNombre(), $estado[0]->getCetDescripcion(), $item->getCeFechaIni(), $estado[0]->getIdCompraEstadoTipo(), $idcompra, $compraitem[0]->getCiCantidad()]);
        }
        return $listatabla;
    }
}

<?php

header('Content-Type: application/json');

require "../../configuracion.php";

$session = new Session();
if (!$session->validar()) {
    echo json_encode(["estado" => false, "mensaje" => "Debes iniciar sesión primero."]);
    exit;
}

$accion = $_POST['accion'] ?? $_GET['accion'] ?? null;

if (!$accion) {
    echo json_encode(["estado" => false, "mensaje" => "No se especificó una acción."]);
    exit;
}

$abmCarrito = new AbmCarrito();
$idUsuario = $session->getUsuario()->getIdUsuario();


switch ($accion) {
    case "agregarAlCarrito":
        if (isset($_POST['idproducto'])) {
            $idProducto = $_POST['idproducto'];

            $producto = new Producto();
            $producto->setIdProducto($idProducto);

            if ($producto->cargar()) {
                $stockDisponible = $producto->getProCantStock();

                $cantidadEnCarrito = $abmCarrito->obtenerCantidadProductoEnCarrito($idUsuario, $idProducto);

                if (($cantidadEnCarrito + 1) <= $stockDisponible) {
                    $resultado = $abmCarrito->agregarProductoAlCarrito($idProducto, $idUsuario);

                    if ($resultado) {
                        echo json_encode([
                            "estado" => true,
                            "mensaje" => "Producto agregado correctamente.",
                            "stockDisponible" => $stockDisponible,
                            "cantidadEnCarrito" => $cantidadEnCarrito + 1
                        ]);
                    } else {
                        echo json_encode([
                            "estado" => false,
                            "mensaje" => "No se pudo agregar el producto."
                        ]);
                    }
                } else {
                    echo json_encode([
                        "estado" => false,
                        "mensaje" => "No puedes agregar más de lo que hay en stock.",
                        "stockDisponible" => $stockDisponible,
                        "cantidadEnCarrito" => $cantidadEnCarrito
                    ]);
                }
            } else {
                echo json_encode(["estado" => false, "mensaje" => "Producto no encontrado."]);
            }
        } else {
            echo json_encode(["estado" => false, "mensaje" => "ID del producto no especificado."]);
        }
        exit;

    case "eliminarProducto":
        if (isset($_GET['idproducto'])) {
            $idProducto = $_GET['idproducto'];
            $resultado = $abmCarrito->eliminarProductoDelCarrito($idProducto);

            if ($resultado) {
                echo json_encode([
                    "estado" => true,
                    "mensaje" => "Producto eliminado."
                ]);
            } else {
                echo json_encode([
                    "estado" => false,
                    "mensaje" => "No se pudo actualizar el producto. Verifica el ID."
                ]);
            }
        } else {
            echo json_encode([
                "estado" => false,
                "mensaje" => "ID del producto no especificado."
            ]);
        }
        exit;

    case "mostrar":
        $carrito = $abmCarrito->verCarrito($idUsuario);
        echo json_encode($carrito);
        break;

    case "vaciarCarrito":
        $resultado = $abmCarrito->vaciarCarrito($idUsuario);

        if ($resultado["estado"]) {
            echo json_encode([
                "success" => true,
                "message" => $resultado["mensaje"]
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => $resultado["mensaje"]
            ]);
        }
        exit;

    default:
        echo json_encode(["estado" => false, "mensaje" => "Acción no reconocida."]);
}

-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 15-10-2018 a las 23:12:45
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdcarritocompras`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` bigint(20) NOT NULL,
  `cofecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idusuario` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestado`
--

CREATE TABLE `compraestado` (
  `idcompraestado` bigint(20) UNSIGNED NOT NULL,
  `idcompra` bigint(11) NOT NULL,
  `idcompraestadotipo` int(11) NOT NULL,
  `cefechaini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cefechafin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestadotipo`
--

CREATE TABLE `compraestadotipo` (
  `idcompraestadotipo` int(11) NOT NULL,
  `cetdescripcion` varchar(50) NOT NULL,
  `cetdetalle` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraestadotipo`
--

INSERT INTO `compraestadotipo` (`idcompraestadotipo`, `cetdescripcion`, `cetdetalle`) VALUES
(1, 'iniciada', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(2, 'aceptada', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1 '),
(3, 'enviada', 'cuando el usuario administrador envia a uno de las compras en estado =2 '),
(4, 'cancelada', 'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado=1 '),
(5, 'carrito', 'estado antes de ser confirmada la compra ');

-- ---------------------------------------------------------
-- Nuevos datos para los test

INSERT INTO menu (idmenu, menombre, medescripcion, idpadre, medeshabilitado) VALUES
(1, 'Home', './home.php', NULL, NULL),
(2, 'Categorias', 'kkkkk', NULL, NULL),
(3, 'Mi cuenta', '../home/micuenta.php', NULL, NULL),
(4, 'Home', './admin.php', NULL, NULL),
(5, 'ABM Usuarios', './abmUsuarios.php', NULL, '2024-11-13 11:30:50'),
(6, 'ABM Roles', './abmRoles.php', NULL, '2024-11-13 11:30:50'),
(7, 'ABM Menú', './abmMenu.php', NULL, '2024-11-13 11:30:50'),
(8, 'ABM Productos', './abmProductos.php', NULL, '2024-11-13 11:30:50'),
(9, 'Mis Pedidos ', '../home/mispedidos.php', NULL, '2024-11-13 11:30:50');


INSERT INTO rol (idrol, rodescripcion) VALUES
(1, 'cliente'),
(2, 'admin'),
(9, 'public');


INSERT INTO menurol (idmenu, idrol) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2).
(9, 1),
(1, 9),
(2, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraitem`
--

CREATE TABLE `compraitem` (
  `idcompraitem` bigint(20) UNSIGNED NOT NULL,
  `idproducto` bigint(20) NOT NULL,
  `idcompra` bigint(20) NOT NULL,
  `cicantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idmenu` bigint(20) NOT NULL,
  `menombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
  `medescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  `idpadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  `medeshabilitado` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`) VALUES
(7, 'nuevo', 'kkkkk', NULL, NULL),
(8, 'nuevo', 'kkkkk', NULL, NULL),
(9, 'nuevo', 'kkkkk', 7, NULL),
(10, 'nuevo', 'kkkkk', NULL, NULL),
(11, 'nuevo', 'kkkkk', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menurol`
--

CREATE TABLE `menurol` (
  `idmenu` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` bigint(20) NOT NULL,
  `pronombre` varchar(50) NOT NULL,
  `prodetalle` varchar(512) NOT NULL,
  `procantstock` int(11) NOT NULL,
   `item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ---------------------------------------------------------
-- Nuevos datos para los test

INSERT INTO producto (idproducto, pronombre, prodetalle, procantstock, tipo) VALUES
(1, 'HELADERA DREAN 364 LTRS BLANCA', 'Capacidad neta de 359 lts esto se divide en 93 lts en el freezer y 266 litros en el refrigerador, eficiencia energética A , estantes regulables en altura en freezer y refrigerador, anaqueles en contrapuerta, para botellas y alimentos regulable en altura, cajón especial para frutas y verduras, control de temperatura interior, apertura de puerta controlada, luz LED en el interior, y dispenser con 2 lts de capacidad.', 2, 1),
(2, 'Heladera Cíclica Drean 277Lts', 'Heladera con freezer Cíclica. Eficiencia Energética A. Color Blanca. Gas ecológico R600a. Capacidad bruta 277 litros. Capacidad neta 264 litros. Deshielo manual. Estantes regulables en altura. Anaqueles en contrapuerta. Cajón especial para frutas y verduras. Luz interior LED. Origen Argentina. ', 2, 1),
(3, 'Televisor Samsung Smart Tv 32 HD Smart TV T4300', 'Solo necesitás de un control remoto para descubrir una infinidad de variedad de contenido. Podrás controlar desde el decodificador hasta la consola de juegos, las aplicaciones e incluso la televisión en vivo', 2, 1),
(4, 'Lavarropas Carga Frontal 6Kg 800 RPM Drean Next 6.08 ECO', 'Lavarropas automático de Carga Frontal. Capacidad de 6 Kg. Color Blanco. Velocidad regulable hasta 800 RPM. Eficiencia energética A+. Sistema de lavado Europeo. Display LED y perilla bidireccional. Bloqueo para niños. Sistema Autobalance. Carga autoadaptativa. Lavado rápido 30’. Origen Argentina.', 2, 1),
(5, 'Celular Samsung Galaxy A15 128/4GB Amarillo', 'La pantalla Super AMOLED de 6.5'' ofrece una claridad vibrante incluso bajo la luz solar directa con Vision Booster, desplazamiento suave con frecuencia de actualización de 90Hz, brillo mejorado de hasta 800 nits y comodidad durante todo el día con luz azul reducida gracias a Eye Comfort Shield.', 2, 2),
(6, 'Celular Motorola G24 128GB Pink Lavender', 'El moto g24 tiene todo lo que buscas en un teléfono de primer nivel Fabricado con materiales innovadores, cuenta con una cubierta de cámara que proporciona una sensación agradable al tacto.', 2, 2),
(7, 'Celular Motorola Moto G14 Rosa 4+128Gb', 'Pantalla Vibrante e Inmersiva: Sumérgete en una experiencia visual inigualable con la pantalla de 6.497 pulgadas (20:9) del Moto G14. La resolución FHD+ de 1080x2400, la tecnología LTPS y el cristal Panda Glass 2.5D te brindan colores vibrantes, detalles nítidos y una calidad visual sorprendente.', 2, 2),
(8, 'Celular Motorola E22 6,5" 64GB Azul', 'El Motorola E22 en color azul no solo refleja tu estilo, sino que también ofrece un rendimiento confiable y funciones avanzadas. Desde capturar momentos especiales hasta mantenerse conectado, este smartphone está diseñado para satisfacer tus necesidades diarias con estilo y eficiencia.', 2,2),
(9, 'Placa De Video Pny Geforce Rtx 4060 Ti 8gb', 'Las GPU NVIDIA® GeForce RTX™ Serie 40 son extremadamente rápidas para jugadores y creadores. Están impulsadas por la arquitectura ultraeficiente NVIDIA Ada Lovelace, que ofrece un salto cuántico tanto en rendimiento como en gráficos potenciados por IA. Experimente mundos virtuales realistas con trazado de rayos y juegos con FPS ultraaltos con la latencia más baja. Descubra nuevas y revolucionarias formas de crear y una aceleración del flujo de trabajo sin precedentes.', 3, 3),
(10, 'Monitor gaming UltraGear™ Full HD IPS de 24” ', 'Descubre gráficos impactantes con un tiempo de respuesta de 1ms, que reduce el efecto fantasma y el retardo de entrada en un panel IPS con 178º de ángulo de visión.', 3, 3),
(11, 'Placa de Video Inno3D NVIDIA GeForce RTX 3070', 'INNO3D® presenta su nueva serie INNO3D GeForce RTX™ 30 con una emocionante gama de ventiladores de última generación que incluyen la INNO3D GeForce RTX™ 3070 y RTX™ 3080 TWIN X2 OC y TWIN X2 con ventilador dual de 9 cm para mantener la refrigeración en un nivel óptimo cuando el overclock de fábrica en este dispositivo de rendimiento constante está trabajando duro para potenciar tus juegos favoritos. ', 3, 3),
(12, 'GABINETE GAMER KJ Z399 4 COOLERS RGB', 'No solo es potente, sino también estilizado. Con un diseño en blanco y/o negro, sumado a sus luces RGB, tu estación de juego se va ver increible. Además, la calidad de construcción garantiza durabilidad para largas sesiones de juego.', 3, 3);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `rodescripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` bigint(20) NOT NULL,
  `usnombre` varchar(50) NOT NULL,
  `uspass` int(11) NOT NULL,
  `usmail` varchar(50) NOT NULL,
  `usdeshabilitado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

CREATE TABLE `usuariorol` (
  `idusuario` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD UNIQUE KEY `idcompra` (`idcompra`),
  ADD KEY `fkcompra_1` (`idusuario`);

--
-- Indices de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD PRIMARY KEY (`idcompraestado`),
  ADD UNIQUE KEY `idcompraestado` (`idcompraestado`),
  ADD KEY `fkcompraestado_1` (`idcompra`),
  ADD KEY `fkcompraestado_2` (`idcompraestadotipo`);

--
-- Indices de la tabla `compraestadotipo`
--
ALTER TABLE `compraestadotipo`
  ADD PRIMARY KEY (`idcompraestadotipo`);

--
-- Indices de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD PRIMARY KEY (`idcompraitem`),
  ADD UNIQUE KEY `idcompraitem` (`idcompraitem`),
  ADD KEY `fkcompraitem_1` (`idcompra`),
  ADD KEY `fkcompraitem_2` (`idproducto`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`),
  ADD UNIQUE KEY `idmenu` (`idmenu`),
  ADD KEY `fkmenu_1` (`idpadre`);

--
-- Indices de la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD PRIMARY KEY (`idmenu`,`idrol`),
  ADD KEY `fkmenurol_2` (`idrol`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD UNIQUE KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`),
  ADD UNIQUE KEY `idrol` (`idrol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD PRIMARY KEY (`idusuario`,`idrol`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idrol` (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  MODIFY `idcompraestado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  MODIFY `idcompraitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fkcompra_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD CONSTRAINT `fkcompraestado_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraestado_2` FOREIGN KEY (`idcompraestadotipo`) REFERENCES `compraestadotipo` (`idcompraestadotipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD CONSTRAINT `fkcompraitem_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraitem_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fkmenu_1` FOREIGN KEY (`idpadre`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD CONSTRAINT `fkmenurol_1` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkmenurol_2` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD CONSTRAINT `fkmovimiento_1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuariorol_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

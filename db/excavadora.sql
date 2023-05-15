-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-09-2022 a las 17:24:33
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `excavadora`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `idarticulo` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `descripcion` decimal(10,2) NOT NULL,
  `medida` varchar(100) NOT NULL,
  `cubicaje` varchar(200) NOT NULL,
  `material` varchar(200) NOT NULL,
  `placacarro` varchar(200) NOT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`idarticulo`, `idcategoria`, `codigo`, `nombre`, `stock`, `descripcion`, `medida`, `cubicaje`, `material`, `placacarro`, `imagen`, `condicion`) VALUES
(4, 1, '48394', 'caudillo', 19, '150.00', '10.5 metros', 'camion', 'hierro', 'BCX834', '1657855825.jpg', 1),
(5, 1, '58503', 'adoquin', 9, '120.00', '90 centimetros', 'contenedor', 'piedra', 'FG3PT7', '1657855825.jpg', 1),
(6, 1, '44930', 'cemento', 10, '80.00', '2 metros', 'contenedor', 'cemento', 'FG3PT7', '1657855825.jpg', 1),
(7, 1, '85902', 'aluminio', 0, '70.00', '12.5 metros', 'camion', 'hierro', 'BCX834', '1657855825.jpg', 1),
(8, 1, '33849', 'ladrillo', 17, '20.00', '8 metros', 'camion', 'cemento', 'BCX834', '1657855825.jpg', 1),
(1315, 1, '19621', 'rodillo', 7, '140.00', '15.7 centimetros', 'contenedor', 'madera', 'FG3PT7', '1659146622.jpg', 1),
(1316, 1, '66489', 'madera', 12, '150.50', '12.8 metros', 'contenedor', 'madera', 'BCX839', '1659193507.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'materiales', 'materiales de construcción', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL,
  `idingreso` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_ingreso`
--

INSERT INTO `detalle_ingreso` (`iddetalle_ingreso`, `idingreso`, `idarticulo`, `cantidad`, `precio_compra`, `precio_venta`) VALUES
(1, 1, 4, 1, '450.00', '98.00'),
(2, 2, 2, 1, '150.00', '21.00'),
(3, 3, 5, 1, '190.00', '110.00'),
(4, 4, 5, 1, '1.00', '1.00'),
(5, 5, 6, 6, '40.00', '50.00'),
(6, 6, 4, 1, '1.00', '1.00'),
(7, 0, 4, 1, '1.00', '1.00'),
(8, 0, 4, 4, '120.00', '140.00'),
(9, 7, 4, 1, '1.00', '1.00'),
(10, 8, 4, 1, '1.00', '1.00'),
(11, 0, 4, 1, '1.00', '1.00'),
(12, 0, 4, 4, '120.00', '130.00'),
(13, 9, 4, 1, '1.00', '1.00'),
(14, 0, 4, 3, '120.00', '140.00'),
(15, 0, 5, 1, '50.00', '60.00'),
(16, 0, 6, 2, '30.00', '40.00'),
(17, 0, 7, 2, '20.00', '30.00'),
(18, 0, 5, 4, '120.00', '150.00'),
(19, 0, 4, 2, '110.00', '120.00'),
(20, 10, 4, 4, '120.00', '140.00'),
(21, 0, 5, 3, '140.00', '150.00'),
(22, 0, 6, 1, '120.00', '130.00'),
(23, 0, 7, 2, '120.00', '130.00'),
(24, 0, 5, 1, '120.00', '120.00'),
(25, 0, 6, 1, '120.00', '120.00'),
(26, 0, 6, 1, '120.00', '120.00'),
(27, 11, 5, 2, '120.00', '120.00'),
(28, 11, 6, 2, '120.00', '120.00'),
(29, 0, 8, 3, '56.00', '90.00'),
(30, 0, 7, 2, '79.00', '100.00'),
(31, 0, 6, 2, '154.00', '172.00'),
(32, 0, 8, 4, '39.00', '59.00'),
(33, 0, 6, 3, '154.00', '1.00'),
(34, 0, 8, 2, '22.00', '1.00'),
(35, 0, 6, 2, '12.00', '1.00'),
(36, 0, 8, 4, '156.00', '1.00'),
(37, 0, 6, 1, '1.00', '1.00'),
(38, 0, 6, 4, '155.00', '1.00'),
(39, 0, 4, 2, '244.00', '266.00'),
(40, 0, 6, 2, '45.00', '1.00'),
(41, 12, 5, 3, '155.00', '1.00'),
(42, 13, 8, 2, '199.00', '1.00'),
(43, 0, 6, 2, '150.00', '155.00'),
(44, 0, 5, 3, '120.00', '130.00'),
(45, 0, 5, 1, '130.00', '140.00'),
(46, 14, 6, 3, '220.00', '230.00');

--
-- Disparadores `detalle_ingreso`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock + NEW.cantidad 
 WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_remision`
--

CREATE TABLE `detalle_remision` (
  `iddetalle_remision` int(11) NOT NULL,
  `idremision` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_remision`
--

INSERT INTO `detalle_remision` (`iddetalle_remision`, `idremision`, `idarticulo`, `cantidad`, `precio_compra`) VALUES
(1, 0, 5, 2, '140.00'),
(23, 12, 6, 3, '159.00'),
(24, 12, 6, 4, '200.00'),
(25, 13, 5, 2, '120.00'),
(26, 13, 7, 1, '140.00'),
(27, 13, 7, 3, '27.00'),
(28, 14, 6, 2, '130.00'),
(29, 14, 5, 1, '14.00'),
(30, 14, 5, 1, '70.00'),
(31, 0, 5, 4, '20.00'),
(32, 0, 5, 3, '50.00'),
(33, 0, 6, 5, '100.00'),
(34, 0, 7, 1, '22.00'),
(35, 0, 7, 1, '333.00'),
(36, 0, 6, 1, '44.00'),
(37, 15, 7, 1, '235.00'),
(38, 15, 6, 1, '120.00'),
(39, 15, 4, 2, '35.00'),
(40, 16, 4, 1, '1.00'),
(41, 17, 4, 1, '1.00'),
(42, 18, 4, 1, '2.00'),
(43, 18, 5, 1, '1.00'),
(44, 18, 6, 1, '1.00'),
(45, 18, 7, 1, '1.00'),
(46, 18, 4, 1, '1.00'),
(47, 18, 5, 1, '1.00');

--
-- Disparadores `detalle_remision`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockRemision` AFTER INSERT ON `detalle_remision` FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock - NEW.cantidad 
 WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`iddetalle_venta`, `idventa`, `idarticulo`, `cantidad`, `precio_venta`, `descuento`) VALUES
(1, 1, 1, 2, '80.00', '10.00'),
(2, 2, 2, 1, '120.00', '10.00'),
(3, 3, 3, 3, '300.00', '126.00'),
(4, 4, 6, 1, '400.00', '81.00'),
(5, 5, 5, 3, '110.00', '10.00'),
(6, 0, 4, 2, '98.00', '10.00'),
(7, 6, 5, 1, '110.00', '0.00'),
(8, 7, 5, 1, '110.00', '0.00'),
(9, 8, 5, 1, '110.00', '0.00'),
(10, 0, 4, 1, '266.00', '10.00'),
(11, 0, 6, 2, '150.00', '14.00'),
(12, 9, 6, 4, '230.00', '30.00');

--
-- Disparadores `detalle_venta`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock - NEW.cantidad 
 WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingreso`
--

INSERT INTO `ingreso` (`idingreso`, `idproveedor`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_compra`, `estado`) VALUES
(1, 2, 1, 'Boleta', 'B', '111', '2022-07-03 00:00:00', '10.00', '450.00', 'Aceptado'),
(3, 2, 1, 'Ticket', 'B', '111', '2022-07-10 00:00:00', '0.00', '190.00', 'Aceptado'),
(4, 2, 1, 'Factura', 'B', '111', '2022-07-05 00:00:00', '0.00', '1.00', 'Aceptado'),
(5, 2, 1, 'Ticket', 'B', '111', '2022-07-05 00:00:00', '0.00', '240.00', 'Aceptado'),
(10, 2, 1, 'Boleta', 'BB', '111', '2022-07-13 22:50:00', '10.00', '480.00', 'Aceptado'),
(11, 2, 1, 'Boleta', 'A', '111', '2022-07-06 22:53:00', '18.00', '480.00', 'Aceptado'),
(12, 2, 1, 'Factura', 'B', '111', '2022-07-08 23:06:00', '18.00', '465.00', 'Aceptado'),
(13, 2, 1, 'Ticket', 'FF', '233', '2022-07-29 23:07:00', '56.00', '398.00', 'Aceptado'),
(14, 2, 1, 'Factura', 'FF', '145', '2022-08-18 23:28:00', '18.00', '660.00', 'Aceptado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Escritorio'),
(2, 'Almacen'),
(3, 'Compras'),
(4, 'Ventas'),
(5, 'Acceso'),
(6, 'Consulta Compras'),
(7, 'Consulta Ventas'),
(8, 'Remision');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `tipo_persona` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `num_documento` varchar(20) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `tipo_persona`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`) VALUES
(1, 'Cliente', 'Christopher PS', 'RUC', '69756909055', 'Lima, La Molina', '973182294', 'cris_antonio2001@hotmail.com'),
(2, 'Proveedor', 'Mauricio AG', 'DNI', '76655698', 'Lima, La Molina', '973182294', 'cris_antonio2001@hotmail.com'),
(3, 'Despachador', 'Enrrique QC', 'RUC', '66945974885', 'Lima, La Molina', '973182294', 'cris_antonio2001@hotmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remision`
--

CREATE TABLE `remision` (
  `idremision` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `guia_remision` varchar(2) NOT NULL,
  `num_remision` varchar(13) NOT NULL,
  `tipo_comprobante` varchar(10) NOT NULL,
  `domicilio_partida` varchar(40) NOT NULL,
  `domicilio_llegada` varchar(40) NOT NULL,
  `razonsocial` varchar(50) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `marca` varchar(20) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `certificado` varchar(20) NOT NULL,
  `licencia` varchar(20) NOT NULL,
  `fecha_emision` datetime NOT NULL,
  `fecha_traslado` datetime NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `remision`
--

INSERT INTO `remision` (`idremision`, `idusuario`, `guia_remision`, `num_remision`, `tipo_comprobante`, `domicilio_partida`, `domicilio_llegada`, `razonsocial`, `tipo_documento`, `num_documento`, `marca`, `placa`, `certificado`, `licencia`, `fecha_emision`, `fecha_traslado`, `total_compra`, `estado`) VALUES
(12, 1, 'CC', '4875345747445', 'Ticket', 'Av Los ingenieros, La Molina, Lima, Perú', 'Av Benavides, Miraflores, Lima, Perú', 'El camión llegó sin inconvenientes a su destino', 'DNI', '56474768585', 'Volvo', 'XPD223J', '56940566533', '44495603489', '2022-08-09 16:09:00', '2022-08-31 16:12:00', '1277.00', 'Aceptado'),
(13, 1, 'BC', '6787687864443', 'Remision', 'Av Los ingenieros, La Molina, Lima, Perú', 'Av Brazil, Lima, Lima, Perú', 'El camión llegó sin inconvenientes a su destino', 'RUC', '56456084589', 'Hyundai', 'MC334XH', '44595059443', '55866948567', '2022-08-17 15:34:00', '2022-08-10 16:31:00', '461.00', 'Aceptado'),
(14, 1, 'AA', '5648389893437', 'Ticket', 'Av Los frutales, La Molina, Lima, Perú', 'Av Benavides, Miraflores, Lima, Perú', 'El camión llegó con poca gasolina.', 'RUC', '34535345453', 'Volvo', 'PD6LQ2W', '54467775233', '55968203981', '2022-08-17 15:40:00', '2022-08-16 16:37:00', '344.00', 'Aceptado'),
(15, 1, 'AS', '4338447293344', 'Remision', 'Av Brazil, Lima, Lima, Perú', 'Av La Fontana, La Molina, Lima, Perú', 'El camión tuvo retraso por la cantidad de tráfico.', 'RUC', '92278360234', 'Toshiba', 'XDL449', '44785923847', '44759633845', '2022-08-11 02:40:00', '2022-08-30 01:41:00', '425.00', 'Aceptado'),
(16, 1, '54', '54564', 'Remision', 'comas', 'lima', '754865', 'DNI', '6456456', '4546', '754865', '56456', '754865', '2022-10-21 10:01:00', '2022-09-27 10:02:00', '1.00', 'Aceptado'),
(17, 1, '75', '754865', 'Remision', '754865', '754865', 'comas', 'DNI', '4564', '754865', '754865', '754865', '754865', '2022-09-03 10:02:00', '2022-09-30 10:02:00', '1.00', 'Aceptado'),
(18, 1, '75', '754865', 'Remision', '754865coco', '754865coco', '754865coco', 'DNI', '7548657777', '754865', '754865', '754865', '754861', '2022-09-28 10:03:00', '2022-09-15 10:04:00', '7.00', 'Aceptado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES
(1, 'admin', 'DNI', '76655698', 'Lima, la Molina', '931742904', 'email@email.com', '', 'admin', 'admin', '1487132068.jpg', 1),
(6, 'chriss', 'DNI', '76655698', 'Lima, la Molina', '973182294', 'email@email.com', '1', 'admin2', 'admin567', '', 1),
(7, 'Irene', 'DNI', '76655698', 'Lima, la Molina', '973182294', 'email@email.com', '1', 'admin3', 'admin123', '', 1),
(8, 'Javier', 'DNI', '76655698', 'Lima, la Molina', '973182294', 'correo@correo.com', '1', 'admin', '123', '', 1),
(9, 'pepe', 'DNI', '76655698', 'Lima, la Molina', '973182294', 'correo@correo.com', '1', 'admin', 'pepe123', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(117, 5, 1),
(118, 5, 2),
(119, 5, 3),
(120, 5, 4),
(121, 5, 5),
(122, 5, 6),
(123, 5, 7),
(124, 5, 8),
(145, 6, 1),
(146, 6, 2),
(147, 6, 3),
(148, 6, 4),
(149, 6, 5),
(150, 6, 6),
(151, 6, 7),
(152, 7, 1),
(153, 7, 2),
(154, 7, 3),
(157, 7, 6),
(158, 7, 7),
(180, 8, 1),
(181, 8, 2),
(182, 8, 3),
(183, 8, 4),
(184, 8, 5),
(185, 8, 6),
(186, 8, 7),
(194, 9, 1),
(195, 9, 2),
(196, 9, 3),
(197, 9, 4),
(198, 9, 5),
(199, 9, 6),
(200, 9, 7),
(215, 10, 1),
(216, 10, 2),
(217, 10, 3),
(218, 10, 4),
(219, 10, 5),
(220, 10, 6),
(221, 10, 7),
(236, 11, 1),
(237, 11, 2),
(238, 11, 3),
(239, 11, 4),
(240, 11, 5),
(241, 11, 6),
(242, 11, 7),
(273, 1, 1),
(274, 1, 2),
(275, 1, 3),
(276, 1, 4),
(277, 1, 5),
(278, 1, 6),
(279, 1, 7),
(280, 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_venta` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `idcliente`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_venta`, `estado`) VALUES
(1, 1, 1, 'Boleta', '2', '111', '2022-06-16 00:00:00', '10.00', '0.00', 'Anulado'),
(5, 1, 1, 'Boleta', 'B', '111', '2022-07-04 00:00:00', '10.00', '320.00', 'Aceptado'),
(6, 1, 1, 'Boleta', 'B', '111', '2022-07-05 00:00:00', '10.00', '110.00', 'Aceptado'),
(7, 1, 1, 'Factura', 'B', '111', '2022-07-05 00:00:00', '18.00', '110.00', 'Aceptado'),
(8, 1, 1, 'Ticket', 'B', '111', '2022-07-05 00:00:00', '0.00', '110.00', 'Aceptado'),
(9, 1, 1, 'Boleta', 'FF', '233', '2022-08-25 14:17:00', '18.00', '890.00', 'Aceptado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`idarticulo`),
  ADD KEY `fk_articulo_categoria_idx` (`idcategoria`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD PRIMARY KEY (`iddetalle_ingreso`),
  ADD KEY `fk_detalle_ingreso_ingreso_idx` (`idingreso`),
  ADD KEY `fk_detalle_ingreso_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `detalle_remision`
--
ALTER TABLE `detalle_remision`
  ADD PRIMARY KEY (`iddetalle_remision`),
  ADD KEY `fk_detalle_remision_remision_idx` (`idremision`) USING BTREE,
  ADD KEY `fk_detalle_remision_articulo_idx` (`idarticulo`) USING BTREE;

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `fk_detalle_venta_venta_idx` (`idventa`),
  ADD KEY `fk_detalle_venta_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `fk_ingreso_persona_idx` (`idproveedor`),
  ADD KEY `fk_ingreso_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `remision`
--
ALTER TABLE `remision`
  ADD PRIMARY KEY (`idremision`),
  ADD KEY `fk_ingreso_usuario_idx` (`idusuario`) USING BTREE;

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`),
  ADD KEY `fk_usuario_permiso_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `fk_venta_persona_idx` (`idcliente`),
  ADD KEY `fk_venta_usuario_idx` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `idarticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1317;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  MODIFY `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `detalle_remision`
--
ALTER TABLE `detalle_remision`
  MODIFY `iddetalle_remision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `remision`
--
ALTER TABLE `remision`
  MODIFY `idremision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `fk_articulo_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

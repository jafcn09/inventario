-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: localhost    Database: excavadora
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.20-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articulo`
--

DROP TABLE IF EXISTS `articulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articulo` (
  `idarticulo` int(11) NOT NULL AUTO_INCREMENT,
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
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idarticulo`),
  KEY `fk_articulo_categoria_idx` (`idcategoria`),
  CONSTRAINT `fk_articulo_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1318 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulo`
--

LOCK TABLES `articulo` WRITE;
/*!40000 ALTER TABLE `articulo` DISABLE KEYS */;
INSERT INTO `articulo` VALUES (4,1,'48394','caudillo',19,150.00,'10.5 metros','camion','hierro','BCX834','1657855825.jpg',1),(5,1,'58503','adoquin',-2,120.00,'90 centimetros','contenedor','piedra','FG3PT7','1657855825.jpg',1),(6,1,'44930','cemento',5,80.00,'2 metros','contenedor','cemento','FG3PT7','1657855825.jpg',1),(7,1,'85902','aluminio',-32,70.00,'12.5 metros','camion','hierro','BCX834','1657855825.jpg',1),(8,1,'33849','ladrillo',4,20.00,'8 metros','camion','cemento','BCX834','1657855825.jpg',1),(1315,1,'19621','rodillo',7,140.00,'15.7 centimetros','contenedor','madera','FG3PT7','1659146622.jpg',1),(1316,1,'66489','madera',12,150.50,'12.8 metros','contenedor','madera','BCX839','1659193507.jpg',1),(1317,1,'343434','aaaaaaaaaaaa',33333,344.00,'3333','3434','343443','43434','',1);
/*!40000 ALTER TABLE `articulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idcategoria`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'materiales','materiales de construcción',1),(2,'AAAAAAAA','AAAAAAAAAAAA',1);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_ingreso`
--

DROP TABLE IF EXISTS `detalle_ingreso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT,
  `idingreso` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_ingreso`),
  KEY `fk_detalle_ingreso_ingreso_idx` (`idingreso`),
  KEY `fk_detalle_ingreso_articulo_idx` (`idarticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_ingreso`
--

LOCK TABLES `detalle_ingreso` WRITE;
/*!40000 ALTER TABLE `detalle_ingreso` DISABLE KEYS */;
INSERT INTO `detalle_ingreso` VALUES (1,1,4,1,450.00,98.00),(2,2,2,1,150.00,21.00),(3,3,5,1,190.00,110.00),(4,4,5,1,1.00,1.00),(5,5,6,6,40.00,50.00),(6,6,4,1,1.00,1.00),(7,0,4,1,1.00,1.00),(8,0,4,4,120.00,140.00),(9,7,4,1,1.00,1.00),(10,8,4,1,1.00,1.00),(11,0,4,1,1.00,1.00),(12,0,4,4,120.00,130.00),(13,9,4,1,1.00,1.00),(14,0,4,3,120.00,140.00),(15,0,5,1,50.00,60.00),(16,0,6,2,30.00,40.00),(17,0,7,2,20.00,30.00),(18,0,5,4,120.00,150.00),(19,0,4,2,110.00,120.00),(20,10,4,4,120.00,140.00),(21,0,5,3,140.00,150.00),(22,0,6,1,120.00,130.00),(23,0,7,2,120.00,130.00),(24,0,5,1,120.00,120.00),(25,0,6,1,120.00,120.00),(26,0,6,1,120.00,120.00),(27,11,5,2,120.00,120.00),(28,11,6,2,120.00,120.00),(29,0,8,3,56.00,90.00),(30,0,7,2,79.00,100.00),(31,0,6,2,154.00,172.00),(32,0,8,4,39.00,59.00),(33,0,6,3,154.00,1.00),(34,0,8,2,22.00,1.00),(35,0,6,2,12.00,1.00),(36,0,8,4,156.00,1.00),(37,0,6,1,1.00,1.00),(38,0,6,4,155.00,1.00),(39,0,4,2,244.00,266.00),(40,0,6,2,45.00,1.00),(41,12,5,3,155.00,1.00),(42,13,8,2,199.00,1.00),(43,0,6,2,150.00,155.00),(44,0,5,3,120.00,130.00),(45,0,5,1,130.00,140.00),(46,14,6,3,220.00,230.00),(47,0,6,3,123.00,123.00),(48,0,6,3,123.00,123.00),(49,0,6,3,31.00,64.00),(50,0,5,1,45.00,32.00),(51,15,7,1,333.00,33.00),(52,16,6,1,1.00,1.00),(53,16,6,1,1.00,1.00),(54,16,7,1,1.00,1.00);
/*!40000 ALTER TABLE `detalle_ingreso` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock + NEW.cantidad 
 WHERE articulo.idarticulo = NEW.idarticulo;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `detalle_remision`
--

DROP TABLE IF EXISTS `detalle_remision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_remision` (
  `iddetalle_remision` int(11) NOT NULL AUTO_INCREMENT,
  `idremision` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_remision`),
  KEY `fk_detalle_remision_remision_idx` (`idremision`) USING BTREE,
  KEY `fk_detalle_remision_articulo_idx` (`idarticulo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_remision`
--

LOCK TABLES `detalle_remision` WRITE;
/*!40000 ALTER TABLE `detalle_remision` DISABLE KEYS */;
INSERT INTO `detalle_remision` VALUES (1,0,5,2,140.00),(23,12,6,3,159.00),(24,12,6,4,200.00),(25,13,5,2,120.00),(26,13,7,1,140.00),(27,13,7,3,27.00),(28,14,6,2,130.00),(29,14,5,1,14.00),(30,14,5,1,70.00),(31,0,5,4,20.00),(32,0,5,3,50.00),(33,0,6,5,100.00),(34,0,7,1,22.00),(35,0,7,1,333.00),(36,0,6,1,44.00),(37,15,7,1,235.00),(38,15,6,1,120.00),(39,15,4,2,35.00),(40,16,4,1,1.00),(41,17,4,1,1.00),(42,18,4,1,2.00),(43,18,5,1,1.00),(44,18,6,1,1.00),(45,18,7,1,1.00),(46,18,4,1,1.00),(47,18,5,1,1.00),(48,0,7,1,3.00),(49,0,7,1,3.00),(50,0,7,1,3.00),(51,0,7,1,3.00),(52,0,7,3,2.00),(53,0,7,2,51.00),(54,0,7,2,4.00),(55,0,7,3,123.00),(56,0,7,2,123.00),(57,0,6,3,33.00),(58,0,6,2,33.00),(59,0,5,2,123.00),(60,0,7,1,1.00),(61,0,7,1,1.00),(62,0,7,3,123.00),(63,0,8,3,1.00),(64,0,7,2,1.00),(65,0,8,3,123.00),(66,0,8,1,1.00),(67,0,8,1,1.00),(68,0,8,3,231.00),(69,0,7,3,123.00),(70,0,7,2,123.00),(71,0,6,3,145.00),(72,0,6,1,1.00),(73,0,6,1,1.00);
/*!40000 ALTER TABLE `detalle_remision` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_updStockRemision` AFTER INSERT ON `detalle_remision` FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock - NEW.cantidad 
 WHERE articulo.idarticulo = NEW.idarticulo;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `detalle_venta`
--

DROP TABLE IF EXISTS `detalle_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT,
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_venta`),
  KEY `fk_detalle_venta_venta_idx` (`idventa`),
  KEY `fk_detalle_venta_articulo_idx` (`idarticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_venta`
--

LOCK TABLES `detalle_venta` WRITE;
/*!40000 ALTER TABLE `detalle_venta` DISABLE KEYS */;
INSERT INTO `detalle_venta` VALUES (1,1,1,2,80.00,10.00),(2,2,2,1,120.00,10.00),(3,3,3,3,300.00,126.00),(4,4,6,1,400.00,81.00),(5,5,5,3,110.00,10.00),(6,0,4,2,98.00,10.00),(7,6,5,1,110.00,0.00),(8,7,5,1,110.00,0.00),(9,8,5,1,110.00,0.00),(10,0,4,1,266.00,10.00),(11,0,6,2,150.00,14.00),(12,9,6,4,230.00,30.00),(13,10,7,1,100.00,12.00),(17,6,5,1,110.00,0.00),(18,0,8,1,1.00,0.00),(19,0,8,1,1.00,0.00),(20,0,7,1,33.00,0.00),(21,0,6,1,64.00,0.00),(22,0,5,1,32.00,0.00),(23,0,6,1,64.00,0.00),(24,0,6,1,64.00,0.00),(25,0,5,1,32.00,0.00),(26,0,6,1,1.00,0.00),(27,0,5,1,32.00,0.00),(28,0,5,1,32.00,0.00),(29,0,5,1,32.00,0.00),(30,0,5,1,32.00,0.00),(31,0,6,1,1.00,0.00),(32,0,7,1,1.00,0.00),(33,0,7,1,1.00,0.00),(34,0,5,1,32.00,0.00),(35,0,5,1,32.00,0.00),(36,0,6,1,1.00,0.00);
/*!40000 ALTER TABLE `detalle_venta` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock - NEW.cantidad 
 WHERE articulo.idarticulo = NEW.idarticulo;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ingreso`
--

DROP TABLE IF EXISTS `ingreso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL AUTO_INCREMENT,
  `idproveedor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idingreso`),
  KEY `fk_ingreso_persona_idx` (`idproveedor`),
  KEY `fk_ingreso_usuario_idx` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingreso`
--

LOCK TABLES `ingreso` WRITE;
/*!40000 ALTER TABLE `ingreso` DISABLE KEYS */;
INSERT INTO `ingreso` VALUES (1,2,1,'Boleta','B','111','2022-07-03 00:00:00',10.00,450.00,'Anulado'),(3,2,1,'Ticket','B','111','2022-07-10 00:00:00',0.00,190.00,'Anulado'),(4,2,1,'Factura','B','111','2022-07-05 00:00:00',0.00,1.00,'Aceptado'),(5,2,1,'Ticket','B','111','2022-07-05 00:00:00',0.00,240.00,'Anulado'),(10,2,1,'Boleta','BB','111','2022-07-13 22:50:00',10.00,480.00,'Aceptado'),(11,2,1,'Boleta','A','111','2022-07-06 22:53:00',18.00,480.00,'Aceptado'),(12,2,1,'Factura','B','111','2022-07-08 23:06:00',18.00,465.00,'Aceptado'),(13,2,1,'Ticket','FF','233','2022-07-29 23:07:00',56.00,398.00,'Aceptado'),(14,2,1,'Factura','FF','145','2022-08-18 23:28:00',18.00,660.00,'Aceptado'),(16,2,1,'Factura','AS','145','2022-09-22 21:37:00',18.00,3.00,'Aceptado');
/*!40000 ALTER TABLE `ingreso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso`
--

DROP TABLE IF EXISTS `permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`idpermiso`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso`
--

LOCK TABLES `permiso` WRITE;
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
INSERT INTO `permiso` VALUES (1,'Escritorio'),(2,'Almacen'),(3,'Compras'),(4,'Ventas'),(5,'Acceso'),(6,'Consulta Compras'),(7,'Consulta Ventas'),(8,'Remision'),(9,'Visitas');
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_persona` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `num_documento` varchar(20) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idpersona`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,'Cliente','Christopher PS','RUC','69756909055','Lima, La Molina','973182294','cris_antonio2001@hotmail.com'),(2,'Proveedor','Mauricio AG','DNI','76655698','Lima, La Molina','973182294','cris_antonio2001@hotmail.com'),(3,'Despachador','Enrrique QC','RUC','66945974885','Lima, La Molina','973182294','cris_antonio2001@hotmail.com'),(4,'Cliente','Lopez LV','RUC','2345677528','Lima, La Molina','973182294','cris_antonio2001@hotmail.com');
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `remision`
--

DROP TABLE IF EXISTS `remision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `remision` (
  `idremision` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `num_remision` varchar(13) NOT NULL,
  `correlativo` varchar(13) NOT NULL,
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
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idremision`),
  KEY `fk_ingreso_usuario_idx` (`idusuario`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remision`
--

LOCK TABLES `remision` WRITE;
/*!40000 ALTER TABLE `remision` DISABLE KEYS */;
INSERT INTO `remision` VALUES (12,1,'4875345747445','0012','Ticket','Av Los ingenieros, La Molina, Lima, Perú','Av Benavides, Miraflores, Lima, Perú','El camión llegó sin inconvenientes a su destino','DNI','56474768585','Volvo','XPD223J','56940566533','44495603489','2022-08-09 16:09:00','2022-08-31 16:12:00',1277.00,'Aceptado'),(13,1,'6787687864443','0013','Remision','Av Los ingenieros, La Molina, Lima, Perú','Av Brazil, Lima, Lima, Perú','El camión llegó sin inconvenientes a su destino','RUC','56456084589','Hyundai','MC334XH','44595059443','55866948567','2022-08-17 15:34:00','2022-08-10 16:31:00',461.00,'Aceptado'),(14,1,'5648389893437','00123123124','Ticket','Av Los frutales, La Molina, Lima, Perú','Av Benavides, Miraflores, Lima, Perú','El camión llegó con poca gasolina.','RUC','34535345453','Volvo','PD6LQ2W','54467775233','55968203981','2022-08-17 15:40:00','2022-08-16 16:37:00',344.00,'Aceptado');
/*!40000 ALTER TABLE `remision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
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
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','DNI','76655698','Lima, la Molina','931742904','email@email.com','','admin','admin','1487132068.jpg',1),(6,'chriss','DNI','76655698','Lima, la Molina','973182294','email@email.com','1','admin2','admin567','',1),(7,'Irene','DNI','76655698','Lima, la Molina','973182294','email@email.com','1','admin3','admin123','',1),(8,'Javier','DNI','76655698','Lima, la Molina','973182294','correo@correo.com','1','admin','123','',1),(9,'pepe','DNI','76655698','Lima, la Molina','973182294','correo@correo.com','1','admin','pepe123','',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_permiso`
--

DROP TABLE IF EXISTS `usuario_permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL,
  PRIMARY KEY (`idusuario_permiso`),
  KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`),
  KEY `fk_usuario_permiso_usuario_idx` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=306 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_permiso`
--

LOCK TABLES `usuario_permiso` WRITE;
/*!40000 ALTER TABLE `usuario_permiso` DISABLE KEYS */;
INSERT INTO `usuario_permiso` VALUES (117,5,1),(118,5,2),(119,5,3),(120,5,4),(121,5,5),(122,5,6),(123,5,7),(124,5,8),(145,6,1),(146,6,2),(147,6,3),(148,6,4),(149,6,5),(150,6,6),(151,6,7),(152,7,1),(153,7,2),(154,7,3),(157,7,6),(158,7,7),(180,8,1),(181,8,2),(182,8,3),(183,8,4),(184,8,5),(185,8,6),(186,8,7),(194,9,1),(195,9,2),(196,9,3),(197,9,4),(198,9,5),(199,9,6),(200,9,7),(215,10,1),(216,10,2),(217,10,3),(218,10,4),(219,10,5),(220,10,6),(221,10,7),(236,11,1),(237,11,2),(238,11,3),(239,11,4),(240,11,5),(241,11,6),(242,11,7),(297,1,1),(298,1,2),(299,1,3),(300,1,4),(301,1,5),(302,1,6),(303,1,7),(304,1,8),(305,1,9);
/*!40000 ALTER TABLE `usuario_permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `correlativo` varchar(13) NOT NULL,
  `num_remision` varchar(13) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(13) NOT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_venta` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idventa`),
  KEY `fk_venta_persona_idx` (`idcliente`),
  KEY `fk_venta_usuario_idx` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
INSERT INTO `venta` VALUES (1,1,1,'0001','3884493866945','Boleta','0001','111','2022-06-16 00:00:00',10.00,0.00,'Anulado'),(5,1,1,'0002','3884493866945','Boleta','0002','111','2022-07-04 00:00:00',10.00,320.00,'Aceptado'),(6,1,1,'0003','3884493866945','Boleta','0003','111','2022-07-05 00:00:00',10.00,110.00,'Aceptado'),(7,1,1,'0004','3884493866945','Factura','0004','111','2022-07-05 00:00:00',18.00,110.00,'Aceptado'),(8,4,1,'00099','3884493866945','Ticket','0006','111','2022-07-05 00:00:00',0.00,110.00,'Aceptado');
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitas`
--

DROP TABLE IF EXISTS `visitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visitas` (
  `idvisitas` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `motivo` text NOT NULL,
  `fecha_entrada` datetime NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idvisitas`),
  KEY `fk_visitas_usuario_idx` (`idusuario`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitas`
--

LOCK TABLES `visitas` WRITE;
/*!40000 ALTER TABLE `visitas` DISABLE KEYS */;
INSERT INTO `visitas` VALUES (7,1,'asdasd','RUC','47715777','El cliente revisará los ingresos y se retirará pronto.','2022-09-08 01:40:00','2022-09-19 23:07:26','Ingresado'),(8,1,'Miguel','RUC','76655698','El cliente revisará los ingresos y se retirará pronto.','2022-09-18 22:44:00','2022-09-18 22:46:10','Finalizado');
/*!40000 ALTER TABLE `visitas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-20 20:31:44

-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.8-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5728
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para mecanica_utp
CREATE DATABASE IF NOT EXISTS `mecanica_utp` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mecanica_utp`;

-- Volcando estructura para tabla mecanica_utp.actividad_mantenimiento
CREATE TABLE IF NOT EXISTS `actividad_mantenimiento` (
  `idMantenimiento` int(11) NOT NULL AUTO_INCREMENT,
  `idHerramienta` int(11) NOT NULL,
  `idRepuesto` int(11) NOT NULL,
  `mantenimiento` varchar(50) NOT NULL DEFAULT '' COMMENT 'nombre del mantenimento',
  `fecha_creacion` date NOT NULL,
  PRIMARY KEY (`idMantenimiento`),
  KEY `FK1_herramientas` (`idHerramienta`),
  KEY `FK2_repuestos` (`idRepuesto`),
  CONSTRAINT `FK1_herramientas` FOREIGN KEY (`idHerramienta`) REFERENCES `herramientas` (`idHerramienta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_repuestos` FOREIGN KEY (`idRepuesto`) REFERENCES `repuestos` (`idRepuesto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Tabla para almacenar los mantenimientos que se tienen disponibles';

-- Volcando datos para la tabla mecanica_utp.actividad_mantenimiento: ~4 rows (aproximadamente)
DELETE FROM `actividad_mantenimiento`;
/*!40000 ALTER TABLE `actividad_mantenimiento` DISABLE KEYS */;
INSERT INTO `actividad_mantenimiento` (`idMantenimiento`, `idHerramienta`, `idRepuesto`, `mantenimiento`, `fecha_creacion`) VALUES
	(2, 2, 4, 'Limpieza de teclado', '2019-11-19'),
	(3, 1, 1, 'Mantenimiento Frontal', '2019-11-19'),
	(4, 3, 3, 'Cambio de pantalla', '2019-11-19'),
	(5, 6, 5, 'CAMBIO DE CARCASA', '2019-11-20');
/*!40000 ALTER TABLE `actividad_mantenimiento` ENABLE KEYS */;

-- Volcando estructura para tabla mecanica_utp.caracteristicas
CREATE TABLE IF NOT EXISTS `caracteristicas` (
  `idCaracteristica` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  PRIMARY KEY (`idCaracteristica`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='Tabla donde se almacena las caracteristicas';

-- Volcando datos para la tabla mecanica_utp.caracteristicas: ~9 rows (aproximadamente)
DELETE FROM `caracteristicas`;
/*!40000 ALTER TABLE `caracteristicas` DISABLE KEYS */;
INSERT INTO `caracteristicas` (`idCaracteristica`, `marca`, `color`, `modelo`) VALUES
	(1, 'Motorola', 'Negro', 'G5s'),
	(2, 'Lenovo', 'Blanco', 'E480'),
	(3, 'Dell', 'Gris', 'N5050'),
	(6, 'Motorola', 'Indigo Plus', 'G7 plus'),
	(7, 'LG', 'Rojo', 'Lg35465'),
	(9, 'Motorola', 'Blanco', 'Z-PLAY'),
	(10, 'Dell', 'Negro', 'n5040'),
	(11, 'COMPAQ', 'Gris', 'CQ45'),
	(13, 'PANASONIC', 'NEGRO', 'VVVV88');
/*!40000 ALTER TABLE `caracteristicas` ENABLE KEYS */;

-- Volcando estructura para tabla mecanica_utp.equipos
CREATE TABLE IF NOT EXISTS `equipos` (
  `idEquipo` int(11) NOT NULL AUTO_INCREMENT,
  `equipo` varchar(100) NOT NULL DEFAULT '',
  `idGrupo` int(11) NOT NULL,
  `frecuencia` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  PRIMARY KEY (`idEquipo`),
  KEY `FK1_grupo` (`idGrupo`),
  CONSTRAINT `FK1_grupo` FOREIGN KEY (`idGrupo`) REFERENCES `grupos` (`idGrupo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla mecanica_utp.equipos: ~3 rows (aproximadamente)
DELETE FROM `equipos`;
/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
INSERT INTO `equipos` (`idEquipo`, `equipo`, `idGrupo`, `frecuencia`, `fecha_creacion`) VALUES
	(2, 'Dos', 4, 2, '2019-11-19'),
	(3, 'Prueba', 3, 4, '2019-11-20'),
	(4, 'Control X1', 5, 12, '2019-11-20');
/*!40000 ALTER TABLE `equipos` ENABLE KEYS */;

-- Volcando estructura para tabla mecanica_utp.grupos
CREATE TABLE IF NOT EXISTS `grupos` (
  `idGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(100) NOT NULL,
  `idCaracteristica` int(11) NOT NULL,
  `idMantenimiento` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  PRIMARY KEY (`idGrupo`),
  KEY `FK1_caracteristica` (`idCaracteristica`),
  KEY `FK2_mantenimiento` (`idMantenimiento`),
  CONSTRAINT `FK1_caracteristica` FOREIGN KEY (`idCaracteristica`) REFERENCES `caracteristicas` (`idCaracteristica`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_mantenimiento` FOREIGN KEY (`idMantenimiento`) REFERENCES `actividad_mantenimiento` (`idMantenimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Grupos de mantenimiento';

-- Volcando datos para la tabla mecanica_utp.grupos: ~4 rows (aproximadamente)
DELETE FROM `grupos`;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` (`idGrupo`, `grupo`, `idCaracteristica`, `idMantenimiento`, `fecha_creacion`) VALUES
	(2, 'Celulares', 1, 3, '2019-11-19'),
	(3, 'Teclados', 3, 2, '2019-11-19'),
	(4, 'Pantallas', 11, 4, '2019-11-19'),
	(5, 'COMPUTO', 3, 5, '2019-11-20');
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;

-- Volcando estructura para tabla mecanica_utp.herramientas
CREATE TABLE IF NOT EXISTS `herramientas` (
  `idHerramienta` int(11) NOT NULL AUTO_INCREMENT,
  `herramienta` varchar(50) NOT NULL,
  `fecha_creacion` date NOT NULL,
  PRIMARY KEY (`idHerramienta`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Herramientas disponibles ';

-- Volcando datos para la tabla mecanica_utp.herramientas: ~5 rows (aproximadamente)
DELETE FROM `herramientas`;
/*!40000 ALTER TABLE `herramientas` DISABLE KEYS */;
INSERT INTO `herramientas` (`idHerramienta`, `herramienta`, `fecha_creacion`) VALUES
	(1, 'KIT 1', '2019-11-19'),
	(2, 'KIT 2', '2019-11-18'),
	(3, 'KIT 3', '2019-11-20'),
	(4, 'Kit 5', '2019-11-19'),
	(6, 'KIT 4', '2019-11-20');
/*!40000 ALTER TABLE `herramientas` ENABLE KEYS */;

-- Volcando estructura para tabla mecanica_utp.repuestos
CREATE TABLE IF NOT EXISTS `repuestos` (
  `idRepuesto` int(11) NOT NULL AUTO_INCREMENT,
  `repuesto` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  PRIMARY KEY (`idRepuesto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Tabla para almacenar los respuestos';

-- Volcando datos para la tabla mecanica_utp.repuestos: ~4 rows (aproximadamente)
DELETE FROM `repuestos`;
/*!40000 ALTER TABLE `repuestos` DISABLE KEYS */;
INSERT INTO `repuestos` (`idRepuesto`, `repuesto`, `cantidad`, `fecha_creacion`) VALUES
	(1, 'frontal', 15, '2019-11-18'),
	(3, 'Pantalla', 15, '2019-11-18'),
	(4, 'teclado', 45, '2019-11-18'),
	(5, 'CARCASA SS98', 10, '2019-11-20');
/*!40000 ALTER TABLE `repuestos` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

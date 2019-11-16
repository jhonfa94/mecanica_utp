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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla para almacenar los mantenimientos que se tienen disponibles';

-- Volcando datos para la tabla mecanica_utp.actividad_mantenimiento: ~0 rows (aproximadamente)
DELETE FROM `actividad_mantenimiento`;
/*!40000 ALTER TABLE `actividad_mantenimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `actividad_mantenimiento` ENABLE KEYS */;

-- Volcando estructura para tabla mecanica_utp.caracteristicas
CREATE TABLE IF NOT EXISTS `caracteristicas` (
  `idCaracteristica` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  PRIMARY KEY (`idCaracteristica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla donde se almacena las caracteristicas';

-- Volcando datos para la tabla mecanica_utp.caracteristicas: ~0 rows (aproximadamente)
DELETE FROM `caracteristicas`;
/*!40000 ALTER TABLE `caracteristicas` DISABLE KEYS */;
/*!40000 ALTER TABLE `caracteristicas` ENABLE KEYS */;

-- Volcando estructura para tabla mecanica_utp.crear_equipo
CREATE TABLE IF NOT EXISTS `crear_equipo` (
  `idEquipo` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `frecuencia` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  PRIMARY KEY (`idEquipo`),
  KEY `FK1_grupo` (`idGrupo`),
  CONSTRAINT `FK1_grupo` FOREIGN KEY (`idGrupo`) REFERENCES `grupo` (`idGrupo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla mecanica_utp.crear_equipo: ~0 rows (aproximadamente)
DELETE FROM `crear_equipo`;
/*!40000 ALTER TABLE `crear_equipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `crear_equipo` ENABLE KEYS */;

-- Volcando estructura para tabla mecanica_utp.grupo
CREATE TABLE IF NOT EXISTS `grupo` (
  `idGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `idCaracteristica` int(11) NOT NULL,
  `idMantenimiento` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  PRIMARY KEY (`idGrupo`),
  KEY `FK1_caracteristica` (`idCaracteristica`),
  KEY `FK2_mantenimiento` (`idMantenimiento`),
  CONSTRAINT `FK1_caracteristica` FOREIGN KEY (`idCaracteristica`) REFERENCES `caracteristicas` (`idCaracteristica`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_mantenimiento` FOREIGN KEY (`idMantenimiento`) REFERENCES `actividad_mantenimiento` (`idMantenimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Grupos de mantenimiento';

-- Volcando datos para la tabla mecanica_utp.grupo: ~0 rows (aproximadamente)
DELETE FROM `grupo`;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;

-- Volcando estructura para tabla mecanica_utp.herramientas
CREATE TABLE IF NOT EXISTS `herramientas` (
  `idHerramienta` int(11) NOT NULL AUTO_INCREMENT,
  `herramienta` varchar(50) NOT NULL,
  `fecha_creacion` date NOT NULL,
  PRIMARY KEY (`idHerramienta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Herramientas disponibles ';

-- Volcando datos para la tabla mecanica_utp.herramientas: ~0 rows (aproximadamente)
DELETE FROM `herramientas`;
/*!40000 ALTER TABLE `herramientas` DISABLE KEYS */;
/*!40000 ALTER TABLE `herramientas` ENABLE KEYS */;

-- Volcando estructura para tabla mecanica_utp.repuestos
CREATE TABLE IF NOT EXISTS `repuestos` (
  `idRepuesto` int(11) NOT NULL AUTO_INCREMENT,
  `repuesto` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  PRIMARY KEY (`idRepuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla para almacenar los respuestos';

-- Volcando datos para la tabla mecanica_utp.repuestos: ~0 rows (aproximadamente)
DELETE FROM `repuestos`;
/*!40000 ALTER TABLE `repuestos` DISABLE KEYS */;
/*!40000 ALTER TABLE `repuestos` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

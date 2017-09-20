-- MySQL Script generated by MySQL Workbench
-- Wed Sep 20 08:57:12 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema dbthunder
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dbthunder
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbthunder` DEFAULT CHARACTER SET utf8 ;
USE `dbthunder` ;

-- -----------------------------------------------------
-- Table `dbthunder`.`thu_administrador_rol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_administrador_rol` (
  `idthu_administrador_rol` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_administrador_rol`))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_administrador` (
  `idthu_administrador` INT(11) NOT NULL,
  `idthu_administrador_rol` INT(11) NOT NULL,
  `avatar` VARCHAR(200) NULL,
  `usuario` VARCHAR(45) NULL,
  `token` VARCHAR(255) NULL,
  `nombre` VARCHAR(60) NULL,
  `apellidos` VARCHAR(60) NULL,
  `nacimiento` DATETIME NULL,
  `correo` VARCHAR(80) NULL,
  `telefono` VARCHAR(45) NULL,
  `puesto` VARCHAR(100) NULL,
  `root` INT(1) NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_administrador`),
  INDEX `fk_thu_administrador_thu_administrador_rol_idx` (`idthu_administrador_rol` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_proyecto_status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_proyecto_status` (
  `idthu_proyecto_status` INT(11) NOT NULL AUTO_INCREMENT,
  `idthu_administrador` INT(11) NOT NULL,
  `nombre` VARCHAR(80) NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_proyecto_status`),
  INDEX `fk_thu_proyecto_status_thu_administrador1_idx` (`idthu_administrador` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_proyecto_tipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_proyecto_tipo` (
  `idthu_proyecto_tipo` INT(11) NOT NULL AUTO_INCREMENT,
  `idthu_administrador` INT(11) NOT NULL,
  `nombre` VARCHAR(80) NULL,
  `responsable` INT(11) NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_proyecto_tipo`),
  INDEX `fk_thu_proyecto_tipo_thu_administrador1_idx` (`idthu_administrador` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_usuario` (
  `idthu_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `correo` VARCHAR(80) NULL,
  `token` VARCHAR(255) NULL,
  `avatar` VARCHAR(200) NULL,
  `nombre` VARCHAR(80) NULL,
  `apellidos` VARCHAR(80) NULL,
  `activo` INT(1) NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_usuario`))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_cliente` (
  `idthu_cliente` INT(11) NOT NULL AUTO_INCREMENT,
  `idthu_usuario` INT(11) NOT NULL,
  `logotipo` VARCHAR(200) NULL,
  `razon_social` VARCHAR(200) NULL,
  `rfc` VARCHAR(45) NULL,
  `direccion` VARCHAR(200) NULL,
  `colonia` VARCHAR(200) NULL,
  `codigo_postal` VARCHAR(20) NULL,
  `ciudad` VARCHAR(80) NULL,
  `estado` VARCHAR(80) NULL,
  `responsable` VARCHAR(100) NULL,
  `puesto` VARCHAR(100) NULL,
  `correo` VARCHAR(100) NULL,
  `telefono` VARCHAR(45) NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_cliente`),
  INDEX `fk_thu_cliente_thu_usuario1_idx` (`idthu_usuario` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_proyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_proyecto` (
  `idthu_proyecto` INT(11) NOT NULL AUTO_INCREMENT,
  `idthu_administrador` INT(11) NOT NULL,
  `idthu_proyecto_tipo` INT(11) NOT NULL,
  `idthu_proyecto_status` INT(11) NOT NULL,
  `idthu_cliente` INT(11) NOT NULL,
  `portada` VARCHAR(200) NULL,
  `nombre` VARCHAR(200) NULL,
  `introduccion` VARCHAR(200) NULL,
  `descripcion` TEXT NULL,
  `fecha_inicio` DATETIME NULL,
  `fecha_termino` DATETIME NULL,
  `tags` VARCHAR(200) NULL,
  `costo` DECIMAL(10,2) NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_proyecto`),
  INDEX `fk_thu_portafolio_thu_proyecto_status1_idx` (`idthu_proyecto_status` ASC),
  INDEX `fk_thu_portafolio_thu_proyecto_tipo1_idx` (`idthu_proyecto_tipo` ASC),
  INDEX `fk_thu_portafolio_thu_cliente1_idx` (`idthu_cliente` ASC),
  INDEX `fk_thu_proyecto_thu_administrador1_idx` (`idthu_administrador` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_servicio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_servicio` (
  `idthu_servicio` INT(11) NOT NULL AUTO_INCREMENT,
  `idthu_administrador` INT(11) NOT NULL,
  `idthu_proyecto_tipo` INT(11) NOT NULL,
  `portada` VARCHAR(200) NULL,
  `icono` VARCHAR(80) NULL,
  `nombre` VARCHAR(200) NULL,
  `introduccion` VARCHAR(200) NULL,
  `descripcion` TEXT NULL,
  `tags` VARCHAR(200) NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_servicio`),
  INDEX `fk_thu_servicio_thu_proyecto_tipo1_idx` (`idthu_proyecto_tipo` ASC),
  INDEX `fk_thu_servicio_thu_administrador1_idx` (`idthu_administrador` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_servicio_responsable`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_servicio_responsable` (
  `idthu_servicio` INT(11) NOT NULL,
  `idthu_administrador` INT NOT NULL,
  PRIMARY KEY (`idthu_servicio`, `idthu_administrador`),
  INDEX `fk_thu_servicio_has_thu_administrador_thu_administrador1_idx` (`idthu_administrador` ASC),
  INDEX `fk_thu_servicio_has_thu_administrador_thu_servicio1_idx` (`idthu_servicio` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_config`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_config` (
  `idthu_config` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NULL,
  `descripcion` VARCHAR(200) NULL,
  `mantenimiento` INT(1) NULL,
  PRIMARY KEY (`idthu_config`))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_equipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_equipo` (
  `idthu_equipo` INT(11) NOT NULL AUTO_INCREMENT,
  `idthu_administrador` INT(11) NOT NULL,
  `avatar` VARCHAR(200) NULL,
  `nombre` VARCHAR(80) NULL,
  `apellidos` VARCHAR(80) NULL,
  `puesto` VARCHAR(100) NULL,
  `facebook` VARCHAR(200) NULL,
  `twitter` VARCHAR(200) NULL,
  `instagram` VARCHAR(200) NULL,
  `correo` VARCHAR(200) NULL,
  `fecha_ingreso` DATETIME NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_equipo`),
  INDEX `fk_thu_equipo_thu_administrador1_idx` (`idthu_administrador` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_proyecto_actividades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_proyecto_actividades` (
  `idthu_proyecto_actividades` INT(11) NOT NULL,
  `idthu_administrador` INT(11) NOT NULL,
  `idthu_proyecto` INT(11) NOT NULL,
  `nombre` VARCHAR(200) NULL,
  `descripcion` TEXT NULL,
  `fecha_inicio` DATETIME NULL,
  `fecha_fin` DATETIME NULL,
  `asignado` INT(11) NULL,
  `estatus` INT(1) NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_proyecto_actividades`),
  INDEX `fk_thu_proyecto_actividades_thu_administrador1_idx` (`idthu_administrador` ASC),
  INDEX `fk_thu_proyecto_actividades_thu_proyecto1_idx` (`idthu_proyecto` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_paquete`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_paquete` (
  `idthu_paquete` INT(11) NOT NULL AUTO_INCREMENT,
  `idthu_administrador` INT(11) NOT NULL,
  `nombre` VARCHAR(100) NULL,
  `precio` DECIMAL(10,2) NULL,
  `precio_anterior` DECIMAL(10,2) NULL,
  `descuento` INT(1) NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_paquete`),
  INDEX `fk_thu_paquete_thu_administrador1_idx` (`idthu_administrador` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_paquete_opciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_paquete_opciones` (
  `idthu_paquete_opciones` INT(11) NOT NULL AUTO_INCREMENT,
  `idthu_paquete` INT(11) NOT NULL,
  `nombre` VARCHAR(200) NULL,
  `creado` DATETIME NULL,
  PRIMARY KEY (`idthu_paquete_opciones`),
  INDEX `fk_thu_paquete_opciones_thu_paquete1_idx` (`idthu_paquete` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbthunder`.`thu_cliente_contrata_paquete`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbthunder`.`thu_cliente_contrata_paquete` (
  `idthu_cliente` INT(11) NOT NULL,
  `idthu_paquete` INT(11) NOT NULL,
  `fecha` DATETIME NULL,
  PRIMARY KEY (`idthu_cliente`, `idthu_paquete`),
  INDEX `fk_thu_cliente_has_thu_paquete_thu_paquete1_idx` (`idthu_paquete` ASC),
  INDEX `fk_thu_cliente_has_thu_paquete_thu_cliente1_idx` (`idthu_cliente` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO `dbthunder`.`thu_administrador_rol` (`idthu_administrador_rol`, `nombre`, `creado`) VALUES (1, 'Administrador', '2017-09-06 12:11:00');
INSERT INTO `dbthunder`.`thu_administrador_rol` (`idthu_administrador_rol`, `nombre`, `creado`) VALUES (2, 'Desarrollador', '2017-09-06 12:11:10');
INSERT INTO `dbthunder`.`thu_administrador_rol` (`idthu_administrador_rol`, `nombre`, `creado`) VALUES (3, 'Operativo', '2017-09-06 12:11:11');


INSERT INTO `dbthunder`.`thu_administrador` (`idthu_administrador`, `idthu_administrador_rol`, `avatar`, `usuario`, `token`, `nombre`, `apellidos`, `nacimiento`, `correo`, `telefono`, `puesto`, `root`, `creado`) VALUES (1, 1, NULL, 'argenis', 'e10adc3949ba59abbe56e057f20f883e', 'Alfredo Argenis', 'Barraza Guillén', '1984-01-19 00:00:00', 'argenisbg@thundertechnology.mx', '9611286553', 'Responsable Desarrollo de Software', 1, '2017-09-06 12:12:55');
INSERT INTO `dbthunder`.`thu_administrador` (`idthu_administrador`, `idthu_administrador_rol`, `avatar`, `usuario`, `token`, `nombre`, `apellidos`, `nacimiento`, `correo`, `telefono`, `puesto`, `root`, `creado`) VALUES (2, 1, NULL, 'josue', 'e10adc3949ba59abbe56e057f20f883e', 'Josue', 'Toledo Gómez', '1993-12-02 00:00:00', 'josue.toledo@thundertechnology.mx', '9612677109', 'Responsable de Desarrollo de Hardware', 0, '2017-09-06 12:17:45');
INSERT INTO `dbthunder`.`thu_administrador` (`idthu_administrador`, `idthu_administrador_rol`, `avatar`, `usuario`, `token`, `nombre`, `apellidos`, `nacimiento`, `correo`, `telefono`, `puesto`, `root`, `creado`) VALUES (3, 2, NULL, 'fernando', 'e10adc3949ba59abbe56e057f20f883e', 'Luis Fernando', 'Gómez del Porte', '1996-05-07 00:00:00', 'fernandogp@thundertechnology.mx', '9613289926', 'Desarrollador Web', 0, '2017-09-06 12:18:00');
INSERT INTO `dbthunder`.`thu_administrador` (`idthu_administrador`, `idthu_administrador_rol`, `avatar`, `usuario`, `token`, `nombre`, `apellidos`, `nacimiento`, `correo`, `telefono`, `puesto`, `root`, `creado`) VALUES (4, 2, NULL, 'jesus', 'e10adc3949ba59abbe56e057f20f883e', 'Jesús Afdel', 'Guzmán Luis', '1995-10-31 00:00:00', 'jesusgl@thundertechnology.mx', '9711287419', 'Desarrollador Web', 0, '2017-09-06 12:20:00');
INSERT INTO `dbthunder`.`thu_administrador` (`idthu_administrador`, `idthu_administrador_rol`, `avatar`, `usuario`, `token`, `nombre`, `apellidos`, `nacimiento`, `correo`, `telefono`, `puesto`, `root`, `creado`) VALUES (5, 2, NULL, 'cesar', 'e10adc3949ba59abbe56e057f20f883e', 'Cesar Ulises', 'Gálvez Jiménez', '1993-02-15 00:00:00', 'cesar.galvez@thundertechnology.mx', '9612785936', 'Desarrollador de Hardware', 0, '2017-09-06 12:24:00');
INSERT INTO `dbthunder`.`thu_administrador` (`idthu_administrador`, `idthu_administrador_rol`, `avatar`, `usuario`, `token`, `nombre`, `apellidos`, `nacimiento`, `correo`, `telefono`, `puesto`, `root`, `creado`) VALUES (6, 2, NULL, 'diego', 'e10adc3949ba59abbe56e057f20f883e', 'Diego de Jesús', 'Pérez Nangullasmú', '1995-01-04 00:00:00', 'diego.nangullasmu@thundertechnology.mx', '9612721257', 'Desarrollador de Hardware', 0, '2017-09-06 12:25:00');
INSERT INTO `dbthunder`.`thu_administrador` (`idthu_administrador`, `idthu_administrador_rol`, `avatar`, `usuario`, `token`, `nombre`, `apellidos`, `nacimiento`, `correo`, `telefono`, `puesto`, `root`, `creado`) VALUES (7, 2, NULL, 'joseluis', 'e10adc3949ba59abbe56e057f20f883e', 'José Luís', 'Aguilar Nucamendi', '2000-11-03 00:00:00', 'luisan@thundertechnology', NULL, NULL, NULL, NULL);

INSERT INTO `dbthunder`.`thu_proyecto_tipo` (`idthu_proyecto_tipo`, `idthu_administrador`, `nombre`, `responsable`, `creado`) VALUES (1, 1, 'Software', 1, '2017-09-07 12:05:00');
INSERT INTO `dbthunder`.`thu_proyecto_tipo` (`idthu_proyecto_tipo`, `idthu_administrador`, `nombre`, `responsable`, `creado`) VALUES (2, 1, 'Hardware', 2, '2017-09-07 12:06:00');






SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

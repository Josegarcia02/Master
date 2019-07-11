DROP DATABASE IF EXISTS luxe;
CREATE DATABASE luxe;
USE luxe;

--DROP TABLE IF NOT EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`nombre` char(255) NOT NULL,
`apellido` char(255) NOT NULL,
`email` varchar(255) NOT NULL,
`password` varchar(255) NOT NULL,
`rol` CHAR(255) NOT NULL 
CONSTRAINT `pk_usuarios` PRIMARY KEY (`id`)
) ENGINE=InnoDB;

--DROP TABLE IF NOT EXISTS `vehiculos`;
CREATE TABLE IF NOT EXISTS `vehiculos`(
    `id`int(11) NOT NULL  AUTO_INCREMENT,
    `num_inventario` varchar(255)NOT NULL,
    `serie` varchar(255) NOT NULL,
    `vehiculo` varchar(255) NOT NULL,
    `marca` varchar(255) NOT NULL,
    `modelo` varchar(255) NOT NULL,
    `placa` varchar(255) NOT NULL,
    `color` varchar(255) NOT NULL,
    `asignado` varchar(255) NOT NULL,
    `resguardo` varchar(255) NOT NULL,
    `observaciones` varchar(255) NOT NULL,
    CONSTRAINT `pk_vehiculos` PRIMARY KEY (`id`),
    CONSTRAINT `uq_num_inventario` UNIQUE (`num_inventario`) 
)ENGINE=InnoDB;


--DROP TABLE IF NOT EXISTS `mantenimiento`;
CREATE TABLE IF NOT EXISTS `mantenimiento` (
 `id` INT (11) NOT NULL  AUTO_INCREMENT,
 `id_vehiculo` int(11) NOT NULL,
 `marca` varchar(255) NOT NULL,
 `placa` varchar(255) NOT NULL,
 `serie` varchar(255) NOT NULL,
 `num_inventario` varchar(255) NOT NULL,
 `fecha` date NOT NULL,
 `mantenimiento` text NOT NULL,
 `observaciones` varchar(255) NOT NULL,
 CONSTRAINT `pk_mantenimiento` PRIMARY KEY (`id`),
 CONSTRAINT `fk_mantenimiento_vehiculos` FOREIGN KEY (`id_vehiculo`) REFERENCES vehiculos (`id`)
 ON DELETE RESTRICT 
) ENGINE=InnoDB;


--DROP TABLE IF NOT EXISTS `inventario`;
CREATE TABLE IF NOT EXISTS `inventario`(
 `id` int(11) NOT NULL AUTO_INCREMENT, 
 `id_vehiculo` int(11) NOT NULL,
`tcirculacion` varchar(255) NOT NULL,
`poliza_seguro` varchar(255) NOT NULL,
`num_inventario` varchar(255) NOT NULL,
`vehiculo_tipo` varchar(255) NOT NULL,
`color` varchar(255) NOT NULL,
`accesorios` text NOT NULL,
`carroceria` text NOT NULL,
`observaciones` varchar(255) NOT NULL,
CONSTRAINT `pk_inventario` PRIMARY KEY (`id`),
CONSTRAINT `fk_inventario_vehiculos` FOREIGN KEY (`id_vehiculo`) REFERENCES vehiculos(`id`)
ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE=InnoDB;




INSERT INTO `usuarios`(`email`,`password`) VALUES
    ('jose@hotmail.com', md5('12345'));

INSERT INTO `vehiculos` (`num_inventario`, `serie`,`vehiculo`,`marca`, `modelo`,`placa`,`color`,`asignado`,`resguardo`,`observaciones`)VALUES
('dj-dl-033','8afer5aa3d6154522','camioneta ranger xl','ford','2013','vm-90-702','blanco oxfor','direcion de sustentabilidad y recursos naturales','alvaro lopez','buenas condiciones');
   
INSERT INTO `mantenimiento`(`id_vehiculo`,`marca`,`placa`,`serie`,`num_inventario`,`fecha`,`mantenimiento`,`observaciones`)
VALUE (1,'FORD','37UDHF','37EUEHJRUE848','I3484UDJRJRRJDJD','2019-05-10','CAMBIO DE LLANTAS','BUENAS CONDICIONES');

INSERT INTO `inventario` (`id_vehiculo`,`tcirculacion`, `poliza_seguro`, `num_inventario`,`vehiculo_tipo`, `color`,`accesorios`, `carroceria`,`observaciones`)
VALUE (1,'74HE7474','73YSGEJE3','736WH36HE','CAMIONETA','AZUL','LLANTAS','GOLPEADA','NINGUNA');
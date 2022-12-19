# click_and_pic
Proyecto final de grado de desarrollo aplicaciones web
Aqui os dejo adjunta tambien la base de datos que he estado utilizando(Creada por mi)

 CREATE DATABASE IF NOT EXISTS `click_and_pic` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
  USE `click_and_pic`;

  create table IF NOT EXISTS `usuario` (
  `login` varchar(25) primary key,
  `nombre` varchar(30) not null,
  `apellido` varchar(40) not null,
  `correo` varchar(40) not null,
  `contraseña` varchar(999) not null,
  `rol` varchar(10) not null,
  `foto_perfil` LONGBLOB);

  create table IF NOT EXISTS `empresaReparto` (
  `codigo_empresa` varchar(10) primary key,
  `nombre_empresa` varchar(30) not null,
  `datos_empresa` varchar(999));

  create table IF NOT EXISTS `proveedor` (
  `codigo_proveedor` varchar(10) primary key,
  `nombre_proveedor` varchar(30) not null,
  `datos_proveedor` varchar(999));

  create table IF NOT EXISTS `producto` (
  `nombre_corto` varchar(20) primary key,
  `nombre_prod` varchar(60) not null,
  `codigo_empresa` varchar(10),
  `codigo_proveedor` varchar(10),
  `foto_producto` LONGBLOB not null,
  `tipo` varchar(50) not null,
  `precio` DECIMAL(10,2) NOT NULL,
  `tipo_producto` varchar(50) not null,
  foreign key (`codigo_empresa`) references `empresaReparto`(`codigo_empresa`),
  foreign key (`codigo_proveedor`) references `proveedor`(`codigo_proveedor`));
  


  create table IF NOT EXISTS `pedido` (
  `codigo_pedido` int(99) primary key AUTO_INCREMENT,
  `login` varchar(25) not null,
  `total_precio` DECIMAL(10,2) NOT NULL,
  foreign key (`login`) references `usuario`(`login`));
  


  create table IF NOT EXISTS `publicacion` (
  `cod_publi` int(99) primary key AUTO_INCREMENT,
  `titulo` varchar(60) not null,
  `foto_publicacion` LONGBLOB not null,
  `login` varchar(25) not null,
  `tipo` varchar(50) not null,
  foreign key (`login`) references `usuario`(`login`));
  }



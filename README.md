# click_and_pic

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
## ESPAÑOL 
Proyecto final de grado de desarrollo aplicaciones web.
No he utilizado ningun framework(Exceptuando boostrap para el diseño) ya que queria ver de lo que era capaz de hacer sin ninguno de ellos.
La idea del proyecto es una pagina web que a parte de vender camras y accesorios para fotos, puedas subir a la propia pagina tus fotos para que la gente lo pueda ver.
Aqui os dejo adjunta tambien la base de datos que he estado utilizando, posee 6 tablas (Creadas por mi).
Futuramente me gustariuua ir mejorando este proyecto para ir viendo de lo que soy capaz.

## ENGLISH 
Final degree project of web applications development.
I have not used any framework (Except bootstrap for the design) because I wanted to see what I was able to do without any of them.
The idea of the project is a web page that apart from selling cameras and photo accessories, you can upload your photos to the page itself so that people can see it.
Here I also attach the database that I have been using, it has 6 tables (Created by me).
In the future I would like to improve this project to see what I am capable of.
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

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



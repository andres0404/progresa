/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.14-log : Database - uvd_cprogresa
***************************************************************

*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`uvd_cprogresa` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `uvd_cprogresa`;

/*Table structure for table `conf_lineas_practica` */

CREATE TABLE `conf_lineas_practica` (
  `id_conf_linea` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cf_nombre` varchar(250) DEFAULT NULL COMMENT 'Nombre linea de practica',
  `cf_estado` smallint(6) DEFAULT NULL,
  `cf_linea_practica` smallint(6) DEFAULT NULL COMMENT 'MT 7',
  PRIMARY KEY (`id_conf_linea`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COMMENT='Nombre de las lineas de practicas disponibles en la plataforma';

/*Data for the table `conf_lineas_practica` */

insert  into `conf_lineas_practica`(`id_conf_linea`,`cf_nombre`,`cf_estado`,`cf_linea_practica`) values (1,'Investigación social',1,2),(2,'Monitoria',1,2),(3,'Registro de problemas',1,NULL),(4,'Emprendimiento',1,NULL),(5,'practica 1',NULL,NULL),(6,'demo 1qqwq',1,NULL),(7,'demo 1qqwq',1,NULL),(8,'demo tal tal',1,NULL),(9,'practica demo1',1,NULL),(10,'otra p',1,NULL),(11,'Esta es una practica',1,NULL),(12,'Esta es una practica',1,NULL),(13,'Práctica seria',1,1),(14,'Investigación social 1',1,1),(15,'Investigación social 2',1,1),(16,'Investigación social 3',1,1),(17,'Investigación social',1,2),(18,'otra de esas',1,2),(19,'Investigación social',1,2),(20,'Investigación social',1,2),(21,'otra',1,2),(22,'fdgfdgfdgf',1,2);

/*Table structure for table `conf_lineas_practica_archivos` */

CREATE TABLE `conf_lineas_practica_archivos` (
  `id_arch_lp` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_conf_linea` bigint(20) unsigned DEFAULT NULL,
  `id_tipo_archivo` bigint(20) unsigned DEFAULT NULL COMMENT 'MT 2',
  PRIMARY KEY (`id_arch_lp`),
  KEY `REL_CONF_LP_ARCHIVOS` (`id_conf_linea`),
  CONSTRAINT `REL_CONF_LP_ARCHIVOS` FOREIGN KEY (`id_conf_linea`) REFERENCES `conf_lineas_practica` (`id_conf_linea`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1 COMMENT='Archivos lineas de practica para inscripcion';

/*Data for the table `conf_lineas_practica_archivos` */

insert  into `conf_lineas_practica_archivos`(`id_arch_lp`,`id_conf_linea`,`id_tipo_archivo`) values (15,3,1),(16,3,3),(17,3,2),(18,3,4),(19,4,3),(20,4,2),(21,4,4),(22,7,1),(23,7,4),(24,7,5),(25,8,1),(26,8,3),(27,8,4),(28,8,5),(29,9,2),(30,9,4),(31,9,6),(32,10,1),(33,10,2),(34,11,1),(35,11,5),(36,12,1),(37,12,5),(39,14,1),(40,14,3),(41,14,4),(42,15,1),(43,15,3),(44,15,4),(45,16,1),(46,16,3),(47,16,4),(48,17,1),(49,17,3),(50,17,4),(54,19,1),(55,19,3),(56,19,4),(57,NULL,1),(58,NULL,3),(59,NULL,4),(60,NULL,1),(61,NULL,3),(62,NULL,4),(63,20,1),(64,20,3),(65,20,4),(69,18,1),(70,18,3),(71,18,4),(81,21,1),(82,21,3),(83,21,4),(84,2,1),(85,2,2),(86,2,3),(87,13,1),(88,1,1),(89,1,3),(90,1,4),(91,22,1),(92,22,5),(93,22,6);

/*Table structure for table `conf_lineas_practica_entrega` */

CREATE TABLE `conf_lineas_practica_entrega` (
  `id_entre_lp` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_linea` bigint(20) unsigned NOT NULL,
  `id_rol` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_entre_lp`),
  UNIQUE KEY `UNICO_LP_ENTREGA` (`id_linea`,`id_rol`),
  KEY `REL_ROL_ENTREGA` (`id_rol`),
  CONSTRAINT `REL_LINEA_ENTREGA` FOREIGN KEY (`id_linea`) REFERENCES `lineas_practica` (`id_linea`) ON DELETE CASCADE,
  CONSTRAINT `REL_ROL_ENTREGA` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Roles que deben entregar documentos cuando el estudiante finaliza la practica';

/*Data for the table `conf_lineas_practica_entrega` */

insert  into `conf_lineas_practica_entrega`(`id_entre_lp`,`id_linea`,`id_rol`) values (2,14,1),(4,14,2);

/*Table structure for table `conf_lineas_practica_seguimiento` */

CREATE TABLE `conf_lineas_practica_seguimiento` (
  `id_lp_seg` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_linea` bigint(20) unsigned NOT NULL,
  `id_usu_cp` bigint(20) unsigned NOT NULL COMMENT 'persona que debe hacer seguimiento',
  `fecha_seguimienti` date NOT NULL COMMENT 'fecha a hacer seguimiento',
  `id_segui` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_lp_seg`),
  UNIQUE KEY `UNICO_SEGUIMIENTO` (`id_linea`,`id_usu_cp`,`fecha_seguimienti`),
  KEY `REL_SEGUIMIENTO_SEGUIMIENTO` (`id_segui`),
  KEY `REL_ROL_SEGUIMIENTO` (`id_usu_cp`),
  CONSTRAINT `REL_SEGIMIENTO_LP` FOREIGN KEY (`id_linea`) REFERENCES `lineas_practica` (`id_linea`) ON DELETE CASCADE,
  CONSTRAINT `REL_SEGUIMIENTO_SEGUIMIENTO` FOREIGN KEY (`id_segui`) REFERENCES `seguimientos` (`id_segui`) ON DELETE NO ACTION,
  CONSTRAINT `REL_USU_SEGUIMIENTO` FOREIGN KEY (`id_usu_cp`) REFERENCES `usuarios` (`id_usu_cp`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COMMENT='Configuracion de calendario de seguimientos';

/*Data for the table `conf_lineas_practica_seguimiento` */

insert  into `conf_lineas_practica_seguimiento`(`id_lp_seg`,`id_linea`,`id_usu_cp`,`fecha_seguimienti`,`id_segui`) values (1,14,1,'2018-11-20',NULL),(5,14,1,'2018-11-30',NULL),(7,15,15,'2018-12-04',NULL),(9,15,16,'2019-01-31',NULL),(11,15,15,'2018-12-05',NULL),(13,15,15,'2018-12-26',NULL),(14,15,17,'2019-01-16',NULL),(15,17,15,'2018-12-27',NULL);

/*Table structure for table `empresas` */

CREATE TABLE `empresas` (
  `id_emp` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `emp_nombre` varchar(100) DEFAULT NULL,
  `emp_nit` bigint(20) unsigned NOT NULL,
  `emp_cod_verifica` smallint(5) unsigned NOT NULL,
  `emp_direccion` varchar(100) DEFAULT NULL,
  `emp_telefonos` varchar(150) DEFAULT NULL,
  `emp_estado` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_emp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabla de empresas';

/*Data for the table `empresas` */

/*Table structure for table `lineas_practica` */

CREATE TABLE `lineas_practica` (
  `id_linea` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ln_titulo` varchar(150) NOT NULL,
  `ln_desc` tinytext NOT NULL,
  `id_conf_linea` bigint(5) unsigned NOT NULL COMMENT 'Relacion con configuracion de linea practica',
  `id_emp` bigint(20) unsigned DEFAULT NULL,
  `ln_fec_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_usu_cp` bigint(20) unsigned DEFAULT NULL COMMENT 'cordinador de la practica',
  `ln_estado` smallint(6) DEFAULT '1',
  `id_facultad` varchar(50) DEFAULT NULL COMMENT 'MT 9 usuarios central',
  `id_programa` varchar(50) DEFAULT NULL COMMENT 'MT 1 usuarios central',
  PRIMARY KEY (`id_linea`),
  KEY `REL_LINEA_P_CONF` (`id_conf_linea`),
  KEY `REL_USUCOORDINA_USUARIOS` (`id_usu_cp`),
  CONSTRAINT `REL_LINEA_P_CONF` FOREIGN KEY (`id_conf_linea`) REFERENCES `conf_lineas_practica` (`id_conf_linea`) ON DELETE CASCADE,
  CONSTRAINT `REL_USUCOORDINA_USUARIOS` FOREIGN KEY (`id_usu_cp`) REFERENCES `usuarios` (`id_usu_cp`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COMMENT='Lineas de practica especifica';

/*Data for the table `lineas_practica` */

insert  into `lineas_practica`(`id_linea`,`ln_titulo`,`ln_desc`,`id_conf_linea`,`id_emp`,`ln_fec_crea`,`id_usu_cp`,`ln_estado`,`id_facultad`,`id_programa`) values (14,'Cordinacion de emprendimiento audiovisual','Convocatoria como proyecto de grado a todos los estudiantes interesados en sacar adelante un proyecto audiovisual como proyecto de grado',4,NULL,'2018-11-28 17:38:18',NULL,1,NULL,NULL),(15,'Trabajador Consagrado','Se requiere un Trabajador Consagrado',1,NULL,'2018-12-05 17:26:47',13,1,'1','4,1'),(16,'Trabajador Consagrado si como no','Se requiere un Trabajador Consagrado mucho mucho',1,NULL,'2018-12-05 17:30:27',14,1,'5','4'),(17,'Demo ','Demo ',1,NULL,'2018-12-06 10:58:30',13,1,'1','4,3,12'),(18,'esta es una nueva ','esta es una nueva que sirve para que los alumnos hagan lo que tienen que hacer',1,NULL,'2018-12-06 14:01:30',14,1,'2','4'),(19,'bvcbvc','bcvbcvxbcxvb',1,NULL,'2018-12-06 14:07:56',13,1,'1','4'),(20,'bla bla la','bla bla la',1,NULL,'2018-12-06 14:09:20',14,1,'1','4'),(21,'afdasfdsa','fasdfdsafdadsf',13,NULL,'2018-12-06 14:22:42',13,1,'1','4'),(22,'eeeeeeee','eeeeeeee',13,NULL,'2018-12-06 14:25:16',13,1,'1','4'),(23,'rgfdgfds','gdfgsdfgsdfgfdsg',13,NULL,'2018-12-06 14:25:44',13,1,'1','4'),(24,'owepjt lasdfkjsdfg hsdf','kdfha dlfbg.ka djfv lkajhfdligs rgfndh d',13,NULL,'2018-12-06 14:29:11',13,1,'5','4'),(25,'owepjt lasdfkjsdfg hsdf','kdfha dlfbg.ka djfv lkajhfdligs rgfndh d',13,NULL,'2018-12-06 14:29:22',14,1,'5','4'),(26,'Nueva practica de investigación','Nueva practica la investigación social y temática',14,NULL,'2018-12-06 14:43:29',13,1,'1','4'),(27,'tre','trewtrewtwert',15,NULL,'2018-12-06 14:57:09',13,1,'4','9'),(28,'bla bla bla','bla bla bla',13,NULL,'2018-12-06 15:31:18',13,1,'1,2','15,9,7'),(29,'fsdafdsfsdaf','dsfdsfsdaf',14,NULL,'2018-12-10 11:13:50',14,1,'5','6'),(30,'Desarrollaor php junior','Desarrollaor php junior, dsadsadsa, sd sad ,d sad,sad',16,NULL,'2018-12-10 18:06:39',13,1,'5,2,3','5,7');

/*Table structure for table `maestro_contenido` */

CREATE TABLE `maestro_contenido` (
  `id_tablas` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '{mtablas_contenidos}',
  `id_maestro` bigint(20) unsigned DEFAULT NULL,
  `valor_valor` varchar(100) DEFAULT NULL,
  `valor_nombre` varchar(100) DEFAULT NULL,
  `valor_estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`id_tablas`),
  UNIQUE KEY `both_unico` (`id_maestro`,`valor_valor`),
  CONSTRAINT `REL_NOMBRE_TABLA` FOREIGN KEY (`id_maestro`) REFERENCES `maestro_tablas` (`id_maestro`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

/*Data for the table `maestro_contenido` */

insert  into `maestro_contenido`(`id_tablas`,`id_maestro`,`valor_valor`,`valor_nombre`,`valor_estado`) values (1,1,'1','tal',1),(2,1,'5','tal',1),(11,4,'1','Postulado',1),(12,4,'2','Seleccionado',1),(13,4,'3','Entregado',1),(14,5,'1','Selección',1),(15,5,'2','Seguimiento',1),(16,5,'3','Entrega',1),(17,5,'4','Terminado',1),(25,2,'1','NUEVO DOCUMENTOsss',1),(26,6,'1','NUEVO DOCUMENTO, CARGAR ESE DOCUEMENTO, pata\r\n',1),(27,2,'2','NUEVO DOCUMENTO',1),(28,6,'2','NUEVO DOCUMENTO\r\n',1),(29,2,'3','NUEVO DOCUMENTO',1),(30,6,'3','NUEVO DOCUMENTO\r\n',1),(31,2,'4','NUEVO DOCUMENTO 2',1),(32,6,'4','NUEVO DOCUMENTO 2',1),(39,2,'5','dsadsadsa',1),(40,6,'5','daaasasas',1),(41,2,'6','uydqwweweq',1),(42,6,'6','huasduds ds ds dsdsa dsa idas',1),(43,2,'7','sad',1),(44,6,'7','sadasdas',1),(49,7,'1','Linea 1',1),(50,7,'2','Linea 2',1),(51,7,'3','Linea 3',1),(54,2,'8','wetreewr',1),(55,6,'8','ewrwerwerwerwer',1);

/*Table structure for table `maestro_tablas` */

CREATE TABLE `maestro_tablas` (
  `id_maestro` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '{mtablas_tablas}',
  `nom_tabla` varchar(100) DEFAULT NULL,
  `estado` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_maestro`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `maestro_tablas` */

insert  into `maestro_tablas`(`id_maestro`,`nom_tabla`,`estado`) values (1,'Estados archivos',1),(2,'Lista tipos archivos',1),(3,'Nombres lineas practica',1),(4,'Estado de las practicas',1),(5,'Tipos seguimiento (aplica: estado practica/seguimiento)',1),(6,'Descripcion archivo',1),(7,'Lineas practica',1);

/*Table structure for table `perfiles` */

CREATE TABLE `perfiles` (
  `id_perfil` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `per_nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Perfiles de acceso en la plataforma';

/*Data for the table `perfiles` */

/*Table structure for table `rel_archivos_empresa` */

CREATE TABLE `rel_archivos_empresa` (
  `id_arch_emp` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_archivo` smallint(5) unsigned DEFAULT NULL COMMENT 'MT 1',
  `id_emp` bigint(20) unsigned DEFAULT NULL,
  `id_archivo` bigint(20) unsigned DEFAULT NULL,
  `estado_archivo` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_arch_emp`),
  KEY `REL_ARCHIVO_EMPRESA` (`id_emp`),
  CONSTRAINT `REL_ARCHIVO_EMPRESA` FOREIGN KEY (`id_emp`) REFERENCES `empresas` (`id_emp`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='relacion de empresa con tabla archivos (documentacion subida por la empresa)';

/*Data for the table `rel_archivos_empresa` */

/*Table structure for table `rel_archivos_seguimiento` */

CREATE TABLE `rel_archivos_seguimiento` (
  `id_seg_arc` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_archivos` bigint(20) unsigned NOT NULL,
  `id_segui` bigint(20) unsigned NOT NULL,
  `id_arch_lp` bigint(20) unsigned DEFAULT NULL COMMENT 'conf_lineas_practica_archivos',
  `id_entre_lp` bigint(20) unsigned DEFAULT NULL COMMENT 'conf_lineas_practica_entrega',
  `estado_archivo` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_seg_arc`),
  KEY `REL_ARCHIVO_SE` (`id_archivos`),
  KEY `REL_SEGUIMIENTO_SE` (`id_segui`),
  KEY `REL_ES_ARCHIVO_VINCULA` (`id_arch_lp`),
  KEY `RE_ES_ARCHIVO_ENTREGA` (`id_entre_lp`),
  CONSTRAINT `REL_ARCHIVO_SE` FOREIGN KEY (`id_archivos`) REFERENCES `tbl_archivos` (`id_archivo`) ON DELETE CASCADE,
  CONSTRAINT `REL_ES_ARCHIVO_VINCULA` FOREIGN KEY (`id_arch_lp`) REFERENCES `conf_lineas_practica_archivos` (`id_arch_lp`) ON DELETE CASCADE,
  CONSTRAINT `REL_SEGUIMIENTO_SE` FOREIGN KEY (`id_segui`) REFERENCES `seguimientos` (`id_segui`) ON DELETE CASCADE,
  CONSTRAINT `RE_ES_ARCHIVO_ENTREGA` FOREIGN KEY (`id_entre_lp`) REFERENCES `conf_lineas_practica_entrega` (`id_entre_lp`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Archivos de los seguimiento de una linea de practica';

/*Data for the table `rel_archivos_seguimiento` */

insert  into `rel_archivos_seguimiento`(`id_seg_arc`,`id_archivos`,`id_segui`,`id_arch_lp`,`id_entre_lp`,`estado_archivo`) values (1,6,1,90,NULL,1);

/*Table structure for table `rel_linea_perfil` */

CREATE TABLE `rel_linea_perfil` (
  `id_lin_perfil` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_linea` bigint(20) unsigned NOT NULL,
  `id_perfil` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_lin_perfil`),
  KEY `REL_PRACTUCA` (`id_linea`),
  KEY `REL_PERFIL` (`id_perfil`),
  CONSTRAINT `REL_PERFIL` FOREIGN KEY (`id_perfil`) REFERENCES `lineas_practica` (`id_linea`) ON DELETE CASCADE,
  CONSTRAINT `REL_PRACTUCA` FOREIGN KEY (`id_linea`) REFERENCES `perfiles` (`id_perfil`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Privilegios que tienen los perfiles para gestionar lineas de practica';

/*Data for the table `rel_linea_perfil` */

/*Table structure for table `rel_usuarios_practicas` */

CREATE TABLE `rel_usuarios_practicas` (
  `id_practica` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_linea` bigint(20) unsigned NOT NULL,
  `id_usu_cp` bigint(20) unsigned NOT NULL,
  `id_sede` bigint(20) unsigned NOT NULL,
  `fecha_reg` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado_practica` smallint(5) unsigned NOT NULL COMMENT 'MT 4',
  PRIMARY KEY (`id_practica`),
  UNIQUE KEY `UNICA_INSCRIPCION` (`id_linea`,`id_usu_cp`),
  KEY `REL_LINEA_P` (`id_linea`),
  KEY `REL_USUARIOS` (`id_usu_cp`),
  CONSTRAINT `REL_LINEA_P` FOREIGN KEY (`id_linea`) REFERENCES `lineas_practica` (`id_linea`) ON DELETE CASCADE,
  CONSTRAINT `REL_USUARIOS` FOREIGN KEY (`id_usu_cp`) REFERENCES `usuarios` (`id_usu_cp`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1 COMMENT='Tabla de vinculacion de un usuario con una practica';

/*Data for the table `rel_usuarios_practicas` */

insert  into `rel_usuarios_practicas`(`id_practica`,`id_linea`,`id_usu_cp`,`id_sede`,`fecha_reg`,`estado_practica`) values (31,15,18,2,'2018-12-12 18:08:52',1);

/*Table structure for table `roles` */

CREATE TABLE `roles` (
  `id_rol` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom_rol` varchar(50) DEFAULT NULL,
  `rol_bit_a_bit` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`id_rol`,`nom_rol`,`rol_bit_a_bit`) values (1,'DOCENTE',1),(2,'ORIENTADOR',2),(3,'COORDINADOR',4),(4,'ADMIN_LINEA',8),(5,'EMPRESA',16),(6,'SUPER_ADMIN',32),(7,'ESTUDIANTE',64);

/*Table structure for table `seguimientos` */

CREATE TABLE `seguimientos` (
  `id_segui` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_practica` bigint(20) unsigned DEFAULT NULL,
  `segui_titulo` varchar(100) DEFAULT NULL,
  `segui_tipo` smallint(6) DEFAULT NULL COMMENT 'Estado sacado de lineas_practica',
  `id_usu_cent` bigint(20) unsigned NOT NULL COMMENT 'Persona que registra el seguimiento',
  `segui_fecha_reg` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_segui`),
  KEY `REL_PRACTICA` (`id_practica`),
  KEY `REL_USUARIO_SEGUIMIENTO` (`id_usu_cent`),
  CONSTRAINT `REL_PRACTICA` FOREIGN KEY (`id_practica`) REFERENCES `rel_usuarios_practicas` (`id_practica`) ON DELETE CASCADE,
  CONSTRAINT `REL_USUARIO_SEGUIMIENTO` FOREIGN KEY (`id_usu_cent`) REFERENCES `usuarios` (`id_usu_cent`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='registro de seguimientos de una linea de practica';

/*Data for the table `seguimientos` */

insert  into `seguimientos`(`id_segui`,`id_practica`,`segui_titulo`,`segui_tipo`,`id_usu_cent`,`segui_fecha_reg`) values (1,31,'Esto es un archivo',NULL,17,'2018-12-14 10:45:47');

/*Table structure for table `sys_log` */

CREATE TABLE `sys_log` (
  `id_log` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usu` bigint(20) unsigned DEFAULT NULL COMMENT 'usuario',
  `log_accion` varchar(200) DEFAULT NULL,
  `browser_bits` smallint(5) unsigned DEFAULT NULL COMMENT 'Bits del navegador',
  `browser` varchar(40) DEFAULT NULL COMMENT 'Nevegador',
  `majorver` smallint(6) DEFAULT NULL COMMENT 'Version nevegador',
  `browser_type` varchar(20) DEFAULT NULL COMMENT 'tipo de navegador',
  `browser_maker` varchar(40) DEFAULT NULL COMMENT 'fabricante navegador',
  `platform` varchar(40) DEFAULT NULL COMMENT 'SO',
  `platform_version` varchar(10) DEFAULT NULL COMMENT 'Version SO',
  `platform_bits` smallint(5) unsigned DEFAULT NULL COMMENT 'bits SO',
  `platform_maker` varchar(40) DEFAULT NULL COMMENT 'Fabricante SO',
  `device_type` varchar(20) DEFAULT NULL COMMENT 'Tipo de dispositivo',
  `device_pointing_method` varchar(10) DEFAULT NULL COMMENT 'Forma de manejo dispositivo',
  `device_brand_name` varchar(15) DEFAULT NULL COMMENT 'Merca del dispositivo',
  `cssversion` varchar(10) DEFAULT NULL COMMENT 'Version del css',
  `javascript` smallint(5) unsigned DEFAULT NULL COMMENT 'javascript activo',
  `cookies` smallint(5) unsigned DEFAULT NULL COMMENT 'Cookies activo',
  `log_useragent` varchar(350) DEFAULT NULL COMMENT 'metadatos useragent navegador',
  `log_ip_client` varchar(50) DEFAULT NULL COMMENT 'IP del usuario',
  `log_fecha` date DEFAULT NULL,
  `log_hora` time DEFAULT NULL,
  PRIMARY KEY (`id_log`),
  KEY `INDEX_LOG_USUARIO` (`id_usu`),
  KEY `INDEX_LOG_USUARIO_ACCION` (`log_accion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sys_log` */

/*Table structure for table `tbl_archivos` */

CREATE TABLE `tbl_archivos` (
  `id_archivo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ahv_imagen` mediumblob,
  `ahv_mime` varchar(100) DEFAULT NULL,
  `ahv_nombre` varchar(100) DEFAULT NULL COMMENT 'nombre del archivo',
  `id_segui` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_archivo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Tabla de archivos del sistema';

/*Data for the table `tbl_archivos` */

insert  into `tbl_archivos`(`id_archivo`,`ahv_imagen`,`ahv_mime`,`ahv_nombre`,`id_segui`) values (1,NULL,'pdf/tal','cedula',1),(5,NULL,'pdf/aplication','certificado',1),(6,NULL,'pdf/aplication','certificado 2',1);

/*Table structure for table `usuarios` */

CREATE TABLE `usuarios` (
  `id_usu_cp` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '{tbl_usuarios}',
  `id_usu_cent` bigint(20) unsigned NOT NULL,
  `id_rol` bigint(20) unsigned NOT NULL,
  `id_emp` bigint(20) unsigned DEFAULT NULL,
  `cf_linea_practica` smallint(5) unsigned DEFAULT NULL COMMENT 'MT 7',
  `id_usu_cp_crea` bigint(20) unsigned DEFAULT NULL COMMENT 'id del usuario que crea al usuario',
  PRIMARY KEY (`id_usu_cp`),
  UNIQUE KEY `UNICO_ROL` (`id_usu_cent`),
  KEY `REL_ROLES_USUARIO` (`id_rol`),
  KEY `REL_EMPRESA_USUARIO` (`id_emp`),
  CONSTRAINT `REL_EMPRESA_USUARIO` FOREIGN KEY (`id_emp`) REFERENCES `empresas` (`id_emp`) ON DELETE CASCADE,
  CONSTRAINT `REL_ROLES_USUARIO` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COMMENT='Usuarios central activos en la plataforma';

/*Data for the table `usuarios` */

insert  into `usuarios`(`id_usu_cp`,`id_usu_cent`,`id_rol`,`id_emp`,`cf_linea_practica`,`id_usu_cp_crea`) values (1,17,1,NULL,NULL,3),(2,156759,6,NULL,NULL,NULL),(3,156772,4,NULL,1,NULL),(4,156773,4,NULL,2,3),(5,156774,4,NULL,1,NULL),(6,156775,4,NULL,1,NULL),(7,156776,4,NULL,1,3),(8,156777,4,NULL,3,3),(9,156778,4,NULL,1,3),(10,156779,4,NULL,2,NULL),(11,156780,4,NULL,2,NULL),(12,156781,4,NULL,1,NULL),(13,156782,3,NULL,1,3),(14,156784,3,NULL,1,3),(15,156785,1,NULL,1,13),(16,156786,1,NULL,1,13),(17,156787,2,NULL,1,13),(18,60178,7,NULL,1,13),(19,1,7,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
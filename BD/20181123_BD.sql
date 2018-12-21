/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.21 : Database - uvd_cprogresa
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `uvd_cprogresa`;

/*Table structure for table `conf_lineas_practica` */

DROP TABLE IF EXISTS `conf_lineas_practica`;

CREATE TABLE `conf_lineas_practica` (
  `id_conf_linea` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cf_nombre` varchar(250) DEFAULT NULL COMMENT 'Nombre linea de practica',
  `cf_estado` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_conf_linea`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Nombre de las lineas de practicas disponibles en la plataforma';

/*Data for the table `conf_lineas_practica` */

insert  into `conf_lineas_practica`(`id_conf_linea`,`cf_nombre`,`cf_estado`) values (1,'Investigación social',1),(2,'Monitoria',1),(3,'Registro de problemas',1),(4,'Emprendimiento',1);

/*Table structure for table `conf_lineas_practica_archivos` */

DROP TABLE IF EXISTS `conf_lineas_practica_archivos`;

CREATE TABLE `conf_lineas_practica_archivos` (
  `id_arch_lp` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_conf_linea` bigint(20) unsigned DEFAULT NULL,
  `id_tipo_archivo` bigint(20) unsigned DEFAULT NULL COMMENT 'MT 2',
  PRIMARY KEY (`id_arch_lp`),
  KEY `REL_CONF_LP_ARCHIVOS` (`id_conf_linea`),
  CONSTRAINT `REL_CONF_LP_ARCHIVOS` FOREIGN KEY (`id_conf_linea`) REFERENCES `conf_lineas_practica` (`id_conf_linea`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COMMENT='Archivos lineas de practica para inscripcion';

/*Data for the table `conf_lineas_practica_archivos` */

insert  into `conf_lineas_practica_archivos`(`id_arch_lp`,`id_conf_linea`,`id_tipo_archivo`) values (9,1,1),(10,1,3),(11,1,4),(12,2,1),(13,2,3),(14,2,2),(15,3,1),(16,3,3),(17,3,2),(18,3,4),(19,4,3),(20,4,2),(21,4,4);

/*Table structure for table `conf_lineas_practica_entrega` */

DROP TABLE IF EXISTS `conf_lineas_practica_entrega`;

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

DROP TABLE IF EXISTS `conf_lineas_practica_seguimiento`;

CREATE TABLE `conf_lineas_practica_seguimiento` (
  `id_lp_seg` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_linea` bigint(20) unsigned NOT NULL,
  `id_rol` bigint(20) unsigned NOT NULL COMMENT 'rol que debe hacer seguimiento',
  `fecha_seguimienti` date NOT NULL COMMENT 'fecha a hacer seguimiento',
  `id_segui` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_lp_seg`),
  UNIQUE KEY `UNICO_SEGUIMIENTO` (`id_linea`,`id_rol`,`fecha_seguimienti`),
  KEY `REL_SEGUIMIENTO_SEGUIMIENTO` (`id_segui`),
  KEY `REL_ROL_SEGUIMIENTO` (`id_rol`),
  CONSTRAINT `REL_ROL_SEGUIMIENTO` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE,
  CONSTRAINT `REL_SEGIMIENTO_LP` FOREIGN KEY (`id_linea`) REFERENCES `lineas_practica` (`id_linea`) ON DELETE CASCADE,
  CONSTRAINT `REL_SEGUIMIENTO_SEGUIMIENTO` FOREIGN KEY (`id_segui`) REFERENCES `seguimientos` (`id_segui`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Configuracion de calendario de seguimientos';

/*Data for the table `conf_lineas_practica_seguimiento` */

insert  into `conf_lineas_practica_seguimiento`(`id_lp_seg`,`id_linea`,`id_rol`,`fecha_seguimienti`,`id_segui`) values (1,14,1,'2018-11-20',NULL),(5,14,1,'2018-11-30',NULL);

/*Table structure for table `doc_log` */

DROP TABLE IF EXISTS `doc_log`;

CREATE TABLE `doc_log` (
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

/*Data for the table `doc_log` */

/*Table structure for table `empresas` */

DROP TABLE IF EXISTS `empresas`;

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

DROP TABLE IF EXISTS `lineas_practica`;

CREATE TABLE `lineas_practica` (
  `id_linea` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ln_titulo` varchar(150) NOT NULL,
  `ln_desc` tinytext NOT NULL,
  `id_conf_linea` bigint(5) unsigned NOT NULL COMMENT 'Relacion con configuracion de linea practica',
  `id_emp` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_linea`),
  KEY `REL_LINEA_P_CONF` (`id_conf_linea`),
  CONSTRAINT `REL_LINEA_P_CONF` FOREIGN KEY (`id_conf_linea`) REFERENCES `conf_lineas_practica` (`id_conf_linea`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COMMENT='Lineas de practica especifica';

/*Data for the table `lineas_practica` */

insert  into `lineas_practica`(`id_linea`,`ln_titulo`,`ln_desc`,`id_conf_linea`,`id_emp`) values (14,'Cordinacion de emprendimiento audiovisual','Convocatoria como proyecto de grado a todos los estudiantes interesados en sacar adelante un proyecto audiovisual como proyecto de grado',4,NULL);

/*Table structure for table `maestro_contenido` */

DROP TABLE IF EXISTS `maestro_contenido`;

CREATE TABLE `maestro_contenido` (
  `id_tablas` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '{mtablas_contenidos}',
  `id_maestro` bigint(20) unsigned DEFAULT NULL,
  `valor_valor` varchar(100) DEFAULT NULL,
  `valor_nombre` varchar(100) DEFAULT NULL,
  `valor_estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`id_tablas`),
  UNIQUE KEY `both_unico` (`id_maestro`,`valor_valor`),
  CONSTRAINT `REL_NOMBRE_TABLA` FOREIGN KEY (`id_maestro`) REFERENCES `maestro_tablas` (`id_maestro`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `maestro_contenido` */

insert  into `maestro_contenido`(`id_tablas`,`id_maestro`,`valor_valor`,`valor_nombre`,`valor_estado`) values (1,1,'1','tal',1),(2,1,'5','tal',1),(7,2,'1','Copia de la cedula 150%',1),(8,2,'2','Certificado aprobacion centro progresa',1),(9,2,'3','Sabana de notas',1),(10,2,'4','Permiso de padres y/o acudiantes responsables',1),(11,4,'1','Postulado',1),(12,4,'2','Seleccionado',1),(13,4,'3','Entregado',1),(14,5,'1','Selección',1),(15,5,'2','Seguimiento',1),(16,5,'3','Entrega',1),(17,5,'4','Terminado',1);

/*Table structure for table `maestro_tablas` */

DROP TABLE IF EXISTS `maestro_tablas`;

CREATE TABLE `maestro_tablas` (
  `id_maestro` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '{mtablas_tablas}',
  `nom_tabla` varchar(100) DEFAULT NULL,
  `estado` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_maestro`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `maestro_tablas` */

insert  into `maestro_tablas`(`id_maestro`,`nom_tabla`,`estado`) values (1,'Estados archivos',1),(2,'Lista tipos archivos',1),(3,'Nombres lineas practica',1),(4,'Estado de las practicas',1),(5,'Tipos seguimiento (aplica: estado practica/seguimiento)',1);

/*Table structure for table `perfiles` */

DROP TABLE IF EXISTS `perfiles`;

CREATE TABLE `perfiles` (
  `id_perfil` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `per_nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Perfiles de acceso en la plataforma';

/*Data for the table `perfiles` */

/*Table structure for table `rel_archivos_empresa` */

DROP TABLE IF EXISTS `rel_archivos_empresa`;

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

DROP TABLE IF EXISTS `rel_archivos_seguimiento`;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Archivos de los seguimiento de una linea de practica';

/*Data for the table `rel_archivos_seguimiento` */

insert  into `rel_archivos_seguimiento`(`id_seg_arc`,`id_archivos`,`id_segui`,`id_arch_lp`,`id_entre_lp`,`estado_archivo`) values (1,1,1,10,NULL,1),(2,5,2,9,NULL,1),(3,6,3,11,NULL,1);

/*Table structure for table `rel_linea_perfil` */

DROP TABLE IF EXISTS `rel_linea_perfil`;

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

DROP TABLE IF EXISTS `rel_usuarios_practicas`;

CREATE TABLE `rel_usuarios_practicas` (
  `id_practica` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_linea` bigint(20) unsigned NOT NULL,
  `id_usu_cp` bigint(20) unsigned NOT NULL,
  `id_sede` bigint(20) unsigned NOT NULL,
  `estado_practica` smallint(5) unsigned NOT NULL COMMENT 'MT 4',
  PRIMARY KEY (`id_practica`),
  KEY `REL_LINEA_P` (`id_linea`),
  KEY `REL_USUARIOS` (`id_usu_cp`),
  CONSTRAINT `REL_LINEA_P` FOREIGN KEY (`id_linea`) REFERENCES `lineas_practica` (`id_linea`) ON DELETE CASCADE,
  CONSTRAINT `REL_USUARIOS` FOREIGN KEY (`id_usu_cp`) REFERENCES `usuarios` (`id_usu_cp`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Tabla de vinculacion de un usuario con una practica';

/*Data for the table `rel_usuarios_practicas` */

insert  into `rel_usuarios_practicas`(`id_practica`,`id_linea`,`id_usu_cp`,`id_sede`,`estado_practica`) values (1,14,1,10,1);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id_rol` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom_rol` varchar(50) DEFAULT NULL,
  `rol_bit_a_bit` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`id_rol`,`nom_rol`,`rol_bit_a_bit`) values (1,'DOCENTE',1),(2,'ORIENTADOR',2),(3,'COORDINADOR',4),(4,'ADMIN_LINEA',8),(5,'EMPRESA',16),(6,'SUPER_ADMIN',32);

/*Table structure for table `seguimientos` */

DROP TABLE IF EXISTS `seguimientos`;

CREATE TABLE `seguimientos` (
  `id_segui` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_practica` bigint(20) unsigned DEFAULT NULL,
  `segui_titulo` varchar(100) DEFAULT NULL,
  `segui_tipo` smallint(6) DEFAULT NULL COMMENT 'Estado sacado de lineas_practica',
  `id_usu_cent` bigint(20) unsigned NOT NULL COMMENT 'Persona que registra el seguimiento',
  PRIMARY KEY (`id_segui`),
  KEY `REL_PRACTICA` (`id_practica`),
  KEY `REL_USUARIO_SEGUIMIENTO` (`id_usu_cent`),
  CONSTRAINT `REL_PRACTICA` FOREIGN KEY (`id_practica`) REFERENCES `rel_usuarios_practicas` (`id_practica`) ON DELETE CASCADE,
  CONSTRAINT `REL_USUARIO_SEGUIMIENTO` FOREIGN KEY (`id_usu_cent`) REFERENCES `usuarios` (`id_usu_cent`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='registro de seguimientos de una linea de practica';

/*Data for the table `seguimientos` */

insert  into `seguimientos`(`id_segui`,`id_practica`,`segui_titulo`,`segui_tipo`,`id_usu_cent`) values (1,1,'Archivo tal',1,17),(2,1,'Se sube tal cosa',1,17),(3,1,'Se sube archivo bla',1,17);

/*Table structure for table `tbl_archivos` */

DROP TABLE IF EXISTS `tbl_archivos`;

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

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id_usu_cp` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '{tbl_usuarios}',
  `id_usu_cent` bigint(20) unsigned NOT NULL,
  `id_rol` bigint(20) unsigned NOT NULL,
  `id_emp` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_usu_cp`),
  UNIQUE KEY `UNICO_ROL` (`id_usu_cent`),
  KEY `REL_ROLES_USUARIO` (`id_rol`),
  KEY `REL_EMPRESA_USUARIO` (`id_emp`),
  CONSTRAINT `REL_EMPRESA_USUARIO` FOREIGN KEY (`id_emp`) REFERENCES `empresas` (`id_emp`) ON DELETE CASCADE,
  CONSTRAINT `REL_ROLES_USUARIO` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Usuarios central activos en la plataforma';

/*Data for the table `usuarios` */

insert  into `usuarios`(`id_usu_cp`,`id_usu_cent`,`id_rol`,`id_emp`) values (1,17,1,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

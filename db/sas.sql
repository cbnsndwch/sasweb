/*
Navicat MySQL Data Transfer

Source Server         : localhostXAMP
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : sas

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2015-03-25 20:08:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for android_devices
-- ----------------------------
DROP TABLE IF EXISTS `android_devices`;
CREATE TABLE `android_devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `sdk` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of android_devices
-- ----------------------------

-- ----------------------------
-- Table structure for applications
-- ----------------------------
DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `description` text,
  `sdkversion` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `downloads` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `have_data` tinyint(4) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `verificate` tinyint(1) DEFAULT '0',
  `users_id` int(11) DEFAULT '1',
  `recommended` tinyint(1) DEFAULT '0',
  `only_logged` tinyint(1) DEFAULT '0',
  `developer` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=301 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of applications
-- ----------------------------
INSERT INTO `applications` VALUES ('298', 'com.mxtech.videoplayer.ad', 'MX Player', '34', '1.6j', '3', 'xsxs', '7', '5991707', '0', '0', '0', '2015-03-25 05:48:24', '2015-03-25 05:48:25', '1', '1', '0', '0', null, '300');
INSERT INTO `applications` VALUES ('299', 'com.mxtech.videoplayer.ad', 'MX Video Player', '14', '1.4a', '3', 'vavaev', '7', '4734841', '0', '0', '0', '2015-03-25 05:48:24', '2015-03-25 05:48:25', '1', '1', '0', '0', null, '300');
INSERT INTO `applications` VALUES ('300', 'com.mxtech.videoplayer.ad', 'MX Player', '43', '1.7.7', '3', 'cscsc', '7', '6911457', '0', '0', '0', '2015-03-25 05:48:25', '2015-03-25 05:48:25', '1', '1', '0', '0', null, null);

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'Sin Clasificar');
INSERT INTO `categories` VALUES ('3', 'Herramientas');
INSERT INTO `categories` VALUES ('4', 'ComunicaciÃ³n');
INSERT INTO `categories` VALUES ('5', 'Productividad');
INSERT INTO `categories` VALUES ('6', 'Entretenimiento');
INSERT INTO `categories` VALUES ('7', 'Sociedad');
INSERT INTO `categories` VALUES ('8', 'Puzle');
INSERT INTO `categories` VALUES ('9', 'MÃºsica y audio');
INSERT INTO `categories` VALUES ('10', 'PersonalizaciÃ³n');
INSERT INTO `categories` VALUES ('11', 'Juegos de rol');
INSERT INTO `categories` VALUES ('12', 'Deportes');
INSERT INTO `categories` VALUES ('13', 'FotografÃ­a');
INSERT INTO `categories` VALUES ('14', 'Arcade');
INSERT INTO `categories` VALUES ('15', 'Tiempo');
INSERT INTO `categories` VALUES ('16', 'Cartas');
INSERT INTO `categories` VALUES ('17', 'Casual');
INSERT INTO `categories` VALUES ('18', 'Libros y obras de consulta');
INSERT INTO `categories` VALUES ('19', 'Carreras');
INSERT INTO `categories` VALUES ('20', 'Negocios');
INSERT INTO `categories` VALUES ('21', 'Aventura');
INSERT INTO `categories` VALUES ('22', 'Viajes y guÃ­as');
INSERT INTO `categories` VALUES ('23', 'Estilo de vida');
INSERT INTO `categories` VALUES ('24', 'Noticias y revistas');
INSERT INTO `categories` VALUES ('25', 'Multimedia y vÃ­deo');
INSERT INTO `categories` VALUES ('26', 'Palabras');
INSERT INTO `categories` VALUES ('27', 'Salud y bienestar');
INSERT INTO `categories` VALUES ('28', 'AcciÃ³n');
INSERT INTO `categories` VALUES ('29', 'Juegos de mesa');
INSERT INTO `categories` VALUES ('30', 'Cine familiar');
INSERT INTO `categories` VALUES ('31', 'Bibliotecas y demos');
INSERT INTO `categories` VALUES ('32', 'Compras');
INSERT INTO `categories` VALUES ('33', 'Finanzas');
INSERT INTO `categories` VALUES ('34', 'MÃºsica');
INSERT INTO `categories` VALUES ('35', 'EducaciÃ³n');
INSERT INTO `categories` VALUES ('36', 'Medicina');
INSERT INTO `categories` VALUES ('37', 'Transporte');
INSERT INTO `categories` VALUES ('38', 'SimulaciÃ³n');
INSERT INTO `categories` VALUES ('39', 'Estrategia');

-- ----------------------------
-- Table structure for coments
-- ----------------------------
DROP TABLE IF EXISTS `coments`;
CREATE TABLE `coments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) DEFAULT NULL,
  `applications_id` int(255) DEFAULT NULL,
  `coment` varchar(1000) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `visible` tinyint(1) DEFAULT '0',
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of coments
-- ----------------------------
INSERT INTO `coments` VALUES ('6', '2', '100', 'ddddd', '::1', '2015-03-25 02:00:18', '1', '2015-03-25 02:00:18');
INSERT INTO `coments` VALUES ('7', '2', '100', 'a sfcsdvcds \r\nxxx', '::1', '2015-03-25 02:00:34', '1', '2015-03-25 02:00:34');

-- ----------------------------
-- Table structure for configurations
-- ----------------------------
DROP TABLE IF EXISTS `configurations`;
CREATE TABLE `configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bd_hash` varchar(255) DEFAULT NULL,
  `last_db_update` datetime DEFAULT NULL,
  `days_to_new` int(11) DEFAULT '15',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of configurations
-- ----------------------------
INSERT INTO `configurations` VALUES ('1', 'e9ea7a827ec2694ecdfee1583d5dbbd80dfe3019', '2015-03-16 20:57:04', '15');

-- ----------------------------
-- Table structure for datas
-- ----------------------------
DROP TABLE IF EXISTS `datas`;
CREATE TABLE `datas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL,
  `verificate` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of datas
-- ----------------------------

-- ----------------------------
-- Table structure for generalcoments
-- ----------------------------
DROP TABLE IF EXISTS `generalcoments`;
CREATE TABLE `generalcoments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coment` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `usertag` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of generalcoments
-- ----------------------------
INSERT INTO `generalcoments` VALUES ('11', 'adicionar opción para instalar todos los updates', '10.8.182.42', '2015-01-16 14:43:16', 'HUAWEI - U8860', 'hjkmnd32456787jhbvw345bv', '');
INSERT INTO `generalcoments` VALUES ('12', 'ssss', '::1', '2015-03-25 02:01:33', 'web', 'vjksdbvi6sadvg7sd6vsdiv67gsdvi7sdav67', null);

-- ----------------------------
-- Table structure for histories
-- ----------------------------
DROP TABLE IF EXISTS `histories`;
CREATE TABLE `histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5003 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of histories
-- ----------------------------
INSERT INTO `histories` VALUES ('4997', 'addon.simplylock.theme.kanttii', '1.0', '::1', 'WebAccess', '2015-03-25 02:38:51');
INSERT INTO `histories` VALUES ('4998', 'com.mxtech.videoplayer.ad', '1.7.31', '::1', 'WebAccess', '2015-03-25 03:13:37');
INSERT INTO `histories` VALUES ('4999', 'com.mxtech.videoplayer.ad', '1.6j', '::1', 'WebAccess', '2015-03-25 03:13:45');
INSERT INTO `histories` VALUES ('5000', 'com.mxtech.videoplayer.ad', '1.7.31', '::1', 'WebAccess', '2015-03-25 03:13:49');
INSERT INTO `histories` VALUES ('5001', 'com.mxtech.videoplayer.ad', '1.6j', '::1', 'WebAccess', '2015-03-25 03:28:53');
INSERT INTO `histories` VALUES ('5002', 'com.mxtech.videoplayer.ad', '1.6j', '::1', 'WebAccess', '2015-03-25 03:30:00');

-- ----------------------------
-- Table structure for networks
-- ----------------------------
DROP TABLE IF EXISTS `networks`;
CREATE TABLE `networks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rango` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of networks
-- ----------------------------
INSERT INTO `networks` VALUES ('1', '10.8.80.0/20', 'FAC. Electrica');
INSERT INTO `networks` VALUES ('2', '10.8.96.0/20', 'FAC. Arquitectura');
INSERT INTO `networks` VALUES ('3', '10.8.112.0/20', 'FAC. Mecanica');
INSERT INTO `networks` VALUES ('4', '10.8.128.0/20', 'FAC. INDUSTRIAL');
INSERT INTO `networks` VALUES ('5', '10.8.144.0/20', 'FAC. CIVIL');
INSERT INTO `networks` VALUES ('6', '10.8.160.0/20', 'FAC. QUÃMICA');
INSERT INTO `networks` VALUES ('7', '10.8.176.0/20', 'CEIS');
INSERT INTO `networks` VALUES ('8', '10.8.172.0/20', 'CIPEL');
INSERT INTO `networks` VALUES ('9', '10.8.208.0/20', 'Reservada 1');
INSERT INTO `networks` VALUES ('10', '10.8.224.0/20', 'Reservada 3');
INSERT INTO `networks` VALUES ('11', '10.8.240.0/20', 'Reservada 2');
INSERT INTO `networks` VALUES ('12', '10.8.241.0/24', 'CIME');
INSERT INTO `networks` VALUES ('13', '10.8.242.0/24', 'CECAT');
INSERT INTO `networks` VALUES ('14', '10.8.243.0/24', 'CREA');
INSERT INTO `networks` VALUES ('15', '10.8.244.0/24', 'CIH');
INSERT INTO `networks` VALUES ('16', '10.8.245.0/24', 'BTUR');
INSERT INTO `networks` VALUES ('17', '10.8.246.0/24', 'CETA');
INSERT INTO `networks` VALUES ('18', '10.8.247.0/24', 'UDM');
INSERT INTO `networks` VALUES ('19', '10.8.248.0/24', 'DICT');
INSERT INTO `networks` VALUES ('20', '10.8.250.0/24', 'Reservadas 4');
INSERT INTO `networks` VALUES ('21', '10.8.249.0/24', 'CEIM');
INSERT INTO `networks` VALUES ('22', '10.8.251.0/24', 'Casablanca');
INSERT INTO `networks` VALUES ('23', '10.8.252.0/24', 'CETER');
INSERT INTO `networks` VALUES ('24', '10.8.16.0/24', 'RECTORADO');
INSERT INTO `networks` VALUES ('25', '10.8.17.0/24', 'Ofic. Rector / Sec. Gen.');
INSERT INTO `networks` VALUES ('26', '10.8.18.0/24', 'Dir. Ext. Universitaria');
INSERT INTO `networks` VALUES ('27', '10.8.19.0/24', 'Reservada 5');
INSERT INTO `networks` VALUES ('28', '10.8.20.0/24', 'Reservada 6');
INSERT INTO `networks` VALUES ('29', '10.8.21.0/24', 'Relaciones Internacionales');
INSERT INTO `networks` VALUES ('30', '10.8.22.0/24', 'VREU');
INSERT INTO `networks` VALUES ('31', '10.8.23.0/24', 'VRIP');
INSERT INTO `networks` VALUES ('32', '10.8.24.0/24', 'Economia');
INSERT INTO `networks` VALUES ('33', '10.8.25.0/24', 'DirecciÃ³n de Prot. FÃ­sica');
INSERT INTO `networks` VALUES ('34', '10.8.26.0/24', 'Recursos Humanos');
INSERT INTO `networks` VALUES ('35', '10.8.27.0/24', 'VRIC / UJC');
INSERT INTO `networks` VALUES ('36', '10.8.28.0/24', 'VRAS');
INSERT INTO `networks` VALUES ('37', '10.8.29.0/24', 'AtenciÃ³n Extranjeros');
INSERT INTO `networks` VALUES ('38', '10.8.33.0/24', 'DEDER');
INSERT INTO `networks` VALUES ('39', '10.8.32.0/24', 'CENTRO DIST. HOTELITO');
INSERT INTO `networks` VALUES ('40', '10.8.34.0/24', 'ALIMENTACIÃ“N');
INSERT INTO `networks` VALUES ('41', '10.8.35.0/24', 'HOTELITO');
INSERT INTO `networks` VALUES ('42', '10.8.36.0/24', 'Edificio 600');
INSERT INTO `networks` VALUES ('43', '10.8.37.0/24', 'Edificio 700');
INSERT INTO `networks` VALUES ('44', '10.8.38.0/24', 'Edificio 800');
INSERT INTO `networks` VALUES ('45', '10.8.64.0/24', 'OTRAS ÃREAS');
INSERT INTO `networks` VALUES ('46', '10.8.59.0/24', 'Edificio 20');
INSERT INTO `networks` VALUES ('47', '10.8.40.0/24', 'BECA');
INSERT INTO `networks` VALUES ('48', '10.8.41.0/24', 'Beca DirecciÃ³n');
INSERT INTO `networks` VALUES ('49', '10.8.42.0/24', 'Beca Laboratorios');
INSERT INTO `networks` VALUES ('50', '10.8.43.0/24', 'Beca Edificio 100');
INSERT INTO `networks` VALUES ('51', '10.8.44.0/24', 'Beca Edificio 200');
INSERT INTO `networks` VALUES ('52', '10.8.45.0/24', 'Beca Edificio 300');
INSERT INTO `networks` VALUES ('53', '10.8.46.0/24', 'Beca Edificio 400');
INSERT INTO `networks` VALUES ('54', '10.8.47.0/24', 'Beca Edificio 500');
INSERT INTO `networks` VALUES ('55', '10.8.48.0/24', 'CENTRO DIST. EDICIONES');
INSERT INTO `networks` VALUES ('56', '10.8.49.0/24', 'EDICIONES');
INSERT INTO `networks` VALUES ('57', '10.8.50.0/24', 'CENTRO DIST. EDICIONES GEST');
INSERT INTO `networks` VALUES ('58', '10.8.51.0/24', 'Reservadas 7');
INSERT INTO `networks` VALUES ('59', '10.8.52.0/24', 'Reservadas 8');
INSERT INTO `networks` VALUES ('60', '10.8.53.0/24', 'TRANSPORTE');
INSERT INTO `networks` VALUES ('61', '10.8.54.0/24', 'MANT. E INV.');
INSERT INTO `networks` VALUES ('62', '10.8.55.0/24', 'Reservadas');
INSERT INTO `networks` VALUES ('63', '10.8.56.0/24', 'Edificio 19');
INSERT INTO `networks` VALUES ('64', '10.8.57.0/24', 'UDIO');
INSERT INTO `networks` VALUES ('65', '10.8.58.0/24', 'Edificio 20 Lab. Est.');
INSERT INTO `networks` VALUES ('66', '10.8.59.0/24', 'Edificio 20');
INSERT INTO `networks` VALUES ('67', '10.9.0.0/16', 'Citi');

-- ----------------------------
-- Table structure for noticies
-- ----------------------------
DROP TABLE IF EXISTS `noticies`;
CREATE TABLE `noticies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `body` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of noticies
-- ----------------------------

-- ----------------------------
-- Table structure for uploads
-- ----------------------------
DROP TABLE IF EXISTS `uploads`;
CREATE TABLE `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `categories_id` int(255) DEFAULT '1',
  `description` text,
  `sdkversion` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `have_data` tinyint(4) DEFAULT '0',
  `ip` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `developer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of uploads
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'system', 'b38fdeb334c833d798de409cce891288da6055ee', 'admin', '2014-11-21 04:08:29', '2014-11-21 04:08:29', 'ewrcgergeweewrgergergcergergcegcwergegewrgwe', 'Sas Team');
INSERT INTO `users` VALUES ('2', 'chenry', '821bc1a102bb50ac8f16f333cdfb34fae49a8ab1', 'admin', '2014-11-21 04:08:29', '2015-03-19 14:05:15', 'vjksdbvi6sadvg7sd6vsdiv67gsdvi7sdav67', 'chenry');

-- ----------------------------
-- Table structure for versions
-- ----------------------------
DROP TABLE IF EXISTS `versions`;
CREATE TABLE `versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `version` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `code` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `category` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` text,
  `sdkversion` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `downloads` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `have_data` tinyint(4) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT '1',
  `developer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of versions
-- ----------------------------

-- ----------------------------
-- View structure for sincatalogar
-- ----------------------------
DROP VIEW IF EXISTS `sincatalogar`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `sincatalogar` AS  ;

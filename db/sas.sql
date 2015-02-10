/*
Navicat MySQL Data Transfer

Source Server         : localhostXAMP
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : sas

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2014-11-21 00:42:13
*/

SET FOREIGN_KEY_CHECKS=0;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('2', 'chenry', 'b38fdeb334c833d798de409cce891288da6055ee', 'admin', '2014-11-21 04:08:29', '2014-11-21 04:08:29');

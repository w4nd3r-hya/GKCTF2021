/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2021-06-16 19:52:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for board
-- ----------------------------
DROP TABLE IF EXISTS `board`;
CREATE TABLE `board` (
  `board` varchar(2555) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of board
-- ----------------------------
INSERT INTO `board` VALUES ('{\"admin1\":{\"name\":\"Blue-Eyes White Dragon\",\"ATK\":\"3000\",\"DEF\":\"2500\",\"URL\":\"https://ftp.bmp.ovh/imgs/2021/06/f66c705bd748e034.jpg\"}}', 'admin1');
INSERT INTO `board` VALUES ('{\"admin\":{\"name\":\"Blue-Eyes White Dragon\",\"ATK\":\"3000\",\"DEF\":\"2500\",\"URL\":\"https://ftp.bmp.ovh/imgs/2021/06/f66c705bd748e034.jpg\"}}', 'admin');
INSERT INTO `board` VALUES ('{\"__proto__\":{\"name\":\"Blue-Eyes White Dragon\",\"ATK\":\"3000\",\"DEF\":\"2500\",\"URL\":\"https://ftp.bmp.ovh/imgs/2021/06/f66c705bd748e034.jpg\"}}', '__proto__');

-- ----------------------------
-- Table structure for test
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of test
-- ----------------------------
INSERT INTO `test` VALUES ('admin', 'a4a506abf4d80cd7a4ca0e7d4580fd4a');
INSERT INTO `test` VALUES ('__proto__', '123');
INSERT INTO `test` VALUES ('__proto__', '123');
INSERT INTO `test` VALUES ('admin1', '123');

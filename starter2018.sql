/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100125
 Source Host           : localhost:3306
 Source Schema         : starter2018

 Target Server Type    : MySQL
 Target Server Version : 100125
 File Encoding         : 65001

 Date: 26/03/2019 10:02:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for biodata
-- ----------------------------
DROP TABLE IF EXISTS `biodata`;
CREATE TABLE `biodata`  (
  `BiodataId` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Fullname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `TelpNo` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ProfilPict` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `login_id` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `placeofbirth` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `dateofbirth` date NULL DEFAULT NULL,
  `gender` int(4) NULL DEFAULT NULL,
  PRIMARY KEY (`BiodataId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of biodata
-- ----------------------------
INSERT INTO `biodata` VALUES ('BI001', 'Boby Kurniawan', 'Jalan swasembada', '0896889651', NULL, 'U001', 'Jakarta', '1994-10-11', 1);
INSERT INTO `biodata` VALUES ('BI005', 'Toto maryoto', 'jalan', '234234', NULL, 'U002', '', '2000-01-11', 1);

-- ----------------------------
-- Table structure for modules
-- ----------------------------
DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules`  (
  `module_id` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `module_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `module_parent` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `module_path` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `module_flag` int(4) NULL DEFAULT NULL,
  `module_type` int(4) NULL DEFAULT NULL,
  `module_icon` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`module_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of modules
-- ----------------------------
INSERT INTO `modules` VALUES ('MD001', 'Developer', '', '#', 1, 1, 'web.png');
INSERT INTO `modules` VALUES ('MD004', 'User', 'MD001', 'User/', 1, 2, 'fas fa-users-cog');
INSERT INTO `modules` VALUES ('MD005', 'Manage Module', 'MD001', 'Module/', 1, 2, 'fas  fa-file-signature');
INSERT INTO `modules` VALUES ('MD006', 'Manage Type', 'MD001', 'Usertype/', 1, 2, 'fas fa-universal-access');
INSERT INTO `modules` VALUES ('MD007', 'Transaksi Baru', 'MD002', 'Transaksi', 1, 2, 'fas fa-cash-register');
INSERT INTO `modules` VALUES ('MD008', 'Site Setting', 'MD001', 'sitesetting', 1, 2, '');

-- ----------------------------
-- Table structure for modules_access
-- ----------------------------
DROP TABLE IF EXISTS `modules_access`;
CREATE TABLE `modules_access`  (
  `access_id` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `module_id` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `usertype` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`access_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of modules_access
-- ----------------------------
INSERT INTO `modules_access` VALUES ('AC001', 'MD001', 'TP001');
INSERT INTO `modules_access` VALUES ('AC004', 'MD004', 'TP001');
INSERT INTO `modules_access` VALUES ('AC005', 'MD005', 'TP001');
INSERT INTO `modules_access` VALUES ('AC006', 'MD006', 'TP001');
INSERT INTO `modules_access` VALUES ('AC010', 'MD007', 'TP002');
INSERT INTO `modules_access` VALUES ('AC011', 'MD008', 'TP001');

-- ----------------------------
-- Table structure for sitesetting
-- ----------------------------
DROP TABLE IF EXISTS `sitesetting`;
CREATE TABLE `sitesetting`  (
  `sitesettingid` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `sitesettingname` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`sitesettingid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of sitesetting
-- ----------------------------
INSERT INTO `sitesetting` VALUES ('SET001', 'sitename', 'avcd');
INSERT INTO `sitesetting` VALUES ('SET002', 'sidebarlogo', 'instagram.png');
INSERT INTO `sitesetting` VALUES ('SET003', 'favicon', 'course.png');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `userid` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `lastlogindate` datetime(0) NULL DEFAULT NULL,
  `usertype` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_flag` int(4) NULL DEFAULT NULL,
  PRIMARY KEY (`userid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('U001', 'boby', '81DC9BDB52D04DC20036DBD8313ED055', NULL, 'TP001', 'boby12kurniawan@gmail.com', 1);
INSERT INTO `users` VALUES ('U002', 'Totos', '81DC9BDB52D04DC20036DBD8313ED055', NULL, 'TP002', 'toto@toto.com', 1);

-- ----------------------------
-- Table structure for usertypes
-- ----------------------------
DROP TABLE IF EXISTS `usertypes`;
CREATE TABLE `usertypes`  (
  `type_id` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `type_description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `flag` int(4) NULL DEFAULT NULL,
  PRIMARY KEY (`type_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of usertypes
-- ----------------------------
INSERT INTO `usertypes` VALUES ('TP001', 'Developer', 1);
INSERT INTO `usertypes` VALUES ('TP002', 'Administrator', 1);
INSERT INTO `usertypes` VALUES ('TP003', 'User', 1);

SET FOREIGN_KEY_CHECKS = 1;

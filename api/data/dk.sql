/*
 Navicat Premium Data Transfer

 Source Server         : XamppSQl
 Source Server Type    : MariaDB
 Source Server Version : 100414
 Source Host           : localhost:3306
 Source Schema         : aad

 Target Server Type    : MariaDB
 Target Server Version : 100414
 File Encoding         : 65001

 Date: 19/10/2021 15:18:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci NULL DEFAULT NULL,
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci NULL DEFAULT NULL,
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'root', '63a9f0ea7bb98050796b649e85481845', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for excle
-- ----------------------------
DROP TABLE IF EXISTS `excle`;
CREATE TABLE `excle`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '关联excel文件',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `frist_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'excle表头',
  `search_key` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '一般来说数量在2~3',
  `is_ok` int(11) NULL DEFAULT 1 COMMENT '1开放   0拒绝',
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `lv` int(11) NULL DEFAULT 0 COMMENT '优先级    推荐范围为0~99  值越大  排序就在前面',
  `xname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '项目名',
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of excle
-- ----------------------------
INSERT INTO `excle` VALUES (1, 'xixi.xlsx', '../xl/', '姓名@身份证@性别@出生日期@电话@民族@QQ@共同借款人姓名@共同借款人身份证号', '身份证', 1, 1632300018, 1633662234, 0, 'xixi', NULL);

-- ----------------------------
-- Table structure for from_key
-- ----------------------------
DROP TABLE IF EXISTS `from_key`;
CREATE TABLE `from_key`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` int(11) NULL DEFAULT 1 COMMENT '查看配置表\r\n\r\n',
  `msg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '选择，下拉时，需要填写并使用@分隔',
  `is_ok` int(255) NULL DEFAULT 0 COMMENT '是否必须   1为是',
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  `is_view` int(11) NULL DEFAULT 0 COMMENT '是否提交后显示',
  `is_se` int(11) NULL DEFAULT 0 COMMENT '是否可查',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of from_key
-- ----------------------------
INSERT INTO `from_key` VALUES (1, 'A', '性别', 1, '男@女', 1, 1634026423, 1634026423, NULL, 0, 1);
INSERT INTO `from_key` VALUES (2, 'B', '身份证号', 0, '', 1, 1634026423, 1634026423, NULL, 1, 1);
INSERT INTO `from_key` VALUES (3, 'C', '电话号码', 0, '', 0, 1634026423, 1634026423, NULL, 1, 0);

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `json` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `time` int(11) NULL DEFAULT NULL COMMENT '存某时间段结尾代表预约该段时间',
  `key1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `key2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `key3` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  `is_ok` int(255) NULL DEFAULT 1 COMMENT '1代表预约成功，0代表完成本次预约，被软删除代表取消本次预约，被软删除后的在进行时间更新时也会被置0',
  `is_new` int(11) NULL DEFAULT 1 COMMENT '为1代表为最新数据，为0代表是更新字段后的数据',
  `info` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES (1, '{\"A\":\"男\",\"B\":\"123123\",\"C\":\"12312\"}', 1634270400, '男', '123123', NULL, 1634180441, 1634180441, NULL, 1, 1, '{\"性别\":\"男\",\"身份证号\":\"123123\",\"电话号码\":\"12312\"}');
INSERT INTO `order` VALUES (2, '{\"A\":\"男\",\"B\":\"21321\",\"C\":\"213123\"}', 1634788800, '男', '21321', NULL, 1634180449, 1634180449, NULL, 1, 1, '{\"性别\":\"男\",\"身份证号\":\"21321\",\"电话号码\":\"213123\"}');
INSERT INTO `order` VALUES (3, '{\"A\":\"男\",\"B\":\"522\",\"C\":\"123\"}', 1634529600, '男', '522', NULL, 1634180459, 1634180459, NULL, 1, 1, '{\"性别\":\"男\",\"身份证号\":\"522\",\"电话号码\":\"123\"}');
INSERT INTO `order` VALUES (4, '{\"A\":\"男\",\"B\":\"5223\",\"C\":\"123\"}', 1634788800, '男', '5223', NULL, 1634180473, 1634180473, NULL, 1, 1, '{\"性别\":\"男\",\"身份证号\":\"5223\",\"电话号码\":\"123\"}');

-- ----------------------------
-- Table structure for sys_config
-- ----------------------------
DROP TABLE IF EXISTS `sys_config`;
CREATE TABLE `sys_config`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `create_time` int(11) NULL DEFAULT NULL,
  `type` int(11) NULL DEFAULT NULL COMMENT '-1为弃用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_config
-- ----------------------------
INSERT INTO `sys_config` VALUES (1, 'hello', '欢迎来到预约系统，需要取消预约请查询到结果之后取消该次预约', '欢迎字符串', 1634181097, NULL, 1);
INSERT INTO `sys_config` VALUES (2, 'order_success', '恭喜您预约成功，请在您预约的时间内到达我们的服务场所。', '成功字符串', 1634181097, NULL, 1);
INSERT INTO `sys_config` VALUES (3, 'order_top', '请选择需要查询的项目', '预约字符串', 1634181097, NULL, 1);
INSERT INTO `sys_config` VALUES (4, 'order_early_day', '5', '可提前预约天数 (防止太早预约）', NULL, NULL, 2);
INSERT INTO `sys_config` VALUES (5, 'order_day', '7', '预约显示天数', NULL, NULL, 2);
INSERT INTO `sys_config` VALUES (6, 'order_time_num', '3', '预约时段数量', 1634094870, NULL, 2);
INSERT INTO `sys_config` VALUES (7, 'order_timef', '8:00@12:00@13:00@17:00@18:00@19:00', '预约时间段第一个和第二个  第三个和第四个如此类推', 1632790776, NULL, 2);
INSERT INTO `sys_config` VALUES (8, 'limit', '50@50@0', '预约人数限制', 1632815640, NULL, 2);
INSERT INTO `sys_config` VALUES (9, 'key1', 'A', '查询关键词1所在列下面同', 1631158062, NULL, -1);
INSERT INTO `sys_config` VALUES (10, 'key2', 'B', '查询关键词2', NULL, NULL, -1);
INSERT INTO `sys_config` VALUES (11, 'key3', 'C', '查询关键词3', NULL, NULL, -1);
INSERT INTO `sys_config` VALUES (12, 'key', '2', '预约数据库查询使用关键词数量', NULL, NULL, -1);
INSERT INTO `sys_config` VALUES (13, 'order_ok', '0', '预约是否开放 0为开放', 1634009398, NULL, 1);
INSERT INTO `sys_config` VALUES (14, 'title', 'Sheet1', '生成文件sheet的标题', NULL, NULL, 0);
INSERT INTO `sys_config` VALUES (15, 'type0', '0', '代表输入框', NULL, NULL, 0);
INSERT INTO `sys_config` VALUES (16, 'type1', '1', '单选', NULL, NULL, 0);
INSERT INTO `sys_config` VALUES (17, 'type2', '2', '多选', NULL, NULL, 0);
INSERT INTO `sys_config` VALUES (18, 'type3', '3', '下拉', NULL, NULL, 0);
INSERT INTO `sys_config` VALUES (19, 'type4', '4', '时间选择器', NULL, NULL, 0);
INSERT INTO `sys_config` VALUES (20, 'type5', '5', '', NULL, NULL, 0);
INSERT INTO `sys_config` VALUES (21, 'order_long', '7', '预约间隔 2次有效预约期间的间隔', NULL, NULL, 2);
INSERT INTO `sys_config` VALUES (22, 'order_open', '1-1@12-31', '预约开放日期', 1633658456, NULL, 2);
INSERT INTO `sys_config` VALUES (23, 'order_skip', '6,7', '预约忽略', 1632725380, NULL, 2);

SET FOREIGN_KEY_CHECKS = 1;

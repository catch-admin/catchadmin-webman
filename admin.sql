/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : tp_admin

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 27/03/2024 13:22:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '昵称',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮箱',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `remember_token` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '登录令牌',
  `department_id` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '部门ID',
  `creator_id` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建人ID',
  `status` tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态:1正常 2禁用',
  `login_ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '登录IP',
  `login_at` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录时间',
  `created_at` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `deleted_at` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_has_jobs
-- ----------------------------
DROP TABLE IF EXISTS `admin_has_jobs`;
CREATE TABLE `admin_has_jobs`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` int UNSIGNED NULL DEFAULT 0 COMMENT '用户ID',
  `job_id` int UNSIGNED NULL DEFAULT 0 COMMENT '岗位ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '管理员岗位关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_has_roles`;
CREATE TABLE `admin_has_roles`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` int UNSIGNED NULL DEFAULT 0 COMMENT '用户ID',
  `role_id` int UNSIGNED NULL DEFAULT 0 COMMENT '角色ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '管理员角色关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for departments
-- ----------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `department_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '部门名称',
  `parent_id` int UNSIGNED NULL DEFAULT 0 COMMENT '父级ID',
  `principal` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '负责人',
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '联系电话',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '联系又想',
  `creator_id` int NULL DEFAULT 0 COMMENT '创建人ID',
  `status` tinyint NULL DEFAULT 1 COMMENT '1 正常 2 停用',
  `sort` int NULL DEFAULT 0 COMMENT '排序字段',
  `created_at` int UNSIGNED NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int UNSIGNED NULL DEFAULT 0 COMMENT '更新时间',
  `deleted_at` int UNSIGNED NULL DEFAULT 0 COMMENT '删除状态，null 未删除 timestamp 已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '岗位表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '岗位名称',
  `coding` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '编码',
  `creator_id` int NULL DEFAULT 0 COMMENT '创建人ID',
  `status` tinyint NULL DEFAULT 1 COMMENT '1 正常 2 停用',
  `sort` int NULL DEFAULT 0 COMMENT '排序字段',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '描述',
  `created_at` int UNSIGNED NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int UNSIGNED NULL DEFAULT 0 COMMENT '更新时间',
  `deleted_at` int UNSIGNED NULL DEFAULT 0 COMMENT '删除状态，null 未删除 timestamp 已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '岗位表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for log_login
-- ----------------------------
DROP TABLE IF EXISTS `log_login`;
CREATE TABLE `log_login`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `account` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '账号',
  `login_ip` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '登录IP',
  `browser` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '浏览器',
  `platform` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '平台',
  `login_at` int NULL DEFAULT 0 COMMENT '登录时间',
  `status` tinyint NULL DEFAULT 1 COMMENT '1 正常 2 停用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 68 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '登录日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for log_operate
-- ----------------------------
DROP TABLE IF EXISTS `log_operate`;
CREATE TABLE `log_operate`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `module` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '模块',
  `action` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '操作',
  `params` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '参数',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT 'IP',
  `http_method` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '请求方式',
  `http_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT 'http status code',
  `start_at` int NULL DEFAULT 0 COMMENT '开始时间',
  `time_token` int NULL DEFAULT 0 COMMENT '耗时',
  `creator_id` int NULL DEFAULT 0 COMMENT '创建人',
  `created_at` int NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 110 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '操作日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '菜单名称',
  `parent_id` int UNSIGNED NULL DEFAULT 0 COMMENT '父级ID',
  `route` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '路由',
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '菜单图标',
  `module` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '模块',
  `permission_mark` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '权限标识',
  `type` tinyint NULL DEFAULT 1 COMMENT '1 菜单 2 按钮',
  `active_menu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '权限标识',
  `component` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '组件名称',
  `redirect` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '跳转地址',
  `hidden` tinyint NULL DEFAULT 1 COMMENT '1 显示 2隐藏',
  `keepalive` tinyint NULL DEFAULT 1 COMMENT '1 缓存 2 不存在 ',
  `creator_id` int NULL DEFAULT 0 COMMENT '创建人ID',
  `sort` int NULL DEFAULT 0 COMMENT '排序字段',
  `created_at` int UNSIGNED NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int UNSIGNED NULL DEFAULT 0 COMMENT '更新时间',
  `deleted_at` int UNSIGNED NULL DEFAULT 0 COMMENT '删除状态，null 未删除 timestamp 已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for role_has_departments
-- ----------------------------
DROP TABLE IF EXISTS `role_has_departments`;
CREATE TABLE `role_has_departments`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int UNSIGNED NULL DEFAULT 0 COMMENT '用户ID',
  `department_id` int UNSIGNED NULL DEFAULT 0 COMMENT '部门ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '角色部门关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int UNSIGNED NULL DEFAULT 0 COMMENT '角色ID',
  `permission_id` int UNSIGNED NULL DEFAULT 0 COMMENT '权限ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 345 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '角色权限关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '角色名',
  `identify` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '角色标识',
  `parent_id` int UNSIGNED NULL DEFAULT 0 COMMENT '父级ID',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '角色备注',
  `data_range` tinyint NULL DEFAULT 0 COMMENT '1 全部数据 2 自定义数据 3 仅本人数据 4 部门数据 5 部门及以下数据',
  `creator_id` int NULL DEFAULT 0 COMMENT '创建人ID',
  `created_at` int UNSIGNED NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int UNSIGNED NULL DEFAULT 0 COMMENT '更新时间',
  `deleted_at` int UNSIGNED NULL DEFAULT 0 COMMENT '删除状态，0未删除 >0 已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `admin` VALUES (1, 'admin', '$2y$10$0EUjMJbweFHKSJyv1u0vvu4gq.QPLf88f9edGvlINb6ojGpxkz0G2', 'catch@admin.com', '', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MTE1MTE1NDMsImV4cCI6MTcxMTU5Nzk0MywibmJmIjoxNzExNTExNTQzLCJ1aWQiOjEsImVtYWlsIjoiY2F0Y2hAYWRtaW4uY29tIn0.cA-6ycBoPfVTrLLwQf0jot56_qMxkAM21xQ4WoGnLPQ', 0, 1, 1, '', 0, 1711272664, 1711511543, 0);

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, '权限管理', 0, '/permission', 'arrow-down-on-square-stack', 'permissions', '', 1, '', '/layout/index.vue', NULL, 1, 1, 0, 1, 1670579928, 1711444174, 0);
INSERT INTO `permissions` VALUES (2, '角色管理', 1, 'roles', 'arrow-left-circle', 'permissions', 'Roles', 2, '', '/permissions/roles/index.vue', '', 1, 1, 1, 6, 1670579968, 1711445598, 0);
INSERT INTO `permissions` VALUES (3, '列表', 2, '', '', 'permissions', 'Roles@index', 3, '', '', '', 1, 1, 1, 1, 1671526858, 1708264137, 0);
INSERT INTO `permissions` VALUES (4, '新增', 2, '', '', 'permissions', 'Roles@store', 3, '', '', '', 1, 1, 1, 2, 1671526858, 1708264137, 0);
INSERT INTO `permissions` VALUES (5, '读取', 2, '', '', 'permissions', 'Roles@show', 3, '', '', '', 1, 1, 1, 3, 1671526858, 1711445604, 0);
INSERT INTO `permissions` VALUES (6, '更新', 2, '', '', 'permissions', 'Roles@update', 3, '', '', '', 1, 1, 1, 4, 1671526858, 1708264137, 0);
INSERT INTO `permissions` VALUES (7, '删除', 2, '', '', 'permissions', 'Roles@destroy', 3, '', '', '', 1, 1, 1, 5, 1671526858, 1708264137, 0);
INSERT INTO `permissions` VALUES (8, '菜单管理', 1, 'permissions', 'finger-print', 'permissions', 'Permissions', 2, '', '/permissions/permissions/index.vue', NULL, 1, 1, 0, 1, 1670641371, 1708264137, 0);
INSERT INTO `permissions` VALUES (9, '列表', 8, '', '', 'permissions', 'Permissions@index', 3, '', '', '', 1, 1, 1, 1, 1671524755, 1708264137, 0);
INSERT INTO `permissions` VALUES (10, '新增', 8, '', '', 'permissions', 'Permissions@store', 3, '', '', '', 1, 1, 1, 2, 1671524755, 1708264137, 0);
INSERT INTO `permissions` VALUES (11, '读取', 8, '', '', 'permissions', 'Permissions@show', 3, '', '', '', 1, 1, 1, 3, 1671524755, 1708264137, 0);
INSERT INTO `permissions` VALUES (12, '更新', 8, '', '', 'permissions', 'Permissions@update', 3, '', '', '', 1, 1, 1, 4, 1671524756, 1708264137, 0);
INSERT INTO `permissions` VALUES (13, '删除', 8, '', '', 'permissions', 'Permissions@destroy', 3, '', '', '', 1, 1, 1, 5, 1671524756, 1708264137, 0);
INSERT INTO `permissions` VALUES (14, '禁用/启用', 8, '', '', 'permissions', 'Permissions@enable', 3, '', '', '', 1, 1, 1, 6, 1671524756, 1708264137, 0);
INSERT INTO `permissions` VALUES (15, '岗位管理', 1, 'jobs', 'globe-americas', 'permissions', 'Jobs', 2, '', '/permissions/jobs/index.vue', NULL, 1, 1, 0, 1, 1670641399, 1708264137, 0);
INSERT INTO `permissions` VALUES (16, '列表', 15, '', '', 'permissions', 'Jobs@index', 3, '', '', '', 1, 1, 1, 1, 1671524747, 1708264137, 0);
INSERT INTO `permissions` VALUES (17, '新增', 15, '', '', 'permissions', 'Jobs@store', 3, '', '', '', 1, 1, 1, 2, 1671524747, 1708264137, 0);
INSERT INTO `permissions` VALUES (18, '读取', 15, '', '', 'permissions', 'Jobs@show', 3, '', '', '', 1, 1, 1, 3, 1671524747, 1708264137, 0);
INSERT INTO `permissions` VALUES (19, '更新', 15, '', '', 'permissions', 'Jobs@update', 3, '', '', '', 1, 1, 1, 4, 1671524747, 1708264137, 0);
INSERT INTO `permissions` VALUES (20, '删除', 15, '', '', 'permissions', 'Jobs@destroy', 3, '', '', '', 1, 1, 1, 5, 1671524747, 1708264137, 0);
INSERT INTO `permissions` VALUES (21, '禁用/启用', 15, '', '', 'permissions', 'Jobs@enable', 3, '', '', '', 1, 1, 1, 6, 1671524747, 1708264137, 0);
INSERT INTO `permissions` VALUES (22, '部门管理', 1, 'departments', 'table-cells', 'permissions', 'Departments', 2, '', '/permissions/departments/index.vue', NULL, 1, 1, 0, 1, 1670641426, 1708264137, 0);
INSERT INTO `permissions` VALUES (23, '列表', 22, '', '', 'permissions', 'Departments@index', 3, '', '', '', 1, 1, 1, 1, 1671501850, 1708264137, 0);
INSERT INTO `permissions` VALUES (24, '新增', 22, '', '', 'permissions', 'Departments@store', 3, '', '', '', 1, 1, 1, 1, 1671501861, 1708264137, 0);
INSERT INTO `permissions` VALUES (25, '读取', 22, '', '', 'permissions', 'Departments@show', 3, '', '', '', 1, 1, 1, 1, 1671501872, 1708264137, 0);
INSERT INTO `permissions` VALUES (26, '更新', 22, '', '', 'permissions', 'Departments@update', 3, '', '', '', 1, 1, 1, 1, 1671517311, 1708264137, 0);
INSERT INTO `permissions` VALUES (27, '删除', 22, '', '', 'permissions', 'Departments@destroy', 3, '', '', '', 1, 1, 1, 1, 1671517324, 1708264137, 0);
INSERT INTO `permissions` VALUES (28, '禁用/启用', 22, '', '', 'permissions', 'Departments@enable', 3, '', '', '', 1, 1, 1, 6, 1671524493, 1708264137, 0);
INSERT INTO `permissions` VALUES (29, '用户管理', 1, 'user', 'users', 'permissions', 'user', 2, '', '/user/index.vue', NULL, 1, 1, 1, 1, 1709342019, 1711437783, 0);
INSERT INTO `permissions` VALUES (30, '列表', 29, '', '', 'permissions', 'user@index', 3, '', '', '', 1, 1, 1, 1, 1709373354, 1709373354, 0);
INSERT INTO `permissions` VALUES (31, '新增', 29, '', '', 'permissions', 'user@store', 3, '', '', '', 1, 1, 1, 2, 1709373354, 1709373354, 0);
INSERT INTO `permissions` VALUES (32, '读取', 29, '', '', 'permissions', 'user@show', 3, '', '', '', 1, 1, 1, 3, 1709373354, 1709373354, 0);
INSERT INTO `permissions` VALUES (33, '更新', 29, '', '', 'permissions', 'user@update', 3, '', '', '', 1, 1, 1, 4, 1709373354, 1709373354, 0);
INSERT INTO `permissions` VALUES (34, '删除', 29, '', '', 'permissions', 'user@destroy', 3, '', '', '', 1, 1, 1, 5, 1709373354, 1709373354, 0);
INSERT INTO `permissions` VALUES (35, '禁用/启用', 29, '', '', 'permissions', 'user@enable', 3, '', '', '', 1, 1, 1, 6, 1709373354, 1709373354, 0);
INSERT INTO `permissions` VALUES (36, '导出', 29, '', '', 'permissions', 'user@export', 3, '', '', '', 1, 1, 1, 10, 1709373354, 1711432904, 1711432904);

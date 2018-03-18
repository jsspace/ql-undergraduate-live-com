-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 60.205.214.51:3306
-- Generation Time: 2017-11-04 05:36:39
-- 服务器版本： 5.6.35
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kaoben`
--

-- --------------------------------------------------------

--
-- 表的结构 `tbl_advertorial`
--

CREATE TABLE `tbl_advertorial` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '软文题目',
  `type` tinyint(1) NOT NULL COMMENT '软文类别，外链or内部软文',
  `pic` varchar(255) NOT NULL COMMENT '软文的开头图片',
  `content` text COMMENT '软文内容编辑',
  `src` varchar(255) DEFAULT NULL COMMENT '外链链接地址',
  `create_time` int(11) DEFAULT NULL COMMENT '软文创建时间',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '软文已阅读的人的数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_auth_assignment`
--

CREATE TABLE `tbl_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `tbl_auth_assignment`
--

INSERT INTO `tbl_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1503807889),
('head_teacher', '2', 1503821012),
('head_teacher', '3', 1503821097),
('marketer', '13', NULL),
('marketer', '14', NULL),
('marketer', '3', 1503834544),
('marketer', '9', NULL),
('student', '2', 1506148461),
('student', '3', 1503835388),
('teacher', '3', 1503828168);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_auth_item`
--

CREATE TABLE `tbl_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `tbl_auth_item`
--

INSERT INTO `tbl_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/assignment/*', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/assignment/assign', 2, NULL, NULL, NULL, 1500195362, 1500195362),
('/admin/assignment/index', 2, NULL, NULL, NULL, 1500195258, 1500195258),
('/admin/assignment/revoke', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/assignment/view', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/default/*', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/default/index', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/menu/*', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/menu/create', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/menu/delete', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/menu/index', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/menu/update', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/menu/view', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/permission/*', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/permission/assign', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/permission/create', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/permission/delete', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/permission/index', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/permission/remove', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/permission/update', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/permission/view', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/role/*', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/role/assign', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/role/create', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/role/delete', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/role/index', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/role/remove', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/role/update', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/role/view', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/route/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/route/assign', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/route/create', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/route/index', 2, NULL, NULL, NULL, 1503826172, 1503826172),
('/admin/route/refresh', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/route/remove', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/rule/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/rule/create', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/rule/delete', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/rule/index', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/rule/update', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/rule/view', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/user/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/user/activate', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/user/change-password', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/user/delete', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/user/index', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/user/login', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/user/logout', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/user/request-password-reset', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/user/reset-password', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/user/signup', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/admin/user/view', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/cart/*', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/cart/create', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/cart/delete', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/cart/index', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/cart/update', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/cart/view', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/coupon/*', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/coupon/create', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/coupon/delete', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/coupon/index', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/coupon/update', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/coupon/view', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-category/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-category/create', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-category/delete', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-category/index', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-category/update', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-category/view', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-chapter/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-chapter/create', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-chapter/delete', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-chapter/index', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-chapter/update', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-chapter/view', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-coment/*', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-coment/create', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-coment/delete', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-coment/index', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-coment/update', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-coment/view', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-news/*', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-news/create', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-news/delete', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-news/index', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-news/update', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-news/view', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-package-category/*', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package-category/create', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package-category/delete', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package-category/index', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package-category/update', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package-category/view', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package/*', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package/create', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package/delete', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package/getcategory', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package/getcourse', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/course-package/index', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package/update', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package/uploadimg', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-package/view', 2, NULL, NULL, NULL, 1503830084, 1503830084),
('/course-section/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-section/create', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-section/delete', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-section/index', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-section/update', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course-section/view', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/course/*', 2, NULL, NULL, NULL, 1503809390, 1503809390),
('/course/create', 2, NULL, NULL, NULL, 1503809390, 1503809390),
('/course/delete', 2, NULL, NULL, NULL, 1503809390, 1503809390),
('/course/getcategory', 2, NULL, NULL, NULL, 1503809390, 1503809390),
('/course/index', 2, NULL, NULL, NULL, 1503809390, 1503809390),
('/course/update', 2, NULL, NULL, NULL, 1503809390, 1503809390),
('/course/uploadimg', 2, NULL, NULL, NULL, 1503809390, 1503809390),
('/course/view', 2, NULL, NULL, NULL, 1503809390, 1503809390),
('/data/*', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/data/create', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/data/delete', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/data/index', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/data/update', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/data/view', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/debug/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/debug/default/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/debug/default/db-explain', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/debug/default/download-mail', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/debug/default/index', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/debug/default/toolbar', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/debug/default/view', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/friendly-links/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/friendly-links/create', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/friendly-links/delete', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/friendly-links/index', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/friendly-links/update', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/friendly-links/view', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/gii/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/gii/default/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/gii/default/action', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/gii/default/diff', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/gii/default/index', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/gii/default/preview', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/gii/default/view', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/head-teacher/*', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/head-teacher/create', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/head-teacher/delete', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/head-teacher/index', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/head-teacher/update', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/head-teacher/view', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/hot-category/*', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/hot-category/create', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/hot-category/delete', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/hot-category/index', 2, NULL, NULL, NULL, 1504654756, 1504654756),
('/hot-category/update', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/hot-category/view', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/market/*', 2, NULL, NULL, NULL, 1503830863, 1503830863),
('/market/create', 2, NULL, NULL, NULL, 1503830863, 1503830863),
('/market/delete', 2, NULL, NULL, NULL, 1503830863, 1503830863),
('/market/index', 2, NULL, NULL, NULL, 1503830863, 1503830863),
('/market/order', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/market/qrcode', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/market/update', 2, NULL, NULL, NULL, 1503830863, 1503830863),
('/market/view', 2, NULL, NULL, NULL, 1503830863, 1503830863),
('/order-goods/*', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/order-goods/create', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/order-goods/delete', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/order-goods/index', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/order-goods/update', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/order-goods/view', 2, NULL, NULL, NULL, 1508643863, 1508643863),
('/order-info/*', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/order-info/create', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/order-info/delete', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/order-info/index', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/order-info/update', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/order-info/view', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/site/*', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/site/error', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/site/index', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/site/login', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/site/logout', 2, NULL, NULL, NULL, 1503826173, 1503826173),
('/teacher/*', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/teacher/create', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/teacher/delete', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/teacher/index', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/teacher/update', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/teacher/view', 2, NULL, NULL, NULL, 1503831048, 1503831048),
('/user/*', 2, NULL, NULL, NULL, 1503807538, 1503807538),
('/user/create', 2, NULL, NULL, NULL, 1503807538, 1503807538),
('/user/delete', 2, NULL, NULL, NULL, 1503807538, 1503807538),
('/user/index', 2, NULL, NULL, NULL, 1503807538, 1503807538),
('/user/update', 2, NULL, NULL, NULL, 1503807538, 1503807538),
('/user/view', 2, NULL, NULL, NULL, 1503807538, 1503807538),
('/withdraw/*', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/withdraw/create', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/withdraw/delete', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/withdraw/index', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/withdraw/update', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('/withdraw/view', 2, NULL, NULL, NULL, 1506153775, 1506153775),
('admin', 1, '管理员后台', NULL, NULL, 1503807804, 1503811972),
('Course修改权限', 2, NULL, NULL, NULL, 1503809425, 1503809425),
('Course删除权限', 2, NULL, NULL, NULL, 1503809507, 1503809507),
('Course查看详细信息权限', 2, NULL, NULL, NULL, 1503809569, 1503809569),
('Course添加权限', 2, NULL, NULL, NULL, 1503809455, 1503809455),
('Course首页访问权限', 2, NULL, NULL, NULL, 1503809666, 1503809666),
('guest', 1, '游客', NULL, NULL, 1503810052, 1503815609),
('head_teacher', 1, '班主任', NULL, NULL, 1503815518, 1503815518),
('marketer', 1, '市场专员', NULL, NULL, 1503815544, 1503815544),
('student', 1, '学员', NULL, NULL, 1503815562, 1503815562),
('teacher', 1, '教师', NULL, NULL, 1503815487, 1503815487),
('User修改权限', 2, NULL, NULL, NULL, 1503807666, 1503807754),
('User删除权限', 2, NULL, NULL, NULL, 1503808138, 1503808138),
('User查看详细信息权限', 2, NULL, NULL, NULL, 1503808332, 1503808332),
('User添加权限', 2, NULL, NULL, NULL, 1503808266, 1503808266),
('User首页访问权限', 2, NULL, NULL, NULL, 1503808302, 1503829592),
('分配', 2, '分配', NULL, NULL, 1503829520, 1503829520),
('分配查看', 2, '分配查看', NULL, NULL, 1503829320, 1503829320),
('分配移除', 2, '分配移除', NULL, NULL, 1503829406, 1503829406),
('分配首页', 2, '分配首页', NULL, NULL, 1503828876, 1503829487),
('市场专员修改', 2, '市场专员修改', NULL, NULL, 1503831556, 1503831556),
('市场专员删除', 2, '市场专员删除', NULL, NULL, 1503831625, 1503831625),
('市场专员查看', 2, '市场专员查看', NULL, NULL, 1503831666, 1503831666),
('市场专员添加', 2, '市场专员添加', NULL, NULL, 1503831507, 1503831507),
('市场专员首页', 2, '市场专员首页', NULL, NULL, 1503831425, 1503831425),
('提现历史', 2, '提现历史首页', NULL, NULL, 1506154414, 1506154580),
('提现历史修改', 2, NULL, NULL, NULL, 1506154508, 1506154508),
('提现历史创建', 2, NULL, NULL, NULL, 1506154478, 1506154478),
('提现历史删除', 2, NULL, NULL, NULL, 1506154530, 1506154530),
('权限分配', 2, '权限分配', NULL, NULL, 1503830057, 1503830057),
('权限创建', 2, '权限创建', NULL, NULL, 1503830085, 1503830085),
('权限删除', 2, '权限删除', NULL, NULL, 1503830120, 1503830120),
('权限更新', 2, '权限更新', NULL, NULL, 1503830255, 1503830255),
('权限查看', 2, '权限查看', NULL, NULL, 1503830303, 1503830303),
('权限移除', 2, '权限移除', NULL, NULL, 1503830226, 1503830226),
('权限首页', 2, '权限首页', NULL, NULL, 1503830144, 1503830144),
('菜单创建', 2, '菜单创建', NULL, NULL, 1503829813, 1503829813),
('菜单删除', 2, '菜单删除', NULL, NULL, 1503829853, 1503829853),
('菜单更新', 2, '菜单更新', NULL, NULL, 1503829881, 1503829881),
('菜单查看', 2, '菜单查看', NULL, NULL, 1503829955, 1503829955),
('菜单首页', 2, '菜单首页', NULL, NULL, 1503829929, 1503829929),
('规则创建', 2, '规则创建', NULL, NULL, 1503830748, 1503830748),
('规则删除', 2, '规则删除', NULL, NULL, 1503830775, 1503830775),
('规则更新', 2, '规则更新', NULL, NULL, 1503830821, 1503830821),
('规则查看', 2, '规则查看', NULL, NULL, 1503830842, 1503830842),
('规则首页', 2, '规则首页', NULL, NULL, 1503830798, 1503830798),
('角色修改', 2, '角色修改', NULL, NULL, 1503827862, 1503827862),
('角色分配', 2, '给用户分配角色', NULL, NULL, 1503828291, 1503828291),
('角色列表', 2, '角色列表', NULL, NULL, 1503827572, 1503827572),
('角色删除', 2, '角色删除', NULL, NULL, 1503827665, 1503827665),
('角色查看', 2, '角色查看', NULL, NULL, 1503830452, 1503830452),
('角色添加', 2, '角色添加', NULL, NULL, 1503827641, 1503827641),
('角色移除', 2, '将分配给用户的某个权限移除', NULL, NULL, 1503828236, 1503828236),
('课程种类创建', 2, '课程种类创建', NULL, NULL, 1503831799, 1503831823),
('路由分配', 2, '路由分配', NULL, NULL, 1503830525, 1503830525),
('路由创建', 2, '路由创建', NULL, NULL, 1503830607, 1503830607),
('路由更新', 2, '路由更新', NULL, NULL, 1503830670, 1503830670),
('路由移除', 2, '路由移除', NULL, NULL, 1503830700, 1503830700),
('路由首页', 2, '路由首页', NULL, NULL, 1503830640, 1503830640);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_auth_item_child`
--

CREATE TABLE `tbl_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `tbl_auth_item_child`
--

INSERT INTO `tbl_auth_item_child` (`parent`, `child`) VALUES
('admin', '/*'),
('admin', '/admin/*'),
('admin', '/admin/assignment/*'),
('分配首页', '/admin/assignment/*'),
('admin', '/admin/assignment/assign'),
('分配', '/admin/assignment/assign'),
('admin', '/admin/assignment/index'),
('分配首页', '/admin/assignment/index'),
('admin', '/admin/assignment/revoke'),
('分配移除', '/admin/assignment/revoke'),
('admin', '/admin/assignment/view'),
('分配查看', '/admin/assignment/view'),
('admin', '/admin/default/*'),
('admin', '/admin/default/index'),
('admin', '/admin/menu/*'),
('admin', '/admin/menu/create'),
('菜单创建', '/admin/menu/create'),
('admin', '/admin/menu/delete'),
('菜单删除', '/admin/menu/delete'),
('admin', '/admin/menu/index'),
('菜单首页', '/admin/menu/index'),
('admin', '/admin/menu/update'),
('菜单更新', '/admin/menu/update'),
('admin', '/admin/menu/view'),
('菜单查看', '/admin/menu/view'),
('admin', '/admin/permission/*'),
('admin', '/admin/permission/assign'),
('权限分配', '/admin/permission/assign'),
('admin', '/admin/permission/create'),
('权限创建', '/admin/permission/create'),
('admin', '/admin/permission/delete'),
('权限删除', '/admin/permission/delete'),
('admin', '/admin/permission/index'),
('权限首页', '/admin/permission/index'),
('admin', '/admin/permission/remove'),
('权限移除', '/admin/permission/remove'),
('admin', '/admin/permission/update'),
('权限更新', '/admin/permission/update'),
('admin', '/admin/permission/view'),
('权限查看', '/admin/permission/view'),
('admin', '/admin/role/*'),
('admin', '/admin/role/assign'),
('admin', '/admin/role/create'),
('角色添加', '/admin/role/create'),
('admin', '/admin/role/delete'),
('角色删除', '/admin/role/delete'),
('admin', '/admin/role/index'),
('角色列表', '/admin/role/index'),
('admin', '/admin/role/remove'),
('角色移除', '/admin/role/remove'),
('admin', '/admin/role/update'),
('admin', '/admin/role/view'),
('角色查看', '/admin/role/view'),
('admin', '/admin/route/*'),
('admin', '/admin/route/assign'),
('路由分配', '/admin/route/assign'),
('admin', '/admin/route/create'),
('路由创建', '/admin/route/create'),
('admin', '/admin/route/index'),
('路由首页', '/admin/route/index'),
('admin', '/admin/route/refresh'),
('路由更新', '/admin/route/refresh'),
('admin', '/admin/route/remove'),
('路由移除', '/admin/route/remove'),
('admin', '/admin/rule/*'),
('admin', '/admin/rule/create'),
('规则创建', '/admin/rule/create'),
('admin', '/admin/rule/delete'),
('规则删除', '/admin/rule/delete'),
('admin', '/admin/rule/index'),
('规则首页', '/admin/rule/index'),
('admin', '/admin/rule/update'),
('规则更新', '/admin/rule/update'),
('admin', '/admin/rule/view'),
('规则查看', '/admin/rule/view'),
('admin', '/admin/user/*'),
('admin', '/admin/user/activate'),
('admin', '/admin/user/change-password'),
('admin', '/admin/user/delete'),
('admin', '/admin/user/index'),
('admin', '/admin/user/login'),
('admin', '/admin/user/logout'),
('admin', '/admin/user/request-password-reset'),
('admin', '/admin/user/reset-password'),
('admin', '/admin/user/signup'),
('admin', '/admin/user/view'),
('admin', '/cart/*'),
('admin', '/cart/create'),
('admin', '/cart/delete'),
('admin', '/cart/index'),
('admin', '/cart/update'),
('admin', '/cart/view'),
('admin', '/coupon/*'),
('admin', '/coupon/create'),
('admin', '/coupon/delete'),
('admin', '/coupon/index'),
('admin', '/coupon/update'),
('admin', '/coupon/view'),
('admin', '/course-category/*'),
('admin', '/course-category/create'),
('课程种类创建', '/course-category/create'),
('admin', '/course-category/delete'),
('admin', '/course-category/index'),
('admin', '/course-category/update'),
('admin', '/course-category/view'),
('admin', '/course-chapter/*'),
('admin', '/course-chapter/create'),
('admin', '/course-chapter/delete'),
('admin', '/course-chapter/index'),
('admin', '/course-chapter/update'),
('admin', '/course-chapter/view'),
('admin', '/course-coment/*'),
('admin', '/course-coment/create'),
('admin', '/course-coment/delete'),
('admin', '/course-coment/index'),
('admin', '/course-coment/update'),
('admin', '/course-coment/view'),
('admin', '/course-news/*'),
('admin', '/course-news/create'),
('admin', '/course-news/delete'),
('admin', '/course-news/index'),
('admin', '/course-news/update'),
('admin', '/course-news/view'),
('admin', '/course-package-category/*'),
('admin', '/course-package-category/create'),
('admin', '/course-package-category/delete'),
('admin', '/course-package-category/index'),
('admin', '/course-package-category/update'),
('admin', '/course-package-category/view'),
('admin', '/course-package/*'),
('admin', '/course-package/create'),
('admin', '/course-package/delete'),
('admin', '/course-package/getcategory'),
('admin', '/course-package/getcourse'),
('admin', '/course-package/index'),
('admin', '/course-package/update'),
('admin', '/course-package/uploadimg'),
('admin', '/course-package/view'),
('admin', '/course-section/*'),
('admin', '/course-section/create'),
('admin', '/course-section/delete'),
('admin', '/course-section/index'),
('admin', '/course-section/update'),
('admin', '/course-section/view'),
('admin', '/course/*'),
('Course首页访问权限', '/course/*'),
('admin', '/course/create'),
('Course添加权限', '/course/create'),
('admin', '/course/delete'),
('Course删除权限', '/course/delete'),
('admin', '/course/getcategory'),
('admin', '/course/index'),
('Course首页访问权限', '/course/index'),
('admin', '/course/update'),
('Course修改权限', '/course/update'),
('admin', '/course/uploadimg'),
('admin', '/course/view'),
('Course查看详细信息权限', '/course/view'),
('admin', '/data/*'),
('admin', '/data/create'),
('admin', '/data/delete'),
('admin', '/data/index'),
('admin', '/data/update'),
('admin', '/data/view'),
('admin', '/debug/*'),
('admin', '/debug/default/*'),
('admin', '/debug/default/db-explain'),
('admin', '/debug/default/download-mail'),
('admin', '/debug/default/index'),
('admin', '/debug/default/toolbar'),
('admin', '/debug/default/view'),
('admin', '/friendly-links/*'),
('admin', '/friendly-links/create'),
('admin', '/friendly-links/delete'),
('admin', '/friendly-links/index'),
('admin', '/friendly-links/update'),
('admin', '/friendly-links/view'),
('admin', '/gii/*'),
('admin', '/gii/default/*'),
('admin', '/gii/default/action'),
('admin', '/gii/default/diff'),
('admin', '/gii/default/index'),
('admin', '/gii/default/preview'),
('admin', '/gii/default/view'),
('admin', '/head-teacher/*'),
('admin', '/head-teacher/create'),
('admin', '/head-teacher/delete'),
('admin', '/head-teacher/index'),
('admin', '/head-teacher/update'),
('admin', '/head-teacher/view'),
('admin', '/hot-category/*'),
('admin', '/hot-category/create'),
('admin', '/hot-category/delete'),
('admin', '/hot-category/index'),
('admin', '/hot-category/update'),
('admin', '/hot-category/view'),
('admin', '/market/*'),
('市场专员首页', '/market/*'),
('admin', '/market/create'),
('市场专员添加', '/market/create'),
('admin', '/market/delete'),
('市场专员删除', '/market/delete'),
('admin', '/market/index'),
('市场专员首页', '/market/index'),
('admin', '/market/order'),
('admin', '/market/qrcode'),
('admin', '/market/update'),
('市场专员修改', '/market/update'),
('admin', '/market/view'),
('市场专员查看', '/market/view'),
('admin', '/order-goods/*'),
('admin', '/order-goods/create'),
('admin', '/order-goods/delete'),
('admin', '/order-goods/index'),
('admin', '/order-goods/update'),
('admin', '/order-goods/view'),
('admin', '/order-info/*'),
('admin', '/order-info/create'),
('admin', '/order-info/delete'),
('admin', '/order-info/index'),
('admin', '/order-info/update'),
('admin', '/order-info/view'),
('admin', '/site/*'),
('admin', '/site/error'),
('admin', '/site/index'),
('admin', '/site/login'),
('admin', '/site/logout'),
('admin', '/teacher/*'),
('admin', '/teacher/create'),
('admin', '/teacher/delete'),
('admin', '/teacher/index'),
('admin', '/teacher/update'),
('admin', '/teacher/view'),
('admin', '/user/*'),
('User首页访问权限', '/user/*'),
('admin', '/user/create'),
('User添加权限', '/user/create'),
('admin', '/user/delete'),
('User删除权限', '/user/delete'),
('admin', '/user/index'),
('User首页访问权限', '/user/index'),
('admin', '/user/update'),
('User修改权限', '/user/update'),
('admin', '/user/view'),
('User查看详细信息权限', '/user/view'),
('admin', '/withdraw/*'),
('提现历史', '/withdraw/*'),
('admin', '/withdraw/create'),
('提现历史创建', '/withdraw/create'),
('admin', '/withdraw/delete'),
('提现历史删除', '/withdraw/delete'),
('admin', '/withdraw/index'),
('提现历史', '/withdraw/index'),
('admin', '/withdraw/update'),
('提现历史修改', '/withdraw/update'),
('admin', '/withdraw/view'),
('admin', 'Course修改权限'),
('admin', 'Course删除权限'),
('admin', 'Course查看详细信息权限'),
('admin', 'Course添加权限'),
('admin', 'Course首页访问权限'),
('guest', 'Course首页访问权限'),
('admin', 'User修改权限'),
('admin', 'User删除权限'),
('admin', 'User查看详细信息权限'),
('admin', 'User添加权限'),
('admin', 'User首页访问权限'),
('admin', '分配'),
('admin', '分配查看'),
('admin', '分配移除'),
('admin', '分配首页'),
('admin', '市场专员修改'),
('marketer', '市场专员修改'),
('admin', '市场专员删除'),
('admin', '市场专员查看'),
('admin', '市场专员添加'),
('admin', '市场专员首页'),
('marketer', '市场专员首页'),
('admin', '提现历史'),
('admin', '提现历史修改'),
('admin', '提现历史创建'),
('admin', '提现历史删除'),
('admin', '权限分配'),
('admin', '权限创建'),
('admin', '权限删除'),
('admin', '权限更新'),
('admin', '权限查看'),
('admin', '权限移除'),
('admin', '权限首页'),
('admin', '菜单创建'),
('admin', '菜单删除'),
('admin', '菜单更新'),
('admin', '菜单查看'),
('admin', '菜单首页'),
('admin', '规则创建'),
('admin', '规则删除'),
('admin', '规则更新'),
('admin', '规则查看'),
('admin', '规则首页'),
('admin', '角色修改'),
('admin', '角色分配'),
('admin', '角色列表'),
('admin', '角色删除'),
('admin', '角色查看'),
('admin', '角色添加'),
('admin', '角色移除'),
('admin', '课程种类创建'),
('admin', '路由分配'),
('admin', '路由创建'),
('admin', '路由更新'),
('admin', '路由移除'),
('admin', '路由首页');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_auth_rule`
--

CREATE TABLE `tbl_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '对图片的描述',
  `pic` varchar(255) NOT NULL COMMENT 'banner图片'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `type` varchar(50) DEFAULT NULL COMMENT '类型',
  `product_id` int(11) UNSIGNED NOT NULL COMMENT '课程id,套餐id',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车';

--
-- 转存表中的数据 `tbl_cart`
--

INSERT INTO `tbl_cart` (`cart_id`, `user_id`, `type`, `product_id`, `created_at`) VALUES
(14, 2, 'course', 2, 1508658732),
(15, 2, 'course_package', 1, 1508659214),
(17, 2, 'course', 15, 1508665972),
(20, 2, 'course', 19, 1508667333),
(21, 2, 'course', 18, 1508667358),
(30, 1, 'course', 2, 1509182920),
(35, 1, 'course_package', 1, 1509187151);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_collection`
--

CREATE TABLE `tbl_collection` (
  `id` int(11) UNSIGNED NOT NULL,
  `courseid` int(11) UNSIGNED NOT NULL COMMENT '收藏课程',
  `userid` int(11) UNSIGNED NOT NULL COMMENT '收藏学员'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏表';

--
-- 转存表中的数据 `tbl_collection`
--

INSERT INTO `tbl_collection` (`id`, `courseid`, `userid`) VALUES
(12, 19, 1),
(19, 20, 1),
(22, 18, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_cooperation`
--

CREATE TABLE `tbl_cooperation` (
  `id` int(11) UNSIGNED NOT NULL,
  `pic` varchar(255) NOT NULL COMMENT '合作者机构的图片',
  `src` varchar(255) NOT NULL COMMENT '合作者机构的链接地址',
  `title` varchar(255) DEFAULT NULL COMMENT '对合作单位的描述（名称）'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_coupon`
--

CREATE TABLE `tbl_coupon` (
  `coupon_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户',
  `name` varchar(200) NOT NULL COMMENT '优惠券名字',
  `fee` int(11) NOT NULL COMMENT '金额',
  `isuse` tinyint(4) DEFAULT '0' COMMENT '是否使用(0 未使用，1 使用中，2 已使用)',
  `start_time` datetime NOT NULL COMMENT '开始时间',
  `end_time` datetime NOT NULL COMMENT '结束时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券';

--
-- 转存表中的数据 `tbl_coupon`
--

INSERT INTO `tbl_coupon` (`coupon_id`, `user_id`, `name`, `fee`, `isuse`, `start_time`, `end_time`) VALUES
(1, 1, '新会员50元优惠券', 50, 1, '2015-10-20 00:00:00', '2017-10-31 00:00:00'),
(2, 1, '推广新会员50元优惠券', 50, 1, '2017-10-20 00:00:00', '2017-10-31 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_course`
--

CREATE TABLE `tbl_course` (
  `id` int(11) UNSIGNED NOT NULL,
  `course_name` varchar(255) NOT NULL COMMENT '课程名字',
  `list_pic` varchar(255) NOT NULL COMMENT '列表图片',
  `home_pic` varchar(255) NOT NULL COMMENT '封面图片',
  `teacher_id` int(11) NOT NULL COMMENT '授课教师',
  `price` decimal(10,2) NOT NULL COMMENT '价格',
  `discount` decimal(10,2) NOT NULL COMMENT '优惠价格',
  `category_name` varchar(255) NOT NULL COMMENT '课程分类',
  `des` text NOT NULL COMMENT '课程详情',
  `view` int(11) DEFAULT '0' COMMENT '浏览次数',
  `collection` int(11) DEFAULT '0' COMMENT '收藏次数',
  `share` int(11) DEFAULT '0' COMMENT '分享次数',
  `online` int(11) DEFAULT '0' COMMENT '在学人数',
  `onuse` tinyint(1) DEFAULT '1' COMMENT '是否可用',
  `create_time` int(11) DEFAULT NULL COMMENT '课程创建时间',
  `head_teacher` int(11) UNSIGNED NOT NULL COMMENT '班主任'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_course`
--

INSERT INTO `tbl_course` (`id`, `course_name`, `list_pic`, `home_pic`, `teacher_id`, `price`, `discount`, `category_name`, `des`, `view`, `collection`, `share`, `online`, `onuse`, `create_time`, `head_teacher`) VALUES
(2, '语文基础课程', '/uploads/img/course/15043216071946.jpg', '/uploads/img/course/15043216077712.png', 3, '1000.00', '1.00', '媒体经营,媒体融合', '<p>讲述语文基本词汇，古诗文,图片怎么了123123123</p>\r\n\r\n<p><img alt=\"\" src=\"/uploads/img/ckeditor/1504320884_2.png\" /></p>\r\n', 105, 14, 8, 34, 1, 20170709, 3),
(15, '电视新闻编导', '/uploads/img/course/15046022865027.jpg', '/uploads/img/course/15046022861272.jpg', 3, '300.00', '0.01', '媒体经营,媒体融合', '<p>电视新闻编导</p>\r\n', 21, 3, 0, 0, 1, 1504602286, 2),
(16, '新闻获奖作品解析', '/uploads/img/course/15046027828103.jpg', '/uploads/img/course/15046027821546.jpg', 3, '700.00', '0.01', '新闻创新', '<p>新闻获奖作品解析</p>\r\n', 10, 3, 0, 0, 1, 1504602782, 3),
(17, '摄影艺术创作', '/uploads/img/course/15046028321680.jpg', '/uploads/img/course/15046028321343.jpg', 3, '600.00', '1.00', '摄影技术', '<p>摄影艺术创作</p>\r\n', 7, 1, 0, 0, 1, 1504602832, 3),
(18, '视频新闻摄影', '/uploads/img/course/15046029011787.jpg', '/uploads/img/course/15046029016439.jpg', 3, '500.00', '1.00', '摄影技术,新闻业务', '<p>视频新闻摄影</p>\r\n', 5, 2, 0, 0, 1, 1504602901, 3),
(19, '广播电视业务', '/uploads/img/course/15046030088276.jpg', '/uploads/img/course/15046030083592.jpg', 3, '800.00', '1.00', '媒体融合,媒体经营', '<p>广播电视业务</p>\r\n', 8, 3, 0, 0, 1, 1504603008, 3),
(20, '电视摄像实操技艺', '/uploads/img/course/15046031663281.jpg', '/uploads/img/course/15046031661786.jpg', 3, '500.00', '1.00', '摄影技术', '<p>电视摄像技术</p>\r\n', 4, 2, 0, 0, 1, 1504603166, 3);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_course_category`
--

CREATE TABLE `tbl_course_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '分类名称',
  `parent_id` int(11) UNSIGNED NOT NULL COMMENT '父级分类',
  `des` text COMMENT '分类描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_course_category`
--

INSERT INTO `tbl_course_category` (`id`, `name`, `parent_id`, `des`) VALUES
(4, '媒体经营', 0, ''),
(5, '节目策划', 0, ''),
(6, '媒体融合', 4, ''),
(8, '广告经营', 4, ''),
(9, '节目创优', 0, ''),
(10, '精品节目剖析', 9, ''),
(11, '新闻业务', 0, ''),
(12, '新闻写作', 11, ''),
(13, '新闻创新', 11, ''),
(14, '节目制作', 0, ''),
(15, '摄影技术', 14, ''),
(16, '后期制作', 14, ''),
(17, '新媒体', 0, ''),
(18, '微信号运营', 17, ''),
(19, '手机台运营', 17, ''),
(20, '博士讲坛', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_course_chapter`
--

CREATE TABLE `tbl_course_chapter` (
  `id` int(11) UNSIGNED NOT NULL,
  `course_id` int(11) UNSIGNED NOT NULL COMMENT '所属课程',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `position` int(11) DEFAULT '0' COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_course_chapter`
--

INSERT INTO `tbl_course_chapter` (`id`, `course_id`, `name`, `position`) VALUES
(6, 2, '语文基础课程', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_course_coment`
--

CREATE TABLE `tbl_course_coment` (
  `id` int(11) UNSIGNED NOT NULL,
  `course_id` int(11) NOT NULL COMMENT '评价课程',
  `user_id` int(11) NOT NULL COMMENT '评价学员',
  `content` text NOT NULL COMMENT '评价内容',
  `check` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评价状态',
  `create_time` int(11) DEFAULT NULL COMMENT '时间',
  `star` tinyint(4) DEFAULT '5' COMMENT '星级'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_course_coment`
--

INSERT INTO `tbl_course_coment` (`id`, `course_id`, `user_id`, `content`, `check`, `create_time`, `star`) VALUES
(1, 2, 3, '课程干货十足，意犹未尽。', 1, 1505990693, 5),
(2, 15, 3, '都是我们做节目所要学习的干货啊，受益匪浅！', 1, 1506088987, 5),
(3, 16, 3, '太有用了对我们出境主持人来说，每次总觉得自己的造型不洋气。', 1, 1506089110, 5),
(4, 17, 3, '老师不仅学识渊博，而且很有风度，不愧男神老师。', 1, 1506089138, 5),
(5, 2, 3, '老师太帅了', 1, 1508573754, 5),
(6, 2, 1, '测试123', 0, 1508682496, 4),
(7, 2, 1, '测试测试', 0, 1508682617, 5),
(8, 2, 1, '哈哈哈哈', 0, 1508682792, 5),
(9, 2, 1, 'rr', 0, 1509166408, 2),
(10, 2, 1, '老师帅', 0, 1509259504, 5),
(11, 2, 1, '哈哈哈哈哈', 0, 1509769445, 5);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_course_news`
--

CREATE TABLE `tbl_course_news` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `list_pic` varchar(255) DEFAULT NULL COMMENT '列表图片',
  `des` text NOT NULL COMMENT '内容',
  `courseid` varchar(255) DEFAULT NULL COMMENT '相关课程',
  `onuse` tinyint(4) DEFAULT '1' COMMENT '是否可用',
  `position` int(11) DEFAULT NULL COMMENT '排序',
  `view` int(11) DEFAULT '0' COMMENT '浏览次数',
  `create_time` int(11) DEFAULT NULL COMMENT '日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_course_news`
--

INSERT INTO `tbl_course_news` (`id`, `title`, `list_pic`, `des`, `courseid`, `onuse`, `position`, `view`, `create_time`) VALUES
(1, ' 电视采访：让新闻因人而生动 ', '/uploads/img/course-news/15091611794318.png', '<p><span style=\"font-family:宋体\">每一个摄影作品，不论是平淡还是宏伟，重大还是普通，都蕴含着视觉之美。当我们在取景框前观察生活中的具体物体时，例如人、树、房、花等，应把它们看做是形态、线条、质地、明暗、颜色、用光等的结合体。构图既是在构思阶段把所要拍摄的人物或者是景物典型化了以强调和突出的手段，舍弃那些表面的、次要的元素，恰当安排主次的关系，从而使作品比现实生活更完善、更典型、更理想，以增强艺术效果。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">怎么评判画面的优劣</span></strong></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">1</span></strong><strong><span style=\"font-family:宋体\">、普遍性主题</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">电影和电视属于大众传播媒介，影视画面必须是绝大多数受众能够在极短的时间内理解、认同和接受的。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">2</span></strong><strong><span style=\"font-family:宋体\">、形象表现力强</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">所谓&ldquo;百闻不如一见&rdquo;,&ldquo;一图胜千言&rdquo;都是人们在强调画面对于传播的重要性，因为影视传播主要依靠视听手段，所以画面的表现力至关重要</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">作品1：克拉玛依大火中遇难儿童的家长</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">作品2：抱着孩子乞讨的妇女</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">3</span></strong><strong><span style=\"font-family:宋体\">、画面要简洁</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">简洁的画面可以突出主题并带来视觉快感</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">作品《第一乐章》：两只停留在电线上的小鸟</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">作品《岁月》：一位正在写字的老师</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">4</span></strong><strong><span style=\"font-family:宋体\">、画面的形式美</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">画框中的事物都是经过摄影师重新组织过的事物，对事物的组织能力是对一个摄影师观察力和想象力的体现。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">常见构图方法</span></strong></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">黄金构图法、九宫格法</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">这点相信不少摄影朋友早已滚瓜烂熟，以黄金比例为原理的构图方法，将画面以「井」字分割，而可将突出的被摄主体放在井字交点处，而背景层次以能采三分法比例呈现。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">S</span></strong><strong><span style=\"font-family:宋体\">形构图</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">画面上的景物呈S形曲线的构图形式，具有延长、变化的特点，使人看上去有韵律感，产生优美、雅致、协调的感觉。当需要采用曲线形式表现被摄体时，应首先想到使用S形构图。常用于河流、溪水、曲径、小路等。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">对角线构图</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">把主体安排在对角线上，能有效利用画面对角线的长度，同时也能使陪体与主体发生直接关系。富于动感，显得活泼，容易产生线条的汇聚趋势，吸引人的视线，达到突出主体的效果</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">对称性构图</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">以画面的分隔开，让画面出现对称的效果，在视觉上也能带来别样的新鲜感</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">还想要了解更多有关摄影构图的知识，加入郭艳民老师《摄影构图》课程，带你玩转摄影构图。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">主讲教师：郭艳民</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">中国传媒大学电视与新闻学院电视系摄影教研室主任。中国传媒大学教授，硕士生导师，新闻学硕士、广播电视艺术学博士。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">主讲的《摄影构图》课程先后被评为中国传媒大学校级精品课程、北京市精品课程。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">主讲的《电视摄影构图》课程被评为国家级网络精品课程。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">主要作品有大型专题片《让生命永存》、人物传纪片《吴冠中》、《黄文》、《蔡国强》等。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">主要著作有《摄影构图》、《电视新闻摄影理论及应用》、《新闻摄影》等。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">适合对象：广电系统相关部门负责人、管理人员，以及一线新闻采编人员、摄影师、节目制作人员；</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">课程介绍：本课程强调提高学生的实践技能水平，使学生通过学习和实践不仅能够理解电视新闻摄制的一般规律，掌握各种电视节目的摄制方法，而且能够自觉运用这些技法从事创作，独立完成新闻片、专题片、纪录片等的拍摄任务。</span></p>\r\n', '2,15', 1, 1, 0, 1505976598),
(2, '深入报道！深度报道！', '/uploads/img/course-news/15060893514206.png', '<p><strong><span style=\"font-family:宋体\">深入了解广播电视新闻专题节目</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">大家应该都看见过上面的几个节目，即使没有看过，相信也听说过，这些都属于专题类新闻节目，在电视节目的市场中占有相当一部分比重。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">新闻专题节目因为在构思选材时就确定了自己的定位，把目标就锁定在特有的收视群体中，所以节目的内容有明确的取向。从它覆盖领域来看，它涉及到体育、经济、法律等，这些专题节目虽不是特定对象的公众节目，但由于栏目的宗旨和内容的明确定位，在观众中也因此具有很好的知名度。比如《今日说法》在开播时就表明了&ldquo;重在普法、监督执法、促进立法&rdquo;的宗旨，《生活在线》定位于&ldquo;生活在线，再现生活&rdquo;等。这些节目的定位语提升了节目的知名度，而且成为了本专题节目的特有标志。这些有着专门内容取向的新闻专题节目闪亮登场后，成为新闻收视节目的靓点。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">电视新闻专题由于具有深度报道的典型特征，使得它在选题上有自己的鲜明特色。它在选题上常从一些典型事件、典型人物、重大事件着手，对其进行深度报道能对观众的生活和实践工作产生指导作用。如柴静主持的《看见》对轰动一时的药家鑫事件进行深入报道，在片中没有只停留在表面去报道事件的来龙去脉，它的成功之处在于深入其中，反思探讨了当代青少年成长过程中法律意识、担当意识和生命教育的缺失。这使得整个报道的社会效应和教育意义达到了一个新的高度。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">而随着广播电视新闻节目的不断发展，报道深度的多向化和节目形式的组合化也成为发展的新趋势，如《中国法治报道》，平均4分钟左右一条新闻，只达到了深度报道的第一个层次，但是这样的节奏更能够适应人们快节奏的的生活。同时，主持人在节目中定位和风格中的重要性也第一凸显，就拿中央一台的《撒贝宁探案》来说，直接将节目和主持人关联在一起，将节目风格化、个性化。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">在频道资源和节目资源眼花缭乱的今天，电视节目的竞争进行地如火如荼，《法制在线》、《今日说法》这些电视新闻专题节目何以能在传媒市场中取得市场成功，在杂志型栏目不断出现的今天，中国的电视新闻专题节目为何走过二十多个春秋后，还能受到观众的青睐呢？在成功的同时，电视新闻专题节目的构思策划中又存在哪些遗憾和缺陷呢？电视新闻专题节目又怎样才能立足创新，探索新的艺术形式，在竞争中立于不败之地呢?</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">&nbsp;</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">方毅华</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">博士，中国传媒大学教授，新闻业务教研室主任，硕士生导师。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">发表大量新闻作品并多次获得省级、中央级奖励，发表作品近50万字。获得国家省部级奖励7次。发表若干学术论文并参与主编《中国优秀广播作品文选》一书。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">适合对象</span></strong><span style=\"font-family:宋体\">：广电系统相关部门负责人、管理人员，以及一线新闻采编和节目制作人员;</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">课程介绍：新闻性专题节目是广播电台、电视台在新闻传播中经常运用的一种具有特定内容取向、以提供深度报道为主、按一定周期播出的节目类型。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">1.</span><span style=\"font-family:宋体\">新闻性专题节目以及常见的节目类型。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">2.</span><span style=\"font-family:宋体\">新闻性专题节目的主要特点。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">3.</span><span style=\"font-family:宋体\">新闻性专题节目的发展趋势。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">4.</span><span style=\"font-family:宋体\">新闻性专题节目的整体性与节目串联的关系。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">本课程将从以上四个方面来详细阐述广播电视新闻专题这一课题。</span></p>\r\n', '17', 1, 2, 0, 1506089303);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_course_package`
--

CREATE TABLE `tbl_course_package` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '套餐名字',
  `course` varchar(255) DEFAULT NULL COMMENT '课程',
  `list_pic` varchar(255) NOT NULL COMMENT '列表图片',
  `home_pic` varchar(255) NOT NULL COMMENT '封面图片',
  `price` decimal(10,0) NOT NULL COMMENT '价格',
  `discount` decimal(10,0) NOT NULL COMMENT '优惠价格',
  `category_name` varchar(255) NOT NULL COMMENT '套餐分类',
  `intro` text NOT NULL COMMENT '套餐简介',
  `des` text NOT NULL COMMENT '套餐详情',
  `view` int(11) DEFAULT '0' COMMENT '浏览次数',
  `collection` int(11) DEFAULT '0' COMMENT '收藏次数',
  `share` int(11) DEFAULT '0' COMMENT '分享次数',
  `online` int(11) DEFAULT '0' COMMENT '在学人数',
  `onuse` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否可用',
  `create_time` int(11) DEFAULT NULL COMMENT '套餐创建时间',
  `head_teacher` int(10) UNSIGNED NOT NULL COMMENT '班主任'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_course_package`
--

INSERT INTO `tbl_course_package` (`id`, `name`, `course`, `list_pic`, `home_pic`, `price`, `discount`, `category_name`, `intro`, `des`, `view`, `collection`, `share`, `online`, `onuse`, `create_time`, `head_teacher`) VALUES
(1, '低保和人文后期', '2,15', '/uploads/img/course-package/15043371121620.jpg', '/uploads/img/course-package/15043371121737.png', '666', '667', '人像摄影,班级', '低饱和色调是介于黑白色调和彩色色调之间的一种过渡色调', '<p><span style=\"color:rgb(97, 97, 97); font-family:helvetica neue,helvetica,arial,hiragino sans gb,microsoft yahei,wenquanyi micro hei,sans-serif; font-size:14px\">低饱和色调是介于黑白色调和彩色色调之间的一种过渡色调</span></p>\r\n', 0, 0, 0, 0, 1, NULL, 3),
(2, '低保和人文中期', '16', '/uploads/img/course-package/15056380853074.png', '/uploads/img/course-package/15056380855480.png', '555', '555', '人像摄影,微课', '低饱和色调是介于黑白色调和彩色色调之间的一种过渡色调', '<p><span style=\"color:rgb(97, 97, 97); font-family:helvetica neue,helvetica,arial,hiragino sans gb,microsoft yahei,wenquanyi micro hei,sans-serif; font-size:14px\">低饱和色调是介于黑白色调和彩色色调之间的一种过渡色调</span></p>\r\n\r\n<p><img alt=\"\" src=\"/uploads/img/ckeditor/1505638081_2.png\" style=\"height:200px; width:200px\" /></p>\r\n', 0, 0, 0, 0, 1, 1503822867, 2);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_course_package_category`
--

CREATE TABLE `tbl_course_package_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '分类名称',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级分类',
  `des` text COMMENT '分类描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_course_package_category`
--

INSERT INTO `tbl_course_package_category` (`id`, `name`, `parent_id`, `des`) VALUES
(2, '微课', 0, '微课微课'),
(3, '人像摄影', 2, '微课====》人像摄影'),
(4, '班级', 0, '班级'),
(5, '摄影课程', 4, '班级===》摄影课程');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_course_section`
--

CREATE TABLE `tbl_course_section` (
  `id` int(10) UNSIGNED NOT NULL,
  `chapter_id` int(10) UNSIGNED NOT NULL COMMENT '所属章',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `position` int(11) DEFAULT '0' COMMENT '排序',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '网课/直播课',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `video_url` varchar(255) NOT NULL COMMENT '视频地址',
  `roomid` varchar(50) NOT NULL COMMENT 'roomid',
  `duration` varchar(50) NOT NULL COMMENT '时长',
  `playback_url` varchar(255) DEFAULT NULL COMMENT '回放地址',
  `paid_free` tinyint(4) NOT NULL COMMENT '收费/免费'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_course_section`
--

INSERT INTO `tbl_course_section` (`id`, `chapter_id`, `name`, `position`, `type`, `start_time`, `video_url`, `roomid`, `duration`, `playback_url`, `paid_free`) VALUES
(15, 6, '第一节', 1, 0, '2017-10-29 09:40:00', 'https://view.csslcloud.net/api/view/index?roomid=E5F3016F3FDBC13B9C33DC5901307461&userid=C33E4EBC5FB186CF', 'E5F3016F3FDBC13B9C33DC5901307461', '60', '', 1),
(16, 6, '第二节', 2, 0, '2017-10-28 14:30:00', 'https://view.csslcloud.net/api/view/index?roomid=8EFA264F77A57E209C33DC5901307461&userid=C33E4EBC5FB186CF', '8EFA264F77A57E209C33DC5901307461', '60', '', 1),
(17, 6, '第三节', 3, 0, '2017-10-28 16:00:00', 'https://view.csslcloud.net/api/view/index?roomid=8EFA264F77A57E209C33DC5901307461&userid=C33E4EBC5FB186CF', 'E5F3016F3FDBC13B9C33DC5901307461', '30', '', 1),
(18, 6, '第四节', 1, 1, '2017-10-21 14:45:00', 'www.baidu.com', '123', '60', '123', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_data`
--

CREATE TABLE `tbl_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '资料名称',
  `list_pic` varchar(255) NOT NULL COMMENT '列表图片',
  `url_type` int(11) NOT NULL DEFAULT '1' COMMENT '内链接/外链接',
  `summary` text NOT NULL COMMENT '概述',
  `content` text COMMENT '资料详情',
  `course_id` int(10) UNSIGNED DEFAULT NULL COMMENT '相关课程',
  `ctime` varchar(255) DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_data`
--

INSERT INTO `tbl_data` (`id`, `name`, `list_pic`, `url_type`, `summary`, `content`, `course_id`, `ctime`) VALUES
(1, '教你如何玩转摄影构图', '/uploads/img/data/15091586157002.png', 1, '每一个摄影作品，不论是平淡还是宏伟，重大还是普通，都蕴含着视觉之美...', '<p><span style=\"font-family:宋体\">每一个摄影作品，不论是平淡还是宏伟，重大还是普通，都蕴含着视觉之美。当我们在取景框前观察生活中的具体物体时，例如人、树、房、花等，应把它们看做是形态、线条、质地、明暗、颜色、用光等的结合体。构图既是在构思阶段把所要拍摄的人物或者是景物典型化了以强调和突出的手段，舍弃那些表面的、次要的元素，恰当安排主次的关系，从而使作品比现实生活更完善、更典型、更理想，以增强艺术效果。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">怎么评判画面的优劣</span></strong></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">1</span></strong><strong><span style=\"font-family:宋体\">、普遍性主题</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">电影和电视属于大众传播媒介，影视画面必须是绝大多数受众能够在极短的时间内理解、认同和接受的。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">2</span></strong><strong><span style=\"font-family:宋体\">、形象表现力强</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">所谓&ldquo;百闻不如一见&rdquo;,&ldquo;一图胜千言&rdquo;都是人们在强调画面对于传播的重要性，因为影视传播主要依靠视听手段，所以画面的表现力至关重要</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">作品1：克拉玛依大火中遇难儿童的家长</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">作品2：抱着孩子乞讨的妇女</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">3</span></strong><strong><span style=\"font-family:宋体\">、画面要简洁</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">简洁的画面可以突出主题并带来视觉快感</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">作品《第一乐章》：两只停留在电线上的小鸟</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">作品《岁月》：一位正在写字的老师</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">4</span></strong><strong><span style=\"font-family:宋体\">、画面的形式美</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">画框中的事物都是经过摄影师重新组织过的事物，对事物的组织能力是对一个摄影师观察力和想象力的体现。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">常见构图方法</span></strong></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">黄金构图法、九宫格法</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">这点相信不少摄影朋友早已滚瓜烂熟，以黄金比例为原理的构图方法，将画面以「井」字分割，而可将突出的被摄主体放在井字交点处，而背景层次以能采三分法比例呈现。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">S</span></strong><strong><span style=\"font-family:宋体\">形构图</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">画面上的景物呈S形曲线的构图形式，具有延长、变化的特点，使人看上去有韵律感，产生优美、雅致、协调的感觉。当需要采用曲线形式表现被摄体时，应首先想到使用S形构图。常用于河流、溪水、曲径、小路等。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">对角线构图</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">把主体安排在对角线上，能有效利用画面对角线的长度，同时也能使陪体与主体发生直接关系。富于动感，显得活泼，容易产生线条的汇聚趋势，吸引人的视线，达到突出主体的效果</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">对称性构图</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">以画面的分隔开，让画面出现对称的效果，在视觉上也能带来别样的新鲜感</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">还想要了解更多有关摄影构图的知识，加入郭艳民老师《摄影构图》课程，带你玩转摄影构图。</span></p>\r\n\r\n<p><strong><span style=\"font-family:宋体\">主讲教师：郭艳民</span></strong></p>\r\n\r\n<p><span style=\"font-family:宋体\">中国传媒大学电视与新闻学院电视系摄影教研室主任。中国传媒大学教授，硕士生导师，新闻学硕士、广播电视艺术学博士。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">主讲的《摄影构图》课程先后被评为中国传媒大学校级精品课程、北京市精品课程。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">主讲的《电视摄影构图》课程被评为国家级网络精品课程。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">主要作品有大型专题片《让生命永存》、人物传纪片《吴冠中》、《黄文》、《蔡国强》等。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">主要著作有《摄影构图》、《电视新闻摄影理论及应用》、《新闻摄影》等。</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">适合对象：广电系统相关部门负责人、管理人员，以及一线新闻采编人员、摄影师、节目制作人员；</span></p>\r\n\r\n<p><span style=\"font-family:宋体\">课程介绍：本课程强调提高学生的实践技能水平，使学生通过学习和实践不仅能够理解电视新闻摄制的一般规律，掌握各种电视节目的摄制方法，而且能够自觉运用这些技法从事创作，独立完成新闻片、专题片、纪录片等的拍摄任务。</span></p>\r\n', 2, '1508582417'),
(2, '深入报道！深度报道！', '/uploads/img/data/15091586711113.png', 0, '深入了解广播电视新闻专题节目 大家应该都看见过上面的几个节目，即使...', '<p>http://www.baidu.com</p>\r\n', 15, '1508582566'),
(3, '新闻摄影：观众的“眼睛”', '/uploads/img/data/15091588021622.jpg', 0, '相信每个人都看过中央一台的《新闻联播》，对于其中的会议画面更是司空见...', '<p>http://www.baidu.com</p>\r\n', 2, '1508582752');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_friendly_links`
--

CREATE TABLE `tbl_friendly_links` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '名称',
  `src` varchar(255) NOT NULL COMMENT '链接',
  `position` int(11) UNSIGNED DEFAULT '0' COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_friendly_links`
--

INSERT INTO `tbl_friendly_links` (`id`, `title`, `src`, `position`) VALUES
(1, '中央人民广播电台', 'http://www.cnr.cn/', 1),
(2, '中国传媒大学', 'http://www.cuc.edu.cn', 2),
(3, '中央电视台', 'http://www.cctv.com', 3);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_hot_category`
--

CREATE TABLE `tbl_hot_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `categoryid` int(10) UNSIGNED NOT NULL COMMENT '热门分类',
  `backgroundcolor` varchar(255) DEFAULT NULL COMMENT '背景色',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `position` int(11) DEFAULT NULL COMMENT '显示顺序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_hot_category`
--

INSERT INTO `tbl_hot_category` (`id`, `categoryid`, `backgroundcolor`, `icon`, `title`, `position`) VALUES
(2, 4, '#f6ce00', '/uploads/img/hot-course/15046596322382.png', '媒体经营', 1),
(3, 5, '#4caafc', '/uploads/img/hot-course/15046589893387.png', '节目策划', 2),
(4, 9, '#e994dc', '/uploads/img/hot-course/15047929005725.png', '节目创优', 3),
(5, 11, '#54cea9', '/uploads/img/hot-course/15047929953627.png', '新闻业务', 4),
(6, 14, '#9985cc', '/uploads/img/hot-course/15047930698792.png', '节目制作', 5),
(7, 17, '#e3b47b', '/uploads/img/hot-course/15047931237443.png', '新媒体', 6),
(8, 20, '#848d99', '/uploads/img/hot-course/15047932977653.png', '博士讲坛', 7);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_menu`
--

INSERT INTO `tbl_menu` (`id`, `name`, `parent`, `route`, `order`, `data`) VALUES
(1, '用户管理', 2, '/user/index', 1, 0x7b2269636f6e223a202266612066612d75736572222c202276697369626c65223a2066616c73657d),
(2, '系统设置', NULL, NULL, 1, NULL),
(3, '学员管理', NULL, NULL, 2, NULL),
(4, '课程管理', NULL, NULL, 3, NULL),
(5, '讲师管理', NULL, '/teacher/index', 4, NULL),
(7, '权限列表', 2, '/admin/permission/index', 3, NULL),
(8, '角色列表', 2, '/admin/role/index', 4, NULL),
(9, '分配', 2, '/admin/assignment/index', 2, NULL),
(10, '路由列表', 2, '/admin/route/index', 5, NULL),
(11, '规则列表', 2, '/admin/rule/index', 6, NULL),
(12, '菜单', 2, '/admin/menu/index', 7, NULL),
(13, '市场专员', NULL, '/market/index', 7, NULL),
(14, '热门分类', 4, '/hot-category/index', 5, NULL),
(16, '提现历史', NULL, '/withdraw/index', 2, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_migration`
--

CREATE TABLE `tbl_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1497701611),
('m140209_132017_init', 1497701616),
('m140403_174025_create_account_table', 1497701618),
('m140504_113157_update_tables', 1497701621),
('m140506_102106_rbac_init', 1499516801),
('m140602_111327_create_menu_table', 1499516779),
('m160312_050000_create_user', 1499516780),
('m170709_054736_add_phone_to_user_table', 1500194416);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_notice`
--

CREATE TABLE `tbl_notice` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '公告标题'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_goods`
--

CREATE TABLE `tbl_order_goods` (
  `rec_id` int(11) UNSIGNED NOT NULL COMMENT '订单商品信息自增id',
  `order_sn` varchar(200) NOT NULL COMMENT '订单商品信息对应的详细信息id，取值order_info的order_sn',
  `goods_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品的的id，取值表ecs_goods 的goods_id',
  `goods_name` varchar(120) DEFAULT NULL COMMENT '商品的名称，取值表ecs_goods ',
  `goods_sn` varchar(60) DEFAULT NULL COMMENT '商品的唯一货号，取值ecs_goods ',
  `goods_number` smallint(5) UNSIGNED NOT NULL DEFAULT '1' COMMENT '商品的购买数量',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品的市场售价，取值ecs_goods ',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品的本店售价，取值ecs_goods ',
  `goods_attr` text COMMENT '购买该商品时所选择的属性；',
  `send_number` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '当不是实物时，是否已发货，0，否；1，是',
  `is_real` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否是实物，0，否；1，是；取值ecs_goods ',
  `extension_code` varchar(30) DEFAULT NULL COMMENT '商品的扩展属性，比如像虚拟卡。取值ecs_goods ',
  `parent_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父商品id，取值于ecs_cart的parent_id；如果有该值则是值多代表的物品的配件',
  `is_gift` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否参加优惠活动，0，否；其他，取值于ecs_cart 的is_gift，跟其一样，是参加的优惠活动的id',
  `type` varchar(300) NOT NULL COMMENT '类型'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单的商品信息，注：订单的商品信息基本都是从购物车所对应的表中取来的。' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `tbl_order_goods`
--

INSERT INTO `tbl_order_goods` (`rec_id`, `order_sn`, `goods_id`, `goods_name`, `goods_sn`, `goods_number`, `market_price`, `goods_price`, `goods_attr`, `send_number`, `is_real`, `extension_code`, `parent_id`, `is_gift`, `type`) VALUES
(27, 'KB-201710221808163183293824', 15, '电视新闻编导', NULL, 1, '300.00', '200.00', NULL, 0, 0, NULL, 0, 0, ''),
(28, 'KB-201710221808163183293824', 18, '视频新闻摄影', NULL, 1, '500.00', '1.00', NULL, 0, 0, NULL, 0, 0, ''),
(29, 'KB-201710221808163183293824', 19, '广播电视业务', NULL, 1, '800.00', '1.00', NULL, 0, 0, NULL, 0, 0, ''),
(30, 'KB-201710221808163183293824', 1, '低保和人文后期', NULL, 1, '666.00', '667.00', NULL, 0, 0, NULL, 0, 0, ''),
(31, 'KB-201710221808163183293824', 2, '低保和人文中期', NULL, 1, '555.00', '555.00', NULL, 0, 0, NULL, 0, 0, ''),
(32, 'KB-201710221810393663709128', 15, '电视新闻编导', NULL, 1, '300.00', '200.00', NULL, 0, 0, NULL, 0, 0, ''),
(33, 'KB-201710221810393663709128', 18, '视频新闻摄影', NULL, 1, '500.00', '1.00', NULL, 0, 0, NULL, 0, 0, ''),
(34, 'KB-201710221810393663709128', 19, '广播电视业务', NULL, 1, '800.00', '1.00', NULL, 0, 0, NULL, 0, 0, ''),
(35, 'KB-201710221810393663709128', 1, '低保和人文后期', NULL, 1, '666.00', '667.00', NULL, 0, 0, NULL, 0, 0, ''),
(36, 'KB-201710221810393663709128', 2, '低保和人文中期', NULL, 1, '555.00', '555.00', NULL, 0, 0, NULL, 0, 0, ''),
(37, 'KB-201710221811208017160940', 15, '电视新闻编导', NULL, 1, '300.00', '200.00', NULL, 0, 0, NULL, 0, 0, ''),
(38, 'KB-201710221811208017160940', 18, '视频新闻摄影', NULL, 1, '500.00', '1.00', NULL, 0, 0, NULL, 0, 0, ''),
(39, 'KB-201710221811208017160940', 19, '广播电视业务', NULL, 1, '800.00', '1.00', NULL, 0, 0, NULL, 0, 0, ''),
(40, 'KB-201710221811208017160940', 1, '低保和人文后期', NULL, 1, '666.00', '667.00', NULL, 0, 0, NULL, 0, 0, ''),
(41, 'KB-201710221811208017160940', 2, '低保和人文中期', NULL, 1, '555.00', '555.00', NULL, 0, 0, NULL, 0, 0, ''),
(42, 'KB-201710281118028855515524', 2, '语文基础课程', NULL, 1, '1000.00', '1.00', NULL, 0, 0, NULL, 0, 0, ''),
(43, 'KB-201710281118028855515524', 2, '低保和人文中期', NULL, 1, '555.00', '555.00', NULL, 0, 0, NULL, 0, 0, ''),
(44, 'KB-201710281133006342058637', 1, '低保和人文后期', NULL, 1, '666.00', '667.00', NULL, 0, 0, NULL, 0, 0, ''),
(45, 'KB-201710281141459261512631', 1, '低保和人文后期', NULL, 1, '666.00', '667.00', NULL, 0, 0, NULL, 0, 0, ''),
(46, 'KB-201710281144147358365720', 1, '低保和人文后期', NULL, 1, '666.00', '667.00', NULL, 0, 0, NULL, 0, 0, ''),
(47, 'KB-201710281144356462685915', 1, '低保和人文后期', NULL, 1, '666.00', '667.00', NULL, 0, 0, NULL, 0, 0, ''),
(48, 'KB-201710281232081029021048', 20, '电视摄像实操技艺', NULL, 1, '500.00', '1.00', NULL, 0, 0, NULL, 0, 0, ''),
(49, 'KB-201710281232081029021048', 1, '低保和人文后期', NULL, 1, '666.00', '667.00', NULL, 0, 0, NULL, 0, 0, ''),
(50, 'KB-201710281630139985201526', 15, '电视新闻编导', NULL, 1, '300.00', '0.01', NULL, 0, 0, NULL, 0, 0, 'course'),
(51, 'KB-201710281630139985201526', 16, '新闻获奖作品解析', NULL, 1, '700.00', '0.01', NULL, 0, 0, NULL, 0, 0, 'course'),
(52, 'KB-201710281730517494530624', 15, '电视新闻编导', NULL, 1, '300.00', '0.01', NULL, 0, 0, NULL, 0, 0, 'course'),
(53, 'KB-201710281811567929542316', 15, '电视新闻编导', NULL, 1, '300.00', '0.01', NULL, 0, 0, NULL, 0, 0, 'course'),
(54, 'KB-201710281834204862628718', 15, '电视新闻编导', NULL, 1, '300.00', '0.01', NULL, 0, 0, NULL, 0, 0, 'course'),
(55, 'KB-201710281835573372371123', 15, '电视新闻编导', NULL, 1, '300.00', '0.01', NULL, 0, 0, NULL, 0, 0, 'course'),
(56, 'KB-201710281853095883865406', 15, '电视新闻编导', NULL, 1, '300.00', '0.01', NULL, 0, 0, NULL, 0, 0, 'course'),
(57, 'KB-201710290937331731716819', 15, '电视新闻编导', NULL, 1, '300.00', '0.01', NULL, 0, 0, NULL, 0, 0, 'course');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_info`
--

CREATE TABLE `tbl_order_info` (
  `order_id` int(11) UNSIGNED NOT NULL COMMENT '订单详细信息自增id',
  `order_sn` varchar(200) NOT NULL COMMENT '订单号，唯一',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id，同ecs_users的user_id',
  `order_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '订单状态。0，未确认；1，已确认；2，已取消；3，无效；4，退货；',
  `pay_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付状态；0，未付款；1，付款中；2，已付款',
  `consignee` varchar(60) DEFAULT NULL COMMENT '收货人的姓名，用户页面填写，默认取值于表user_address',
  `mobile` varchar(60) DEFAULT NULL COMMENT '收货人的手机，用户页面填写，默认取值于表user_phone',
  `email` varchar(60) DEFAULT NULL COMMENT '收货人的邮箱，用户页面填写，默认取值于表user_email',
  `pay_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '用户选择的支付方式的id，取值表ecs_payment',
  `pay_name` varchar(120) DEFAULT NULL COMMENT '用户选择的支付方式的名称，取值表ecs_payment',
  `goods_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总金额',
  `pay_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付费用,跟支付方式的配置相关，取值表ecs_payment',
  `money_paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已付款金额',
  `integral` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '使用的积分的数量，取用户使用积分，商品可用积分，用户拥有积分中最小者',
  `integral_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用积分金额',
  `bonus` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用红包金额',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '应付款金额',
  `add_time` varchar(50) NOT NULL COMMENT '订单生成时间',
  `confirm_time` varchar(50) DEFAULT NULL COMMENT '订单确认时间',
  `pay_time` varchar(50) DEFAULT NULL COMMENT '订单支付时间',
  `bonus_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '红包的id，ecs_user_bonus的bonus_id',
  `is_separate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0，未分成或等待分成；1，已分成；2，取消分成；',
  `parent_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '能获得推荐分成的用户id，id取值于表ecs_users',
  `discount` decimal(10,2) DEFAULT NULL COMMENT '折扣金额',
  `invalid_time` varchar(50) DEFAULT NULL COMMENT '失效时间',
  `course_ids` varchar(200) NOT NULL COMMENT '课程id',
  `coupon_ids` varchar(100) DEFAULT NULL COMMENT '优惠券id',
  `coupon_money` decimal(10,0) DEFAULT '0' COMMENT '优惠券金额'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单的配送，贺卡等详细信息' ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `tbl_order_info`
--

INSERT INTO `tbl_order_info` (`order_id`, `order_sn`, `user_id`, `order_status`, `pay_status`, `consignee`, `mobile`, `email`, `pay_id`, `pay_name`, `goods_amount`, `pay_fee`, `money_paid`, `integral`, `integral_money`, `bonus`, `order_amount`, `add_time`, `confirm_time`, `pay_time`, `bonus_id`, `is_separate`, `parent_id`, `discount`, `invalid_time`, `course_ids`, `coupon_ids`, `coupon_money`) VALUES
(24, '1', 1, 0, 2, '', '', '', 0, '', '0.00', '0.00', '0.00', 0, '0.00', '0.00', '0.00', '1509160682', NULL, NULL, 0, 0, 0, NULL, '1509248676', '1,2,3,4', NULL, '0'),
(25, '2', 1, 0, 2, '', '', '', 0, '', '0.00', '0.00', '0.00', 0, '0.00', '0.00', '0.00', '1509160682', NULL, NULL, 0, 0, 0, NULL, '1509248676', '5,7,9', NULL, '0'),
(26, 'KB-201710221811208017160940', 1, 1, 0, 'admin', '18792512631', '1@1.com', 0, NULL, '1424.00', '0.00', '0.00', 0, '0.00', '0.00', '1374.00', '1508667080', NULL, NULL, 0, 0, 0, NULL, '1509248676', '15,18,19,2,16,', '1', '50'),
(27, 'KB-201710281118028855515524', 1, 1, 0, 'admin', '18792512631', '1@1.com', 0, NULL, '556.00', '0.00', '0.00', 0, '0.00', '0.00', '506.00', '1509160682', NULL, NULL, 0, 0, 0, NULL, '1509248676', '2,16,', '2', '50'),
(28, 'KB-201710281133006342058637', 1, 1, 0, 'admin', '18792512631', '1@1.com', 0, NULL, '667.00', '0.00', '0.00', 0, '0.00', '0.00', '617.00', '1509161580', NULL, NULL, 0, 0, 0, NULL, '1509248676', '2,15,', '1', '50'),
(29, 'KB-201710281141459261512631', 1, 1, 0, 'admin', '18792512631', '1@1.com', 0, NULL, '667.00', '0.00', '0.00', 0, '0.00', '0.00', '667.00', '1509162105', NULL, NULL, 0, 0, 0, NULL, '1509248676', '2,15,', '', '0'),
(30, 'KB-201710281144147358365720', 1, 1, 0, 'admin', '18792512631', '1@1.com', 0, NULL, '667.00', '0.00', '0.00', 0, '0.00', '0.00', '667.00', '1509162254', NULL, NULL, 0, 0, 0, NULL, '1509248676', '2,15,', '', '0'),
(31, 'KB-201710281144356462685915', 1, 1, 0, 'admin', '18792512631', '1@1.com', 0, NULL, '667.00', '0.00', '0.00', 0, '0.00', '0.00', '667.00', '1509162276', NULL, NULL, 0, 0, 0, NULL, '1409248676', '2,15,', '', '0'),
(32, 'KB-201710281232081029021048', 1, 1, 0, 'admin', '18792512631', '1@1.com', 0, NULL, '668.00', '0.00', '0.00', 0, '0.00', '0.00', '618.00', '1509165165', NULL, NULL, 0, 0, 0, NULL, '1509251565', '20,2,15,', '2', '50'),
(33, 'KB-201710281630139985201526', 1, 1, 0, 'admin', '18792512631', '1@1.com', 0, NULL, '0.02', '0.00', '0.00', 0, '0.00', '0.00', '0.02', '1509179426', NULL, NULL, 0, 0, 0, NULL, '1509265826', '15,16,', '', '0'),
(34, 'KB-201710281730517494530624', 1, 1, 0, 'admin', '18792512631', '1@1.com', 0, NULL, '0.01', '0.00', '0.00', 0, '0.00', '0.00', '0.01', '1509183061', NULL, NULL, 0, 0, 0, NULL, NULL, '15,', '', '0'),
(35, 'KB-201710281811567929542316', 1, 1, 2, 'admin', '18792512631', '1@1.com', 0, NULL, '0.01', '0.00', '0.01', 0, '0.00', '0.00', '0.01', '1509185524', NULL, '1509190692', 0, 0, 0, NULL, NULL, '15,', '', '0'),
(36, 'KB-201710281834204862628718', 1, 1, 2, 'admin', '18792512631', '1@1.com', 0, NULL, '0.01', '0.00', '0.01', 0, '0.00', '0.00', '0.01', '1509186865', NULL, '1509188302', 0, 0, 0, NULL, NULL, '15,', '', '0'),
(37, 'KB-201710281835573372371123', 1, 1, 2, 'admin', '18792512631', '1@1.com', 0, NULL, '0.01', '0.00', '0.01', 0, '0.00', '0.00', '0.01', '1509186963', NULL, '1509188416', 0, 0, 0, NULL, NULL, '15,', '', '0'),
(38, 'KB-201710281853095883865406', 1, 1, 1, 'admin', '18792512631', '1@1.com', 0, NULL, '0.01', '0.00', '0.01', 0, '0.00', '0.00', '0.01', '1509188010', NULL, '1509188032', 0, 0, 0, NULL, NULL, '15,', '', '0'),
(39, 'KB-201710290937331731716819', 1, 1, 0, 'admin', '18792512631', '1@1.com', 0, NULL, '0.01', '0.00', '0.00', 0, '0.00', '0.00', '0.01', '1509241057', NULL, NULL, 0, 0, 0, NULL, NULL, '15,', '', '0');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_quas`
--

CREATE TABLE `tbl_quas` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(11) NOT NULL COMMENT '提问题学生',
  `teacher_id` int(11) DEFAULT NULL COMMENT '回答问题教师',
  `question` text NOT NULL COMMENT '问题',
  `answer` text COMMENT '回答',
  `question_time` int(11) DEFAULT NULL COMMENT '提问题时间',
  `answer_time` int(11) DEFAULT NULL COMMENT '回答问题时间',
  `course_id` int(11) NOT NULL COMMENT '相关课程',
  `check` int(11) NOT NULL COMMENT '审核状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_quas`
--

INSERT INTO `tbl_quas` (`id`, `student_id`, `teacher_id`, `question`, `answer`, `question_time`, `answer_time`, `course_id`, `check`) VALUES
(1, 1, 2, 'aaa', 'ceshi ', 123, 1509258185, 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Password',
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '邮箱',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '电话',
  `gender` tinyint(1) DEFAULT NULL COMMENT '性别（男：0，女：1）',
  `description` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '简短描述',
  `unit` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '单位',
  `office` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '职务',
  `goodat` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '擅长',
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '照片',
  `intro` text COLLATE utf8_unicode_ci COMMENT '介绍',
  `invite` int(11) DEFAULT '0' COMMENT '邀请人',
  `wechat` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '微信号',
  `wechat_img` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '微信二维码',
  `percentage` float NOT NULL DEFAULT '0' COMMENT '提成比例'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `phone`, `gender`, `description`, `unit`, `office`, `goodat`, `picture`, `intro`, `invite`, `wechat`, `wechat_img`, `percentage`) VALUES
(1, 'admin', 'lIEYAgkJduYkLv_pHN5-xH88FiKCH-l9', '$2y$13$s8FJ4vBI/SiXHupudy6e6.7WDN2J1JY2ZvIILu3EtPrQPuWczt3TS', '', '1@1.com', 10, 1462172141, 1509167150, '18792512631', 1, '', '', '', '', 'uploads/img/head_img/15079490151771.png', '', NULL, '', 'uploads/img/wechat_img/15061601941267.jpg', 0),
(2, 'ypgao', 'zjzDRYloSQlnmQS46zqSjbyDp89BeDxT', '$2y$13$olmA6Ifl7n0xMQaOgOoOguCSRPOmzLc1r0/AogkQ2.pTLSSmdpTA.', '', '1312201292@qq.com', 10, 1502011972, 1508660210, '13269392980', NULL, '', '', '', '', '', '', NULL, '', '/uploads/img/course/15043216071946.jpg', 0),
(3, 'ert', 'ert', '$2y$13$s8FJ4vBI/SiXHupudy6e6.7WDN2J1JY2ZvIILu3EtPrQPuWczt3TS', 'ert', 'er@qq.com', 10, 122, 1505618633, '121', 0, '中国人们大学教授', '', '', '', '/img/teacher-icon.jpg', '中国广播电视协会纪录片委员会副会长，中央电视台高级编辑、资深策划，中国纪录片著名编导，中国多项电视奖(政府奖)评委，法国国际电视节评委，英国国际环保电影节评委，中国传媒大学、北京电影学院、中央戏剧学院客座教授，《凤凰卫视》中文台节目策划人，全国十佳电视工作者。', NULL, NULL, NULL, 0),
(5, 'wfzhang', '123', '123', '123', 'sunshowerykk@163.com', 1, 201792, 201792, '18811717528', 1, 'wf', '2f', '2f', 'wf', 'wf', 'wf', 999, NULL, NULL, 0),
(6, '2', '2', '2', '2', '2', 2, 1505030741, 2, '2', 2, '2', '2', '2', '2', '2', '2', NULL, NULL, NULL, 0),
(7, '2', '2', '2', '2', '2', 2, 1505030762, 2, '2', 2, '2', '2', '2', '2', '2', '2', NULL, NULL, NULL, 0),
(9, '9', '7p1OKkMADgkgbCxodIKlkyiw1jWS65Gu', '$2y$13$9ASUYwA6DctTcpGYEuYJa.at7bpbgA6WCZ2GSfjNeya/rG8nC61K.', NULL, '9@q.com', 0, 1505038372, NULL, '1', 1, '1', '1', '1', '1', '1', '1', NULL, NULL, NULL, 0),
(10, '12', 'uC_X6CJhDvvtflGGjMHr31rtoWh646r4', '$2y$13$GdVVLUoSkxNKpz7NEW3QBO9e97He7gyc6Win8i56sSIw/.Uhbm4Qu', NULL, '1qq23456@qq.com', 10, 1505038556, 1505038556, '12345678901', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(11, '22', 'WgJ8ri-pm5YYRZcifvGjSWIvqDSQXmcH', '$2y$13$PMcgBF7sBOhSBc2VtRgrGu36/g95Ed1lEP.A/P42BIzJEj/jIZmYG', NULL, 'w@q.com', 10, 1505040106, 1505040106, '12345678909', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0),
(12, '123', 'IWt9zXfTGri6QjfUQEQf53u2oGNZ1KoR', '$2y$13$Z3bRNJnv5OAUyQoIeaRAR.fR8Ruw7k4EZDaCIAYvWyfz9vAXxrb12', NULL, '123@q.com', 10, 1505040211, 1505040211, '12345678931', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 123, NULL, NULL, 0),
(13, '123', 'oITEPQKBk_Q7tNrAY6i1P2vXbMbe5OeW', '$2y$13$Ca4D7Q.GlMQ5nlBq5hXL6uIdGXb8Zpklf/0MzS/C8NFmtMz0Afhuq', NULL, '123@m.com', 10, 1505631715, NULL, '18793450987', 0, 'qww', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 0),
(14, '123', '_siS1nvOR9vW_WvNMMg2LoZEqt3vJL3G', '$2y$13$OyXS8nwpcbO2.EbYp.rKv.Zm.62ldXV.xA4IKMtGy0js1tf5N5wD.', NULL, '123@m.com', 10, 1505631749, 1505633151, '18793450987', 0, 'qww', NULL, NULL, NULL, 'uploads/img/head_img/15056331517561.jpg', NULL, NULL, NULL, NULL, 0),
(15, 'dingxingjian', '1pRe5hEvpFH5nKNxJrp8iwH_S-OQxg03', '$2y$13$UuPr9Xloe.4LHzrMLeHg9e3rDJl06HqCoSErrDPc3atxqzCuwWQNm', NULL, '771569533@qq.com', 10, 1505920027, 1507467827, '13147734276', 0, NULL, NULL, NULL, NULL, 'uploads/img/head_img/15074671498727.png', NULL, -1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_user_old`
--

CREATE TABLE `tbl_user_old` (
  `id` int(11) NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `tbl_user_old`
--

INSERT INTO `tbl_user_old` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `phone`) VALUES
(1, 'admin', 'lIEYAgkJduYkLv_pHN5-xH88FiKCH-l9', '$2y$13$s8FJ4vBI/SiXHupudy6e6.7WDN2J1JY2ZvIILu3EtPrQPuWczt3TS', NULL, '1@1.com', 10, 1462172141, 1462172141, '');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_withdraw`
--

CREATE TABLE `tbl_withdraw` (
  `withdraw_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT '市场专员',
  `fee` decimal(10,0) DEFAULT NULL COMMENT '金额',
  `info` text COMMENT '描述信息',
  `create_time` datetime DEFAULT NULL COMMENT '提现时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现历史';

--
-- 转存表中的数据 `tbl_withdraw`
--

INSERT INTO `tbl_withdraw` (`withdraw_id`, `user_id`, `fee`, `info`, `create_time`) VALUES
(1, 1, '20', 'wwww', '2015-09-10 00:00:00'),
(2, 3, '33', '3', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_advertorial`
--
ALTER TABLE `tbl_advertorial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_auth_assignment`
--
ALTER TABLE `tbl_auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `tbl_auth_item`
--
ALTER TABLE `tbl_auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `tbl_auth_item_child`
--
ALTER TABLE `tbl_auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `tbl_auth_rule`
--
ALTER TABLE `tbl_auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_collection`
--
ALTER TABLE `tbl_collection`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tbl_cooperation`
--
ALTER TABLE `tbl_cooperation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head_teacher` (`head_teacher`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `tbl_course_category`
--
ALTER TABLE `tbl_course_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `tbl_course_chapter`
--
ALTER TABLE `tbl_course_chapter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `tbl_course_coment`
--
ALTER TABLE `tbl_course_coment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_course_news`
--
ALTER TABLE `tbl_course_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_course_package`
--
ALTER TABLE `tbl_course_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_course_package_category`
--
ALTER TABLE `tbl_course_package_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_course_section`
--
ALTER TABLE `tbl_course_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_id` (`chapter_id`);

--
-- Indexes for table `tbl_data`
--
ALTER TABLE `tbl_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_friendly_links`
--
ALTER TABLE `tbl_friendly_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_hot_category`
--
ALTER TABLE `tbl_hot_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryid` (`categoryid`);

--
-- Indexes for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `tbl_migration`
--
ALTER TABLE `tbl_migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `tbl_notice`
--
ALTER TABLE `tbl_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_goods`
--
ALTER TABLE `tbl_order_goods`
  ADD PRIMARY KEY (`rec_id`),
  ADD KEY `order_id` (`order_sn`),
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `tbl_order_info`
--
ALTER TABLE `tbl_order_info`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_sn` (`order_sn`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_status` (`order_status`),
  ADD KEY `pay_status` (`pay_status`),
  ADD KEY `pay_id` (`pay_id`);

--
-- Indexes for table `tbl_quas`
--
ALTER TABLE `tbl_quas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_old`
--
ALTER TABLE `tbl_user_old`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_user_unique_phone` (`phone`);

--
-- Indexes for table `tbl_withdraw`
--
ALTER TABLE `tbl_withdraw`
  ADD PRIMARY KEY (`withdraw_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tbl_advertorial`
--
ALTER TABLE `tbl_advertorial`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cart_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- 使用表AUTO_INCREMENT `tbl_collection`
--
ALTER TABLE `tbl_collection`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- 使用表AUTO_INCREMENT `tbl_cooperation`
--
ALTER TABLE `tbl_cooperation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  MODIFY `coupon_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- 使用表AUTO_INCREMENT `tbl_course_category`
--
ALTER TABLE `tbl_course_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- 使用表AUTO_INCREMENT `tbl_course_chapter`
--
ALTER TABLE `tbl_course_chapter`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- 使用表AUTO_INCREMENT `tbl_course_coment`
--
ALTER TABLE `tbl_course_coment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- 使用表AUTO_INCREMENT `tbl_course_news`
--
ALTER TABLE `tbl_course_news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `tbl_course_package`
--
ALTER TABLE `tbl_course_package`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `tbl_course_package_category`
--
ALTER TABLE `tbl_course_package_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `tbl_course_section`
--
ALTER TABLE `tbl_course_section`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- 使用表AUTO_INCREMENT `tbl_data`
--
ALTER TABLE `tbl_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `tbl_friendly_links`
--
ALTER TABLE `tbl_friendly_links`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `tbl_hot_category`
--
ALTER TABLE `tbl_hot_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- 使用表AUTO_INCREMENT `tbl_notice`
--
ALTER TABLE `tbl_notice`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tbl_order_goods`
--
ALTER TABLE `tbl_order_goods`
  MODIFY `rec_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单商品信息自增id', AUTO_INCREMENT=58;
--
-- 使用表AUTO_INCREMENT `tbl_order_info`
--
ALTER TABLE `tbl_order_info`
  MODIFY `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单详细信息自增id', AUTO_INCREMENT=40;
--
-- 使用表AUTO_INCREMENT `tbl_quas`
--
ALTER TABLE `tbl_quas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- 使用表AUTO_INCREMENT `tbl_user_old`
--
ALTER TABLE `tbl_user_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tbl_withdraw`
--
ALTER TABLE `tbl_withdraw`
  MODIFY `withdraw_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 限制导出的表
--

--
-- 限制表 `tbl_auth_assignment`
--
ALTER TABLE `tbl_auth_assignment`
  ADD CONSTRAINT `tbl_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_auth_item`
--
ALTER TABLE `tbl_auth_item`
  ADD CONSTRAINT `tbl_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `tbl_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `tbl_auth_item_child`
--
ALTER TABLE `tbl_auth_item_child`
  ADD CONSTRAINT `tbl_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_course_chapter`
--
ALTER TABLE `tbl_course_chapter`
  ADD CONSTRAINT `tbl_course_chapter_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `tbl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_course_section`
--
ALTER TABLE `tbl_course_section`
  ADD CONSTRAINT `tbl_course_section_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `tbl_course_chapter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_hot_category`
--
ALTER TABLE `tbl_hot_category`
  ADD CONSTRAINT `tbl_hot_category_ibfk_1` FOREIGN KEY (`categoryid`) REFERENCES `tbl_course_category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 限制表 `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD CONSTRAINT `tbl_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `tbl_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

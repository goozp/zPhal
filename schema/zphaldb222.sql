-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 �?09 �?29 �?10:33
-- 服务器版本: 5.5.53
-- PHP 版本: 5.6.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `zphaldb`
--

-- --------------------------------------------------------

--
-- 表的结构 `zp_subjects`
--

CREATE TABLE IF NOT EXISTS `zp_subjects` (
  `subject_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '专题 id',
  `subject_name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '专题名称',
  `subject_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '专题缩略名',
  `subject_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '封面图',
  `subject_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '拥有数量',
  `last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次更新',
  `parent` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='专题表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zp_subject_relationships`
--

CREATE TABLE IF NOT EXISTS `zp_subject_relationships` (
  `object_id` int(11) unsigned NOT NULL DEFAULT '0',
  `subject_id` int(11) unsigned NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`subject_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='专题关系表';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

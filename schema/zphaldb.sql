-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-01-03 09:46:21
-- 服务器版本： 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zphaldb`
--

-- --------------------------------------------------------

--
-- 表的结构 `zp_commentmeta`
--

CREATE TABLE `zp_commentmeta` (
  `meta_id` int(11) UNSIGNED NOT NULL,
  `comment_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `zp_comments`
--

CREATE TABLE `zp_comments` (
  `comment_ID` int(11) UNSIGNED NOT NULL COMMENT '评论id',
  `comment_post_ID` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论的文章id',
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '评论者名称',
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '评论者email',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '评论者链接',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '评论者ip',
  `comment_date` datetime NOT NULL COMMENT '评论时间',
  `comment_date_gmt` datetime NOT NULL COMMENT '评论标准时间',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '评论内容',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '是否通过',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '评论来源agent',
  `comment_parent` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父id',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论者id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `zp_links`
--

CREATE TABLE `zp_links` (
  `link_id` int(11) UNSIGNED NOT NULL COMMENT '链接id',
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接url',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接名称',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接图像地址',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '目标(如_blank)',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接描述',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT '是否可见',
  `link_owner` int(11) UNSIGNED NOT NULL DEFAULT '1' COMMENT '所属用户',
  `link_rating` int(11) NOT NULL DEFAULT '0' COMMENT '评分',
  `link_updated` datetime NOT NULL COMMENT '更新时间',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci COMMENT '备注',
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'rss地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `zp_options`
--

CREATE TABLE `zp_options` (
  `option_id` int(11) UNSIGNED NOT NULL COMMENT '配置id',
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '配置名称',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '对应的值',
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no' COMMENT '是否自动加载'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `zp_options`
--

INSERT INTO `zp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'blogname', '新的ZPhal站点', 'yes'),
(2, 'blogdescription', 'ZPhal为效率而生', 'yes'),
(3, 'siteurl', 'http://zphal.com', 'yes'),
(4, 'admin_email', 'example@example.com', 'yes'),
(5, 'users_can_register', '0', 'yes'),
(6, 'timezone_string', 'Asia/Shanghai', 'yes'),
(7, 'default_category', '1', 'yes'),
(8, 'default_link_category', '0', 'yes'),
(9, 'show_on_front', 'posts', 'yes'),
(10, 'show_on_front_page', '0', 'yes'),
(11, 'posts_per_page', '10', 'yes'),
(12, 'open_XML', '1', 'yes'),
(13, 'post_comment_status', 'open', 'yes'),
(14, 'page_comment_status', 'open', 'yes'),
(15, 'comment_need_register', '0', 'yes'),
(16, 'show_comment_page', '1', 'yes'),
(17, 'comment_per_page', '15', 'yes'),
(18, 'comment_page_first', 'last', 'yes'),
(19, 'comment_page_top', 'new', 'yes'),
(20, 'comment_before_show', 'directly', 'yes'),
(21, 'show_avatar', '1', 'yes'),
(22, 'image_thumbnail_width', '150', 'yes'),
(23, 'image_thumbnail_height', '150', 'yes'),
(24, 'image_medium_width', '300', 'yes'),
(25, 'image_medium_height', '300', 'yes'),
(26, 'image_large_width', '1024', 'yes'),
(27, 'image_large_height', '1024', 'yes'),
(28, 'site_description', '一个新的ZPhal站点', 'yes'),
(29, 'site_keywords', 'ZPhal', 'yes'),
(30, 'footer_copyright', '<p> Copyright © 2017 <a id=\"\" href=\"http://www.goozp.com\" target=\"_blank\">goozp</a> All Rights Reserved. Powered by <a href=\"https://www.gzpblog.com\" target=\"_blank\" rel=\"nofollow\">zPhal</a></p>\r\n\r\n<p><a href=\"http://www.miitbeian.gov.cn/\" target=\"_blank\" rel=\"nofollow\">粤ICP备16013442号</a> | <a href=\"/sitemap.xml\" target=\"_blank\">网站地图</a> | 本站运行于 阿里云</p>', 'yes'),
(31, 'show_project', '1', 'yes');

-- --------------------------------------------------------

--
-- 表的结构 `zp_postmeta`
--

CREATE TABLE `zp_postmeta` (
  `meta_id` int(11) UNSIGNED NOT NULL,
  `post_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `zp_postmeta`
--

INSERT INTO `zp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(26, 2, '_zp_page_template', 'default');

-- --------------------------------------------------------

--
-- 表的结构 `zp_posts`
--

CREATE TABLE `zp_posts` (
  `ID` int(11) UNSIGNED NOT NULL COMMENT 'id',
  `post_author` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发表人id',
  `post_date` datetime NOT NULL COMMENT '发表时间',
  `post_date_gmt` datetime NOT NULL COMMENT '发表GMT标准时间',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'markdown内容',
  `post_html_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'html内容',
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish' COMMENT '状态',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open' COMMENT '评论状态(是否开启)',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '缩略名',
  `post_modified` datetime NOT NULL COMMENT '更新时间',
  `post_modified_gmt` datetime NOT NULL COMMENT '更新GMT标准时间',
  `post_parent` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父id',
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '唯一链接',
  `cover_picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '特色图片',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post' COMMENT '类型',
  `comment_count` int(11) NOT NULL DEFAULT '0' COMMENT '评论数目',
  `view_count` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `zp_posts`
--

INSERT INTO `zp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_html_content`, `post_title`, `post_status`, `comment_status`, `post_name`, `post_modified`, `post_modified_gmt`, `post_parent`, `guid`, `cover_picture`, `post_type`, `comment_count`, `view_count`) VALUES
(1, 1, '2018-01-03 16:42:09', '2018-01-03 08:42:09', '# 欢迎使用ZPhal\r\n这是一篇初始文章！', '<h1 id=\"h1--zphal\"><a name=\"欢迎使用ZPhal\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>欢迎使用ZPhal</h1><p>这是一篇初始文章！</p>\r\n', 'ZPhal测试', 'publish', 'open', '', '2018-01-03 16:42:09', '2018-01-03 08:42:09', 0, '/article/1.html', '', 'post', 0, 0),
(2, 1, '2018-01-03 16:43:36', '2018-01-03 08:43:36', '# 这是一个页面\r\nHello！', '<h1 id=\"h1-u8FD9u662Fu4E00u4E2Au9875u9762\"><a name=\"这是一个页面\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>这是一个页面</h1><p>Hello！</p>\r\n', '默认', 'publish', 'open', 'defaultpage', '2018-01-03 16:43:36', '2018-01-03 08:43:36', 0, '/defaultpage', '', 'page', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `zp_resourcemeta`
--

CREATE TABLE `zp_resourcemeta` (
  `meta_id` int(11) UNSIGNED NOT NULL,
  `resource_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `zp_resources`
--

CREATE TABLE `zp_resources` (
  `resource_id` int(11) UNSIGNED NOT NULL COMMENT '资源id',
  `upload_author` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '拥有者id',
  `upload_date` datetime NOT NULL COMMENT '上传时间',
  `upload_date_gmt` datetime NOT NULL COMMENT '上传GMT时间',
  `resource_content` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '资源说明',
  `resource_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '资源名称',
  `resource_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal' COMMENT '资源状态',
  `resource_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '缩略名',
  `resource_parent` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属父post',
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '唯一链接',
  `resource_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'picture' COMMENT '资源类型',
  `resource_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '资源文件类型'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='资源表';

-- --------------------------------------------------------

--
-- 表的结构 `zp_subjects`
--

CREATE TABLE `zp_subjects` (
  `subject_id` int(11) UNSIGNED NOT NULL COMMENT '专题 id',
  `subject_name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '专题名称',
  `subject_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '专题缩略名',
  `subject_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '封面图',
  `subject_description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '拥有数量',
  `last_updated` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '上次更新',
  `parent` int(11) NOT NULL DEFAULT '0' COMMENT '父id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='专题表';

-- --------------------------------------------------------

--
-- 表的结构 `zp_subject_relationships`
--

CREATE TABLE `zp_subject_relationships` (
  `object_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `subject_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `order_num` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='专题关系表';

-- --------------------------------------------------------

--
-- 表的结构 `zp_termmeta`
--

CREATE TABLE `zp_termmeta` (
  `meta_id` int(11) UNSIGNED NOT NULL COMMENT 'id',
  `term_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类条目id',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '属性名称',
  `meta_value` longtext COLLATE utf8mb4_unicode_ci COMMENT '属性值'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `zp_terms`
--

CREATE TABLE `zp_terms` (
  `term_id` int(11) UNSIGNED NOT NULL COMMENT '条件id',
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '条件名称',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '缩略名',
  `term_group` int(11) NOT NULL DEFAULT '0' COMMENT '分组'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `zp_terms`
--

INSERT INTO `zp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, '未分类', 'uncategorized', 0);

-- --------------------------------------------------------

--
-- 表的结构 `zp_term_relationships`
--

CREATE TABLE `zp_term_relationships` (
  `object_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '对象id',
  `term_taxonomy_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属分类id',
  `term_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `zp_term_relationships`
--

INSERT INTO `zp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `zp_term_taxonomy`
--

CREATE TABLE `zp_term_taxonomy` (
  `term_taxonomy_id` int(11) UNSIGNED NOT NULL COMMENT '分类方式id',
  `term_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '条件id',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类方式',
  `description` longtext COLLATE utf8mb4_unicode_ci COMMENT '描述',
  `parent` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父id',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '拥有的数目'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `zp_term_taxonomy`
--

INSERT INTO `zp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `zp_usermeta`
--

CREATE TABLE `zp_usermeta` (
  `umeta_id` int(11) UNSIGNED NOT NULL COMMENT 'id',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '设置的key',
  `meta_value` longtext COLLATE utf8mb4_unicode_ci COMMENT '设置的value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `zp_usermeta`
--

INSERT INTO `zp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'description', '超级管理员'),
(2, 1, 'session_tokens', '');

-- --------------------------------------------------------

--
-- 表的结构 `zp_users`
--

CREATE TABLE `zp_users` (
  `ID` int(11) UNSIGNED NOT NULL COMMENT 'id',
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '登录帐号',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '登录密码',
  `user_nickname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '主页链接',
  `user_registered` datetime NOT NULL COMMENT '注册时间',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '激活码',
  `user_status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '展示名称',
  `user_role` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'subscriber' COMMENT '用户角色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `zp_users`
--

INSERT INTO `zp_users` (`ID`, `user_login`, `user_pass`, `user_nickname`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`, `user_role`) VALUES
(1, 'admin', '$2y$08$eGNKcS83Y21SRjh6Y1F0Ze2AX2nTpe3xAhZaEvJBmgFfnb/JBFK5i', 'admin', 'example@example.com', '', '2018-01-03 16:35:28', '', 0, 'admin', 'administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zp_commentmeta`
--
ALTER TABLE `zp_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `zp_comments`
--
ALTER TABLE `zp_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Indexes for table `zp_links`
--
ALTER TABLE `zp_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Indexes for table `zp_options`
--
ALTER TABLE `zp_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`);

--
-- Indexes for table `zp_postmeta`
--
ALTER TABLE `zp_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `zp_posts`
--
ALTER TABLE `zp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `zp_resourcemeta`
--
ALTER TABLE `zp_resourcemeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `resource_id` (`resource_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `zp_resources`
--
ALTER TABLE `zp_resources`
  ADD PRIMARY KEY (`resource_id`),
  ADD KEY `resource_parent` (`resource_parent`),
  ADD KEY `resource_name` (`resource_name`(191)),
  ADD KEY `resource_type` (`resource_type`,`resource_status`,`upload_date`,`resource_id`);

--
-- Indexes for table `zp_subjects`
--
ALTER TABLE `zp_subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `zp_subject_relationships`
--
ALTER TABLE `zp_subject_relationships`
  ADD PRIMARY KEY (`object_id`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `zp_termmeta`
--
ALTER TABLE `zp_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `zp_terms`
--
ALTER TABLE `zp_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Indexes for table `zp_term_relationships`
--
ALTER TABLE `zp_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Indexes for table `zp_term_taxonomy`
--
ALTER TABLE `zp_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Indexes for table `zp_usermeta`
--
ALTER TABLE `zp_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `zp_users`
--
ALTER TABLE `zp_users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `user_login` (`user_login`),
  ADD UNIQUE KEY `user_email_2` (`user_email`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nickname`),
  ADD KEY `user_email` (`user_email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `zp_commentmeta`
--
ALTER TABLE `zp_commentmeta`
  MODIFY `meta_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `zp_comments`
--
ALTER TABLE `zp_comments`
  MODIFY `comment_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '评论id';
--
-- 使用表AUTO_INCREMENT `zp_links`
--
ALTER TABLE `zp_links`
  MODIFY `link_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '链接id';
--
-- 使用表AUTO_INCREMENT `zp_options`
--
ALTER TABLE `zp_options`
  MODIFY `option_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置id', AUTO_INCREMENT=32;
--
-- 使用表AUTO_INCREMENT `zp_postmeta`
--
ALTER TABLE `zp_postmeta`
  MODIFY `meta_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- 使用表AUTO_INCREMENT `zp_posts`
--
ALTER TABLE `zp_posts`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `zp_resourcemeta`
--
ALTER TABLE `zp_resourcemeta`
  MODIFY `meta_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `zp_resources`
--
ALTER TABLE `zp_resources`
  MODIFY `resource_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '资源id';
--
-- 使用表AUTO_INCREMENT `zp_subjects`
--
ALTER TABLE `zp_subjects`
  MODIFY `subject_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '专题 id';
--
-- 使用表AUTO_INCREMENT `zp_termmeta`
--
ALTER TABLE `zp_termmeta`
  MODIFY `meta_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';
--
-- 使用表AUTO_INCREMENT `zp_terms`
--
ALTER TABLE `zp_terms`
  MODIFY `term_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '条件id', AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `zp_term_taxonomy`
--
ALTER TABLE `zp_term_taxonomy`
  MODIFY `term_taxonomy_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类方式id', AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `zp_usermeta`
--
ALTER TABLE `zp_usermeta`
  MODIFY `umeta_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `zp_users`
--
ALTER TABLE `zp_users`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

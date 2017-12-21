-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-21 11:10:31
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

--
-- 转存表中的数据 `zp_links`
--

INSERT INTO `zp_links` (`link_id`, `link_url`, `link_name`, `link_image`, `link_target`, `link_description`, `link_visible`, `link_owner`, `link_rating`, `link_updated`, `link_notes`, `link_rss`) VALUES
(1, 'http://www.a.com', 'guo', '', '', '', 'Y', 13, 0, '2017-11-23 08:20:25', '', ''),
(2, 'https://regex101.com/2', 'Fotor2', 'https://regex101.com/2', '_top', '爱仕达2', 'N', 13, 0, '2017-11-23 08:04:48', 'https://regex101.com/2', 'https://regex101.com/2'),
(3, 'https://www.processon.com/', 'ProcessOn', '', '', '开源中国开发设计人员在线工具', 'Y', 13, 0, '2017-11-22 05:00:01', '', ''),
(4, 'http://study.163.com/', 'Stack Overflow', '', '', '基佬聚集地', 'N', 13, 0, '2017-11-23 08:20:12', '', ''),
(5, 'https://www.fotor.com.cn/', 'a', '', '_blank', '', 'Y', 13, 0, '2017-12-05 11:58:48', '', '');

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
(3, 'siteurl', 'http://localhost/zphal', 'yes'),
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
(30, 'footer_copyright', '<p> Copyright © 2017 <a id=\"\" href=\"http://www.goozp.com\" target=\"_blank\">goozp</a> All Rights Reserved. Powered by <a href=\"https://www.gzpblog.com\" target=\"_blank\" rel=\"nofollow\">zPhal</a></p>\r\n\r\n<p><a href=\"http://www.miitbeian.gov.cn/\" target=\"_blank\" rel=\"nofollow\">粤ICP备16013442号</a> | <a href=\"/sitemap.xml\" target=\"_blank\">网站地图</a> | 本站运行于 阿里云</p>', 'yes');

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
(1, 2, '_wp_page_template', 'l'),
(2, 42, 'description', '保存草稿'),
(3, 44, 'description', 'jjj'),
(4, 46, 'description', '1122'),
(14, 52, '_zp_page_template', 'default'),
(15, 52, 'description', '测试页面'),
(16, 2, 'description', ''),
(17, 2, '_zp_trash_meta_time', '1513221893'),
(18, 2, '_zp_trash_meta_status', 'publish'),
(19, 54, '_zp_page_template', 'default'),
(20, 54, 'description', ''),
(21, 10, '_zp_trash_meta_time', '1513839572'),
(22, 10, '_zp_trash_meta_status', 'publish'),
(23, 53, 'description', '即更长的单词或短语的缩写形式，前提是开启识别HTML标签时，已默认开启');

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
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件类型',
  `comment_count` int(11) NOT NULL DEFAULT '0' COMMENT '评论数目',
  `view_count` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `zp_posts`
--

INSERT INTO `zp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_html_content`, `post_title`, `post_status`, `comment_status`, `post_name`, `post_modified`, `post_modified_gmt`, `post_parent`, `guid`, `cover_picture`, `post_type`, `post_mime_type`, `comment_count`, `view_count`) VALUES
(1, 1, '2017-08-23 00:13:01', '2017-08-22 16:13:01', '欢迎使用WordPress。这是您的第一篇文章。编辑或删除它，然后开始写作吧！', '<p>欢迎使用WordPress。这是您的第一篇文章。编辑或删除它，然后开始写作吧！</p>\r\n', '世界，您好！', 'publish', 'open', 'hello-world', '2017-12-21 17:40:29', '2017-12-21 09:40:29', 0, 'http://localhost/wordpress/?p=1', '', 'post', '', 1, 0),
(2, 1, '2017-08-23 00:13:01', '2017-08-22 16:13:01', '这是示范页面。页面和博客文章不同，它的位置是固定的，通常会在站点导航栏显示。很多用户都创建一个“关于”页面，向访客介绍自己。例如：\r\n\r\n> 欢迎！我白天是个邮递员，晚上就是个有抱负的演员。这是我的博客。我住在天朝的帝都，有条叫做Jack的狗。\r\n\r\n……或这个：\r\n\r\n> XYZ Doohickey公司成立于1971年，自从建立以来，我们一直向社会贡献着优秀doohickies。我们的公司总部位于天朝魔都，有着超过两千名员工，对魔都政府税收有着巨大贡献。\r\n\r\n而您，作为一个WordPress用户，我们建议您访问，删除本页面，然后添加您自己的页面。祝您使用愉快！', '<p>这是示范页面。页面和博客文章不同，它的位置是固定的，通常会在站点导航栏显示。很多用户都创建一个“关于”页面，向访客介绍自己。例如：</p>\r\n<blockquote>\r\n<p>欢迎！我白天是个邮递员，晚上就是个有抱负的演员。这是我的博客。我住在天朝的帝都，有条叫做Jack的狗。</p>\r\n</blockquote>\r\n<p>……或这个：</p>\r\n<blockquote>\r\n<p>XYZ Doohickey公司成立于1971年，自从建立以来，我们一直向社会贡献着优秀doohickies。我们的公司总部位于天朝魔都，有着超过两千名员工，对魔都政府税收有着巨大贡献。</p>\r\n</blockquote>\r\n<p>而您，作为一个WordPress用户，我们建议您访问，删除本页面，然后添加您自己的页面。祝您使用愉快！</p>\r\n', '示例页面', 'trash', 'closed', 'sample-page', '2017-12-14 11:24:27', '2017-12-14 03:24:27', 0, '/page/sample-page', '', 'page', '', 0, 0),
(3, 1, '2017-08-23 00:13:19', '0000-00-00 00:00:00', '', '', '自动草稿', 'auto-draft', 'open', '', '2017-08-23 00:13:19', '0000-00-00 00:00:00', 0, 'http://localhost/wordpress/?p=3', '', 'post', '', 0, 0),
(4, 13, '2017-10-23 09:07:56', '2017-10-23 09:07:56', '# 啊是大大\r\n123\r\n123\r\n123444', '', '啊哈', 'publish', 'open', '', '2017-10-23 09:07:56', '2017-10-23 09:07:56', 0, '', '', 'post', '', 0, 0),
(5, 13, '2017-10-24 03:00:37', '2017-10-24 03:00:37', '啊哈啊哈啊哈啊哈啊哈啊哈', '', '啊哈啊哈', 'draft', 'open', '', '2017-10-24 03:00:37', '2017-10-24 03:00:37', 0, '', '', 'post', '', 0, 0),
(6, 13, '2017-10-24 09:28:20', '2017-10-24 09:28:20', '# 啊啊啊啊嗄\n可以啊\n!!!\n', '', '测试', 'auto-draft', 'open', '', '2017-10-24 09:28:20', '2017-10-24 09:28:20', 0, '/article/6.html', '', 'post', '', 0, 0),
(7, 13, '2017-10-30 04:05:44', '2017-10-30 04:05:44', '# 测试计数\r\n测试计数', '', '测试计数', 'publish', 'open', '', '2017-10-30 04:05:44', '2017-10-30 04:05:44', 0, '', '', 'post', '', 0, 0),
(8, 13, '2017-10-30 04:09:21', '2017-10-30 04:09:21', '# 测试分类again\r\n测试分类again', '', '测试分类again', 'publish', 'open', '', '2017-10-30 04:09:21', '2017-10-30 04:09:21', 0, '', '', 'post', '', 0, 0),
(9, 13, '2017-10-30 04:13:12', '2017-10-30 04:13:12', '###### 测试叠加\r\n测试叠加', '', '测试叠加', 'publish', 'open', '', '2017-10-30 04:13:12', '2017-10-30 04:13:12', 0, '', '', 'post', '', 0, 0),
(10, 13, '2017-12-21 16:50:23', '2017-12-21 08:50:23', '# 测试URL\r\n测试URL测试URL', '<h1 id=\"h1--url\"><a name=\"测试URL\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>测试URL</h1><p>测试URL测试URL</p>\r\n', '测试URL', 'trash', 'open', '', '2017-12-21 14:59:08', '2017-12-21 06:59:08', 0, '', '', 'post', '', 0, 0),
(11, 13, '2017-10-30 08:55:26', '2017-10-30 08:55:26', '# 测试URL\n测试URL测试URL', '', '测试URL', 'auto-draft', 'open', '', '2017-10-30 08:55:26', '2017-10-30 08:55:26', 0, '', '', 'post', '', 0, 0),
(12, 13, '2017-10-30 08:57:26', '2017-10-30 08:57:26', '# 测试URL\n测试URL测试URL', '', '测试URL', 'auto-draft', 'open', '', '2017-10-30 08:57:26', '2017-10-30 08:57:26', 0, '', '', 'post', '', 0, 0),
(13, 13, '2017-10-30 08:59:26', '2017-10-30 08:59:26', '# 测试URL\n测试URL测试URL', '', '测试URL', 'auto-draft', 'open', '', '2017-10-30 08:59:26', '2017-10-30 08:59:26', 0, '', '', 'post', '', 0, 0),
(14, 13, '2017-10-30 09:01:25', '2017-10-30 09:01:25', '# 测试URL\n测试URL测试URL', '', '测试URL', 'auto-draft', 'open', '', '2017-10-30 09:01:25', '2017-10-30 09:01:25', 0, '', '', 'post', '', 0, 0),
(15, 13, '2017-09-27 01:05:08', '2017-09-27 01:05:08', 'utlutl', '', 'utlutlutl', 'publish', 'open', '', '2017-09-27 01:05:08', '2017-09-27 01:05:08', 0, '', '', 'post', '', 0, 0),
(16, 13, '2017-10-30 09:13:34', '2017-10-30 09:13:34', 'aaaaa', '', 'aaaaa', 'publish', 'open', '', '2017-10-30 09:13:34', '2017-10-30 09:13:34', 0, '', '', 'post', '', 0, 0),
(17, 13, '2017-10-30 09:16:07', '2017-10-30 09:16:07', '测试di utl测试di utl', '', '测试di utl', 'publish', 'open', '', '2017-10-30 09:16:07', '2017-10-30 09:16:07', 0, '', '', 'post', '', 0, 0),
(18, 13, '2017-10-30 09:17:29', '2017-10-30 09:17:29', '测试 测his', '', '测试 测his', 'publish', 'open', '', '2017-10-30 09:17:29', '2017-10-30 09:17:29', 0, '/article/18.html', '', 'post', '', 0, 0),
(19, 13, '2017-10-30 09:25:53', '2017-10-30 09:25:53', '测试 测hisaa', '', '测试 测hisaa', 'publish', 'open', '', '2017-10-30 09:25:53', '2017-10-30 09:25:53', 0, '', '', 'post', '', 0, 0),
(20, 13, '2017-10-30 09:33:59', '2017-10-30 09:33:59', '/ 生成连接', '', '/ 生成连接', 'publish', 'open', '', '2017-10-30 09:33:59', '2017-10-30 09:33:59', 0, '/article/20.html', '', 'post', '', 0, 0),
(21, 13, '2017-10-30 09:45:45', '2017-10-30 09:45:45', '# generateUrl\r\n## generateUrlgenerateUrlgenerateUrlgenerateUrlgenerateUrl\r\n', '', 'generateUrl', 'publish', 'open', '', '2017-10-30 09:45:45', '2017-10-30 09:45:45', 0, '/article/21.html', '', 'post', '', 0, 0),
(22, 13, '2017-10-30 10:06:39', '2017-10-30 10:06:39', 'asdadasd', '', '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊大大亲亲我我我我我我我WAd啊大大的哇啊啊啊啊啊的祈晴娃娃A网单位', 'publish', 'open', '', '2017-10-30 10:06:39', '2017-10-30 10:06:39', 0, '/article/22.html', 'https://www.gzpblog.com/wp-content/themes/SaltedFish/public/images/jumbotron_self.png', 'post', '', 0, 0),
(23, 13, '2017-10-30 10:33:22', '2017-10-30 10:33:22', 'utlutlutlutlutlutlutlutlutlutlutlutl', '', 'utlutlutlutlutlutl', 'publish', 'open', '', '2017-10-30 10:33:22', '2017-10-30 10:33:22', 0, '/article/23.html', '', 'post', '', 0, 0),
(24, 13, '2017-10-30 10:36:29', '2017-10-30 10:36:29', 'kekeke', '', 'kekkk', 'publish', 'open', '', '2017-10-30 10:36:29', '2017-10-30 10:36:29', 0, '/article/24.html', '', 'post', '', 0, 0),
(25, 13, '2017-10-31 02:32:04', '2017-10-31 02:32:04', 'print_r($allId);', '', '啊哈啊哈', 'publish', 'open', '', '2017-10-31 02:32:04', '2017-10-31 02:32:04', 0, '/article/25.html', '', 'post', '', 0, 0),
(26, 13, '2017-10-31 02:52:12', '2017-10-31 02:52:12', 'print_r($allId);', '', '啊哈啊哈', 'publish', 'open', '', '2017-10-31 02:52:12', '2017-10-31 02:52:12', 0, '/article/26.html', '', 'post', '', 0, 0),
(27, 13, '2017-10-31 02:53:05', '2017-10-31 02:53:05', 'testtest', '', 'testtest', 'publish', 'open', '', '2017-10-31 02:53:05', '2017-10-31 02:53:05', 0, '/article/27.html', '', 'post', '', 0, 0),
(28, 13, '2017-10-31 03:00:34', '2017-10-31 03:00:34', '啊哈', '', '啊哈', 'publish', 'open', '', '2017-10-31 03:00:34', '2017-10-31 03:00:34', 0, '/article/28.html', '', 'post', '', 0, 0),
(29, 13, '2017-10-31 03:02:16', '2017-10-31 03:02:16', 'asdasd', '', '啊哈啊哈', 'publish', 'open', '', '2017-11-13 08:52:46', '2017-11-13 08:52:46', 0, '/article/29.html', '', 'post', '', 0, 0),
(30, 13, '2017-10-31 03:33:13', '2017-10-31 03:33:13', '啊哈', '', '啊哈', 'publish', 'open', '', '2017-10-31 03:33:13', '2017-10-31 03:33:13', 0, '/article/30.html', '', 'post', '', 0, 0),
(31, 13, '2017-10-31 03:34:39', '2017-10-31 03:34:39', '啊哈', '', '啊哈', 'publish', 'open', '', '2017-10-31 03:34:39', '2017-10-31 03:34:39', 0, '/article/31.html', '', 'post', '', 0, 0),
(33, 13, '2017-10-31 03:45:05', '2017-10-31 03:45:05', 'asdasd', '', 'asdasda', 'publish', 'open', '', '2017-10-31 03:45:05', '2017-10-31 03:45:05', 0, '/article/33.html', '', 'post', '', 0, 0),
(34, 13, '2017-10-31 04:06:59', '2017-10-31 04:06:59', 'asdasd', '', 'asdasda', 'publish', 'open', '', '2017-10-31 04:06:59', '2017-10-31 04:06:59', 0, '/article/34.html', '', 'post', '', 0, 0),
(35, 13, '2017-10-31 04:07:31', '2017-10-31 04:07:31', 'asdasd', '', 'asdasda', 'publish', 'open', '', '2017-10-31 04:07:31', '2017-10-31 04:07:31', 0, '/article/35.html', '', 'post', '', 0, 0),
(37, 13, '2017-10-31 04:15:30', '2017-10-31 04:15:30', 'asd', '', '啊哈', 'publish', 'open', '', '2017-10-31 04:15:30', '2017-10-31 04:15:30', 0, '/article/37.html', '', 'post', '', 0, 0),
(38, 13, '2017-11-10 15:14:44', '2017-11-10 15:14:44', '啊哈啊哈啊哈啊哈', '', '啊哈啊哈', 'publish', 'open', '', '2017-11-10 10:29:14', '2017-11-10 10:29:14', 0, '/article/38.html', '', 'post', '', 0, 0),
(39, 13, '2017-11-07 10:21:59', '2017-11-07 10:21:59', 'asdaasd', '', 'sdasda', 'publish', 'open', '', '2017-11-07 10:21:59', '2017-11-07 10:21:59', 0, '/article/39.html', '', 'post', '', 0, 0),
(40, 13, '1000-01-01 00:00:00', '1000-01-01 00:00:00', '草稿草稿', '', '草稿', 'draft', 'open', '', '2017-11-07 10:26:35', '2017-11-07 10:26:35', 0, '/article/40.html', '', 'post', '', 0, 0),
(41, 13, '2017-11-10 15:31:17', '2017-11-10 15:31:17', '123123', '', '更新资料时,学校没法填', 'publish', 'open', '', '2017-11-10 07:37:20', '2017-11-10 07:37:20', 0, '/article/41.html', '', 'post', '', 0, 0),
(42, 13, '2017-08-10 07:38:10', '2017-08-09 23:38:10', '保存草稿', '<p>保存草稿</p>\r\n', '保存草稿', 'publish', 'open', '', '2017-12-21 17:39:08', '2017-12-21 09:39:08', 0, '/article/42.html', '', 'post', '', 0, 0),
(43, 13, '2017-02-10 15:28:48', '2017-02-10 15:28:48', '# 保存草稿iooooasdasd', '', '保存草稿oasdasdasdad', 'draft', 'open', '', '2017-11-14 09:19:46', '2017-11-14 09:19:46', 0, '/article/43.html', '', 'post', '', 0, 0),
(44, 13, '2017-11-10 08:23:12', '2017-11-10 07:23:12', '阿萨', '', '啊啊啊', 'publish', 'open', '', '2017-11-23 08:48:11', '2017-11-23 07:48:11', 0, '/article/44.html', '', 'post', '', 0, 0),
(45, 13, '2017-11-20 11:11:27', '2017-11-20 10:11:27', '888', '', '888', 'publish', 'open', '', '2017-11-20 11:14:14', '2017-11-20 10:14:14', 0, '/article/45.html', '', 'post', '', 0, 0),
(46, 13, '2017-11-10 09:46:09', '2017-11-10 08:46:09', ' 1122', '', '1122', 'publish', 'open', '', '2017-11-23 08:48:31', '2017-11-23 07:48:31', 0, '/article/46.html', '', 'post', '', 0, 0),
(51, 13, '2017-11-23 07:47:59', '2017-11-22 23:47:59', '阿萨', '<p>阿萨</p>\r\n', '啊打算', 'publish', 'open', '', '2017-12-21 16:13:15', '2017-12-21 08:13:15', 0, '/article/51.html', '', 'post', '', 0, 0),
(52, 13, '2017-12-05 15:02:27', '2017-12-05 07:02:27', '# 测试页面测试页面', '<h1 id=\"h1-u6D4Bu8BD5u9875u9762u6D4Bu8BD5u9875u9762\"><a name=\"测试页面测试页面\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>测试页面测试页面</h1>', '测试页面', 'publish', 'open', 'test', '2017-12-14 11:24:44', '2017-12-14 03:24:44', 0, '/page/test', '', 'page', '', 0, 0),
(53, 13, '2017-12-12 11:51:07', '2017-12-12 03:51:07', '## Heading 2               \r\n### Heading 3\r\n#### Heading 4\r\n##### Heading 5\r\n###### Heading 6\r\n\r\n## Heading 2 link [Heading link](https://github.com/pandao/editor.md \"Heading link\")\r\n### Heading 3 link [Heading link](https://github.com/pandao/editor.md \"Heading link\")\r\n#### Heading 4 link [Heading link](https://github.com/pandao/editor.md \"Heading link\") Heading link [Heading link](https://github.com/pandao/editor.md \"Heading link\")\r\n##### Heading 5 link [Heading link](https://github.com/pandao/editor.md \"Heading link\")\r\n###### Heading 6 link [Heading link](https://github.com/pandao/editor.md \"Heading link\")\r\n\r\n#### 标题（用底线的形式）Heading (underline)\r\n\r\n\r\nThis is an H2\r\n-------------\r\n\r\n### 字符效果和横线等\r\n                \r\n----\r\n\r\n~~删除线~~ <s>删除线（开启识别HTML标签时）</s>\r\n*斜体字*      _斜体字_\r\n**粗体**  __粗体__\r\n***粗斜体*** ___粗斜体___\r\n\r\n上标：X<sub>2</sub>，下标：O<sup>2</sup>\r\n\r\n**缩写(同HTML的abbr标签)**\r\n\r\n> 即更长的单词或短语的缩写形式，前提是开启识别HTML标签时，已默认开启\r\n\r\nThe <abbr title=\"Hyper Text Markup Language\">HTML</abbr> specification is maintained by the <abbr title=\"World Wide Web Consortium\">W3C</abbr>.\r\n\r\n### 引用 Blockquotes\r\n\r\n> 引用文本 Blockquotes\r\n\r\n引用的行内混合 Blockquotes\r\n                    \r\n> 引用：如果想要插入空白换行`即<br />标签`，在插入处先键入两个以上的空格然后回车即可，[普通链接](http://localhost/)。\r\n\r\n### 锚点与链接 Links\r\n\r\n[普通链接](http://localhost/)\r\n\r\n[普通链接带标题](http://localhost/ \"普通链接带标题\")\r\n\r\n直接链接：<https://github.com>\r\n\r\n[锚点链接][anchor-id] \r\n\r\n[anchor-id]: http://www.this-anchor-link.com/\r\n\r\n[mailto:test.test@gmail.com](mailto:test.test@gmail.com)\r\n\r\nGFM a-tail link @pandao  邮箱地址自动链接 test.test@gmail.com  www@vip.qq.com\r\n\r\n> @pandao\r\n\r\n### 多语言代码高亮 Codes\r\n\r\n#### 行内代码 Inline code\r\n\r\n执行命令：`npm install marked`\r\n\r\n#### 缩进风格\r\n\r\n即缩进四个空格，也做为实现类似 `<pre>` 预格式化文本 ( Preformatted Text ) 的功能。\r\n\r\n    <?php\r\n        echo \"Hello world!\";\r\n    ?>\r\n    \r\n预格式化文本：\r\n\r\n    | First Header  | Second Header |\r\n    | ------------- | ------------- |\r\n    | Content Cell  | Content Cell  |\r\n    | Content Cell  | Content Cell  |\r\n\r\n#### JS代码　\r\n\r\n```javascript\r\nfunction test() {\r\n	console.log(\"Hello world!\");\r\n}\r\n \r\n(function(){\r\n    var box = function() {\r\n        return box.fn.init();\r\n    };\r\n\r\n    box.prototype = box.fn = {\r\n        init : function(){\r\n            console.log(\'box.init()\');\r\n\r\n			return this;\r\n        },\r\n\r\n		add : function(str) {\r\n			alert(\"add\", str);\r\n\r\n			return this;\r\n		},\r\n\r\n		remove : function(str) {\r\n			alert(\"remove\", str);\r\n\r\n			return this;\r\n		}\r\n    };\r\n    \r\n    box.fn.init.prototype = box.fn;\r\n    \r\n    window.box =box;\r\n})();\r\n\r\nvar testBox = box();\r\ntestBox.add(\"jQuery\").remove(\"jQuery\");\r\n```\r\n\r\n#### HTML 代码 HTML codes\r\n\r\n```html\r\n<!DOCTYPE html>\r\n<html>\r\n    <head>\r\n        <mate charest=\"utf-8\" />\r\n        <meta name=\"keywords\" content=\"Editor.md, Markdown, Editor\" />\r\n        <title>Hello world!</title>\r\n        <style type=\"text/css\">\r\n            body{font-size:14px;color:#444;font-family: \"Microsoft Yahei\", Tahoma, \"Hiragino Sans GB\", Arial;background:#fff;}\r\n            ul{list-style: none;}\r\n            img{border:none;vertical-align: middle;}\r\n        </style>\r\n    </head>\r\n    <body>\r\n        <h1 class=\"text-xxl\">Hello world!</h1>\r\n        <p class=\"text-green\">Plain text</p>\r\n    </body>\r\n</html>\r\n```\r\n\r\n### 图片 Images\r\n\r\nImage:\r\n\r\n![](https://pandao.github.io/editor.md/examples/images/4.jpg)\r\n\r\n> Follow your heart.\r\n\r\n![](https://pandao.github.io/editor.md/examples/images/8.jpg)\r\n\r\n> 图为：厦门白城沙滩\r\n\r\n图片加链接 (Image + Link)：\r\n\r\n[![](https://pandao.github.io/editor.md/examples/images/7.jpg)](https://pandao.github.io/editor.md/images/7.jpg \"李健首张专辑《似水流年》封面\")\r\n\r\n> 图为：李健首张专辑《似水流年》封面\r\n                \r\n----\r\n\r\n### 列表 Lists\r\n\r\n#### 无序列表（减号）Unordered Lists (-)\r\n                \r\n- 列表一\r\n- 列表二\r\n- 列表三\r\n     \r\n#### 无序列表（星号）Unordered Lists (*)\r\n\r\n* 列表一\r\n* 列表二\r\n* 列表三\r\n\r\n#### 无序列表（加号和嵌套）Unordered Lists (+)\r\n                \r\n+ 列表一\r\n+ 列表二\r\n    + 列表二-1\r\n    + 列表二-2\r\n    + 列表二-3\r\n+ 列表三\r\n    * 列表一\r\n    * 列表二\r\n    * 列表三\r\n\r\n#### 有序列表 Ordered Lists (-)\r\n                \r\n1. 第一行\r\n2. 第二行\r\n3. 第三行\r\n\r\n#### GFM task list\r\n\r\n- [x] GFM task list 1\r\n- [x] GFM task list 2\r\n- [ ] GFM task list 3\r\n    - [ ] GFM task list 3-1\r\n    - [ ] GFM task list 3-2\r\n    - [ ] GFM task list 3-3\r\n- [ ] GFM task list 4\r\n    - [ ] GFM task list 4-1\r\n    - [ ] GFM task list 4-2\r\n                \r\n----\r\n                    \r\n### 绘制表格 Tables\r\n\r\n| 项目        | 价格   |  数量  |\r\n| --------   | -----:  | :----:  |\r\n| 计算机      | $1600   |   5     |\r\n| 手机        |   $12   |   12   |\r\n| 管线        |    $1    |  234  |\r\n                    \r\nFirst Header  | Second Header\r\n------------- | -------------\r\nContent Cell  | Content Cell\r\nContent Cell  | Content Cell \r\n\r\n| First Header  | Second Header |\r\n| ------------- | ------------- |\r\n| Content Cell  | Content Cell  |\r\n| Content Cell  | Content Cell  |\r\n\r\n| Function name | Description                    |\r\n| ------------- | ------------------------------ |\r\n| `help()`      | Display the help window.       |\r\n| `destroy()`   | **Destroy your computer!**     |\r\n\r\n| Left-Aligned  | Center Aligned  | Right Aligned |\r\n| :------------ |:---------------:| -----:|\r\n| col 3 is      | some wordy text | $1600 |\r\n| col 2 is      | centered        |   $12 |\r\n| zebra stripes | are neat        |    $1 |\r\n\r\n| Item      | Value |\r\n| --------- | -----:|\r\n| Computer  | $1600 |\r\n| Phone     |   $12 |\r\n| Pipe      |    $1 |\r\n\r\n', '<h2 id=\"h2-heading-2\"><a name=\"Heading 2\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>Heading 2</h2><h3 id=\"h3-heading-3\"><a name=\"Heading 3\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>Heading 3</h3><h4 id=\"h4-heading-4\"><a name=\"Heading 4\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>Heading 4</h4><h5 id=\"h5-heading-5\"><a name=\"Heading 5\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>Heading 5</h5><h6 id=\"h6-heading-6\"><a name=\"Heading 6\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>Heading 6</h6><h2 id=\"h2-heading-2-link-heading-link\"><a name=\"Heading 2 link   Heading link\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>Heading 2 link <a href=\"https://github.com/pandao/editor.md\" title=\"Heading link\">Heading link</a></h2><h3 id=\"h3-heading-3-link-heading-link\"><a name=\"Heading 3 link   Heading link\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>Heading 3 link <a href=\"https://github.com/pandao/editor.md\" title=\"Heading link\">Heading link</a></h3><h4 id=\"h4-heading-4-link-heading-link-heading-link-heading-link\"><a name=\"Heading 4 link   Heading link  Heading link   Heading link\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>Heading 4 link <a href=\"https://github.com/pandao/editor.md\" title=\"Heading link\">Heading link</a> Heading link <a href=\"https://github.com/pandao/editor.md\" title=\"Heading link\">Heading link</a></h4><h5 id=\"h5-heading-5-link-heading-link\"><a name=\"Heading 5 link   Heading link\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>Heading 5 link <a href=\"https://github.com/pandao/editor.md\" title=\"Heading link\">Heading link</a></h5><h6 id=\"h6-heading-6-link-heading-link\"><a name=\"Heading 6 link   Heading link\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>Heading 6 link <a href=\"https://github.com/pandao/editor.md\" title=\"Heading link\">Heading link</a></h6><h4 id=\"h4--heading-underline-\"><a name=\"标题（用底线的形式）Heading (underline)\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>标题（用底线的形式）Heading (underline)</h4><h2 id=\"h2-this-is-an-h2\"><a name=\"This is an H2\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>This is an H2</h2><h3 id=\"h3-u5B57u7B26u6548u679Cu548Cu6A2Au7EBFu7B49\"><a name=\"字符效果和横线等\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>字符效果和横线等</h3><hr>\r\n<p><del>删除线</del> &lt;s&gt;删除线（开启识别HTML标签时）&lt;/s&gt;<br><em>斜体字</em>      <em>斜体字</em><br><strong>粗体</strong>  <strong>粗体</strong><br><strong><em>粗斜体</em></strong> <strong><em>粗斜体</em></strong></p>\r\n<p>上标：X&lt;sub&gt;2&lt;/sub&gt;，下标：O&lt;sup&gt;2&lt;/sup&gt;</p>\r\n<p><strong>缩写(同HTML的abbr标签)</strong></p>\r\n<blockquote>\r\n<p>即更长的单词或短语的缩写形式，前提是开启识别HTML标签时，已默认开启</p>\r\n</blockquote>\r\n<p>The &lt;abbr title=&quot;Hyper Text Markup Language&quot;&gt;HTML&lt;/abbr&gt; specification is maintained by the &lt;abbr title=&quot;World Wide Web Consortium&quot;&gt;W3C&lt;/abbr&gt;.</p>\r\n<h3 id=\"h3--blockquotes\"><a name=\"引用 Blockquotes\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>引用 Blockquotes</h3><blockquote>\r\n<p>引用文本 Blockquotes</p>\r\n</blockquote>\r\n<p>引用的行内混合 Blockquotes</p>\r\n<blockquote>\r\n<p>引用：如果想要插入空白换行<code>即&lt;br /&gt;标签</code>，在插入处先键入两个以上的空格然后回车即可，<a href=\"http://localhost/\">普通链接</a>。</p>\r\n</blockquote>\r\n<h3 id=\"h3--links\"><a name=\"锚点与链接 Links\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>锚点与链接 Links</h3><p><a href=\"http://localhost/\">普通链接</a></p>\r\n<p><a href=\"http://localhost/\" title=\"普通链接带标题\">普通链接带标题</a></p>\r\n<p>直接链接：<a href=\"https://github.com\">https://github.com</a></p>\r\n<p><a href=\"http://www.this-anchor-link.com/\">锚点链接</a> </p>\r\n<p><a href=\"mailto:test.test@gmail.com\"\">mailto:test.test&#64;gmail.com</a></p>\r\n<p>GFM a-tail link <a href=\"https://github.com/pandao\" title=\"&#64;pandao\" class=\"at-link\">@pandao</a>  邮箱地址自动链接 <a href=\"mailto:test.test@gmail.com\">test.test@gmail.com</a>  <a href=\"mailto:www@vip.qq.com\">www@vip.qq.com</a></p>\r\n<blockquote>\r\n<p><a href=\"https://github.com/pandao\" title=\"&#64;pandao\" class=\"at-link\">@pandao</a></p>\r\n</blockquote>\r\n<h3 id=\"h3--codes\"><a name=\"多语言代码高亮 Codes\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>多语言代码高亮 Codes</h3><h4 id=\"h4--inline-code\"><a name=\"行内代码 Inline code\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>行内代码 Inline code</h4><p>执行命令：<code>npm install marked</code></p>\r\n<h4 id=\"h4-u7F29u8FDBu98CEu683C\"><a name=\"缩进风格\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>缩进风格</h4><p>即缩进四个空格，也做为实现类似 <code>&lt;pre&gt;</code> 预格式化文本 ( Preformatted Text ) 的功能。</p>\r\n<pre><code>&lt;?php\r\n    echo &quot;Hello world!&quot;;\r\n?&gt;\r\n</code></pre><p>预格式化文本：</p>\r\n<pre><code>| First Header  | Second Header |\r\n| ------------- | ------------- |\r\n| Content Cell  | Content Cell  |\r\n| Content Cell  | Content Cell  |\r\n</code></pre><h4 id=\"h4-js-\"><a name=\"JS代码\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>JS代码　</h4><pre><code class=\"lang-javascript\">function test() {\r\n    console.log(&quot;Hello world!&quot;);\r\n}\r\n\r\n(function(){\r\n    var box = function() {\r\n        return box.fn.init();\r\n    };\r\n\r\n    box.prototype = box.fn = {\r\n        init : function(){\r\n            console.log(&#39;box.init()&#39;);\r\n\r\n            return this;\r\n        },\r\n\r\n        add : function(str) {\r\n            alert(&quot;add&quot;, str);\r\n\r\n            return this;\r\n        },\r\n\r\n        remove : function(str) {\r\n            alert(&quot;remove&quot;, str);\r\n\r\n            return this;\r\n        }\r\n    };\r\n\r\n    box.fn.init.prototype = box.fn;\r\n\r\n    window.box =box;\r\n})();\r\n\r\nvar testBox = box();\r\ntestBox.add(&quot;jQuery&quot;).remove(&quot;jQuery&quot;);\r\n</code></pre>\r\n<h4 id=\"h4-html-html-codes\"><a name=\"HTML 代码 HTML codes\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>HTML 代码 HTML codes</h4><pre><code class=\"lang-html\">&lt;!DOCTYPE html&gt;\r\n&lt;html&gt;\r\n    &lt;head&gt;\r\n        &lt;mate charest=&quot;utf-8&quot; /&gt;\r\n        &lt;meta name=&quot;keywords&quot; content=&quot;Editor.md, Markdown, Editor&quot; /&gt;\r\n        &lt;title&gt;Hello world!&lt;/title&gt;\r\n        &lt;style type=&quot;text/css&quot;&gt;\r\n            body{font-size:14px;color:#444;font-family: &quot;Microsoft Yahei&quot;, Tahoma, &quot;Hiragino Sans GB&quot;, Arial;background:#fff;}\r\n            ul{list-style: none;}\r\n            img{border:none;vertical-align: middle;}\r\n        &lt;/style&gt;\r\n    &lt;/head&gt;\r\n    &lt;body&gt;\r\n        &lt;h1 class=&quot;text-xxl&quot;&gt;Hello world!&lt;/h1&gt;\r\n        &lt;p class=&quot;text-green&quot;&gt;Plain text&lt;/p&gt;\r\n    &lt;/body&gt;\r\n&lt;/html&gt;\r\n</code></pre>\r\n<h3 id=\"h3--images\"><a name=\"图片 Images\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>图片 Images</h3><p>Image:</p>\r\n<p><img src=\"https://pandao.github.io/editor.md/examples/images/4.jpg\" alt=\"\"></p>\r\n<blockquote>\r\n<p>Follow your heart.</p>\r\n</blockquote>\r\n<p><img src=\"https://pandao.github.io/editor.md/examples/images/8.jpg\" alt=\"\"></p>\r\n<blockquote>\r\n<p>图为：厦门白城沙滩</p>\r\n</blockquote>\r\n<p>图片加链接 (Image + Link)：</p>\r\n<p><a href=\"https://pandao.github.io/editor.md/images/7.jpg\" title=\"李健首张专辑《似水流年》封面\"><img src=\"https://pandao.github.io/editor.md/examples/images/7.jpg\" alt=\"\"></a></p>\r\n<blockquote>\r\n<p>图为：李健首张专辑《似水流年》封面</p>\r\n</blockquote>\r\n<hr>\r\n<h3 id=\"h3--lists\"><a name=\"列表 Lists\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>列表 Lists</h3><h4 id=\"h4--unordered-lists-\"><a name=\"无序列表（减号）Unordered Lists (-)\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>无序列表（减号）Unordered Lists (-)</h4><ul>\r\n<li>列表一</li><li>列表二</li><li>列表三</li></ul>\r\n<h4 id=\"h4--unordered-lists-\"><a name=\"无序列表（星号）Unordered Lists (*)\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>无序列表（星号）Unordered Lists (*)</h4><ul>\r\n<li>列表一</li><li>列表二</li><li>列表三</li></ul>\r\n<h4 id=\"h4--unordered-lists-\"><a name=\"无序列表（加号和嵌套）Unordered Lists (+)\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>无序列表（加号和嵌套）Unordered Lists (+)</h4><ul>\r\n<li>列表一</li><li>列表二<ul>\r\n<li>列表二-1</li><li>列表二-2</li><li>列表二-3</li></ul>\r\n</li><li>列表三<ul>\r\n<li>列表一</li><li>列表二</li><li>列表三</li></ul>\r\n</li></ul>\r\n<h4 id=\"h4--ordered-lists-\"><a name=\"有序列表 Ordered Lists (-)\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>有序列表 Ordered Lists (-)</h4><ol>\r\n<li>第一行</li><li>第二行</li><li>第三行</li></ol>\r\n<h4 id=\"h4-gfm-task-list\"><a name=\"GFM task list\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>GFM task list</h4><ul>\r\n<li>[x] GFM task list 1</li><li>[x] GFM task list 2</li><li>[ ] GFM task list 3<ul>\r\n<li>[ ] GFM task list 3-1</li><li>[ ] GFM task list 3-2</li><li>[ ] GFM task list 3-3</li></ul>\r\n</li><li>[ ] GFM task list 4<ul>\r\n<li>[ ] GFM task list 4-1</li><li>[ ] GFM task list 4-2</li></ul>\r\n</li></ul>\r\n<hr>\r\n<h3 id=\"h3--tables\"><a name=\"绘制表格 Tables\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>绘制表格 Tables</h3><table>\r\n<thead>\r\n<tr>\r\n<th>项目</th>\r\n<th style=\"text-align:right\">价格</th>\r\n<th style=\"text-align:center\">数量</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>计算机</td>\r\n<td style=\"text-align:right\">$1600</td>\r\n<td style=\"text-align:center\">5</td>\r\n</tr>\r\n<tr>\r\n<td>手机</td>\r\n<td style=\"text-align:right\">$12</td>\r\n<td style=\"text-align:center\">12</td>\r\n</tr>\r\n<tr>\r\n<td>管线</td>\r\n<td style=\"text-align:right\">$1</td>\r\n<td style=\"text-align:center\">234</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table>\r\n<thead>\r\n<tr>\r\n<th>First Header</th>\r\n<th>Second Header</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>Content Cell</td>\r\n<td>Content Cell</td>\r\n</tr>\r\n<tr>\r\n<td>Content Cell</td>\r\n<td>Content Cell </td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table>\r\n<thead>\r\n<tr>\r\n<th>First Header</th>\r\n<th>Second Header</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>Content Cell</td>\r\n<td>Content Cell</td>\r\n</tr>\r\n<tr>\r\n<td>Content Cell</td>\r\n<td>Content Cell</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table>\r\n<thead>\r\n<tr>\r\n<th>Function name</th>\r\n<th>Description</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td><code>help()</code></td>\r\n<td>Display the help window.</td>\r\n</tr>\r\n<tr>\r\n<td><code>destroy()</code></td>\r\n<td><strong>Destroy your computer!</strong></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table>\r\n<thead>\r\n<tr>\r\n<th style=\"text-align:left\">Left-Aligned</th>\r\n<th style=\"text-align:center\">Center Aligned</th>\r\n<th style=\"text-align:right\">Right Aligned</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td style=\"text-align:left\">col 3 is</td>\r\n<td style=\"text-align:center\">some wordy text</td>\r\n<td style=\"text-align:right\">$1600</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align:left\">col 2 is</td>\r\n<td style=\"text-align:center\">centered</td>\r\n<td style=\"text-align:right\">$12</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align:left\">zebra stripes</td>\r\n<td style=\"text-align:center\">are neat</td>\r\n<td style=\"text-align:right\">$1</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table>\r\n<thead>\r\n<tr>\r\n<th>Item</th>\r\n<th style=\"text-align:right\">Value</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>Computer</td>\r\n<td style=\"text-align:right\">$1600</td>\r\n</tr>\r\n<tr>\r\n<td>Phone</td>\r\n<td style=\"text-align:right\">$12</td>\r\n</tr>\r\n<tr>\r\n<td>Pipe</td>\r\n<td style=\"text-align:right\">$1</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n', 'testemd', 'publish', 'open', '', '2017-12-21 15:16:23', '2017-12-21 07:16:23', 0, '/article/53.html', '', 'post', '', 0, 0),
(54, 13, '2017-12-14 11:25:26', '2017-12-14 03:25:26', '## 123\r\n> 可以的\r\n\r\n###ok的\r\n\r\n', '<h2 id=\"h2-123\"><a name=\"123\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>123</h2><blockquote>\r\n<p>可以的</p>\r\n</blockquote>\r\n<h3 id=\"h3-ok-\"><a name=\"ok的\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>ok的</h3>', 'markdown页面', 'publish', 'open', 'markdown-page', '2017-12-14 11:27:08', '2017-12-14 03:27:08', 0, '/page/markdown-page', '', 'page', '', 0, 0);

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

--
-- 转存表中的数据 `zp_resources`
--

INSERT INTO `zp_resources` (`resource_id`, `upload_author`, `upload_date`, `upload_date_gmt`, `resource_content`, `resource_title`, `resource_status`, `resource_name`, `resource_parent`, `guid`, `resource_type`, `resource_mime_type`) VALUES
(1, 13, '2017-10-08 01:13:21', '2017-10-07 17:13:21', '123', 'QQ图片20170311223801.jpg', 'normal', 'QQ图片20170311223801.jpg', 0, 'uploads/2017/10/QQ图片20170311223801.jpg', 'picture', 'image/jpeg'),
(2, 13, '2017-10-08 01:15:24', '2017-10-07 17:15:24', '', 'default_zp3 _1_.jpg', 'normal', 'default_zp3 _1_.jpg', 0, 'uploads/2017/10/default_zp3 _1_.jpg', 'picture', 'image/jpeg'),
(3, 13, '2017-10-08 01:25:16', '2017-10-07 17:25:16', '', '九里台.jpg', 'normal', '九里台.jpg', 0, 'uploads/cover/九里台.jpg', 'picture', 'image/jpeg');

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

--
-- 转存表中的数据 `zp_subjects`
--

INSERT INTO `zp_subjects` (`subject_id`, `subject_name`, `subject_slug`, `subject_image`, `subject_description`, `count`, `last_updated`, `parent`) VALUES
(1, '编程', 'code', 'uploads/cover/20141272313028441.jpg', '666', 15, '2017-11-13 09:46:17', 0),
(2, 'PHP', 'php', 'uploads/cover/c5131475jw1f9fxxjv7clj209h0az752.jpg', '111', 5, '2017-11-13 09:45:40', 1),
(3, 'golang', 'go', 'uploads/cover/default-zp3 (2).jpg', '666', 3, '2017-11-13 09:45:53', 1),
(4, 'thinkphp', 'thinkphp', 'uploads/cover/九里台.jpg', '', 4, '2017-11-13 09:23:13', 2);

-- --------------------------------------------------------

--
-- 表的结构 `zp_subject_relationships`
--

CREATE TABLE `zp_subject_relationships` (
  `object_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `subject_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='专题关系表';

--
-- 转存表中的数据 `zp_subject_relationships`
--

INSERT INTO `zp_subject_relationships` (`object_id`, `subject_id`, `order`) VALUES
(1, 0, 0),
(7, 4, 0),
(8, 4, 0),
(9, 1, 0),
(10, 0, 0),
(23, 4, 0),
(27, 4, 0),
(28, 1, 0),
(29, 1, 0),
(38, 3, 0),
(42, 0, 0),
(43, 0, 0),
(44, 1, 0),
(45, 0, 0),
(46, 2, 0),
(51, 0, 0),
(53, 0, 0);

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
(1, '未分类', 'uncategorized', 0),
(2, '编程', 'code123', 0),
(3, 'PHP', 'php', 0),
(4, 'Javascript', 'javascript', 0),
(5, 'thinkphp', 'thinkphp', 0),
(12, 'PHP', 'php', 0),
(13, 'golang', 'go', 0),
(43, 'python', 'python', 0),
(44, 'python2', 'python2', 0),
(45, 'python3', 'python3', 0),
(47, 'python5', 'python5', 0),
(48, 'python66', 'python66', 0),
(49, '生活', '生活', 0),
(50, '吐槽', '吐槽', 0),
(51, '变态', '变态', 0),
(52, '科学', '科学', 0),
(53, '好变态', '好变态', 0),
(54, '超变态', 'chaobiantai', 0),
(55, '一般变态', '一般变态', 0),
(56, '很变态哦', 'henbiantai', 0),
(57, 'go', 'go', 0),
(58, '代码', 'code', 0),
(59, '友链', 'youlian', 0);

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
(1, 1, 0),
(2, 30, 0),
(2, 31, 0),
(3, 30, 0),
(3, 31, 0),
(4, 1, 0),
(4, 2, 0),
(4, 3, 0),
(4, 9, 0),
(4, 30, 0),
(4, 31, 0),
(5, 1, 0),
(7, 5, 0),
(8, 9, 0),
(8, 10, 0),
(8, 15, 0),
(8, 24, 0),
(8, 26, 0),
(9, 9, 0),
(9, 10, 0),
(9, 26, 0),
(10, 1, 0),
(16, 1, 0),
(17, 1, 0),
(18, 1, 0),
(19, 1, 0),
(20, 1, 0),
(21, 1, 0),
(22, 5, 0),
(22, 21, 0),
(23, 3, 0),
(23, 5, 0),
(24, 0, 0),
(24, 3, 0),
(27, 2, 0),
(27, 3, 0),
(27, 5, 0),
(28, 9, 0),
(28, 10, 0),
(28, 25, 0),
(28, 26, 0),
(29, 25, 0),
(29, 26, 0),
(37, 21, 0),
(37, 23, 0),
(37, 25, 0),
(37, 26, 0),
(38, 2, 0),
(38, 4, 0),
(38, 9, 0),
(38, 10, 0),
(38, 15, 0),
(38, 21, 0),
(38, 23, 0),
(38, 26, 0),
(39, 1, 0),
(40, 1, 0),
(41, 1, 0),
(42, 1, 0),
(43, 1, 0),
(44, 4, 0),
(44, 5, 0),
(44, 16, 0),
(44, 20, 0),
(45, 3, 0),
(45, 5, 0),
(46, 2, 0),
(46, 10, 0),
(46, 17, 0),
(51, 2, 0),
(53, 2, 0),
(53, 3, 0),
(53, 5, 0),
(53, 9, 0),
(53, 15, 0);

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
(1, 1, 'category', '', 0, 2),
(2, 2, 'category', '骄傲了=', 0, 5),
(3, 3, 'category', '最好的语言', 0, 7),
(4, 4, 'category', 'Javascript', 2, 2),
(5, 5, 'category', 'thinkphpthinkphpthinkphpthinkphp', 3, 7),
(9, 12, 'tag', 'php哦', 0, 5),
(10, 13, 'tag', 'go', 0, 5),
(15, 43, 'tag', ' ', 0, 3),
(16, 44, 'tag', ' ', 0, 1),
(17, 45, 'tag', ' ', 0, 1),
(19, 47, 'tag', ' ', 0, 0),
(20, 48, 'tag', 'asdasdads666', 0, 1),
(21, 49, 'category', ' ', 0, 5),
(22, 50, 'category', ' ', 21, 0),
(23, 51, 'category', ' ', 21, 4),
(24, 52, 'category', ' ', 0, 1),
(25, 53, 'category', '好变态噢', 23, 5),
(26, 54, 'category', '', 25, 6),
(27, 55, 'category', ' ', 23, 0),
(28, 56, 'category', '1', 23, 0),
(29, 57, 'tag', 'gogogo', 0, 0),
(30, 58, 'linkCategory', '代码手册', 0, 3),
(31, 59, 'linkCategory', '有联表', 0, 3);

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
(1, 1, 'nickname', 'root'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'comment_shortcuts', 'false'),
(7, 1, 'admin_color', 'fresh'),
(8, 1, 'use_ssl', '0'),
(9, 1, 'show_admin_bar_front', 'true'),
(10, 1, 'locale', ''),
(11, 1, 'zp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(12, 1, 'zp_user_level', '10'),
(13, 1, 'dismissed_wp_pointers', ''),
(14, 1, 'show_welcome_panel', '1'),
(15, 1, 'session_tokens', 'a:1:{s:64:\"a18e1f3eb0fa65e5ae5e747944aef113cd3098a60d12445b412481d51618067a\";a:4:{s:10:\"expiration\";i:1503591197;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:142:\"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.125 YaBrowser/17.7.1.719 Yowser/2.5 Safari/537.36\";s:5:\"login\";i:1503418397;}}'),
(16, 1, 'zp_dashboard_quick_press_last_post_id', '3'),
(17, 1, 'community-events-location', 'a:1:{s:2:\"ip\";s:2:\"::\";}'),
(18, 14, 'description', ''),
(19, 14, 'session_tokens', '');

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
(1, 'root', '$P$BxiMOJuXpwfTzLZxenWZUAOR3qZnD.1', 'root', '411214120@qq.com', '', '2017-08-22 16:13:00', '', 0, 'root', 'subscriber'),
(13, 'gzp', '$2y$08$aHNGNWQ1MjBlaHliWGJhN.i7unsEtbapIPGi/DEuix12THtnrAMky', 'gzp', 'gzp@goozp.com', 'http://www.goozp.com2', '2017-09-05 17:58:50', '', 0, 'gzp', 'administrator'),
(14, 'aaaaaa', '$2y$08$ZVgxUkJIUXViNVNkK25vRutv/jCjSS0FB7Y9I32AFp/dKgLeAFwPC', 'aaaaaa', 'gzp@aaa.com', '', '2017-10-06 20:54:51', '', 0, 'aaaaaa', 'subscriber');

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
  MODIFY `link_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '链接id', AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `zp_options`
--
ALTER TABLE `zp_options`
  MODIFY `option_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置id', AUTO_INCREMENT=31;
--
-- 使用表AUTO_INCREMENT `zp_postmeta`
--
ALTER TABLE `zp_postmeta`
  MODIFY `meta_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- 使用表AUTO_INCREMENT `zp_posts`
--
ALTER TABLE `zp_posts`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=55;
--
-- 使用表AUTO_INCREMENT `zp_resourcemeta`
--
ALTER TABLE `zp_resourcemeta`
  MODIFY `meta_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `zp_resources`
--
ALTER TABLE `zp_resources`
  MODIFY `resource_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '资源id', AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `zp_subjects`
--
ALTER TABLE `zp_subjects`
  MODIFY `subject_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '专题 id', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `zp_termmeta`
--
ALTER TABLE `zp_termmeta`
  MODIFY `meta_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';
--
-- 使用表AUTO_INCREMENT `zp_terms`
--
ALTER TABLE `zp_terms`
  MODIFY `term_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '条件id', AUTO_INCREMENT=60;
--
-- 使用表AUTO_INCREMENT `zp_term_taxonomy`
--
ALTER TABLE `zp_term_taxonomy`
  MODIFY `term_taxonomy_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类方式id', AUTO_INCREMENT=32;
--
-- 使用表AUTO_INCREMENT `zp_usermeta`
--
ALTER TABLE `zp_usermeta`
  MODIFY `umeta_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=20;
--
-- 使用表AUTO_INCREMENT `zp_users`
--
ALTER TABLE `zp_users`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=15;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-05 11:24:15
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
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes' COMMENT '是否自动加载'
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
(27, 'image_large_height', '1024', 'yes');

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
(15, 52, 'description', '测试页面');

-- --------------------------------------------------------

--
-- 表的结构 `zp_posts`
--

CREATE TABLE `zp_posts` (
  `ID` int(11) UNSIGNED NOT NULL COMMENT 'id',
  `post_author` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发表人id',
  `post_date` datetime NOT NULL COMMENT '发表时间',
  `post_date_gmt` datetime NOT NULL COMMENT '发表GMT标准时间',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
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

INSERT INTO `zp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_status`, `comment_status`, `post_name`, `post_modified`, `post_modified_gmt`, `post_parent`, `guid`, `cover_picture`, `post_type`, `post_mime_type`, `comment_count`, `view_count`) VALUES
(1, 1, '2017-08-23 00:13:01', '2017-08-22 16:13:02', '欢迎使用WordPress。这是您的第一篇文章。编辑或删除它，然后开始写作吧！', '世界，您好！', 'publish', 'open', 'hello-world', '2017-08-23 00:13:01', '2017-08-22 16:13:02', 0, 'http://localhost/wordpress/?p=1', '', 'post', '', 1, 0),
(2, 1, '2017-08-23 00:13:01', '2017-08-22 16:13:02', '这是示范页面。页面和博客文章不同，它的位置是固定的，通常会在站点导航栏显示。很多用户都创建一个“关于”页面，向访客介绍自己。例如：\n\n<blockquote>欢迎！我白天是个邮递员，晚上就是个有抱负的演员。这是我的博客。我住在天朝的帝都，有条叫做Jack的狗。</blockquote>\n\n……或这个：\n\n<blockquote>XYZ Doohickey公司成立于1971年，自从建立以来，我们一直向社会贡献着优秀doohickies。我们的公司总部位于天朝魔都，有着超过两千名员工，对魔都政府税收有着巨大贡献。</blockquote>\n\n而您，作为一个WordPress用户，我们建议您访问<a href=\"http://localhost/wordpress/wp-admin/\">控制板</a>，删除本页面，然后添加您自己的页面。祝您使用愉快！', '示例页面', 'publish', 'closed', 'sample-page', '2017-08-23 00:13:01', '2017-08-22 16:13:02', 0, 'http://localhost/wordpress/?page_id=2', '', 'page', '', 0, 0),
(3, 1, '2017-08-23 00:13:19', '0000-00-00 00:00:00', '', '自动草稿', 'auto-draft', 'open', '', '2017-08-23 00:13:19', '0000-00-00 00:00:00', 0, 'http://localhost/wordpress/?p=3', '', 'post', '', 0, 0),
(4, 13, '2017-10-23 09:07:56', '2017-10-23 09:07:56', '# 啊是大大\r\n123\r\n123\r\n123444', '啊哈', 'publish', 'open', '', '2017-10-23 09:07:56', '2017-10-23 09:07:56', 0, '', '', 'post', '', 0, 0),
(5, 13, '2017-10-24 03:00:37', '2017-10-24 03:00:37', '啊哈啊哈啊哈啊哈啊哈啊哈', '啊哈啊哈', 'draft', 'open', '', '2017-10-24 03:00:37', '2017-10-24 03:00:37', 0, '', '', 'post', '', 0, 0),
(6, 13, '2017-10-24 09:28:20', '2017-10-24 09:28:20', '# 啊啊啊啊嗄\n可以啊\n!!!\n', '测试', 'auto-draft', 'open', '', '2017-10-24 09:28:20', '2017-10-24 09:28:20', 0, '/article/6.html', '', 'post', '', 0, 0),
(7, 13, '2017-10-30 04:05:44', '2017-10-30 04:05:44', '# 测试计数\r\n测试计数', '测试计数', 'publish', 'open', '', '2017-10-30 04:05:44', '2017-10-30 04:05:44', 0, '', '', 'post', '', 0, 0),
(8, 13, '2017-10-30 04:09:21', '2017-10-30 04:09:21', '# 测试分类again\r\n测试分类again', '测试分类again', 'publish', 'open', '', '2017-10-30 04:09:21', '2017-10-30 04:09:21', 0, '', '', 'post', '', 0, 0),
(9, 13, '2017-10-30 04:13:12', '2017-10-30 04:13:12', '###### 测试叠加\r\n测试叠加', '测试叠加', 'publish', 'open', '', '2017-10-30 04:13:12', '2017-10-30 04:13:12', 0, '', '', 'post', '', 0, 0),
(10, 13, '2017-12-21 16:50:23', '2017-12-21 16:50:23', '# 测试URL\r\n测试URL测试URL', '测试URL', 'publish', 'open', '', '2017-12-21 16:50:23', '2017-12-21 16:50:23', 0, '', '', 'post', '', 0, 0),
(11, 13, '2017-10-30 08:55:26', '2017-10-30 08:55:26', '# 测试URL\n测试URL测试URL', '测试URL', 'auto-draft', 'open', '', '2017-10-30 08:55:26', '2017-10-30 08:55:26', 0, '', '', 'post', '', 0, 0),
(12, 13, '2017-10-30 08:57:26', '2017-10-30 08:57:26', '# 测试URL\n测试URL测试URL', '测试URL', 'auto-draft', 'open', '', '2017-10-30 08:57:26', '2017-10-30 08:57:26', 0, '', '', 'post', '', 0, 0),
(13, 13, '2017-10-30 08:59:26', '2017-10-30 08:59:26', '# 测试URL\n测试URL测试URL', '测试URL', 'auto-draft', 'open', '', '2017-10-30 08:59:26', '2017-10-30 08:59:26', 0, '', '', 'post', '', 0, 0),
(14, 13, '2017-10-30 09:01:25', '2017-10-30 09:01:25', '# 测试URL\n测试URL测试URL', '测试URL', 'auto-draft', 'open', '', '2017-10-30 09:01:25', '2017-10-30 09:01:25', 0, '', '', 'post', '', 0, 0),
(15, 13, '2017-09-27 01:05:08', '2017-09-27 01:05:08', 'utlutl', 'utlutlutl', 'publish', 'open', '', '2017-09-27 01:05:08', '2017-09-27 01:05:08', 0, '', '', 'post', '', 0, 0),
(16, 13, '2017-10-30 09:13:34', '2017-10-30 09:13:34', 'aaaaa', 'aaaaa', 'publish', 'open', '', '2017-10-30 09:13:34', '2017-10-30 09:13:34', 0, '', '', 'post', '', 0, 0),
(17, 13, '2017-10-30 09:16:07', '2017-10-30 09:16:07', '测试di utl测试di utl', '测试di utl', 'publish', 'open', '', '2017-10-30 09:16:07', '2017-10-30 09:16:07', 0, '', '', 'post', '', 0, 0),
(18, 13, '2017-10-30 09:17:29', '2017-10-30 09:17:29', '测试 测his', '测试 测his', 'publish', 'open', '', '2017-10-30 09:17:29', '2017-10-30 09:17:29', 0, '/article/18.html', '', 'post', '', 0, 0),
(19, 13, '2017-10-30 09:25:53', '2017-10-30 09:25:53', '测试 测hisaa', '测试 测hisaa', 'publish', 'open', '', '2017-10-30 09:25:53', '2017-10-30 09:25:53', 0, '', '', 'post', '', 0, 0),
(20, 13, '2017-10-30 09:33:59', '2017-10-30 09:33:59', '/ 生成连接', '/ 生成连接', 'publish', 'open', '', '2017-10-30 09:33:59', '2017-10-30 09:33:59', 0, '/article/20.html', '', 'post', '', 0, 0),
(21, 13, '2017-10-30 09:45:45', '2017-10-30 09:45:45', '# generateUrl\r\n## generateUrlgenerateUrlgenerateUrlgenerateUrlgenerateUrl\r\n', 'generateUrl', 'publish', 'open', '', '2017-10-30 09:45:45', '2017-10-30 09:45:45', 0, '/article/21.html', '', 'post', '', 0, 0),
(22, 13, '2017-10-30 10:06:39', '2017-10-30 10:06:39', 'asdadasd', '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊大大亲亲我我我我我我我WAd啊大大的哇啊啊啊啊啊的祈晴娃娃A网单位', 'publish', 'open', '', '2017-10-30 10:06:39', '2017-10-30 10:06:39', 0, '/article/22.html', 'https://www.gzpblog.com/wp-content/themes/SaltedFish/public/images/jumbotron_self.png', 'post', '', 0, 0),
(23, 13, '2017-10-30 10:33:22', '2017-10-30 10:33:22', 'utlutlutlutlutlutlutlutlutlutlutlutl', 'utlutlutlutlutlutl', 'publish', 'open', '', '2017-10-30 10:33:22', '2017-10-30 10:33:22', 0, '/article/23.html', '', 'post', '', 0, 0),
(24, 13, '2017-10-30 10:36:29', '2017-10-30 10:36:29', 'kekeke', 'kekkk', 'publish', 'open', '', '2017-10-30 10:36:29', '2017-10-30 10:36:29', 0, '/article/24.html', '', 'post', '', 0, 0),
(25, 13, '2017-10-31 02:32:04', '2017-10-31 02:32:04', 'print_r($allId);', '啊哈啊哈', 'publish', 'open', '', '2017-10-31 02:32:04', '2017-10-31 02:32:04', 0, '/article/25.html', '', 'post', '', 0, 0),
(26, 13, '2017-10-31 02:52:12', '2017-10-31 02:52:12', 'print_r($allId);', '啊哈啊哈', 'publish', 'open', '', '2017-10-31 02:52:12', '2017-10-31 02:52:12', 0, '/article/26.html', '', 'post', '', 0, 0),
(27, 13, '2017-10-31 02:53:05', '2017-10-31 02:53:05', 'testtest', 'testtest', 'publish', 'open', '', '2017-10-31 02:53:05', '2017-10-31 02:53:05', 0, '/article/27.html', '', 'post', '', 0, 0),
(28, 13, '2017-10-31 03:00:34', '2017-10-31 03:00:34', '啊哈', '啊哈', 'publish', 'open', '', '2017-10-31 03:00:34', '2017-10-31 03:00:34', 0, '/article/28.html', '', 'post', '', 0, 0),
(29, 13, '2017-10-31 03:02:16', '2017-10-31 03:02:16', 'asdasd', '啊哈啊哈', 'publish', 'open', '', '2017-11-13 08:52:46', '2017-11-13 08:52:46', 0, '/article/29.html', '', 'post', '', 0, 0),
(30, 13, '2017-10-31 03:33:13', '2017-10-31 03:33:13', '啊哈', '啊哈', 'publish', 'open', '', '2017-10-31 03:33:13', '2017-10-31 03:33:13', 0, '/article/30.html', '', 'post', '', 0, 0),
(31, 13, '2017-10-31 03:34:39', '2017-10-31 03:34:39', '啊哈', '啊哈', 'publish', 'open', '', '2017-10-31 03:34:39', '2017-10-31 03:34:39', 0, '/article/31.html', '', 'post', '', 0, 0),
(33, 13, '2017-10-31 03:45:05', '2017-10-31 03:45:05', 'asdasd', 'asdasda', 'publish', 'open', '', '2017-10-31 03:45:05', '2017-10-31 03:45:05', 0, '/article/33.html', '', 'post', '', 0, 0),
(34, 13, '2017-10-31 04:06:59', '2017-10-31 04:06:59', 'asdasd', 'asdasda', 'publish', 'open', '', '2017-10-31 04:06:59', '2017-10-31 04:06:59', 0, '/article/34.html', '', 'post', '', 0, 0),
(35, 13, '2017-10-31 04:07:31', '2017-10-31 04:07:31', 'asdasd', 'asdasda', 'publish', 'open', '', '2017-10-31 04:07:31', '2017-10-31 04:07:31', 0, '/article/35.html', '', 'post', '', 0, 0),
(37, 13, '2017-10-31 04:15:30', '2017-10-31 04:15:30', 'asd', '啊哈', 'publish', 'open', '', '2017-10-31 04:15:30', '2017-10-31 04:15:30', 0, '/article/37.html', '', 'post', '', 0, 0),
(38, 13, '2017-11-10 15:14:44', '2017-11-10 15:14:44', '啊哈啊哈啊哈啊哈', '啊哈啊哈', 'publish', 'open', '', '2017-11-10 10:29:14', '2017-11-10 10:29:14', 0, '/article/38.html', '', 'post', '', 0, 0),
(39, 13, '2017-11-07 10:21:59', '2017-11-07 10:21:59', 'asdaasd', 'sdasda', 'publish', 'open', '', '2017-11-07 10:21:59', '2017-11-07 10:21:59', 0, '/article/39.html', '', 'post', '', 0, 0),
(40, 13, '1000-01-01 00:00:00', '1000-01-01 00:00:00', '草稿草稿', '草稿', 'draft', 'open', '', '2017-11-07 10:26:35', '2017-11-07 10:26:35', 0, '/article/40.html', '', 'post', '', 0, 0),
(41, 13, '2017-11-10 15:31:17', '2017-11-10 15:31:17', '123123', '更新资料时,学校没法填', 'publish', 'open', '', '2017-11-10 07:37:20', '2017-11-10 07:37:20', 0, '/article/41.html', '', 'post', '', 0, 0),
(42, 13, '2017-08-10 07:38:10', '2017-08-10 07:38:10', '保存草稿', '保存草稿', 'publish', 'open', '', '2017-11-10 07:40:15', '2017-11-10 07:40:15', 0, '/article/42.html', '', 'post', '', 0, 0),
(43, 13, '2017-02-10 15:28:48', '2017-02-10 15:28:48', '# 保存草稿iooooasdasd', '保存草稿oasdasdasdad', 'draft', 'open', '', '2017-11-14 09:19:46', '2017-11-14 09:19:46', 0, '/article/43.html', '', 'post', '', 0, 0),
(44, 13, '2017-11-10 08:23:12', '2017-11-10 07:23:12', '阿萨', '啊啊啊', 'publish', 'open', '', '2017-11-23 08:48:11', '2017-11-23 07:48:11', 0, '/article/44.html', '', 'post', '', 0, 0),
(45, 13, '2017-11-20 11:11:27', '2017-11-20 10:11:27', '888', '888', 'publish', 'open', '', '2017-11-20 11:14:14', '2017-11-20 10:14:14', 0, '/article/45.html', '', 'post', '', 0, 0),
(46, 13, '2017-11-10 09:46:09', '2017-11-10 08:46:09', ' 1122', '1122', 'publish', 'open', '', '2017-11-23 08:48:31', '2017-11-23 07:48:31', 0, '/article/46.html', '', 'post', '', 0, 0),
(51, 13, '2017-11-23 07:47:59', '2017-11-23 06:47:59', '阿萨', '啊打算', 'publish', 'open', '', '2017-11-23 08:48:23', '2017-11-23 07:48:23', 0, '/article/51.html', '', 'post', '', 0, 0),
(52, 13, '2017-12-05 15:02:27', '2017-12-05 07:02:27', '# 测试页面测试页面', '测试页面', 'publish', 'open', 'test', '2017-12-05 15:02:52', '2017-12-05 07:02:52', 0, '/page/test', '', 'page', '', 0, 0);

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
(7, 4, 0),
(8, 4, 0),
(9, 1, 0),
(23, 4, 0),
(27, 4, 0),
(28, 1, 0),
(29, 1, 0),
(38, 3, 0),
(43, 0, 0),
(44, 1, 0),
(45, 0, 0),
(46, 2, 0),
(51, 0, 0);

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
(54, '超变态', '超变态', 0),
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
(1, 30, 0),
(1, 31, 0),
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
(51, 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `zp_term_taxonomy`
--

CREATE TABLE `zp_term_taxonomy` (
  `term_taxonomy_id` int(11) UNSIGNED NOT NULL COMMENT '分类方式id',
  `term_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '条件id',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类方式',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '描述',
  `parent` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父id',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '拥有的数目'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `zp_term_taxonomy`
--

INSERT INTO `zp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 1),
(2, 2, 'category', '骄傲了=', 0, 4),
(3, 3, 'category', '最好的语言', 0, 6),
(4, 4, 'category', 'Javascript', 2, 2),
(5, 5, 'category', 'thinkphpthinkphpthinkphpthinkphp', 3, 6),
(9, 12, 'tag', 'php哦', 0, 4),
(10, 13, 'tag', 'go', 0, 5),
(15, 43, 'tag', ' ', 0, 2),
(16, 44, 'tag', ' ', 0, 1),
(17, 45, 'tag', ' ', 0, 1),
(19, 47, 'tag', ' ', 0, 0),
(20, 48, 'tag', 'asdasdads666', 0, 1),
(21, 49, 'category', ' ', 0, 5),
(22, 50, 'category', ' ', 21, 0),
(23, 51, 'category', ' ', 21, 4),
(24, 52, 'category', ' ', 0, 1),
(25, 53, 'category', '好变态噢', 23, 5),
(26, 54, 'category', ' ', 25, 6),
(27, 55, 'category', ' ', 23, 0),
(28, 56, 'category', '1', 23, 0),
(29, 57, 'tag', 'gogogo', 0, 0),
(30, 58, 'linkCategory', '代码手册', 0, 4),
(31, 59, 'linkCategory', '有联表', 0, 4);

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
  MODIFY `option_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置id', AUTO_INCREMENT=160;
--
-- 使用表AUTO_INCREMENT `zp_postmeta`
--
ALTER TABLE `zp_postmeta`
  MODIFY `meta_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- 使用表AUTO_INCREMENT `zp_posts`
--
ALTER TABLE `zp_posts`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=53;
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

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `wiki_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `passwd` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `wiki_admin` (`id`, `username`, `passwd`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

CREATE TABLE IF NOT EXISTS `wiki_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text,
  `create_date` int(11) DEFAULT NULL,
  `modify_date` int(11) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `wiki_article` (`id`, `title`, `category`, `type`, `user_id`, `content`, `create_date`, `modify_date`, `tags`, `hits`) VALUES
(1, 'Demo 测试', 1, 0, 1, 'Demo 测试 网站源码发布 0.2.1 版本\r\n\r\n### 新功能\r\n\r\n添加了新闻，扩展\r\n\r\n修改了页面\r\n\r\n### TODO\r\n\r\n网站与新浪微博的连接因为没有ICP备案所以还不能用，还是 Waitting 吧', 1323830614, 1323830614, 'demo,新功能', 4),
(2, '网站源码程序发布0.2.1版本', 1, 1, NULL, '网站源码程序发布0.2.1版本\r\n\r\n### 新功能\r\n\r\n添加了新闻，扩展\r\n\r\n修改了页面\r\n\r\n### TODO\r\n\r\n网站与新浪微博的连接因为没有ICP备案所以还不能用，还是 Waitting 吧', 1323830708, 1323830708, '测试,新闻,demo,功能', 3);

CREATE TABLE IF NOT EXISTS `wiki_chm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `article_count` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL,
  `modify_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `wiki_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text,
  `create_date` int(11) DEFAULT NULL,
  `modify_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `wiki_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text,
  `tags` varchar(255) DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL,
  `summary` varchar(128) DEFAULT NULL,
  `revision` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `wiki_content` (`id`, `article_id`, `title`, `category`, `user_id`, `content`, `tags`, `create_date`, `summary`, `revision`) VALUES
(1, 1, 'Demo 测试', 1, 1, 'Demo 测试 网站源码发布 0.2.1 版本\r\n\r\n### 新功能\r\n\r\n添加了新闻，扩展\r\n\r\n修改了页面\r\n\r\n### TODO\r\n\r\n网站与新浪微博的连接因为没有ICP备案所以还不能用，还是 Waitting 吧', 'demo,新功能', 1323830614, '初始化版本', 1);

CREATE TABLE IF NOT EXISTS `wiki_credit_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `credit` int(11) DEFAULT NULL,
  `reason` int(11) DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `wiki_extension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `content` text,
  `demo_url` varchar(255) DEFAULT NULL,
  `project_url` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL,
  `modify_date` int(11) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `summary` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `wiki_ext_download` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ext_id` int(11) DEFAULT NULL,
  `download_url` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `wiki_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `description` text,
  `status` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL,
  `modify_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `wiki_link` (`id`, `url`, `title`, `description`, `status`, `email`, `create_date`, `modify_date`) VALUES
(1, 'http://www.yiiwiki.com', 'Yii中文百科', 'Yii中文百科，一个学习Yii的网站', 2, 'zhangdi5649@126.com', 1323830771, 1323830771);

CREATE TABLE IF NOT EXISTS `wiki_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `type` varchar(128) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

INSERT INTO `wiki_lookup` (`id`, `name`, `code`, `type`, `position`) VALUES
(1, '新用户奖励', 1, 'CreditReason', 1),
(2, '发表文章', 2, 'CreditReason', 2),
(3, '发表评论', 3, 'CreditReason', 3),
(4, '删除文章', 4, 'CreditReason', 4),
(5, '删除评论', 5, 'CreditReason', 5),
(6, '网站公告', 1, 'NewsType', 1),
(7, '新闻资讯', 0, 'NewsType', 0),
(8, '技巧 | Tips', 1, 'WikiCategory', 1),
(9, '使用方法 | How-tos', 2, 'WikiCategory', 2),
(10, '教程 | Tutorials', 3, 'WikiCategory', 3),
(11, '常见问题 | FAQs', 4, 'WikiCategory', 4),
(12, '其他 | Others', 5, 'WikiCategory', 5),
(13, '新闻资讯', 1, 'NewsCategory', 1),
(14, '网站通告', 2, 'NewsCategory', 2),
(15, '教程', 0, 'ArticleType', 0),
(16, '新闻', 1, 'ArticleType', 1),
(17, '待审核', 1, 'LinkStatus', 1),
(18, '已审核', 2, 'LinkStatus', 2),
(19, '待审核', 1, 'AdminLinkStatus', 1),
(20, '已审核', 2, 'AdminLinkStatus', 2),
(21, '审核失败', -1, 'AdminLinkStatus', 3);

CREATE TABLE IF NOT EXISTS `wiki_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `screen_name` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `theme` varchar(45) DEFAULT NULL,
  `option` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `wiki_module` (`id`, `name`, `screen_name`, `description`, `status`, `theme`, `option`) VALUES
(1, 'space', '个人空间', '个人空间', 1, '', ''),
(3, 'gii', 'gii工具', 'gii工具', 1, '', '{"class":"system.gii.GiiModule","password":"admin"}'),
(4, 'admin', '后台管理', '后台管理', 1, NULL, NULL);

CREATE TABLE IF NOT EXISTS `wiki_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `content` text,
  `sort` int(11) DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL,
  `modify_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `wiki_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `frequency` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

INSERT INTO `wiki_tag` (`id`, `name`, `frequency`) VALUES
(1, 'demo', 2),
(2, '新功能', 1),
(3, '测试', 1),
(4, '新闻', 1),
(5, '功能', 1);

CREATE TABLE IF NOT EXISTS `wiki_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `passwd` varchar(45) DEFAULT NULL,
  `nickname` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `gender` enum('male','female','secrecy') DEFAULT NULL,
  `credit` int(11) DEFAULT '0',
  `reg_date` int(11) DEFAULT NULL,
  `modify_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `wiki_user` (`id`, `username`, `passwd`, `nickname`, `email`, `gender`, `credit`, `reg_date`, `modify_date`) VALUES
(1, 'demo001', 'fe01ce2a7fbac8fafaed7c982a04e229', 'Demo', 'demo@example.com', 'secrecy', 10, 1323830366, 1323830614);

CREATE TABLE IF NOT EXISTS `wiki_user_fav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL,
  `modify_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `wiki_user_fav` (`id`, `user_id`, `article_id`, `type`, `create_date`, `modify_date`) VALUES
(1, 1, 1, 3, 1323830624, 1323830624),
(2, 1, 1, 1, 1323830625, 1323830625);

CREATE TABLE IF NOT EXISTS `wiki_user_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `key` varchar(45) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


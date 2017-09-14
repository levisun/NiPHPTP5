DROP TABLE IF EXISTS `np_book`;
CREATE TABLE IF NOT EXISTS `np_book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '书名',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` varchar(555) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '封面',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `user_id` smallint(6) unsigned NOT NULL COMMENT '作者ID',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '显示',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `is_com` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '置顶',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '最热',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `delete_time` int(11) unsigned DEFAULT NULL COMMENT '删除时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `lang` varchar(20) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `type_id` (`type_id`),
  KEY `user_id` (`user_id`),
  KEY `is_show` (`is_show`),
  KEY `is_pass` (`is_pass`),
  KEY `is_com` (`is_com`),
  KEY `is_top` (`is_top`),
  KEY `is_hot` (`is_hot`),
  KEY `delete_time` (`delete_time`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='书库表';

DROP TABLE IF EXISTS `np_book_type`;
CREATE TABLE IF NOT EXISTS `np_book_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名',
  `description` varchar(555) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='书库分类';

DROP TABLE IF EXISTS `np_book_article`;
CREATE TABLE IF NOT EXISTS `np_book_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` mediumtext NOT NULL COMMENT '内容',
  `book_id` smallint(6) unsigned NOT NULL COMMENT '书ID',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论量',
  `show_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '显示时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `delete_time` int(11) unsigned DEFAULT NULL COMMENT '删除时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `access_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问权限',
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `is_pass` (`is_pass`),
  KEY `delete_time` (`delete_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='书库文章表';
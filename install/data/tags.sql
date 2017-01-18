DROP TABLE IF EXISTS `np_tags`;
CREATE TABLE IF NOT EXISTS `np_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '标签名',
  `count` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '标签文章数量',
  `lang` varchar(20) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `count` (`count`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT '标签表';
DROP TABLE IF EXISTS `np_tags_article`;
CREATE TABLE IF NOT EXISTS `np_tags_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tags_id` int(11) unsigned NOT NULL COMMENT '标签ID',
  `category_id` int(11) unsigned NOT NULL COMMENT '栏目ID',
  `article_id` int(11) unsigned NOT NULL COMMENT '文章ID',
  PRIMARY KEY (`id`),
  KEY `tags_id` (`tags_id`),
  KEY `category_id` (`category_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT '标签文章关联表';
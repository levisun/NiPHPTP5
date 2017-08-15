DROP TABLE IF EXISTS `np_reply`;
CREATE TABLE IF NOT EXISTS `np_reply` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(30) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '内容',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型 1自动回复 2关注回复 0关键词回复',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `lang` varchar(20) NOT NULL DEFAULT 'zh-cn'  COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `keyword` (`keyword`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信回复表';
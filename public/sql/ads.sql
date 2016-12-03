
DROP TABLE IF EXISTS `np_ads`;
CREATE TABLE IF NOT EXISTS `np_ads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '广告名',
  `width` smallint(4) NOT NULL DEFAULT '0' COMMENT '图片宽',
  `height` smallint(4) NOT NULL DEFAULT '0' COMMENT '图片高',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `start_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `lang` varchar(20) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `start_time` (`start_time`),
  KEY `end_time` (`end_time`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告表';

DROP TABLE IF EXISTS `np_banner`;
CREATE TABLE IF NOT EXISTS `np_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(255) NOT NULL COMMENT '幻灯片名',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '图片标题',
  `width` smallint(4) NOT NULL DEFAULT '0' COMMENT '图片宽',
  `height` smallint(4) NOT NULL DEFAULT '0' COMMENT '图片高',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `lang` varchar(20) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `pid` (`pid`),
  KEY `title` (`title`),
  KEY `sort` (`sort`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='幻灯片表';
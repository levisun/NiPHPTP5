DROP TABLE IF EXISTS `np_searchengine`;
CREATE TABLE IF NOT EXISTS `np_searchengine` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL COMMENT '日期',
  `name` varchar(20) NOT NULL COMMENT '搜索引擎名',
  `count` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '统计数量',
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT '搜索引擎';

DROP TABLE IF EXISTS `np_visit`;
CREATE TABLE IF NOT EXISTS `np_visit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL COMMENT '日期',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '访问IP',
  `ip_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '访问IP地区',
  `count` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '统计数量',
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT '访问表';
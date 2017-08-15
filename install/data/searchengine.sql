DROP TABLE IF EXISTS `np_searchengine`;
CREATE TABLE IF NOT EXISTS `np_searchengine` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL COMMENT '日期',
  `name` varchar(20) NOT NULL COMMENT '搜索引擎名',
  `user_agent` varchar(255) NOT NULL DEFAULT '' COMMENT '访问agent',
  `count` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '统计数量',
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT '搜索引擎';

DROP TABLE IF EXISTS `np_visit`;
CREATE TABLE IF NOT EXISTS `np_visit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL COMMENT '日期',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '访问IP',
  `ip_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '访问IP地区',
  `user_agent` varchar(255) NOT NULL DEFAULT '' COMMENT '访问agent',
  `count` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '统计数量',
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT '访问表';

DROP TABLE IF EXISTS `np_request_log`;
CREATE TABLE IF NOT EXISTS `np_request_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '请求IP',
  `module` varchar(15) NOT NULL DEFAULT '' COMMENT '模块',
  `count` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '请求次数',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `create_time` int(11) NOT NULL COMMENT '创建日期',
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`),
  KEY `module` (`module`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT '请求日志表';
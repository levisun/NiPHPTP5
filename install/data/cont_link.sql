DROP TABLE IF EXISTS `np_link`;
CREATE TABLE IF NOT EXISTS `np_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT '标志',
  `description` varchar(555) NOT NULL DEFAULT '' COMMENT '描述',
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布人ID',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `delete_time` int(11) unsigned DEFAULT NULL COMMENT '删除时间',
  `lang` varchar(20) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`),
  KEY `is_pass` (`is_pass`),
  KEY `delete_time` (`delete_time`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友链表';
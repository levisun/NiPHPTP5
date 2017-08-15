DROP TABLE IF EXISTS `np_type`;
CREATE TABLE IF NOT EXISTS `np_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '字段名',
  `description` varchar(555) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类';
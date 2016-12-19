

DROP TABLE IF EXISTS `np_fields`;
CREATE TABLE IF NOT EXISTS `np_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '字段名',
  `description` varchar(555) NOT NULL DEFAULT '' COMMENT '描述',
  `is_require` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '必填',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='自定义字段表';

DROP TABLE IF EXISTS `np_fields_type`;
CREATE TABLE IF NOT EXISTS `np_fields_type` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '类型名',
  `description` varchar(555) NOT NULL DEFAULT '' COMMENT '描述',
  `regex` varchar(255) NOT NULL DEFAULT '' COMMENT '验证方式',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='字段类型表';
INSERT INTO `np_fields_type` (`id`, `name`, `description`, `regex`) VALUES
(1, 'text', '文本', 'require'),
(2, 'number', '数字', 'number'),
(3, 'email', '邮箱', 'email'),
(4, 'url', 'URL地址', 'url'),
(5, 'currency', '货币', 'currency'),
(6, 'abc', '字母', '/^[A-Za-z]+$/'),
(7, 'idcards', '身份证', '/^(\d{14}|\d{17})(\d|[xX])$/'),
(8, 'phone', '移动电话', '/^(1)[1-9][1-9][0-9]{8}$/'),
(9, 'landline', '固话', '/^\d{3,4}-\d{7,8}(-\d{3,4})?$/'),
(10, 'age', '年龄', '/^[1-9][0-9]?[0-9]?$/'),
(11, 'date', '日期', '/^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/');

DROP TABLE IF EXISTS `np_model`;
CREATE TABLE IF NOT EXISTS `np_model` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '模型名',
  `table_name` varchar(255) NOT NULL COMMENT '表名',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `table_name` (`table_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='模型表';
INSERT INTO `np_model` (`id`, `name`, `table_name`, `remark`, `status`, `sort`) VALUES
(1, 'article', 'article', '文章模型', 1, 9),
(2, 'picture', 'picture', '图片模型', 1, 8),
(3, 'download', 'download', '下载模型', 1, 7),
(4, 'page', 'page', '单页模型', 1, 6),
(5, 'feedback', 'feedback', '反馈模型', 1, 5),
(6, 'message', 'message', '留言模型', 1, 4),
(7, 'product', 'product', '产品模型', 1, 3),
(8, 'link', 'link', '友链模型', 1, 2),
(9, 'external', 'external', '外部模型', 1, 1);
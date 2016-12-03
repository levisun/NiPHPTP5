

DROP TABLE IF EXISTS `np_access`;
CREATE TABLE IF NOT EXISTS `np_access` (
  `role_id` smallint(6) unsigned NOT NULL COMMENT '组ID',
  `node_id` smallint(6) unsigned NOT NULL COMMENT '节点ID',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `level` tinyint(1) NOT NULL COMMENT '节点等级',
  `module` varchar(50) DEFAULT NULL COMMENT '节点名',
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '权限表';
INSERT INTO `np_access` (`role_id`, `node_id`, `status`, `level`, `module`) VALUES
(1, 1, 1, 1, 'admin'),
(1, 2, 1, 2, 'settings'),
(1, 3, 1, 3, 'info'),
(1, 4, 1, 3, 'basic'),
(1, 5, 1, 3, 'lang'),
(1, 6, 1, 3, 'image'),
(1, 7, 1, 3, 'safe'),
(1, 8, 1, 3, 'email'),
(1, 9, 1, 2, 'theme'),
(1, 10, 1, 3, 'template'),
(1, 11, 1, 3, 'member'),
(1, 12, 1, 3, 'shop'),
(1, 13, 1, 2, 'category'),
(1, 14, 1, 3, 'category'),
(1, 15, 1, 3, 'model'),
(1, 16, 1, 3, 'fields'),
(1, 17, 1, 3, 'type'),
(1, 18, 1, 2, 'content'),
(1, 19, 1, 3, 'content'),
(1, 20, 1, 3, 'banner'),
(1, 21, 1, 3, 'ads'),
(1, 22, 1, 3, 'comment'),
(1, 23, 1, 3, 'cache'),
(1, 24, 1, 3, 'recycle'),
(1, 25, 1, 2, 'user'),
(1, 26, 1, 3, 'member'),
(1, 27, 1, 3, 'level'),
(1, 28, 1, 3, 'admin'),
(1, 29, 1, 3, 'role'),
(1, 30, 1, 3, 'node'),
(1, 31, 1, 2, 'wechat'),
(1, 32, 1, 3, 'keyword'),
(1, 33, 1, 3, 'auto'),
(1, 34, 1, 3, 'attention'),
(1, 35, 1, 3, 'config'),
(1, 36, 1, 3, 'menu'),
(1, 37, 1, 2, 'shop'),
(1, 38, 1, 3, 'goods'),
(1, 39, 1, 3, 'orders'),
(1, 40, 1, 3, 'category'),
(1, 41, 1, 3, 'type'),
(1, 42, 1, 3, 'brand'),
(1, 43, 1, 3, 'comment'),
(1, 44, 1, 3, 'accountwater'),
(1, 45, 1, 3, 'settings'),
(1, 46, 1, 2, 'expand'),
(1, 47, 1, 3, 'log'),
(1, 48, 1, 3, 'databack'),
(1, 49, 1, 3, 'upgrade'),
(1, 50, 1, 3, 'elogo'),
(1, 51, 1, 3, 'visit');

DROP TABLE IF EXISTS `np_node`;
CREATE TABLE IF NOT EXISTS `np_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '节点操作名',
  `title` varchar(50) DEFAULT NULL COMMENT '节点说明',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `level` tinyint(1) unsigned NOT NULL COMMENT '等级',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT '节点表';
INSERT INTO np_node(`id`, `name`, `title`, `status`, `remark`, `sort`, `pid`, `level`) VALUES
(1, 'admin', '后台', 1, '后台模块', 0, 0, 1),
(2, 'Settings', '设置', 1, '设置控制器', 1, 1, 2),
(3, 'info', '系统信息', 1, '系统信息方法', 2, 2, 3),
(4, 'basic', '基本设置', 1, '基本设置方法', 3, 2, 3),
(5, 'lang', '语言设置', 1, '语言设置方法', 4, 2, 3),
(6, 'image', '图片设置', 1, '图片设置方法', 5, 2, 3),
(7, 'safe', '安全与效率设置', 1, '安全与效率设置方法', 6, 2, 3),
(8, 'email', '邮件设置设置', 1, '邮件设置方法', 7, 2, 3),

(9, 'theme', '界面', 1, '界面控制器', 1, 1, 2),
(10, 'template', '网站界面设置', 1, '网站界面设置方法', 2, 9, 3),
(11, 'member', '会员界面设置', 1, '会员界面设置方法', 3, 9, 3),
(12, 'shop', '商城界面设置', 1, '商城界面设置方法', 4, 9, 3),

(13, 'category', '栏目', 1, '栏目控制器', 1, 1, 2),
(14, 'category', '管理栏目', 1, '管理栏目方法', 2, 13, 3),
(15, 'model', '管理模型', 1, '管理模型方法', 3, 13, 3),
(16, 'fields', '自定义字段', 1, '自定义字段', 4, 13, 3),
(17, 'type', '管理类别', 1, '管理类别方法', 5, 13, 3),

(18, 'content', '内容', 1, '内容控制器', 1, 1, 2),
(19, 'content', '管理内容', 1, '管理内容方法', 2, 18, 3),
(20, 'banner', '管理幻灯片', 1, '管理幻灯片方法', 3, 18, 3),
(21, 'ads', '管理广告', 1, '管理广告方法', 4, 18, 3),
(22, 'comment', '管理评论', 1, '管理评论方法', 5, 18, 3),
(23, 'cache', '更新缓存或静态', 1, '更新缓存或静态方法', 6, 18, 3),
(24, 'recycle', '内容回收站', 1, '内容回收站方法', 7, 18, 3),

(25, 'user', '用户', 1, '用户控制器', 1, 1, 2),
(26, 'member', '会员管理', 1, '会员管理方法', 2, 25, 3),
(27, 'level', '会员等级管理', 1, '会员等级管理方法', 3, 25, 3),
(28, 'admin', '管理员管理', 1, '管理员管理方法', 4, 25, 3),
(29, 'role', '管理员组管理', 1, '管理员组管理方法', 5, 25, 3),
(30, 'node', '系统节点管理', 1, '系统节点管理方法', 6, 25, 3),

(31, 'wechat', '微信', 1, '微信控制器', 1, 1, 2),
(32, 'keyword', '关键词自动回复', 1, '关键词自动回复方法', 2, 31, 3),
(33, 'auto', '默认自动回复', 1, '默认自动回复方法', 3, 31, 3),
(34, 'attention', '关注自动回复', 1, '关注自动回复方法', 4, 31, 3),
(35, 'config', '接口配置', 1, '接口配置方法', 5, 31, 3),
(36, 'menu', '自定义菜单', 1, '自定义菜单方法', 6, 31, 3),

(37, 'shop', '商城', 1, '商城控制器', 1, 1, 2),
(38, 'goods', '管理商品', 1, '管理商品方法', 2, 37, 3),
(39, 'orders', '管理订单', 1, '管理订单方法', 3, 37, 3),
(40, 'category', '管理商城导航', 1, '管理商城导航方法', 4, 37, 3),
(41, 'type', '管理商品分类', 1, '管理商品分类方法', 5, 37, 3),
(42, 'brand', '管理商品品牌', 1, '管理商品品牌方法', 6, 37, 3),
(43, 'comment', '管理商品评论', 1, '管理商品评论方法', 7, 37, 3),
(44, 'accountwater', '账户流水', 1, '账户流水方法', 8, 37, 3),
(45, 'settings', '商城设置', 1, '商城设置方法', 9, 37, 3),

(46, 'expand', '扩展', 1, '扩展控制器', 1, 1, 2),
(47, 'log', '系统日志', 1, '系统日志方法', 2, 46, 3),
(48, 'databack', '数据与备份', 1, '数据与备份方法', 3, 46, 3),
(49, 'upgrade', '在线升级', 1, '在线升级方法', 4, 46, 3),
(50, 'elog', '错误日志', 1, '错误日志方法', 5, 46, 3),
(51, 'visit', '访问统计', 1, '访问统计方法', 6, 46, 3);

DROP TABLE IF EXISTS `np_role`;
CREATE TABLE IF NOT EXISTS `np_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '组名',
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '组表';
INSERT INTO np_role(`name`, `pid`, `status`, `remark`) VALUES('创始人', 0, 1, '创始人');

DROP TABLE IF EXISTS `np_role_admin`;
CREATE TABLE IF NOT EXISTS `np_role_admin` (
  `user_id` smallint(6) unsigned NOT NULL COMMENT '管理员ID',
  `role_id` smallint(6) unsigned DEFAULT NULL COMMENT '组ID',
  PRIMARY KEY (`user_id`),
  KEY `group_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '管理员组关系表';
INSERT INTO np_role_admin(`role_id`, `user_id`) VALUES(1, 1);

DROP TABLE IF EXISTS `np_admin`;
CREATE TABLE IF NOT EXISTS `np_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `email` varchar(40) NOT NULL COMMENT '邮箱',
  `salt` char(6) NOT NULL COMMENT '佐料',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '登录IP',
  `last_login_ip_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '登录IP地区',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `password` (`password`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '管理员表';
INSERT INTO np_admin(`username`, `password`, `email`, `salt`) VALUES('levisun', 'de0c5656615eb18d37cfad23e084449b', 'levisun@mail.com', '0af476');
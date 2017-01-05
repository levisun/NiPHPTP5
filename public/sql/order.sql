DROP TABLE IF EXISTS `np_pay`;
CREATE TABLE IF NOT EXISTS `np_pay` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '支付名称',
  `config` text NOT NULL COMMENT '配置',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '支付方法表';

DROP TABLE IF EXISTS `np_account_log`;
CREATE TABLE IF NOT EXISTS `np_account_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '流入流出金额',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '流入流出积分',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型 1充值 2支付 3提现 4转账',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '会员帐户流水';

DROP TABLE IF EXISTS `np_order`;
CREATE TABLE IF NOT EXISTS `np_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `trade_no` varchar(32) NOT NULL DEFAULT '0' COMMENT '订单号',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '金额',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `pay_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付类型',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 1待支付 2已支付待发货 3发货 4确认收货 5退货 6退款',
  `pay_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `confirm_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '确认时间',
  `return_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '退货时间',
  `refund_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '退款时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '订单表';

DROP TABLE IF EXISTS `np_order_address`;
CREATE TABLE IF NOT EXISTS `np_order_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `consignee` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `country` smallint(6) unsigned NOT NULL DEFAULT '1' COMMENT '国家',
  `province` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '省',
  `city` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '市',
  `district` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `address` varchar(50) NOT NULL DEFAULT '' COMMENT '地址',
  `zipcode` varchar(50) NOT NULL DEFAULT '' COMMENT '邮政编码',
  `tel` varchar(50) NOT NULL DEFAULT '' COMMENT '电话',
  `mobile` varchar(50) NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '订单收货地址';

DROP TABLE IF EXISTS `np_order_info`;
CREATE TABLE IF NOT EXISTS `np_order_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '金额',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '订单详情表';
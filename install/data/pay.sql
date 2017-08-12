DROP TABLE IF EXISTS `np_pay`;
CREATE TABLE IF NOT EXISTS `np_pay` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '支付名称',
  `config` text NOT NULL COMMENT '配置',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '支付方法表';

DROP TABLE IF EXISTS `np_pay_log`;
CREATE TABLE IF NOT EXISTS `np_pay_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `pay_amount` int(11) NOT NULL DEFAULT '0' COMMENT '金额',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `order_id` (`order_id`)
  KEY `status` (`status`)
  KEY `create_time` (`create_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '支付日志表';


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
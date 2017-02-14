DROP TABLE IF EXISTS `np_order`;
CREATE TABLE IF NOT EXISTS `np_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(32) NOT NULL DEFAULT '0' COMMENT '订单号',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商户ID',
  `amount` int(11) NOT NULL DEFAULT '0' COMMENT '金额',
  `bonus` int(11) NOT NULL DEFAULT '0' COMMENT '红包',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `pay_amount` int(11) NOT NULL DEFAULT '0' COMMENT '支付金额',
  `pay_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付类型',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 1待支付 2已支付待发货 3发货 4确认收货 5退货 6退款',
  `pay_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `confirm_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '确认时间',
  `return_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '退货时间',
  `refund_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '退款时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `trade_no` (`trade_no`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '订单表';

DROP TABLE IF EXISTS `np_order_goods`;
CREATE TABLE IF NOT EXISTS `np_order_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_amount` int(11) NOT NULL DEFAULT '0' COMMENT '商品总金额',
  `goods_number` int(11) NOT NULL DEFAULT '0' COMMENT '商品数目',
  `goods_price` int(11) NOT NULL DEFAULT '0' COMMENT '商品价格',
  `goods_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '商品属性',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '订单商品表';

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
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '订单收货地址';



DROP TABLE IF EXISTS `np_bonus`;
CREATE TABLE IF NOT EXISTS `np_bonus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '红包类型',
  `use_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '使用时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `overdue_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `type` (`type`),
  KEY `use_time` (`use_time`),
  KEY `overdue_time` (`overdue_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '红包表';

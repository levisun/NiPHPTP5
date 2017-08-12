DROP TABLE IF EXISTS `ecs_order_ext`;
CREATE TABLE IF NOT EXISTS `ecs_order_ext` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `coupons_prize` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券商品抽奖',
  `coupons_prize_count` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券商品抽奖总次数',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '订单扩展表';

DROP TABLE IF EXISTS `ecs_parity_mall`;
CREATE TABLE IF NOT EXISTS `ecs_parity_mall` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '商城名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '比价商城表';
INSERT INTO `ecs_parity_mall` (`name`, `status`) VALUES
('天猫', 1),
('京东', 1),
('唯品会', 1),
('1号店', 1),
('聚美', 1),
('苏宁易购', 1),
('国美', 1),
('淘宝', 1),
('一淘', 1);

DROP TABLE IF EXISTS `ecs_parity`;
CREATE TABLE IF NOT EXISTS `ecs_parity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `mall_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '商城ID',
  `price` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '价格 单位分',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下架时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`),
  KEY `mall_id` (`mall_id`),
  KEY `end_time` (`end_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '商品比价表';



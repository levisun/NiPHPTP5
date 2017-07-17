DROP TABLE IF EXISTS `np_mall_goods`;
CREATE TABLE IF NOT EXISTS `np_mall_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` smallint(6) unsigned NOT NULL COMMENT '分类ID',
  `brand_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `name` varchar(255) NOT NULL COMMENT '商品名',
  `content` mediumtext NOT NULL COMMENT '描述',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `price` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '价格',
  `market_price` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '市场价格',
  `number` int(11) unsigned NOT NULL DEFAULT '1000' COMMENT '库存',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '显示',
  `is_com` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '置顶',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '最热',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论量',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `delete_time` int(11) unsigned DEFAULT NULL COMMENT '删除时间',
  `lang` varchar(20) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `brand_id` (`brand_id`),
  KEY `is_pass` (`is_pass`),
  KEY `is_show` (`is_show`),
  KEY `is_com` (`is_com`),
  KEY `is_top` (`is_top`),
  KEY `is_hot` (`is_hot`),
  KEY `number` (`number`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商品表';

DROP TABLE IF EXISTS `np_mall_goods_promote`;
CREATE TABLE IF NOT EXISTS `np_mall_goods_promote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `promote_price` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '促销价格',
  `promote_start_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '促销开始时间',
  `promote_ent_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '促销结束时间',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`),
  KEY `promote_start_time` (`promote_start_time`),
  KEY `promote_ent_time` (`promote_ent_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商品促销表';;

DROP TABLE IF EXISTS `np_mall_goods_album`;
CREATE TABLE IF NOT EXISTS `np_mall_goods_album` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) unsigned NOT NULL COMMENT '图文ID',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '原图',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品相册表';

DROP TABLE IF EXISTS `np_mall_goods_attr`;
CREATE TABLE IF NOT EXISTS `np_mall_goods_attr` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(6) unsigned NOT NULL COMMENT '父ID',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '小图标',
  `number` int(11) unsigned NOT NULL DEFAULT '1000' COMMENT '库存',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `goods_id` (`goods_id`),
  KEY `number` (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商品属性表';
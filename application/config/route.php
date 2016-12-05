<?php
/**
 *
 * 路由配置文件
 *
 * @package   NiPHPCMS
 * @category  config\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: route.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
return [
	'/'                => 'index',
	'entry/:cid'       => 'index/index/entry',
	'article/:cid/:id' => 'index/index/article',
	'tags/:id'         => 'index/index/tags',
	'message/:id'      => 'index/index/message',
	'feedback/:id'     => 'index/index/feedback',
	'jump/:cid/:id'    => 'index/index/jump',
];

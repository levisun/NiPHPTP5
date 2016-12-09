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
	'jump/:cid/:id'    => 'index/index/jump',


	'member'           => 'index/member/index',
	'member/account'   => 'index/member/account',


	'mall'             => 'index/mall/index',
	'mall/item/:id'    => 'index/mall/item',
	'mall/order/:id'   => 'index/mall/order',
	'mall/cart'        => 'index/mall/cart',
	'mall/shop/:id'    => 'index/mall/shop',
];

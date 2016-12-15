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

	// website
	'entry/:cid'       => 'index/entry/index',
	'article/:cid/:id' => 'index/article/index',
	'tags/:id'         => 'index/tags/index',
	'jump/:cid/:id'    => 'index/jump/index',

	// comment
	'comment/:cid'     => 'index/comment/index',
	'comment/added'    => 'index/comment/added',

	// member
	'member/login'     => 'member/index/login',
	'member/logout'    => 'member/index/logout',
	'member/reg'       => 'member/index/reg',
	'member/forget'    => 'member/index/forget',
	'member'           => 'member/my/index',

	// mall
	'mall'             => 'index/mall/index',
	'mall/item/:id'    => 'index/mall/item',
	'mall/order/:id'   => 'index/mall/order',
	'mall/cart'        => 'index/mall/cart',
	'mall/shop/:id'    => 'index/mall/shop',
];

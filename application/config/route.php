<?php
/**
 *
 * 路由配置文件
 *
 * @package   NiPHPCMS
 * @category  config\extra
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: route.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
return [
	// 全局变量规则定义
    '__pattern__' => [
        'cid' => '\d+',
        'id'  => '\d+',
    ],

	'/' => 'index',

	// website
	'entry/:cid'       => 'index/entry/index',
	'article/:cid/:id' => 'index/article/index',
	'tags/:id'         => 'index/tags/index',
	'jump/:cid/:id'    => 'index/jump/index',
	'wechat'           => 'wechat/index/index',

	// comment
	'comment/:cid'     => 'index/comment/index',
	'comment/added'    => 'index/comment/added',

	// member
	'member/login'                 => 'member/index/login',
	'member/oauth/:type/[:method]' => 'member/index/oauth',
	'member/logout'                => 'member/index/logout',
	'member/reg'                   => 'member/index/reg',
	'member/forget'                => 'member/index/forget',
	'member'                       => 'member/my/index',

	// mall
	'mall'           => 'mall/index/index',
	'mall/item/:id'  => 'mall/index/item',
	'mall/order/:id' => 'mall/order/index',
	'mall/cart'      => 'mall/cart/index',
	'mall/shop/:id'  => 'mall/shop/index',
];

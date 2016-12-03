<?php
/**
 *
 * 广告 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Ads.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/28
 */
namespace app\admin\validate;
use think\Validate;
class Ads extends Validate
{
	protected $rule = [
		'id'         => ['require', 'number'],
		'name'       => ['require', 'length:2,255', 'token'],
		'width'      => ['require', 'number'],
		'height'     => ['require', 'number'],
		'image'      => ['require', 'max:255'],
		'url'        => ['require', 'url', 'max:500'],
		'start_time' => ['require', 'date'],
		'end_time'   => ['require', 'date']
	];

	protected $message = [
		'id.require'         => 'illegal operation',
		'id.number'          => 'illegal operation',
		'name.require'       => 'error ads name require',
		'name.length'        => 'error ads name length not',
		'width.require'      => 'error width require',
		'width.number'       => 'error width number',
		'height.require'     => 'error height require',
		'height.number'      => 'error height number',
		'image.require'      => 'error image require',
		'image.max'          => 'error image length not',
		'url.require'        => 'error url require',
		'url.url'            => 'error url url',
		'url.max'            => 'error url length not',
		'start_time.require' => 'error start_time require',
		'start_time.date'    => 'error start_time date',
		'end_time.require'   => 'error end_time require',
		'end_time.date'      => 'error end_time date',
	];

	protected $scene = [
		'added' => [
			'name',
			'width',
			'height',
			'image',
			'url',
			'start_time',
			'end_time'
		],
		'editor' => [
			'id',
			'name',
			'width',
			'height',
			'image',
			'url',
			'start_time',
			'end_time'
		],
		'illegal' => ['id'],
		'remove' => ['id'],
	];
}
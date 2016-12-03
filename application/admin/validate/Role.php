<?php
/**
 *
 * 管理员组 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Role.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/10
 */
namespace app\admin\validate;
use think\Validate;
class Role extends Validate
{
	protected $rule = [
		'id'     => ['require', 'number'],
		'name'   => ['require', 'length:2,20', 'unique:role', 'token'],
		'status' => ['require', 'number'],
		'remark' => ['max:250'],
	];

	protected $message = [
		'id.require'     => 'illegal operation',
		'id.number'      => 'illegal operation',
		'name.require'   => 'error rolename require',
		'name.length'    => 'error rolename length not',
		'name.unique'    => 'error rolename unique',
		'status.require' => 'error status require',
		'status.number'  => 'error status number',
		'remark.max'     => 'error remark length not',
	];

	protected $scene = [
		'added' => [
			'name',
			'status',
			'remark'
		],
		'editor' => [
			'id',
			'name',
			'status',
			'remark'
		],
		'illegal' => ['id'],
		'remove' => ['id'],
	];
}
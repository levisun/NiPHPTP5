<?php
/**
 *
 * 组表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Role.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/03
 */
namespace app\admin\model;
use think\Model;
class Role extends Model
{
	protected $name = 'role';
	protected $autoWriteTimestamp = false;
	protected $field = [
		'id',
		'name',
		'pid',
		'status',
		'remark'
	];
}
<?php
/**
 *
 * 权限表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Access.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/29
 */
namespace app\admin\model;
use think\Model;
class Access extends Model
{
	protected $name = 'access';
	protected $autoWriteTimestamp = false;
	protected $updateTime = false;
	protected $pk = 'id';
	protected $field = [
		'id',
		'role_id',
		'node_id',
		'status',
		'level',
		'module'
	];
}
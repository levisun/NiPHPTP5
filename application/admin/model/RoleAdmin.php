<?php
/**
 *
 * 管理员组关系表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: RoleAdmin.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/03
 */
namespace app\admin\model;
use think\Model;
class RoleAdmin extends Model
{
	protected $name = 'role_admin';
	protected $autoWriteTimestamp = false;
	protected $field = [
		'user_id' => 'int',
		'role_id' => 'int',
	];
}
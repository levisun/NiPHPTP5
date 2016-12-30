<?php
/**
 *
 * 管理员表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Admin.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\model;
use think\Model;
class Admin extends Model
{
	protected $name = 'admin';
	protected $autoWriteTimestamp = true;
	protected $updateTime = 'last_login_time';
	protected $pk = 'id';
	protected $field = [
		'id',
		'username',
		'password',
		'email',
		'salt',
		'last_login_ip',
		'last_login_ip_attr',
		'last_login_time',
		'create_time',
		'update_time'
	];
}
<?php
/**
 *
 * 行为日志表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ActionLog.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/29
 */
namespace app\admin\model;
use think\Model;
class ActionLog extends Model
{
	protected $name = 'action_log';
	protected $autoWriteTimestamp = true;
	protected $updateTime = false;
	protected $field = [
		'action_id'   => 'int',
		'user_id'     => 'int',
		'action_ip',
		'model',
		'record_id'   => 'int',
		'remark',
		'create_time' => 'int',
	];
}
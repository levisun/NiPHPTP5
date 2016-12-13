<?php
/**
 *
 * 留言扩展表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: MessageData.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/03
 */
namespace app\admin\model;
use think\Model;
class MessageData extends Model
{
	protected $name = 'message_data';
	protected $autoWriteTimestamp = false;
	protected $field = [
		'id'        => 'int',
		'main_id'   => 'int',
		'fields_id' => 'int',
		'data'
	];
}
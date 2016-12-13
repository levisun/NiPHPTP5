<?php
/**
 *
 * 评论表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Comment.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/03
 */
namespace app\admin\model;
use think\Model;
class Comment extends Model
{
	protected $name = 'comment';
	protected $autoWriteTimestamp = true;
	protected $updateTime = false;
	protected $field = [
		'id' => 'int',
		'category_id' => 'int',
		'content_id'  => 'int',
		'user_id'     => 'int',
		'pid'         => 'int',
		'content',
		'is_pass'     => 'int',
		'is_report'   => 'int',
		'support'     => 'int',
		'report_time' => 'int',
		'ip',
		'ip_attr',
		'create_time' => 'int',
		'lang'
	];
}
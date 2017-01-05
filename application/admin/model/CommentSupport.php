<?php
/**
 *
 * 评论支持表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CommentReport.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/03
 */
namespace app\admin\model;
use think\Model;
class CommentReport extends Model
{
	protected $name = 'comment_support';
	protected $autoWriteTimestamp = true;
	protected $updateTime = false;
	protected $pk = 'id';
	protected $field = [
		'id',
		'create_time',
		'comment_id',
		'user_id',
		'ip',
		'ip_attr'
	];
}
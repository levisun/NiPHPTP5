<?php
/**
 *
 * 友链表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Link.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/29
 */
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Link extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $name = 'link';
	protected $autoWriteTimestamp = true;
	protected $field = [
		'id'          => 'int',
		'title',
		'logo',
		'description',
		'category_id' => 'int',
		'type_id'     => 'int',
		'mebmer_id'   => 'int',
		'is_pass'     => 'int',
		'sort'        => 'int',
		'hits'        => 'int',
		'user_id'     => 'int',
		'url',
		'create_time' => 'int',
		'update_time' => 'int',
		'delete_time' => 'int',
		'lang'
	];
}
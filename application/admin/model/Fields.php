<?php
/**
 *
 * 自定义字段表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Fields.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/02
 */
namespace app\admin\model;
use think\Model;
class Fields extends Model
{
	protected $name = 'fields';
	protected $autoWriteTimestamp = false;
	protected $field = [
		'id',
		'category_id',
		'type_id',
		'name',
		'description',
		'is_require'
	];
}
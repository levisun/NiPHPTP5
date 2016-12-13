<?php
/**
 *
 * 栏目表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Category.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\model;
use think\Model;
class Category extends Model
{
	protected $name = 'category';
	protected $autoWriteTimestamp = true;
	protected $field = [
		'id'          => 'int',
		'pid'         => 'int',
		'name',
		'aliases',
		'seo_title',
		'seo_keywords',
		'seo_description',
		'image',
		'type_id'     => 'int',
		'model_id'    => 'int',
		'is_show'     => 'int',
		'is_channel'  => 'int',
		'sort'        => 'int',
		'access_id'   => 'int',
		'url',
		'create_time' => 'int',
		'update_time' => 'int',
		'lang'
	];
}
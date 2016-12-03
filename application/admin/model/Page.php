<?php
/**
 *
 * 单页表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Page.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/03
 */
namespace app\admin\model;
use think\Model;
class Page extends Model
{
	protected $name = 'page';
	protected $autoWriteTimestamp = true;
	protected $field = [
		'id',
		'title',
		'keywords',
		'description',
		'content',
		'thumb',
		'category_id',
		'type_id',
		'is_pass',
		'is_com',
		'is_top',
		'is_hot',
		'sort',
		'hits',
		'comment_count',
		'username',
		'origin',
		'user_id',
		'url',
		'is_link',
		'show_time',
		'create_time',
		'update_time',
		'delete_time',
		'access_id',
		'lang'
	];
}
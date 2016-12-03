<?php
/**
 *
 * 文章扩展表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ArticleData.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/29
 */
namespace app\admin\model;
use think\Model;
class ArticleData extends Model
{
	protected $name = 'article_data';
	protected $autoWriteTimestamp = false;
	protected $field = [
		'id',
		'main_id',
		'fields_id',
		'data'
	];
}
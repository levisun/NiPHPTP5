<?php
/**
 *
 * 图文扩展表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: PictureData.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/03
 */
namespace app\admin\model;
use think\Model;
class PictureData extends Model
{
	protected $name = 'picture_data';
	protected $autoWriteTimestamp = false;
	protected $field = [
		'id'        => 'int',
		'main_id'   => 'int',
		'fields_id' => 'int',
		'data'
	];
}
<?php
/**
 *
 * 广告表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Ads.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/29
 */
namespace app\admin\model;
use think\Model;
class Ads extends Model
{
	protected $name = 'ads';
	protected $autoWriteTimestamp = true;
	protected $field = [
		'id'          => 'int',
		'name',
		'width',
		'height',
		'image',
		'url',
		'hits'        => 'int',
		'start_time'  => 'int',
		'end_time'    => 'int',
		'create_time' => 'int',
		'update_time' => 'int',
		'lang'
	];
}
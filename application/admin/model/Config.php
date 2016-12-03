<?php
/**
 *
 * 配置表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Account.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\model;
use think\Model;
class Config extends Model
{
	protected $name = 'config';
	protected $field = [
		'id',
		'name',
		'value',
		'lang'
	];
}
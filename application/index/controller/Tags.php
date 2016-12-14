<?php
/**
 *
 * 标签 - 控制器
 *
 * @package   NiPHPCMS
 * @category  index\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Tags.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\controller;
use think\Loader;
use think\Url;
use think\Lang;
use app\index\controller\Common;
use app\index\logic\Jump as IndexJump;
class Tags extends Common
{
	protected $beforeActionList = [
		'first',
	];

	public function index()
	{
		return $this->fetch('entry/tags');
	}
}
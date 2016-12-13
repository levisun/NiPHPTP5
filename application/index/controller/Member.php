<?php
/**
 *
 * 会员 - 控制器
 *
 * @package   NiPHPCMS
 * @category  index\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Member.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\controller;
use think\Loader;
use think\Url;
use think\Lang;
use app\index\controller\Common;
class Member extends Common
{
	protected $beforeActionList = [
		'first'
	];

	public function login()
	{
		// return $this->fetch('index/login');
	}

	public function index()
	{
		halt('member');
	}

	public function first()
	{
		trace(1);
	}
}
<?php
/**
 *
 * 首页 - 控制器
 *
 * @package   NiPHPCMS
 * @category  member\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Index.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\member\controller;
use app\index\controller\Common;
class Index extends Common
{
	protected $beforeActionList = [
		'first'
	];
	protected $user_data = [];

	public function login()
	{
		// return $this->fetch();
	}

	public function index()
	{
		return $this->fetch();
	}

	public function first()
	{
		cookie(config("USER_AUTH_KEY"));
	}
}
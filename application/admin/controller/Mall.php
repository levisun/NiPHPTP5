<?php
/**
 *
 * 商城 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Mall.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\controller;
use think\Controller;
use think\Url;
class Mall extends Controller
{

	/**
	 * 商品管理
	 * @access public
	 * @param
	 * @return string
	 */
	public function goods()
	{
		return $this->fetch();
	}
}
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
use app\admin\controller\Base;
class Mall extends Base
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

	public function accountflow()
	{
		return $this->fetch();
	}

	/**
	 * 商城设置
	 * @access public
	 * @param
	 * @return string
	 */
	public function settings()
	{
		$data = parent::editor('MallSettings', 'Config.mall', 'config_editor', false);
		$this->assign('data', $data);
		return $this->fetch();
	}
}
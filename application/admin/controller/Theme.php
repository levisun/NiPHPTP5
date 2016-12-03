<?php
/**
 *
 * 模板 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Theme.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/16
 */
namespace app\admin\controller;
use app\admin\controller\Common;
use think\Loader;
use think\Lang;
use think\Url;
class Theme extends Common
{

	/**
	 * 网站
	 * @access public
	 * @param
	 * @return mixed
	 */
	public function template()
	{
		return $this->theme();
	}

	/**
	 * 会员
	 * @access public
	 * @param
	 * @return mixed
	 */
	public function member()
	{
		return $this->theme();
	}

	/**
	 * 商城
	 * @access public
	 * @param
	 * @return mixed
	 */
	public function shop()
	{
		return $this->theme();
	}

	protected function theme()
	{
		if ($this->method == 'update') {
			$result = Loader::model('ThemeTemplate', 'logic')->editor();
			if (true === $result) {
				$this->actionLog('config_editor');
				$url = Url::build($this->request->action());
				$this->success(Lang::get('success update'), $url);
			} else {
				$this->error(Lang::get('error update'));
			}
		}

		$data = parent::select('ThemeTemplate');
		$this->assign('list', $data['list']);
		$this->assign('config', $data['config']);
		$this->assign('type', $data['type']);
		return $this->fetch('template');
	}
}
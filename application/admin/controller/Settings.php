<?php
/**
 *
 * 帐户 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Settings.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\controller;
use app\admin\controller\Common;
use think\Loader;
class Settings extends Common
{

	/**
	 * 系统信息
	 * @access public
	 * @param
	 * @return string
	 */
	public function info()
	{
		$this->assign('data', Loader::model('SettingsInfo', 'logic')->getSysInfo());
		return $this->fetch();
	}

	/**
	 * 基本设置
	 * @access public
	 * @param
	 * @return string
	 */
	public function basic()
	{
		$data = parent::editor('SettingsBasic', 'Config.basic', 'config_editor', false);
		$this->assign('data', $data);
		return $this->fetch();
	}

	/**
	 * 语言设置
	 * @access public
	 * @param
	 * @return string
	 */
	public function lang()
	{
		$data = parent::editor('SettingsLang', 'Config.lang', 'config_editor', false);
		$this->assign('lang_list', $data['lang_list']);
		$this->assign('sys_default_lang', $data['sys_default_lang']);
		$this->assign('web_default_lang', $data['web_default_lang']);
		$this->assign('lang_switch_on', $data['lang_switch_on']);
		return $this->fetch();
	}

	/**
	 * 图片设置
	 * @access public
	 * @param
	 * @return string
	 */
	public function image()
	{
		$data = parent::editor('SettingsImage', 'Config.image', 'config_editor', false);
		$this->assign('data', $data);
		return $this->fetch();
	}

	/**
	 * 安全与效率
	 * @access public
	 * @param
	 * @return string
	 */
	public function safe()
	{
		$data = parent::editor('SettingsSafe', 'Config.safe', 'config_editor', false);
		$this->assign('data', $data);
		return $this->fetch();
	}

	/**
	 * 邮箱设置
	 * @access public
	 * @param
	 * @return string
	 */
	public function email()
	{
		$data = parent::editor('SettingsEmail', 'Config.email', 'config_editor', false);
		$this->assign('data', $data);
		return $this->fetch();
	}
}
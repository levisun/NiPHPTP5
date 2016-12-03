<?php
/**
 *
 * 系统信息 - 设置 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: SettingsInfo.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\logic;
use think\Model;
use think\Request;
use think\Config;
use app\admin\model\Member as AdminMember;
use app\admin\model\Feedback as AdminFeedback;
use app\admin\model\Message as AdminMessage;
use app\admin\model\Link as AdminLink;
use app\admin\model\Ads as AdminAds;
class SettingsInfo extends Model
{
	protected $request = null;

	protected function initialize()
	{
		parent::initialize();

		$this->request = Request::instance();
	}

	/**
	 * 获得系统信息
	 * @access public
	 * @param
	 * @return array
	 */
	public function getSysInfo()
	{
		$sys_data = [
			'os' => PHP_OS,
			'env' => $_SERVER['SERVER_SOFTWARE'],
			'php_version' => PHP_VERSION,
			'db_type' => Config::get('database.type'),
		];

		$db_version =
		$this->query('SELECT version()');
		$sys_data['db_version'] = $db_version[0]['version()'];

		$member = new AdminMember;
		$sys_data['member'] = $member->count();
		$sys_data['member_reg'] = $member->where(['status' => 0])->count();

		$feedback = new AdminFeedback;
		$sys_data['feedback'] = $feedback->count();

		$message = new AdminMessage;
		$sys_data['message'] = $message->count();

		$link = new AdminLink;
		$sys_data['link'] = $link->count();

		$ads = new AdminAds;
		$sys_data['ads'] = $ads->where(['end_time' => ['egt', time()]])->count();

		return $sys_data;
	}
}
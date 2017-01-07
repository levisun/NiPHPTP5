<?php
/**
 *
 * 第三方登录 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  member\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: OAuth.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\member\logic;
use think\Model;
use think\Request;
use think\Url;
class OAuth extends Model
{
	protected $request = null;

	protected function initialize()
	{
		parent::initialize();

		$this->request = Request::instance();
	}

	public function login()
	{
		if ($this->request->has('method') && $this->request->param('method') == 'callback') {
			return $this->callback();
		} else {
			return $this->authorizeURL();
		}
	}

	/**
	 * 请求回调
	 * @access private
	 * @param
	 * @return array
	 */
	private function callback()
	{
		$type = $this->request->param('type');

		if ($this->request->isMobile()) {
			$display = 'mobile';
		} else {
			$display = 'default';
		}

		$class = '\\net\\oauth\\' . $type;

		$oauth = new $class($this->config(), $display);
		$oauth->getAccessToken();

		$oauth->userinfo();

		return Url::build('/member');
	}

	/**
	 * 请求Authorize访问地址
	 * @access private
	 * @param
	 * @return array
	 */
	private function authorizeURL()
	{
		$type = $this->request->param('type');

		if ($this->request->isMobile()) {
			$display = 'mobile';
		} else {
			$display = 'default';
		}

		$class = '\\net\\oauth\\' . $type;

		$oauth = new $class($this->config(), $display);
		return $oauth->getAuthorizeURL();
	}

	/**
	 * 获得OAuth设置
	 * @access private
	 * @param
	 * @return array
	 */
	private function config()
	{
		$type = $this->request->param('type');

		// 获得域名地址
		$domain = $this->request->root(true);
		$domain = strtr($domain, [$this->request->root() => '', '/index.php' => '']);
		$callback = $domain . Url::build('/member/' . $type . '/callback');

		$config = [
			'app_key'    => '101252308',
			'app_secret' => '692a153a3e3f4076ceec0197dcf46478',
			'scope'      => 'get_user_info',
			'callback'   => [
				'default' => $callback,
				'mobile'  => $callback,
			]
		];

		return $config;
	}
}
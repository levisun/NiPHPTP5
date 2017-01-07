<?php
/**
 *
 * 第三方登陆实例抽象类
 *
 * @package   NiPHPCMS
 * @category  net\oauth\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: OAuth.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/01/03
 */
namespace net\oauth;
use net\oauth\Http as OAuthHttp;
use think\exception\HttpException;
use think\Cookie;
abstract class OAuth
{
	protected $config = [];				// 第三方配置属性
	protected $accessToken = null;		// 获取到的第三方Access Token
	protected $display = 'default';		// 请求授权页面展现形式
	protected $token;					// 获取到的Token信息
	private   $channel = '';			// 接口渠道
	protected $timestamp = '';			// 当前时间戳

	protected $AuthorizeURL;			// 获取requestCode的api接口
	protected $AccessTokenURL;			// 获取Access Token的api接口
	protected $ApiBase;					// API根路径

	public function __construct($config=null, $type)
	{
		if (empty($config) ||
			!array_key_exists('app_key', $config) ||
			!array_key_exists('app_secret', $config) ||
			!array_key_exists('callback', $config) ||
			!array_key_exists('scope', $config)
			){
			throw new HttpException(404, '请配置申请的APP_KEY和APP_SECRET');
        }

        $class           = get_class($this);
		$cls_arr         = explode('\\', $class);
		$this->channel   = strtoupper(end($cls_arr));

		$this->timestamp = time();
        $this->config    = array_merge($config, ['response_type' => 'code', 'grant_type' => 'authorization_code']);

        $this->setDisplay($type);
	}

	/**
	 * 设置授权页面样式，PC或者Mobile
	 * @access public
	 * @param  string $display
	 * @return void
	 */
	public function setDisplay($display)
	{
		if (in_array($display, ['default', 'mobile'])) {
			$this->display = $display;
		}
	}

	/**
	 * 初始化一些特殊配置
	 * @access protected
	 * @param
	 * @return void
	 */
	protected function initConfig() {
		$this->config['callback'] = $this->config['callback'][$this->display];
	}

	/**
	 * 合并默认参数和额外参数
	 * @access protected
	 * @param  array $params  默认参数
	 * @param  array/string $param 额外参数
	 * @return array:
	 */
	protected function param($params, $param) {
		if (is_string($param)) {
			parse_str($param, $param);
		}
		return array_merge($params, $param);
	}

	/**
	 * 默认的AccessToken请求参数
	 * @access protected
	 * @param
	 * @return array
	 */
	protected function _params()
	{
		$params = [
			'client_id'     => $this->config['app_key'],
			'client_secret' => $this->config['app_secret'],
			'grant_type'    => $this->config['grant_type'],
			'code'          => $_GET['code'],
			'redirect_uri'  => $this->config['callback'],
		];
		return $params;
	}

	/**
	 * 获取指定API请求的URL
	 * @access protected
	 * @param  string $api API名称
	 * @param  string $fix api后缀
	 * @return string      请求的完整URL
	 */
	protected function url($api, $fix='')
	{
		return $this->ApiBase . $api . $fix;
	}

	/**
	 * 获取access_token
	 * @access public
	 * @param  boolean $ignore_stat
	 * @return string
	 */
	public function getAccessToken($ignore_stat=false)
	{
		if ($ignore_stat === false && isset($_COOKIE['A_S']) && $_GET['state'] != $_COOKIE['A_S']) {
			throw new HttpException(404, '传递的STATE参数不匹配！');
		} else {
			$this->initConfig();
			$params      = $this->_params();
			$data        = OAuthHttp::post($this->AccessTokenURL, $params);
			$this->token = $this->parseToken($data);
			// setcookie('A_S', $this->timestamp, $this->timestamp - 600, '/');
			Cookie::delete('A_S');
			return $this->token;
		}
	}

	/**
	 * 请求Authorize访问地址
	 * @access public
	 * @param
	 * @return string
	 */
	abstract public function getAuthorizeURL();

	/**
	 * 组装接口调用参数 并调用接口
	 * @access public
	 * @param  string $api    请求API
	 * @param  string $param  调用API的额外参数
	 * @param  string $method HTTP请求方法 默认为GET
	 * @return json
	 */
	abstract public function call($api, $param='', $method='GET');

	/**
	 * 解析access_token方法请求后的返回值
	 * @access public
	 * @param  string $result 获取access_token的方法的返回值
	 * @return array
	 */
	abstract public function parseToken($result);

	/**
	 * 获取当前授权应用的openid
	 * @access public
	 * @param
	 * @return string
	 */
	abstract public function openid();

	/**
	 * 获取授权用户的用户信息
	 * @access public
	 * @param
	 * @return array
	 */
	abstract public function userinfo();
}
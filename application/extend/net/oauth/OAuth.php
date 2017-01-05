<?php
/**
 *
 */
abstract class OAuth
{
	protected $config = [];
	protected $accessToken = null;
	protected $display = 'default';
	protected $token;
	private   $channel = '';
	protected $timestamp = '';

	function __construct()
	{
		# code...
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
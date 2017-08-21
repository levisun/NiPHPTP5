<?php
/**
 *
 * 常用设置 - 公众 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  member\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Common.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\member\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Config;
use think\Cookie;
use think\Url;
use think\Cache;
use app\admin\model\Config as ModelConfig;

class Common extends Model
{
    protected $request = null;
    protected $to_html = [
        'bottom_message',
        'copyright',
        'script'
    ];

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 权限菜单
     * @access public
     * @param
     * @return array
     */
    public function getAuthMenu()
    {
        $CACHE = check_key([], __METHOD__);

        if ($CACHE && $auth_menu = Cache::get($CACHE)) {
            return $auth_menu;
        }

        $nav  = Lang::get('_nav');
        $menu = Lang::get('_menu');
        $auth_menu = array();
        foreach ($nav as $key => $value) {
            $controller = strtolower($key);
            $auth_menu[$controller]['name'] = $nav[$controller];
            $auth_menu[$controller]['url'] = Url::build('/my/' . $controller);

            foreach ($menu as $k => $val) {
                $arr = explode('_', strtolower($k));
                if ($arr[0] !== $controller) {
                    continue;
                }
                $auth_menu[$arr[0]]['menu'][$k] = [
                    'action' => $arr[1],
                    'url'    => Url::build('/my/' . $controller . '/' . $arr[1]),
                    'lang'   => $menu[$controller . '_' . $arr[1]],
                ];
            }
        }

        if ($CACHE) {
            Cache::set($CACHE, $auth_menu);
        }

        return $auth_menu;
    }

    /**
     * 权限验证
     * @access public
     * @param
     * @return mixed
     */
    public function accountAuth()
    {
        $action = explode(',', Config::get('NOT_AUTH_ACTION'));
        $user_auth_key = Cookie::get(Config::get('USER_AUTH_KEY'));

        if (!in_array($this->request->action(), $action) && !$user_auth_key) {
            return Url::build('/login');
        }
        if (in_array($this->request->action(), $action) && $user_auth_key) {
            return Url::build('/my');
        }

        return true;
    }

    /**
     * 获得网站基本设置数据
     * @access public
     * @param
     * @return array
     */
    public function getWetsiteData()
    {
        $map = [
            'name' => [
                'in',
                'website_name,website_keywords,website_description,bottom_message,copyright,script,'
                . strtolower($this->request->module()) . '_theme'
            ],
            'lang' => Lang::detect()
        ];

        $config = new ModelConfig;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $config->field(true)
        ->where($map)
        ->cache($CACHE, 0)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            if (in_array($value['name'], $this->to_html)) {
                $data[$value['name']] = htmlspecialchars_decode($value['value']);
            } else {
                $data[$value['name']] = $value['value'];
            }
        }

        return $data;
    }
}

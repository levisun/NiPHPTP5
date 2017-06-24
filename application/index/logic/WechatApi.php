<?php
/**
 *
 * 微信 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: WechatApi.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Config;
use think\Cookie;
use think\Url;
use think\Cache;
use net\Wechat;
use app\admin\model\Config as IndexConfig;
use app\admin\model\MemberWechat as IndexMemberWechat;

class WechatApi extends Model
{
    protected $request = null;
    protected $wechat;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();

        $data = $this->getConfig();
        $option = [
            'token'          => $data['wechat_token'],
            'encodingaeskey' => $data['wechat_encodingaeskey'],
            'appid'          => $data['wechat_appid'],
            'appsecret'      => $data['wechat_appsecret']
        ];

        $this->wechat = new Wechat($option);
    }

    /**
     * 获取JsApi使用签名
     * @access public
     * @param
     * @return mixed
     */
    public function getJsSign()
    {
        // 是否微信请求
        if (!is_wechat_request()) {
            return false;
        }

        return $this->wechat->getJsSign($this->request->url(true));
    }

    /**
     * 判断微信访问
     * 如访问查询微信用户信息并生成cookie
     * 不做缓存实时查询
     * @access public
     * @param
     * @return boolean
     */
    public function isWechat()
    {
        // 是否微信请求
        if (!is_wechat_request()) {
            return false;
        }

        // url openid参数 并记录cookie
        if ($this->request->has('openid', 'param')) {
            $openid = $this->request->param('openid');
            Cookie::set('WECHAT_OPENID', $openid);
        }

        // cookie存在
        if (Cookie::has('WECHAT_OPENID')) {
            $openid = Cookie::get('WECHAT_OPENID');

            $member_wechat = new IndexMemberWechat;

            $map = ['openid' => $openid];
            $result =
            $member_wechat->field(true)
            ->where($map)
            ->find();

            $wechat_data = $result->toArray();

            if ($wechat_data) {
                Cookie::set('WECHAT_DATA', $wechat_data);
            }

            return true;
        }

        return false;
    }

    /**
     * 更新微信用户信息
     * @access public
     * @param  array  $data
     * @param  string $openid
     * @param  int    $subscribe
     * @return void
     */
    public function wechatMemberInfo($data, $openid, $subscribe = 1)
    {
        if (empty($data)) {
            $data = [
                'openid' => $openid,
                'subscribe' => $subscribe
            ];
        } else {
            $data['subscribe'] = $subscribe;
        }

        $member_wechat = new IndexMemberWechat;
        $CACHE = check_key($map, __METHOD__);

        $map = ['openid' => $openid];
        $result =
        $member_wechat->field(true)
        ->where($map)
        ->cache($CACHE)
        ->find();

        if (!$result) {
            $member_wechat->allowField(true)
            ->isUpdate(false)
            ->data($data)
            ->save();
        } else {
            $member_wechat->allowField(true)
            ->isUpdate(true)
            ->save($data, $map);
        }
    }

    /**
     * 获得微信接口配置
     * @access private
     * @param
     * @return array
     */
    private function getConfig()
    {
        $map = [
            'name' => [
                'in',
                'wechat_token,wechat_encodingaeskey,wechat_appid,wechat_appsecret'
            ],
            'lang' => 'niphp'
        ];

        $config = new IndexConfig;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $config->field(true)
        ->where($map)
         ->cache($CACHE)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $data[$value['name']] = $value['value'];
        }

        return $data;
    }
}

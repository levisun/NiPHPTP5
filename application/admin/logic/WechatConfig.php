<?php
/**
 *
 * 关键词回复 - 微信 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: WechatKeyword.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/11
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use app\admin\model\Config as AdminConfig;

class WechatConfig extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 微信接口数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = [
            'name' => [
                'in', 'wechat_token,wechat_encodingaeskey,wechat_appid,wechat_appsecret'
            ],
            'lang' => 'niphp'
        ];

        $config = new AdminConfig;
        $result =
        $config->field(true)
        ->where($map)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $data[$value['name']] = $value['value'];
        }

        return $data;
    }

    /**
     * 修改邮件设置
     * @access public
     * @param
     * @return mixed
     */
    public function editor()
    {
        $config = new AdminConfig;

        $post_data = $this->request->post();
        foreach ($post_data as $key => $value) {
            $map = ['name' => $key];
            $data = ['value' => $value];

            $config->allowField(true)
            ->isUpdate(true)
            ->save($data, $map);
        }

        return true;
    }
}

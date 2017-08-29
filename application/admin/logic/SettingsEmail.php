<?php
/**
 *
 * 邮件设置 - 设置 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: SettingsEmail.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\logic;

use think\Request;
use think\Cache;
use app\admin\model\Config AS ModelConfig;

class SettingsEmail
{
    protected $request = null;

    public function __construct()
    {
        $this->request = Request::instance();
    }

    /**
     * 邮件设置数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = [
            'name' => [
                'in',
                'smtp_host,smtp_port,smtp_username,smtp_password,smtp_from_email,smtp_from_name'
            ],
            'lang' => 'niphp'
        ];

        $config = new ModelConfig;
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
        $config = new ModelConfig;

        $post_data = $this->request->post();
        foreach ($post_data as $key => $value) {
            $map = ['name' => $key];
            $data = ['value' => $value];

            $config->allowField(true)
            ->isUpdate(true)
            ->save($data, $map);
        }
        Cache::clear();
        return true;
    }
}

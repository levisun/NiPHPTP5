<?php
/**
 *
 * 安全与效率 - 设置 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: SettingsSafe.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Session;
use think\Cache;
use app\admin\model\Config as AdminConfig;

class SettingsSafe extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 安全与效率设置数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = [
            'name' => [
                'in',
                'system_portal,content_check,member_login_captcha,
                website_submit_captcha,upload_file_max,upload_file_type,
                website_static'
            ],
            'lang' => 'niphp'
        ];

        $config = new AdminConfig;
        $result =
        $config->field(true)
        ->where($map)
        ->select();

        $data = Session::get('ADMIN_DATA');
        foreach ($result as $value) {
            $value = $value->toArray();
            $data[$value['name']] = $value['value'];
        }

        $data['founder'] = $data['role_id'] == 1 ? 1 : 0;

        return $data;
    }

    /**
     * 修改安全与效率设置
     * @access public
     * @param
     * @return mixed
     */
    public function editor()
    {
        $config = new AdminConfig;

        $post_data = $this->request->post();

        $data = Session::get('ADMIN_DATA');
        if ($data['role_id'] == 1) {
            $map = ['name' => 'system_portal'];

            $config_system_portal =
            $config->field(true)
            ->where($map)
            ->value('value');

            if ($post_data['system_portal'] != $config_system_portal) {
                $old_name = ROOT_PATH . $config_system_portal . '.php';
                $new_name = ROOT_PATH . $post_data['system_portal'] . '.php';
                rename($old_name, $new_name);
            }
        }

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

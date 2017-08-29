<?php
/**
 *
 * 基础设置 - 设置 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: SettingsBasic.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\logic;

use think\Request;
use think\Lang;
use think\Cache;
use app\admin\model\Config as ModelConfig;

class SettingsBasic
{
    protected $request = null;

    protected $toHtml = [
        'bottom_message',
        'copyright',
        'script'
    ];

    public function __construct()
    {
        $this->request = Request::instance();
    }

    /**
     * 基本设置数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = [
            'name' => [
                'in',
                'website_name,website_keywords,website_description,bottom_message,copyright,script'
            ],
            'lang' => Lang::detect()
        ];

        $config = new ModelConfig;
        $result =
        $config->field(true)
        ->where($map)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            if (in_array($value['name'], $this->toHtml)) {
                $data[$value['name']] = htmlspecialchars_decode($value['value']);
            } else {
                $data[$value['name']] = $value['value'];
            }
        }

        return $data;
    }

    /**
     * 修改基本设置
     * @access public
     * @param
     * @return mixed
     */
    public function editor()
    {
        $config = new ModelConfig;

        foreach ($_POST as $key => $value) {
            $map = ['name' => $key];
            if (in_array($key, $this->toHtml)) {
                $data = ['value' => $this->request->post($key, '', 'trim,htmlspecialchars')];
            } else {
                $data = ['value' => $this->request->post($key)];
            }

            $config->allowField(true)
            ->isUpdate(true)
            ->save($data, $map);
        }
        Cache::clear();
        return true;
    }
}

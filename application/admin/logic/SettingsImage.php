<?php
/**
 *
 * 语言设置 - 设置 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: SettingsImage.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\logic;

use think\Request;
use think\Lang;
use think\Cache;
use app\admin\model\Config as ModelConfig;

class SettingsImage
{
    protected $request = null;

    public function __construct()
    {
        $this->request = Request::instance();
    }

    /**
     * 图片设置数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = [
            'name' => [
                'in',
                'auto_image,add_water,water_type,water_location,water_text,water_image,article_module_width,article_module_height,ask_module_width,ask_module_height,download_module_width,download_module_height,job_module_width,job_module_height,link_module_width,link_module_height,page_module_width,page_module_height,picture_module_width,picture_module_height,product_module_width,product_module_height',
            ],
            'lang' => Lang::detect(),
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
     * 修改图片设置
     * @access public
     * @param
     * @return mixed
     */
    public function editor()
    {
        $config = new ModelConfig;

        foreach ($_POST as $key => $value) {
            $map = ['name' => $key];

            if (in_array($key, ['water_text', 'water_image'])) {
                $data = ['value' => $this->request->post($key)];
            } else {
                $data = ['value' => $this->request->post($key . '/f', 1)];
            }

            $config->allowField(true)
            ->isUpdate(true)
            ->save($data, $map);
        }
        Cache::clear();
        return true;
    }
}

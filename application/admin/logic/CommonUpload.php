<?php
/**
 *
 * 上传文件 - 公众 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CommonUpload.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/27
 */
namespace app\admin\logic;

use think\Model;
use think\Lang;
use think\Request;
use think\Image;
use util\File;
use app\admin\model\Config as AdminConfig;

class CommonUpload extends Model
{
    protected $ext = ['gif', 'jpg', 'jpeg', 'bmp', 'png'];
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 删除上传文件
     * @access public
     * @param
     * @return mixed
     */
    public function delUpload()
    {
        $image = $this->request->post('image');
        if (!filter_var($image, FILTER_VALIDATE_URL)) {
            File::delete($image);
        }
        $thumb = $this->request->post('thumb');
        if (!filter_var($thumb, FILTER_VALIDATE_URL)) {
            File::delete($thumb);
        }
    }

    /**
     * 上传文件
     * @access public
     * @param
     * @return array
     */
    public function upload()
    {
        $file = $this->request->file('upload');
        if (null === $file) {
            return Lang::get('error upload');
        }

        // 查询合法上传文件后缀
        $map = [
            'name' => [
                'in',
                'upload_file_type,upload_file_max'
            ],
            'lang' => 'niphp',
        ];

        $config = new AdminConfig;
        $result =
        $config->field(true)
        ->where($map)
        ->select();

        foreach ($result as $value) {
            $array = $value->toArray();
            if ($array['name'] == 'upload_file_max') {
                $validate['size'] = $array['value'] * 1024 * 1024;
            } else {
                $validate['ext'] = str_replace('|', ',', $array['value']);
            }
        }

        // 安上传文件类型生成对应保存目录
        $upload_type = $this->type();
        $save_path = ROOT_PATH . 'public/upload/' . $upload_type['dir'];

        $result =
        $file->validate($validate)
        ->move($save_path);

        if ($result) {
            // 上传文件后缀
            $file_ext = $result->getExtension();
            // 上传文件保存名
            $file_name = $result->getSaveName();

            // 非图片文件
            if (!in_array($file_ext, $this->ext)) {
                $data['file_name'] = './public/upload/' . $upload_type['dir'] . $file_name;
                $data['file_name'] = str_replace('\\', '/', $data['file_name']);
                return $data;
            }

            // 图片文件生成缩略添加水印
            // 安上传文件类型获得缩略图尺寸
            $image_size = $this->size($upload_type['type']);
            // 生成缩略图
            $file_thumb_name = $this->thumb($image_size, $save_path, $file_name, $file_ext);
            // 添加水印
            $this->water($save_path, $file_name, $file_thumb_name, $upload_type['type']);
            // 图片保存地址
            $data['file_name'] = './public/upload/' . $upload_type['dir'] . $file_name;
            $data['file_name'] = str_replace('\\', '/', $data['file_name']);

            if ($file_thumb_name) {
                $data['file_thumb_name'] = './public/upload/' . $upload_type['dir'] . $file_thumb_name;
                $data['file_thumb_name'] = str_replace('\\', '/', $data['file_thumb_name']);
            } else {
                $data['file_thumb_name'] = $data['file_name'];
            }

            return $data;
        } else {
            return $file->getError();
        }
    }

    /**
     * 添加水印
     * @access protected
     * @param  array  $file_dir   文件目录
     * @param  string $file_name  文件名
     * @param  string $thumb_name 文件缩略图名
     * @param  string $type       上传文件类型
     * @return string
     */
    protected function water($file_dir, $file_name, $thumb_name, $type)
    {
        // 不添加水印
        $no_water = [
            'water',
            'ads',
            'banner',
            'comment',
            'portrait',
            'category',
            'malltype',
            'mallbrand',
        ];
        if (in_array($type, $no_water)) {
            return false;
        }

        // 获得水印设置
        $map = [
            'name' => [
                'in',
                'add_water,water_type,water_location,water_text,water_image'
            ],
            'lang' => Lang::detect(),
        ];
        $field = [
            'name',
            'value'
        ];

        $config = new AdminConfig;
        $result =
        $config->field($field)
        ->where($map)
        ->select();

        $config_data = [];
        foreach ($result as $key => $value) {
            $value = $value->toArray();
            $config_data[$value['name']] = $value['value'];
        }

        // 不添加水印
        if (!$config_data['add_water']) {
            return false;
        }

        if ($config_data['water_type']) {
            // 图片水印
            $image = Image::open($file_dir . $file_name);
            $image->water(ROOT_PATH . $config_data['water_image'], $config_data['water_location'], 50);
            $image->save($file_dir . $file_name);

            if ($thumb_name) {
                $image = Image::open($file_dir . $thumb_name);
                $image->water(ROOT_PATH . $config_data['water_image'], $config_data['water_location'], 50);
                $image->save($file_dir . $thumb_name);
            }
        } else {
            // 文字水印
            $font_path = EXTEND_PATH . 'fonts/HYQingKongTiJ.ttf';

            $image = Image::open($file_dir . $file_name);
            $image->text($config_data['water_text'], $font_path, 20, '#ffffff', $config_data['water_location']);
            $image->save($file_dir . $file_name);

            if ($thumb_name) {
                $image = Image::open($file_dir . $thumb_name);
                $image->text($config_data['water_text'], $font_path, 20, '#ffffff', $config_data['water_location']);
                $image->save($file_dir . $thumb_name);
            }
        }
    }

    /**
     * 生成缩略图
     * @access protected
     * @param  array  $thumb_size 尺寸大小
     * @param  string $file_dir   文件地址
     * @param  string $file_name  文件名称
     * @param  string $ext        文件后缀
     * @return string
     */
    protected function thumb($thumb_size, $file_dir, $file_name, $ext)
    {
        // 不生成缩略图
        if (false === $thumb_size) {
            return false;
        }

        // 组合缩略图文件名
        $save_name = str_replace('.' . $ext, '_thumb.' . $ext, $file_name);
        // 生成缩略图
        $image = Image::open($file_dir . $file_name);
        $image->thumb($thumb_size['width'], $thumb_size['height'], Image::THUMB_CENTER)
        ->save($file_dir . $save_name);
        return $save_name;
    }

    /**
     * 图片尺寸
     * @access protected
     * @param  string $type 图片类型
     * @return array  width|height
     */
    protected function size($type)
    {
        switch ($type) {
            case 'portrait':
            case 'category':
            case 'album':
                $size['width'] = $size['height'] = 500;
                break;

            case 'image':
                $size = $this->model();
                break;

            case 'mallimage':
            case 'mallalbum':
                $size['width'] = $size['height'] = 500;
                break;
        }
        return !empty($size) ? $size : false;
    }

    /**
     * 模型图片尺寸
     * @access protected
     * @param
     * @return array width|height
     */
    protected function model()
    {
        $model = $this->request->post('model');
        if (empty($model)) {
            return false;
        }
        $map = [
            'name' => [
                'in',
                $model . '_module_width,' . $model . '_module_height'
            ],
            'lang' => Lang::detect(),
        ];
        $field = [
            'name',
            'value'
        ];

        $config = new AdminConfig;
        $result =
        $config->field($field)
        ->where($map)
        ->select();

        $data = [];
        foreach ($result as $key => $value) {
            $value = $value->toArray();
            $data[] = $value['value'];
        }
        if (empty($data)) {
            return false;
        }
        $size['width'] = (int) $data[0];
        $size['height'] = (int) $data[1];
        return $size;
    }

    /**
     * 上传图片类型
     * @access protected
     * @param
     * @return array 图片类型和路径
     */
    protected function type()
    {
        // 如果POST值不存在 获得GET值
        $upload_type = $this->request->post('type');
        $upload_type = !empty($upload_type) ? $upload_type : $this->request->param('type');

        // 保存子目录
        if (in_array($upload_type, ['image', 'ckeditor'])) {
            $dir = 'images/';
        } else {
            $dir = $upload_type . '/';
        }

        $data['type'] = $upload_type;
        $data['dir'] = $dir;
        return $data;
    }
}

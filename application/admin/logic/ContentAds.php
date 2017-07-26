<?php
/**
 *
 * 广告 - 内容 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ContentAds.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/14
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Lang;
use app\admin\model\Ads as ModelAds;

class ContentAds extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 列表数据
     * @access public
     * @param
     * @return array
     */
    public function getListData()
    {
        $map = [];
        if ($key = $this->request->param('key')) {
            $map['name'] = ['LIKE', '%' . $key . '%'];
        }

        $ads = new ModelAds;
        $result =
        $ads->field(true)
        ->where($map)
        ->paginate();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        $page = $result->render();

        return ['list' => $list, 'page' => $page];
    }

    /**
     * 添加数据
     * @access public
     * @param
     * @return boolean
     */
    public function added()
    {
        $data = [
            'name'       => $this->request->post('name'),
            'width'      => $this->request->post('width/d'),
            'height'     => $this->request->post('height/d'),
            'image'      => $this->request->post('image'),
            'url'        => $this->request->post('url'),
            'start_time' => $this->request->post('start_time/f', 0, 'trim,strtotime'),
            'end_time'   => $this->request->post('end_time/f', 0, 'trim,strtotime'),
            'lang'       => Lang::detect(),
        ];

        $ads = new ModelAds;
        $ads->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        return $ads->id ? true : false;
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = ['id' => $this->request->param('id/f')];

        $ads = new ModelAds;
        $result =
        $ads->field(true)
        ->where($map)
        ->find();

        return !empty($result) ? $result->toArray() : [];
    }

    /**
     * 编辑数据
     * @access public
     * @param
     * @return boolean
     */
    public function editor()
    {
        $data = [
            'name'       => $this->request->post('name'),
            'width'      => $this->request->post('width/d'),
            'height'     => $this->request->post('height/d'),
            'image'      => $this->request->post('image'),
            'url'        => $this->request->post('url'),
            'start_time' => $this->request->post('start_time/f', 0, 'trim,strtotime'),
            'end_time'   => $this->request->post('end_time/f', 0, 'trim,strtotime'),
        ];
        $map = ['id' => $this->request->post('id/f')];

        $ads = new ModelAds;
        $result =
        $ads->allowField(true)
        ->isUpdate(true)
        ->save($data, $map);

        return $result ? true : false;
    }

    /**
     * 删除数据
     * @access public
     * @param
     * @return boolean
     */
    public function remove()
    {
        $map = ['id' => $this->request->param('id/f')];

        $ads = new ModelAds;
        $result =
        $ads->where($map)
        ->delete();

        return $result ? true : false;
    }
}

<?php
/**
 *
 * 分类 - 商城 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: MallType.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/01/03
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Cache;
use app\admin\model\MallType as ModelMallType;

class MallType extends Model
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
        $map = [
            'mt.pid' => 0,
            'mt.lang' => Lang::detect()
        ];

        if ($key = $this->request->param('key')) {
            $map['mt.name'] = ['LIKE', '%' . $key . '%'];
        }

        $cid = $this->request->param('pid/f', 0);    // 用于内容管理中栏目显示

        if ($pid = $this->request->param('id/f', $cid)) {
            $map['mt.pid'] = $pid;
        }

        $type = new ModelMallType;
        $result =
        $type->view('mall_type mt', 'id,pid,name,sort')
        ->view('mall_type mtc', ['id'=>'child'], 'mt.id=mtc.pid', 'LEFT')
        ->where($map)
        ->group('mt.id')
        ->order('mt.sort ASC, mt.id DESC')
        ->select();

        $data = [];
        foreach ($result as $value) {
            $data[] = $value->toArray();
        }

        return $data;
    }

    /**
     * 获得父级栏目数据
     * @access public
     * @param
     * @return array
     */
    public function getParent()
    {
        $map = ['id' => $this->request->param('pid/f', 0)];

        $type = new ModelMallType;
        $result =
        $type->field(true)
        ->where($map)
        ->find();

        $data = !empty($result) ? $result->toArray() : [];

        $data['id']   = !empty($data['id']) ? $data['id'] : 0;
        $data['pid']  = !empty($data['pid']) ? $data['pid'] : 0;
        $data['name'] = !empty($data['name']) ? $data['name'] : Lang::get('select parent');

        return $data;
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
            'name'  => $this->request->post('name'),
            'image' => $this->request->post('image'),
            'pid'   => $this->request->post('pid/f', 0),
            'lang'  => Lang::detect(),
        ];

        $type = new ModelMallType;
        $type->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        return $type->id ? true : false;
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = ['mt.id' => $this->request->param('id/f')];

        $type = new ModelMallType;
        $result =
        $type->view('mall_type mt', true)
        ->view('mall_type mtc', ['name'=>'parentname'], 'mt.pid=mtc.id', 'LEFT')
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
            'name'  => $this->request->post('name'),
            'image' => $this->request->post('image'),
            'pid'   => $this->request->post('pid/f', 0),
            'lang'  => Lang::detect(),
        ];
        $map = ['id' => $this->request->post('id/f')];

        $type = new ModelMallType;
        $result =
        $type->allowField(true)
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
        $id = $this->request->param('id/f');
        $map = ['pid' => $id];

        $type = new ModelMallType;
        $result =
        $type->field(true)
        ->where($map)
        ->find();

        $data = !empty($result) ? $result->toArray() : null;
        if (!empty($data)) {
            return 'error child remove';
        }

        $map = ['id' => $id];

        $result = $type->where($map)->delete();

        return $result ? true : false;
    }

    /**
     * 排序
     * @access public
     * @param
     * @return boolean
     */
    public function listSort()
    {
        $post = $this->request->post('sort/a');
        foreach ($post as $key => $value) {
            $data[] = [
                'id' => $key,
                'sort' => $value,
            ];
        }

        $type = new ModelMallType;
        $result =
        $type->saveAll($data);

        return true;
    }
}
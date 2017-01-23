<?php
/**
 *
 * 会员组管理 - 用户 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: UserNode.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/07
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use app\admin\model\Node as AdminNode;

class UserNode extends Model
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
        $map = ['id' => ['neq', 1]];
        if ($key = $this->request->param('key')) {
            $map['title'] = ['LIKE', '%' . $key . '%'];
        }

        $node = new AdminNode;
        $result =
        $node->field(true)
        ->where($map)
        ->order('id ASC')
        ->select();

        $data = [];
        foreach ($result as $key => $value) {
            $data[$key] = $value = $value->toArray();
            $ext = '';
            for ($i=1; $i < $value['level']; $i++) {
                $ext .= '|__';
            }
            $data[$key]['title'] = $ext . $value['title'];
        }

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
            'title'  => $this->request->post('title'),
            'name'   => $this->request->post('name'),
            'pid'    => $this->request->post('pid/f'),
            'level'  => $this->request->post('level/d'),
            'remark' => $this->request->post('remark'),
            'status' => $this->request->post('status/d')
        ];

        $node = new AdminNode;
        $result =
        $node->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        return $node->id ? true : false;
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = [
            'id' => $this->request->param('id/f')
        ];

        $node = new AdminNode;
        $result =
        $node->field(true)
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
            'title'  => $this->request->post('title'),
            'name'   => $this->request->post('name'),
            'pid'    => $this->request->post('pid/f'),
            'level'  => $this->request->post('level/d'),
            'remark' => $this->request->post('remark'),
            'status' => $this->request->post('status/d')
        ];
        $map = ['id' => $this->request->post('id/f')];

        $node = new AdminNode;
        $result =
        $node->allowField(true)
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
        $map = ['id' => $id];

        $node = new AdminNode;
        $result =
        $node->where($map)
        ->delete();

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

        $node = new AdminNode;
        $result =
        $node->saveAll($data);

        return true;
    }
}

<?php
/**
 *
 * 会员组管理 - 用户 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: UserLevel.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/07
 */
namespace app\admin\logic;

use think\Request;
use app\admin\model\Level as ModelLeval;

class UserLevel
{
    protected $request = null;

    public function __construct()
    {
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

        $level = new ModelLeval;
        $result =
        $level->field(true)
        ->where($map)
        ->order('id DESC')
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
            'name'     => $this->request->post('name'),
            'integral' => $this->request->post('integral/f'),
            'status'   => $this->request->post('status/d'),
            'remark'   => $this->request->post('remark')
        ];

        $level = new ModelLeval;
        $level->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        return $level->id ? true : false;
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

        $level = new ModelLeval;
        $result =
        $level->field(true)
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
            'name'     => $this->request->post('name'),
            'integral' => $this->request->post('integral/f'),
            'status'   => $this->request->post('status/d'),
            'remark'   => $this->request->post('remark')
        ];
        $map = ['id' => $this->request->post('id/f')];

        $level = new ModelLeval;
        $result =
        $level->allowField(true)
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
        $level = new ModelLeval;
        $result =
        $level->where($map)
        ->delete();

        return $result ? true : false;
    }
}

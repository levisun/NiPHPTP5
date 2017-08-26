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
use think\Lang;
use app\admin\model\Reply as ModelReply;

class WechatKeyword extends Model
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
        $map = ['type' => $this->request->param('type')];
        if ($key = $this->request->param('key')) {
            $map['keyword'] = ['LIKE', '%' . $key . '%'];
        }

        $reply = new ModelReply;
        $result =
        $reply->field(true)
        ->where($map)
        ->order('keyword DESC, sort ASC, id DESC')
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
            'keyword' => $this->request->post('keyword'),
            'title'   => $this->request->post('title'),
            'content' => $this->request->post('content'),
            'image'   => $this->request->post('image'),
            'url'     => $this->request->post('url'),
            'status'  => $this->request->post('status/d'),
            'type'    => $this->request->post('type/d'),
            'lang'    => Lang::detect()
        ];

        $reply = new ModelReply;
        $reply->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        return $reply->id ? true : false;
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

        $reply = new ModelReply;
        $result =
        $reply->field(true)
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
            'keyword' => $this->request->post('keyword'),
            'title'   => $this->request->post('title'),
            'content' => $this->request->post('content'),
            'image'   => $this->request->post('image'),
            'url'     => $this->request->post('url'),
            'status'  => $this->request->post('status/d'),
        ];

        $map = ['id' => $this->request->post('id/f')];

        $reply = new ModelReply;
        $result =
        $reply->allowField(true)
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

        $reply = new ModelReply;
        $result =
        $reply->where($map)
        ->delete();

        return !empty($result) ? true : false;
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

        $banner = new ModelReply;
        $result =
        $banner->saveAll($data);

        return true;
    }
}

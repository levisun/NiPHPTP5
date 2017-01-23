<?php
/**
 *
 * 评论 - 内容 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ContentComment.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/14
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Lang;
use app\admin\model\Comment as AdminComment;

class ContentComment extends Model
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
        $map = ['c.lang' => Lang::detect()];
        if ($key = $this->request->param('key')) {
            $map['c.content'] = ['LIKE', '%' . $key . '%'];
        }

        // 未审
        if ($this->request->param('pass')) {
            $map['c.is_pass'] = 1;
        }

        // 举报
        if ($this->request->param('report')) {
            $map['c.is_report'] = 1;
        }

        $comment = new AdminComment;
        $result =
        $comment->view('comment c', true)
        ->view('member m', 'username', 'm.id=c.user_id')
        ->where($map)
        ->order('c.id DESC')
        ->paginate();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        $page = $result->render();

        return ['list' => $list, 'page' => $page];
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = ['c.id' => $this->request->param('id/f')];

        $comment = new AdminComment;
        $result =
        $comment->view('comment c', '*')
        ->view('member m', 'username', 'm.id=c.user_id')
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
            'is_report' => $this->request->post('is_report/d'),
            'is_pass'   => $this->request->post('is_pass/d')
        ];
        $map = ['id' => $this->request->post('id/f')];

        $comment = new AdminComment;
        $result =
        $comment->allowField(true)
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

        $comment = new AdminComment;
        $result =
        $comment->where($map)
        ->delete();

        return $result ? true : false;
    }
}

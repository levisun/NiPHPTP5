<?php
/**
 *
 * 分类管理 - 书库 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: BookType.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/09/12
 */
namespace app\admin\logic;

use think\Request;
use think\Lang;
use app\admin\model\BookType as ModelBookType;

class BookType
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

        $book_type = new ModelBookType;
        $result =
        $book_type->where($map)
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
            'name'        => $this->request->post('name'),
            'description' => $this->request->post('description'),
        ];

        $book_type = new ModelBookType;
        $book_type->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        return $book_type->id ? true : false;
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {}

    /**
     * 编辑数据
     * @access public
     * @param
     * @return boolean
     */
    public function editor()
    {}

    /**
     * 删除数据
     * @access public
     * @param
     * @return boolean
     */
    public function remove()
    {}
}

<?php
/**
 *
 * 书库 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Book.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/09/08
 */
namespace app\admin\controller;

use app\admin\controller\Base;

class Book extends Base
{

    /**
     * 书库
     * @access public
     * @param
     * @return string
     */
    public function book()
    {
        $this->assign('submenu', 1);
        $this->assign('submenu_button_added', 1);

    }

    /**
     * 分类
     * @access public
     * @param
     * @return string
     */
    public function type()
    {
        $this->assign('submenu', 1);
        $this->assign('submenu_button_added', 1);

        // 新增
        if ($this->method == 'added') {
            parent::added('BookType');
            return $this->fetch('type_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('BookType');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $this->assign('data', parent::editor('BookType'));
            return $this->fetch('type_editor');
        }

        $data = parent::select('BookType');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);
        return $this->fetch();
    }

    /**
     * 作者
     * @access public
     * @param
     * @return string
     */
    public function user()
    {
        $this->assign('submenu', 1);
    }
}

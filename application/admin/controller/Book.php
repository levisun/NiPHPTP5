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

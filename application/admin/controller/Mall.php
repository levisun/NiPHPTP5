<?php
/**
 *
 * 商城 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Mall.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\logic\MallGoods as AdminMallGoods;
class Mall extends Base
{

    /**
     * 商品管理
     * @access public
     * @param
     * @return string
     */
    public function goods()
    {
        $this->assign('submenu', 1);
        $this->assign('submenu_button_added', 1);

        // 新增
        if ($this->method == 'added') {
            parent::added('MallGoods');
            return $this->fetch('goods_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('MallGoods');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $data = parent::editor('MallGoods');
            $this->assign('data', $data);
            return $this->fetch('goods_editor');
        }

        $data = parent::select('MallGoods');
        $this->assign('list', $data);

        return $this->fetch();
    }

    /**
     * 帐户流水
     * @access public
     * @param
     * @return string
     */
    public function accountflow()
    {
        $this->assign('submenu', 1);

        return $this->fetch();
    }

    /**
     * 商城设置
     * @access public
     * @param
     * @return string
     */
    public function settings()
    {
        $data = parent::editor('MallSettings', 'Config.mall', 'config_editor', false);
        $this->assign('data', $data);
        return $this->fetch();
    }
}
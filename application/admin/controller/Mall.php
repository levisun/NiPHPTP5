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
use app\admin\logic\MallGoods as LogicMallGoods;
use app\admin\logic\MallCategory as LogicMallCategory;
use app\admin\logic\MallType as LogicMallType;
use app\admin\logic\MallGRecycle as LogicMallGRecycle;

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

        if (in_array($this->method, ['added', 'editor'])) {
            $logic = new LogicMallGoods;
            $this->assign('type', $logic->getType());
            $this->assign('brand', $logic->getBrand());
        }

        // 新增
        if ($this->method == 'added') {
            parent::added('MallGoods', 'MallGoods.added');
            return $this->fetch('mall/goods/goods_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('MallGoods', 'MallGoods.remove');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $this->assign('data', parent::editor('MallGoods', 'MallGoods.editor'));
            return $this->fetch('mall/goods/goods_editor');
        }

        $data = parent::select('MallGoods');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);

        return $this->fetch('mall/goods/goods');
    }

    public function orders()
    {
        $this->assign('submenu', 1);

        return $this->fetch('mall/orders/orders');
    }

    /**
     * 导航
     * @access public
     * @param
     * @return string
     */
    public function category()
    {
        $this->assign('submenu', 1);
        $this->assign('submenu_button_added', 1);

        // 父级分类信息
        $logic = new LogicMallCategory;
        $this->assign('parent', $logic->getParent());

        // 新增
        if ($this->method == 'added') {
            parent::added('MallCategory', 'MallCategory.added');
            return $this->fetch('mall/type/type_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('MallCategory', 'MallCategory.remove');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $data = parent::editor('MallCategory', 'MallCategory.editor');
            $this->assign('data', $data);
            return $this->fetch('mall/type/type_editor');
        }

        $data = parent::select('MallCategory');
        $this->assign('list', $data);

        return $this->fetch('mall/category/category');
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

        // 父级分类信息
        $logic = new LogicMallType;
        $this->assign('parent', $logic->getParent());

        // 新增
        if ($this->method == 'added') {
            parent::added('MallType', 'MallType.added');
            return $this->fetch('mall/type/type_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('MallType', 'MallType.remove');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $data = parent::editor('MallType', 'MallType.editor');
            $this->assign('data', $data);
            return $this->fetch('mall/type/type_editor');
        }


        $data = parent::select('MallType');
        $this->assign('list', $data);

        return $this->fetch('mall/type/type');
    }

    /**
     * 品牌
     * @access public
     * @param
     * @return string
     */
    public function brand()
    {
        $this->assign('submenu', 1);
        $this->assign('submenu_button_added', 1);

        if (in_array($this->method, ['added', 'editor'])) {
            $logic = new LogicMallGoods;
            $this->assign('type', $logic->getType());
        }

        // 新增
        if ($this->method == 'added') {
            parent::added('MallBrand', 'MallBrand.added');
            return $this->fetch('mall/brand/brand_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('MallBrand', 'MallBrand.remove');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $data = parent::editor('MallBrand', 'MallBrand.remove');
            $this->assign('data', $data);
            return $this->fetch('mall/brand/brand_editor');
        }

        $data = parent::select('MallBrand');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);

        return $this->fetch('mall/brand/brand');
    }

    /**
     * 帐户流水
     * @access public
     * @param
     * @return string
     */
    public function account()
    {
        $this->assign('submenu', 1);

        return $this->fetch();
    }

    /**
     * 商品回收站
     * @access public
     * @param
     * @return string
     */
    public function grecycle()
    {
        $this->assign('submenu', 1);

        // 删除
        if ($this->method == 'remove') {
            parent::remove('MallGRecycle', 'MallGoods.remove');
            return ;
        }

        // 还原
        if ($this->method == 'reduction') {
            parent::reduction('MallGRecycle');
        }

        // 编辑
        if ($this->method == 'editor') {
            $logic = new LogicMallGoods;
            $this->assign('type', $logic->getType());
            $this->assign('brand', $logic->getBrand());

            $data = parent::editor('MallGRecycle', 'MallGoods.editor');
            $this->assign('data', parent::editor('MallGRecycle', 'MallGoods.editor'));
            return $this->fetch('mall/goods/recycle_editor');
        }

        $data = parent::select('MallGRecycle');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);

        return $this->fetch('mall/goods/recycle');
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

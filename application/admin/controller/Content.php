<?php
/**
 *
 * 内容 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Content.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/12
 */
namespace app\admin\controller;

use think\Lang;
use think\Url;
use app\admin\controller\Base;
use app\admin\logic\ContentContent as LogicContentContent;
use app\admin\logic\CategoryCategory as LogicCategoryCategory;
use app\admin\logic\ContentRecycle as LogicContentRecycle;
use app\admin\logic\ContentCache as LogicContentCache;

class Content extends Base
{

    /**
     * 内容
     * @access public
     * @param
     * @return string
     */
    public function content()
    {
        $this->assign('sort', 0);
        $theme = 'content/content/';

        // 获得模型表名
        $logic = new LogicContentContent;
        $this->assign('model_name', $logic->tableName);

        if (in_array($this->method, ['page', 'added', 'editor'])) {
            // 分类
            $this->assign('type', $logic->typeData);
            // 权限
            $this->assign('level', $logic->levelData);

            // 自定义字段
            $data['field_data'] = $logic->dataModel->getAddedFieldsData();
            $this->assign('data', $data);

            // 是否审核
            $this->assign('is_pass', $logic->dataModel->isPass());
        }

        // 单页
        if ($this->method == 'page') {
            // 添加
            if ($this->request->isPost() && !$this->request->has('id', 'post')) {
                parent::added('ContentContent', 'ContentContent.page_added');
            }

            // 编辑数据
            $data = parent::editor('ContentContent', 'ContentContent.page_editor', '', false);

            // 编辑数据不存在 获得添加字段数据
            if (!$data) {
                $data['field_data'] = $logic->dataModel->getAddedFieldsData($logic->tableName);
            }

            $this->assign('data', $data);
            $logic->tableName .= !empty($data['id'])? '_editor' : '_added';
            return $this->fetch($theme . 'model/' . $logic->tableName);
        }

        // 添加
        if ($this->method == 'added') {
            parent::added('ContentContent');
            return $this->fetch($theme . 'model/' . $logic->tableName . '_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('ContentContent');
        }

        // 编辑
        if ($this->method == 'editor') {
            $data = parent::editor('ContentContent');
            $this->assign('data', $data);
            return $this->fetch($theme . 'model/' . $logic->tableName . '_editor');
        }

        // 列表
        if ($this->method == 'manage') {
            $this->assign('submenu', 1);
            if (!in_array($logic->tableName, ['message', 'feedback'])) {
                $this->assign('submenu_button_added', 1);
            }

            $data = $logic->getListData();
            $this->assign('list', $data['list']);
            $this->assign('page', $data['page']);
            return $this->fetch($theme . 'list');
        }

        // 栏目
        $logic = new LogicCategoryCategory;
        $category = $logic->getListData();
        foreach ($category as $key => $value) {
            if ($value['model_name'] == 'external') {
                unset($category[$key]);
            }
        }
        $this->assign('category', $category);
        return $this->fetch($theme . 'category');
    }

    /**
     * 回收站
     * @access public
     * @param
     * @return string
     */
    public function recycle()
    {
        $this->assign('sort', 0);
        $theme = 'content/content/';

        // 获得模型表名
        $logic = new LogicContentRecycle;
        $this->assign('model_name', $logic->tableName);

        if (in_array($this->method, ['page', 'added', 'editor'])) {
            // 分类
            $this->assign('type', $logic->typeData);
            // 权限
            $this->assign('level', $logic->levelData);

            // 自定义字段
            $data['field_data'] = $logic->dataModel->getAddedFieldsData($logic->tableName);
            $this->assign('data', $data);

            // 是否审核
            $this->assign('is_pass', $logic->dataModel->isPass());
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('ContentRecycle');
        }

        // 编辑
        if ($this->method == 'editor') {
            $this->assign('data', $logic->getEditorData());
            return $this->fetch($theme . 'recycle/' . $logic->tableName . '_editor');
        }

        // 还原
        if ($this->method == 'reduction') {
            parent::reduction('ContentRecycle');
        }

        // 列表
        if ($this->method == 'manage') {
            $this->assign('submenu', 1);
            /*if (!in_array($logic->tableName, ['message', 'feedback'])) {
                $this->assign('submenu_button_added', 1);
            }*/

            $data = $logic->getListData();
            $this->assign('list', $data['list']);
            $this->assign('page', $data['page']);
            return $this->fetch($theme . 'recycle');
        }

        // 栏目
        $logic = new LogicCategoryCategory;
        $category = $logic->getListData();
        foreach ($category as $key => $value) {
            if (in_array($value['model_name'], ['page', 'external'])) {
                unset($category[$key]);
            }
        }
        $this->assign('category', $category);
        return $this->fetch($theme . 'category');
    }

    /**
     * Banner
     * @access public
     * @param
     * @return string
     */
    public function banner()
    {
        $this->assign('submenu', 1);
        $this->assign('submenu_button_added', 1);

        if (in_array($this->method, ['added', 'editor'])) {
            if ($this->request->param('pid/f')) {
                $validate = 'ContentBanner.' . $this->method;
            } else {
                $validate = 'ContentBanner.' . $this->method . '_main';
            }
        }

        // 新增
        if ($this->method == 'added') {
            parent::added('ContentBanner', $validate);
            return $this->fetch('banner_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('ContentBanner');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $data = parent::editor('ContentBanner', $validate);
            $this->assign('data', $data);
            return $this->fetch('banner_editor');
        }

        $data = parent::select('ContentBanner');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);
        return $this->fetch();
    }

    /**
     * 广告管理
     * @access public
     * @param
     * @return mixed
     */
    public function ads()
    {
        $this->assign('submenu', 1);
        $this->assign('submenu_button_added', 1);

        // 新增
        if ($this->method == 'added') {
            parent::added('ContentAds');
            return $this->fetch('ads_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('ContentAds');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $data = parent::editor('ContentAds');
            $this->assign('data', $data);
            return $this->fetch('ads_editor');
        }

        $data = parent::select('ContentAds');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);
        return $this->fetch();
    }

    /**
     * 评论管理
     * @access public
     * @param
     * @return mixed
     */
    public function comment()
    {
        $this->assign('submenu', 1);

        // 删除
        if ($this->method == 'remove') {
            parent::remove('ContentComment');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $data = parent::editor('ContentComment');
            $this->assign('data', $data);
            return $this->fetch('comment_editor');
        }

        $data = parent::select('ContentComment');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);
        return $this->fetch();
    }

    /**
     * 更新缓存
     * @access public
     * @param
     * @return mixed
     */
    public function cache()
    {
        if ($this->method == 'remove') {
            $logic = new LogicContentCache;
            $result = $logic->remove();

            $url = Url::build($this->request->action());

            if ($result == 'cache') {
                $this->success(Lang::get('success cache'), $url);
            }

            if ($result == 'compile') {
                $this->success(Lang::get('success compile'), $url);
            }
        }
        return $this->fetch();
    }
}

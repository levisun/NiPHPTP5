<?php
/**
 *
 * 微信 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Wechat.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/10
 */
namespace app\admin\controller;
use app\admin\controller\Base;
class Wechat extends Base
{
    /**
     * 关键词回复
     * @access public
     * @param
     * @return string
     */
    public function keyword()
    {
        $this->assign('submenu', 1);
        $this->assign('submenu_button_added', 1);
        $this->request->get(['type'=>0]);

        // 新增
        if ($this->method == 'added') {
            parent::added('WechatKeyword', 'Reply.added');
            return $this->fetch('keyword_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('WechatKeyword', 'Reply.remove');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $data = parent::editor('WechatKeyword', 'Reply.added');
            $this->assign('data', $data);
            return $this->fetch('keyword_editor');
        }

        $data = parent::select('WechatKeyword');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);
        return $this->fetch();
    }

    /**
     * 自动回复
     * @access public
     * @param
     * @return string
     */
    public function auto()
    {
        $this->assign('submenu', 1);
        $this->assign('submenu_button_added', 1);
        $this->request->get(['type'=>1]);

        // 新增
        if ($this->method == 'added') {
            parent::added('WechatKeyword', 'Reply.added');
            return $this->fetch('keyword_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('WechatKeyword', 'Reply.remove');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $data = parent::editor('WechatKeyword', 'Reply.added');
            $this->assign('data', $data);
            return $this->fetch('keyword_editor');
        }

        $data = parent::select('WechatKeyword');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);
        return $this->fetch('keyword');
    }

    /**
     * 关注回复
     * @access public
     * @param
     * @return string
     */
    public function attention()
    {
        $this->assign('submenu', 1);
        $this->assign('submenu_button_added', 1);
        $this->request->get(['type'=>2]);

        // 新增
        if ($this->method == 'added') {
            parent::added('WechatKeyword', 'Reply.added');
            return $this->fetch('keyword_added');
        }

        // 删除
        if ($this->method == 'remove') {
            parent::remove('WechatKeyword', 'Reply.remove');
            return ;
        }

        // 编辑
        if ($this->method == 'editor') {
            $data = parent::editor('WechatKeyword', 'Reply.added');
            $this->assign('data', $data);
            return $this->fetch('keyword_editor');
        }

        $data = parent::select('WechatKeyword');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);
        return $this->fetch('keyword');
    }

    /**
     * 接口配置
     * @access public
     * @param
     * @return string
     */
    public function config()
    {
        $data = parent::editor('WechatConfig', 'Config.wechat', 'config_editor', false);
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 自定义菜单
     * @access public
     * @param
     * @return string
     */
    public function menu()
    {
        $this->assign('submenu', 1);
        $this->assign('submenu_button_added', 1);

        return $this->fetch();
    }
}
<?php
/**
 *
 * 网站全局 - 控制器
 *
 * @package   NiPHPCMS
 * @category  mall\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Base.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\mall\controller;

use think\Controller;
use think\Lang;
use think\Config;
use think\Log;
use app\index\logic\Visit as IndexLogicVisit;
use app\mall\logic\Common as LogicCommon;
use app\mall\logic\Type as LogicType;

class Base extends Controller
{
    // 网站基本数据
    protected $mallData = [];

    /**
     * 初始化
     * @access protected
     * @param
     * @return void
     */
    protected function _initialize()
    {
        cache_clear();

        // 设置IP为授权Key
        // Log::key($this->request->ip(0, true));

        // 访问与搜索日志
        $visit = new IndexLogicVisit;
        $visit->visit();
        $visit->requestLog();

        $common_model = new LogicCommon;

        // 商城基本数据
        $this->mallData = $common_model->getMallData();
        $this->themeConfig();
    }

    /**
     * 商品分类
     * @access protected
     * @param
     * @return array
     */
    protected function type()
    {
        $type = new LogicType;
        return $type->getType();
    }

    /**
     * 模板配置
     * @access protected
     * @param
     * @return void
     */
    protected function themeConfig()
    {
        $template = Config::get('template');
        // $template['taglib_pre_load'] = 'taglib\Label';

        $module = strtolower($this->request->module());

        // 模板路径
        $template['view_path'] = ROOT_PATH . 'public' . DS . 'theme' . DS . $module . DS;
        $template['view_path'] .= $this->mallData[$module . '_theme'] . DS;

        // 判断访问端
        $mobile = $this->request->isMobile() ? 'mobile' . DS : '';
        $info = $this->request->header();
        if (strpos($info['user-agent'], 'MicroMessenger')) {
            if (is_dir($template['view_path'] . 'wechat' . DS)) {
                $mobile = 'wechat' . DS;
            }
        }

        // 移动端和微信端模板
        if (is_dir($template['view_path'] . $mobile)) {
            $template['view_path'] .= $mobile;
        }

        // 模板路径
        $this->view->engine($template);

        // 获得域名地址
        $domain = $this->request->domain();
        $domain .= substr($this->request->baseFile(), 0, -10);
        $default_theme = $domain . '/public/theme/' . $module . '/';
        $default_theme .= $this->mallData[$module . '_theme'] . '/' . $mobile;

        $replace = [
            '__DOMAIN__'      => $domain,
            '__PHP_SELF__'    => basename($this->request->baseFile()),
            '__STATIC__'      => $domain . '/public/static/',
            '__LIBRARY__'     => $domain . '/public/static/library/',
            '__LAYOUT__'      => $domain . '/public/static/layout/',
            '__THEME__'       => $this->mallData[$module . '_theme'],
            '__CSS__'         => $default_theme . 'css/',
            '__JS__'          => $default_theme . 'js/',
            '__IMG__'         => $default_theme . 'img/',
            '__MESSAGE__'     => $this->mallData['mall_bottom_message'],
            '__COPYRIGHT__'   => $this->mallData['mall_copyright'],
            '__SCRIPT__'      => $this->mallData['mall_script'],

            '__TITLE__'       => $this->mallData['mall_name'],
            '__KEYWORDS__'    => $this->mallData['mall_keywords'],
            '__DESCRIPTION__' => $this->mallData['mall_description'],

            '__MALL_TYPE__'   => $this->type(),
        ];
        $this->view->replace($replace);
    }
}

<?php
/**
 *
 * 网站全局 - 控制器
 *
 * @package   NiPHPCMS
 * @category  index\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Base.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\index\controller;

use think\Controller;
use think\Lang;
use think\Config;
use think\Log;
use think\Cookie;
use think\Cache;
use app\index\logic\Visit as LogicVisit;
use app\index\logic\Common as LogicCommon;
use app\member\logic\Account as MemberLogicAccount;
use app\wechat\logic\Api as WechatLogicApi;

class Base extends Controller
{
    // 公众业务
    protected $commonLogic = null;
    // 当前请求表名
    protected $tableName   = null;
    // 网站基本数据
    protected $websiteData = [];
    // 微信对象
    protected $wechatLogicApi = null;

    /**
     * 初始化
     * @access protected
     * @param
     * @return void
     */
    protected function _initialize()
    {
        if ($this->request->isMobile()) {
            $host = $this->request->host();
            $no = [
                'localhost',
                'm.' . top_domain()
            ];
            if (!in_array($host, $no)) {
                $url = $this->request->scheme() . '://m.' . top_domain();
                $this->redirect($url, 302);
            }
        }
        cache_clear();

        // 设置IP为授权Key
        // Log::key($this->request->ip(0, true));

        // 加载网站配置
        Config::load(CONF_PATH . 'website.php');

        // 访问与搜索日志
        $visit = new LogicVisit;
        $visit->searchengine();
        $visit->visit();
        // $visit->requestLog();

        // 公众业务
        $this->commonLogic = new LogicCommon;

        // 当前请求表名
        $this->tableName = $this->commonLogic->tableName;
        // 网站基本数据
        $this->websiteData = $this->commonLogic->getWetsiteData();

        $this->themeConfig();

        $this->wechat();
    }

    /**
     * 微信
     * @access protected
     * @param
     * @return void
     */
    protected function wechat()
    {
        // 是否微信请求
        if (!is_wechat_request()) {
            return false;
        }

        $account_logic = new MemberLogicAccount;
        $account_logic->autoWechatLogin();

        $this->wechatLogicApi = new WechatLogicApi;

        // 生成微信用户信息cookie
        $this->wechatLogicApi->openid();

        $this->assign('wechat_url', $this->request->url(true));

        $this->assign('wechat_openid', Cookie::get('WECHAT_OPENID'));

        // 生成微信JS签名
        $this->assign('wechat_js', $this->wechatLogicApi->jsSign());

        // 生成微信分享代码
        $param = [
            'title' => $this->websiteData['website_name'],
            'link'  => $this->request->url(true),
            'desc'  => $this->websiteData['website_description'],
            'img'   => 'http://www.youtuiyou.cn/images/201708/thumb_img/5403_thumb_G_1502702568078.jpg',
        ];
        $this->assign('wechat_share', $this->wechatLogicApi->jsShare($param));
    }

    /**
     * 首页 列表页 网站标题等数据
     * @access protected
     * @param
     * @return void
     */
    protected function first()
    {
        if ($this->request->has('cid', 'param')) {
            $web_info = $this->getCatWebInfo();
        } else {
            $web_info = [
                'title' => $this->websiteData['website_name'],
                'keywords' => $this->websiteData['website_keywords'],
                'description' => $this->websiteData['website_description']
            ];
        }
        $replace = [
            '__TITLE__' => $web_info['title'],
            '__KEYWORDS__' => $web_info['keywords'],
            '__DESCRIPTION__' => $web_info['description'],
        ];
        $this->view->replace($replace);
    }

    /**
     * 安栏目获得网站标题、关键词、描述
     * @access protected
     * @param
     * @return arrays
     */
    protected function getCatWebInfo()
    {
        $web_title = $web_keywords = $web_description = '';
        if ($this->request->has('cid', 'param')) {
            $data = $this->commonLogic->getCategoryData();
            $this->assign('__SUB_TITLE__', $data[0]['name']);

            foreach ($data as $value) {
                $web_title .= $value['seo_title'] ? $value['seo_title'] : $value['name'] . ' - ';
            }

            $web_keywords = $data[0]['seo_keywords'];
            $web_description = $data[0]['seo_description'];

            $web_keywords = $web_keywords ? $web_keywords : $this->websiteData['website_keywords'];
            $web_description = $web_description ? $web_description : $this->websiteData['website_description'];
        }

        $web_title .= $this->websiteData['website_name'];

        return [
            'title' => $web_title,
            'keywords' => $web_keywords,
            'description' => $web_description
        ];
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
        $template['taglib_pre_load'] = 'taglib\Label';

        $module = strtolower($this->request->module());

        // 模板路径
        $template['view_path'] = ROOT_PATH . 'public' . DS . 'theme' . DS . $module . DS;
        $template['view_path'] .= $this->websiteData[$module . '_theme'] . DS;

        // 判断访问端
        $mobile = $this->request->isMobile() ? 'mobile' . DS : '';
        if (is_wechat_request()) {
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
        $default_theme .= $this->websiteData[$module . '_theme'] . '/' . $mobile;

        $replace = [
            '__DOMAIN__'    => $domain,
            '__PHP_SELF__'  => basename($this->request->baseFile()),
            '__STATIC__'    => $domain . '/public/static/',
            '__LIBRARY__'   => $domain . '/public/static/library/',
            '__LAYOUT__'    => $domain . '/public/static/layout/',
            '__THEME__'     => $this->websiteData[$module . '_theme'],
            '__CSS__'       => $default_theme . 'css/',
            '__JS__'        => $default_theme . 'js/',
            '__IMG__'       => $default_theme . 'img/',
            '__MESSAGE__'   => $this->websiteData['bottom_message'],
            '__COPYRIGHT__' => $this->websiteData['copyright'],
            '__SCRIPT__'    => $this->websiteData['script'],
        ];
        $this->view->replace($replace);
    }
}

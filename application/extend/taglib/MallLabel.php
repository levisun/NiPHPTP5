<?php
/**
 *
 * 标签
 *
 * @package   NiPHPCMS
 * @category  extend\taglib\
 * @package   NiPHPCMS
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Label.php 2016-01 $
 * @link      http://www.NiPHP.com
 */
namespace taglib;

use think\template\TagLib;

class MallLabel extends TagLib
{
    // 标签定义
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'goods'  => ['attr' => 'id,num,order,com,top,hot', 'alias' => 'item'],
        'member' => ['attr' => '', 'alias' => 'user'],
        'meta'   => ['attr' => '', 'close' => 0],
    ];

    public function tagGoods($tag, $content)
    {
        $parse_str = '<?php ';
        $parse_str .= ' $param = ' . var_export($tag, true) . ';';
        $parse_str .= ' $label["goods"]["' . $tag['id'] . '"] = \taglib\MallLabelFun::tagGoods("' . $tag['id'] . '", $param);';
        $parse_str .= ' if (!empty($label["goods"]["' . $tag['id'] . '"])) {';
        $parse_str .= ' $tag_count = count($label["goods"]["' . $tag['id'] . '"]);';
        $parse_str .= ' foreach ($label["goods"]["' . $tag['id'] . '"] as $key => $vo) { ?>';
        $parse_str .= $content;
        $parse_str .= '<?php } } ?>';
        return $parse_str;
    }

    /**
     * 获得会员信息
     * @access public
     * @param  array  $tag     标签属性
     * @param  string $content 标签内容
     * @return string
     */
    public function tagMember($tag, $content)
    {
        $parse_str = '<?php ';
        $parse_str .= ' $label["member"] = cookie(config("USER_AUTH_KEY"));';
        $parse_str .= ' $label["user_data"] = cookie(config("USER_DATA"));';
        $parse_str .= ' $label["member_url"]["home"] = url("/my");';
        $parse_str .= ' $label["member_url"]["login"] = url("/login");';
        $parse_str .= ' $label["member_url"]["logout"] = url("/logout");';
        $parse_str .= ' $label["member_url"]["reg"] = url("/reg");';
        $parse_str .= ' $label["member_url"]["forget"] = url("/forget"); ?>';
        $parse_str .= $content;
        return $parse_str;
    }

    /**
     * tags标签解析 meta信息
     * @access public
     * @param  array  $tag     标签属性
     * @param  string $content 标签内容
     * @return string|void
     */
    public function tagMeta($tag, $content)
    {
        $request = \think\Request::instance();

        $meta = '<meta name="renderer" content="webkit">';
        $meta .= '<meta http-equiv="Cache-Control" content="no-siteapp">';
        if ($request->isMobile()) {
            $meta .= '<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">';
            $meta .= '<meta name="apple-mobile-web-app-capable" content="yes">';
            $meta .= '<meta name="apple-mobile-web-app-status-bar-style" content="black">';
            $meta .= '<meta name="format-detection" content="telephone=yes">';
            $meta .= '<meta name="format-detection" content="email=yes">';
        } else {
            $meta .= '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
        }

        return $meta;
    }
}

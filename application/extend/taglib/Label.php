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

class Label extends TagLib
{
    // 标签定义
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'category'   => ['attr' => 'type',                     'alias' => 'nav'],
        'breadcrumb' => ['attr' => '',                         'alias' => 'map'],
        'sidebar'    => ['attr' => '',                         'alias' => 'sub'],
        'ads'        => ['attr' => 'id',                       'alias' => 'guanggao'],
        'banner'     => ['attr' => 'id',                       'alias' => 'huandengpian'],
        'article'    => ['attr' => 'id,cid',                   'alias' => 'neirong'],
        'list'       => ['attr' => 'id,num,order,com,top,hot', 'alias' => 'entry'],
        'tags'       => ['attr' => '',                         'alias' => 'biaoqian'],
        'member'     => ['attr' => '',                         'alias' => 'user'],

        'meta'       => ['attr' => '', 'close' => 0],

    ];

    /**
     * category标签解析 循环输出数据集
     * @access public
     * @param  array  $tag     标签属性
     * @param  string $content 标签内容
     * @return string|void
     */
    public function tagCategory($tag, $content)
    {
        $type = !empty($tag['type']) ? trim($tag['type']) : 'main';

        switch ($type) {
            case 'top':
                $type_id = 1;
                break;

            case 'foot':
                $type_id = 3;
                break;

            case 'other':
                $type_id = 4;
                break;

            default:
                $type_id = 2;
                break;
        }

        $parseStr = '<?php ';
        $parseStr .= ' $label["category"][' . $type_id . '] = \taglib\LabelFun::tagCategory(' . $type_id . ');';
        $parseStr .= ' $tag_count = count($label["category"][' . $type_id . ']);';
        $parseStr .= ' foreach ($label["category"][' . $type_id . '] as $key => $vo) { ?>';
        $parseStr .= $content;
        $parseStr .= '<?php } ?>';

        return $parseStr;
    }

    /**
     * breadcrumb标签解析 循环输出数据集
     * @access public
     * @param  array  $tag     标签属性
     * @param  string $content 标签内容
     * @return string|void
     */
    public function tagBreadcrumb($tag, $content)
    {
        $parseStr = '<?php ';
        $parseStr .= ' $label["breadcrumb"] = \taglib\LabelFun::tagBreadcrumb();';
        $parseStr .= ' if (!empty($label["breadcrumb"])) {';
        $parseStr .= ' $tag_count = count($label["breadcrumb"]);';
        $parseStr .= ' foreach ($label["breadcrumb"] as $key => $vo) {';
        $parseStr .= ' $vo["url"] = url("/list/" . $vo["id"]);?>';
        $parseStr .= $content;
        $parseStr .= '<?php } } ?>';

        return $parseStr;
    }

    /**
     * sidebar标签解析 循环输出数据集
     * @access public
     * @param  array  $tag     标签属性
     * @param  string $content 标签内容
     * @return string|void
     */
    public function tagSidebar($tag, $content)
    {
        $parseStr = '<?php ';
        $parseStr .= ' $label["sidebar"] = \taglib\LabelFun::tagSidebar();';
        $parseStr .= ' if (!empty($label["sidebar"])) {';
        $parseStr .= ' $tag_count = count($label["sidebar"]);';
        $parseStr .= ' $label_sidebar_name = $label["sidebar"][0]["name"];';
        $parseStr .= ' foreach ($label["sidebar"] as $key => $vo) { ?>';
        $parseStr .= $content;
        $parseStr .= '<?php } } ?>';

        return $parseStr;
    }

    /**
     * ads标签解析 循环输出数据集
     * @access public
     * @param  array  $tag     标签属性
     * @param  string $content 标签内容
     * @return string|void
     */
    public function tagAds($tag, $content)
    {
        $id = (float) $tag['id'];

        $parseStr = '<?php ';
        $parseStr .= ' $label["ads"][' . $id . '] = \taglib\LabelFun::tagAds(' . $id . ');';
        $parseStr .= ' if (!empty($label["ads"][' . $id . '])) {';
        $parseStr .= ' $label["ads"][' . $id . ']["url"] = url("/ads/" . $ads["id"]); ?>';
        $parseStr .= $content;
        $parseStr .= '<?php } ?>';
        return $parseStr;
    }

    /**
     * 幻灯片标签解析
     * @access public
     * @param  array  $tag     标签属性
     * @param  string $content 标签内容
     * @return string|void
     */
    public function tagBanner($tag, $content)
    {
        $id = (float) $tag['id'];

        $parseStr = '<?php ';
        $parseStr .= ' $label["banner"][' . $id . '] = \taglib\LabelFun::tagBanner(' . $id . ');';
        $parseStr .= ' if (!empty($label["banner"][' . $id . '])) {';
        $parseStr .= ' $tag_count = count($label["banner"][' . $id . ']);';
        $parseStr .= ' foreach ($label["banner"][' . $id . ']["data"] as $key => $vo) { ?>';
        $parseStr .= $content;
        $parseStr .= '<?php } } ?>';
        return $parseStr;
    }

    /**
     * 文章标签解析 循环输出数据集
     * @access public
     * @param  array  $tag     标签属性
     * @param  string $content 标签内容
     * @return string|void
     */
    public function tagArticle($tag, $content)
    {
        $id = (float) $tag['id'];
        $cid = (float) $tag['cid'];

        $parseStr = '<?php ';
        $parseStr .= ' $label["article"]["' . $id . $cid . '"] = \taglib\LabelFun::tagArticle(' . $id . ', ' . $cid . ');';
        $parseStr .= ' if (!empty($label["article"]["' . $id . $cid . '"])) {';
        $parseStr .= ' $tag_count = count($label["article"]["' . $id . $cid . '"]);';
        $parseStr .= ' $article = $label["article"]["' . $id . $cid . '"]; ?>';
        $parseStr .= $content;
        $parseStr .= '<?php } ?>';
        return $parseStr;
    }

    /**
     * list标签解析 循环输出数据集
     * @access public
     * @param  array  $tag     标签属性
     * @param  string $content 标签内容
     * @return string|void
     */
    public function tagList($tag, $content)
    {
        $parseStr = '<?php ';
        $parseStr .= ' $param = ' . var_export($tag, true) . ';';
        $parseStr .= ' $label["list"]["' . $tag['id'] . '"] = \taglib\LabelFun::tagList("' . $tag['id'] . '", $param);';
        $parseStr .= ' if (!empty($label["list"]["' . $tag['id'] . '"])) {';
        $parseStr .= ' $tag_count = count($label["list"]["' . $tag['id'] . '"]);';
        $parseStr .= ' foreach ($label["list"]["' . $tag['id'] . '"] as $key => $vo) { ?>';
        $parseStr .= $content;
        $parseStr .= '<?php } } ?>';
        return $parseStr;
    }

    /**
     * tags标签解析 循环输出数据集
     * @access public
     * @param  array  $tag     标签属性
     * @param  string $content 标签内容
     * @return string|void
     */
    public function tagTags($tag, $content)
    {
        $parseStr = '<?php ';
        $parseStr .= ' $label["tags"] = \taglib\LabelFun::tagTags();';
        $parseStr .= ' if (!empty($label["tags"])) {';
        $parseStr .= ' $tag_count = count($label["tags"]);';
        $parseStr .= ' foreach ($label["tags"] as $key => $vo) { ?>';
        $parseStr .= $content;
        $parseStr .= '<?php } } ?>';
        return $parseStr;
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
        $parseStr = '<?php ';
        $parseStr .= ' $label["member"] = cookie(config("USER_AUTH_KEY"));';
        $parseStr .= ' $label["user_data"] = cookie(config("USER_DATA"));';
        $parseStr .= ' $label["member_url"]["home"] = url("/my");';
        $parseStr .= ' $label["member_url"]["login"] = url("/login");';
        $parseStr .= ' $label["member_url"]["logout"] = url("/logout");';
        $parseStr .= ' $label["member_url"]["reg"] = url("/reg");';
        $parseStr .= ' $label["member_url"]["forget"] = url("/forget"); ?>';
        $parseStr .= $content;
        return $parseStr;
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

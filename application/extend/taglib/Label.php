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
		'category'   => ['attr' => 'type',   'alias' => 'nav'],
		'breadcrumb' => ['attr' => '',       'alias' => 'map'],
		'sidebar'    => ['attr' => '',       'alias' => 'sub'],
		'ads'        => ['attr' => 'id',     'alias' => 'guanggao'],
		'banner'     => ['attr' => 'id',     'alias' => 'huandengpian'],
		'article'    => ['attr' => 'id,cid', 'alias' => 'neirong'],
		'list'       => ['attr' => 'id,num,order,com,top,hot', 'alias' => 'entry'],
		'tags'       => ['attr' => '', 'alias' => 'biaoqian'],
		//
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
		$parseStr .= ' $vo["url"] = url("entry", ["cid"=>$vo["id"]]);?>';
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
		/*$parseStr .= ' $label["banner"][' . $id . ']["data"][$key] = $vo["url"] = url("/banner/" . $vo["id"]);';
		$parseStr .= ' $label["banner"][' . $id . ']["data"][$key] = $vo["width"] = $label["banner"][' . $id . ']["size"]["width"];';
		$parseStr .= ' $label["banner"][' . $id . ']["data"][$key] = $vo["height"] = $label["banner"][' . $id . ']["size"]["height"];?>';*/
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
		/*$parseStr .= ' $article["cat_url"] = url("/entry/" . $article["category_id"]);';
		$parseStr .= ' $article["url"] = url("/article/" . $article["category_id"] . "/" . $article["id"]); ?>';
		*/
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
		$id = (float) $tag['id'];

		$parseStr = '<?php ';
		$parseStr .= ' $param = ' . var_export($tag, true) . ';';
		$parseStr .= ' $label["list"]["' . $id . '"] = \taglib\LabelFun::tagList(' . $id . ', $param);';
		$parseStr .= ' if (!empty($label["list"]["' . $id . '"])) {';
		$parseStr .= ' $tag_count = count($label["list"]["' . $id . '"]);';
		$parseStr .= ' foreach ($label["list"][' . $id . '] as $key => $vo) { ?>';
		/*$parseStr .= ' $vo["cat_url"] = url("/entry/" . $vo["category_id"]);';
		$parseStr .= ' $vo["url"] = url("/article/" . $vo["category_id"] . "/" . $vo["id"]); ?>';
		*/
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
		/*$parseStr .= ' $vo["url"] = url("/tags/" . $vo["id"]); ?>';*/
		$parseStr .= $content;
		$parseStr .= '<?php } } ?>';
		return $parseStr;
	}
}
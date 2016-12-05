<?php
/**
 *
 * 标签（类）文件
 *
 * @package   NiPHPCMS
 * @category  extend\taglib\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: common.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace taglib;
use think\Request;
use think\Lang;
use think\Loader;
use think\Url;
use app\admin\model\Category as IndexCategory;
use app\admin\model\Ads as IndexAds;
use app\admin\model\Banner as IndexBanner;
use app\admin\model\Tags as IndexTags;
class LabelFun
{

	/**
	 * category标签函数
	 * @access public
	 * @param  intval $type_id_
	 * @return array
	 */
	public static function tagCategory($type_id_)
	{
		$map = [
			'type_id' => $type_id_,
			'is_show' => 1,
			'pid'     => 0,
			'lang'    => Lang::detect()
		];
		$order = 'sort ASC, id DESC';
		$field = [
			'id',
			'name',
			'pid',
			'aliases',
			'seo_title',
			'seo_keywords',
			'seo_description',
			'image',
			'url'
		];

		$category = new IndexCategory;
		$CACHE = !APP_DEBUG ? __METHOD__ . implode('', $map) : false;

		$result =
		$category->field($field)
		->where($map)
		->order($order)
		->cache($CACHE)
		->select();

		$data = [];
		foreach ($result as $value) {
			$data[] = $value->toArray();
		}

		return self::__getChild($data);
	}

	/**
	 * 获得子导航
	 * @access protected
	 * @param  array $data_
	 * @return array
	 */
	protected static function __getChild($data_)
	{
		$nav = $id = [];

		$map   = ['lang' => Lang::detect()];
		$field = [
			'id',
			'name',
			'pid',
			'aliases',
			'seo_title',
			'seo_keywords',
			'seo_description',
			'image',
			'url'
		];
		$order = 'sort ASC,id DESC';

		foreach ($data_ as $key => $value) {
			$nav[$key] = $value;
			$nav[$key]['url'] = Url::build('/entry/' . $value['id']);

			// 查询子类
			$map['pid'] = $value['id'];

			$category = new IndexCategory;
			$CACHE = !APP_DEBUG ? __METHOD__ . implode('', $map) : false;

			$result =
			$category->field($field)
			->where($map)
			->order($order)
			->cache($CACHE)
			->select();

			$child = [];
			foreach ($result as $value) {
				$child[] = $value->toArray();
			}

			if (!empty($child)) {
				// 递归查询子类
				$_child = self::__getChild($child);
				$child = !empty($_child) ? $_child : $child;
				$nav[$key]['child'] = $child;
			}
		}

		return $nav;
	}

	/**
	 * breadcrumb标签函数
	 * @access public
	 * @param
	 * @return array
	 */
	public static function tagBreadcrumb()
	{
		$request = Request::instance();
		if (!$request->has('cid', 'param')) {
			return [];
		}

		$id = $request->param('cid/f');

		return self::__getParent($id);
	}

	/**
	 * 获得父级栏目
	 * @access protected
	 * @param  intval $pid_
	 * @return intval
	 */
	protected static function __getParent($pid_)
	{
		$parent = [];

		$map = [
			'id'   => $pid_,
			'lang' => Lang::detect()
		];

		$field = [
			'id',
			'name',
			'pid',
			'aliases',
			'seo_title',
			'seo_keywords',
			'seo_description',
			'image',
			'url'
		];

		$category = new IndexCategory;
		$CACHE = !APP_DEBUG ? __METHOD__ . implode('', $map) : false;

		$result =
		$category->field($field)
		->where($map)
		->cache($CACHE)
		->find();

		$data = $result ? $result->toArray() : [];

		if (!empty($data['pid'])) {
			$parent = self::__getParent($data['pid']);
		}

		$parent[] = $data;

		return $parent;
	}

	/**
	 * sidebar标签函数
	 * @access public
	 * @param
	 * @return string|void
	 */
	public static function tagSidebar()
	{
		$request = Request::instance();
		if (!$request->has('cid', 'param')) {
			return [];
		}

		$id = $request->param('cid/f');

		$id = self::__toParent($id);

		$map = [
			'id'      => $id,
			'is_show' => 1,
			'pid'     => 0,
			'lang'    => Lang::detect()
		];
		$field = [
			'id',
			'name',
			'pid',
			'aliases',
			'seo_title',
			'seo_keywords',
			'seo_description',
			'image',
			'url'
		];

		$category = new IndexCategory;
		$CACHE = !APP_DEBUG ? __METHOD__ . implode('', $map) : false;

		$result =
		$category->field($field)
		->where($map)
		->cache($CACHE)
		->select();

		$data = [];
		foreach ($result as $value) {
			$data[] = $value->toArray();
		}

		if (empty($data)) {
			return ;
		}

		return self::__getChild($data);

	}

	/**
	 * 获得父级ID
	 * @access protected
	 * @param  intval $cid_
	 * @return intval
	 */
	protected static function __toParent($cid_)
	{
		$map = [
			'id'   => $cid_,
			'lang' => Lang::detect()
		];

		$field = [
			'id',
			'name',
			'pid',
			'aliases',
			'seo_title',
			'seo_keywords',
			'seo_description',
			'image',
			'url'
		];

		$category = new IndexCategory;
		$CACHE = !APP_DEBUG ? __METHOD__ . implode('', $map) : false;

		$result =
		$category->field($field)
		->where($map)
		->cache($CACHE)
		->find();

		$data = $result ? $result->toArray() : [];

		if (!empty($data['pid'])) {
			return self::__toParent($data['pid']);
		}

		return $data['id'];
	}

	/**
	 * ads标签函数
	 * @access public
	 * @param  intval $id_
	 * @return array
	 */
	public static function tagAds($id_)
	{
		$map = [
			'id' => $id_,
			'end_time' => ['EGT', time()],
			'start_time' => ['ELT', time()],
			'lang' => Lang::detect()
		];

		$category = new IndexAds;
		$CACHE = !APP_DEBUG ? __METHOD__ . $id_ : false;

		$result =
		$category->field(true)
		->where($map)
		->cache($CACHE)
		->find();

		return $result ? $result->toArray() : [];
	}

	/**
	 * 幻灯片标签函数
	 * @access public
	 * @param  intval $id_
	 * @return array
	 */
	public static function tagBanner($id_)
	{
		if (empty($id_)) {
			return ;
		}

		$map = [
			'id' => $id_,
			'lang' => Lang::detect()
		];
		$banner = new IndexBanner;
		$CACHE = !APP_DEBUG ? __METHOD__ . 'PARENT' . implode('', $map) : false;

		$result =
		$banner->field(true)
		->where($map)
		->cache($CACHE)
		->find();

		$size = $result ? $result->toArray() : [];

		if (empty($size)) {
			return ;
		}

		$map = [
			'pid' => $id_,
			'lang' => Lang::detect()
		];
		$CACHE = !APP_DEBUG ? __METHOD__ . 'CHILD' . implode('', $map) : false;

		$result =
		$banner->field(true)
		->where($map)
		->cache($CACHE)
		->select();

		$data = [];
		foreach ($result as $value) {
			$data[] = $value->toArray();
		}

		return ['data' => $data, 'size' => $size];
	}

	/**
	 * 文章标签函数
	 * @access public
	 * @param  intval $id_
	 * @param  intval $cid_
	 * @return array
	 */
	public static function tagArticle($id_, $cid_)
	{
		if (empty($id_) || empty($cid_)) {
			return ;
		}

		$table_name = self::__getModelTable($cid_);
		if (empty($table_name)) {
			return ;
		}

		$map = [
			'a.id'          => $id_,
			'a.category_id' => $cid_,
			'a.is_pass'     => 1,
			'a.show_time'   => ['ELT', time()],
			'a.lang'        => Lang::detect()
		];

		$model = Loader::model(ucfirst($table_name), 'model', false, 'admin');
		$CACHE = !APP_DEBUG ? __METHOD__ . $id_ . $cid_ : false;

		$result =
		$model->view($table_name . ' a', true)
		->view('type t', ['name' => 'type_name'], 't.id=a.type_id', 'LEFT')
		->view('level l', ['name' => 'level_name'], 'l.id=a.access_id', 'LEFT')
		->view('category c', ['name' => 'cat_name'], 'c.id=a.category_id')
		->view('admin ad', ['username' => 'editor_name'], 'a.user_id=ad.id')
		->where($map)
		->cache($CACHE)
		->find();

		$data = $result ? $result->toArray() : [];

		$data['content'] = htmlspecialchars_decode($data['content']);

		/*
		TODO
		$data['field'] = $this->getFieldsData();
		$data['tags'] = $this->getTagsData();

		if (in_array($this->model_name, ['picture', 'product'])) {
			$data['album'] = $this->getAlbumData();
		}*/

		return $data;
	}

	/**
	 * list标签函数
	 * @access public
	 * @param  intval $id_
	 * @param  array  $param_
	 * @return array
	 */
	public static function tagList($id_, $param_)
	{
		$table_name = self::__getModelTable($id_);
		if (empty($table_name)) {
			return ;
		}

		if (in_array($table_name, ['link', 'feedback', 'message'])) {
			return ;
		}

		$map = [
			'a.category_id' => ['IN', $id_],
			'a.is_pass'     => 1,
			'a.show_time'   => ['ELT', time()],
			'a.lang'        => Lang::detect()
		];

		// 推荐
		if (!empty($param_['com'])) {
			$map['a.is_com'] = 1;
		}
		// 置顶
		if (!empty($param_['top'])) {
			$map['a.is_top'] = 1;
		}
		// 最热
		if (!empty($param_['hot'])) {
			$map['a.is_hot'] = 1;
		}

		$limit = !empty($param_['limit']) ? (float) $param_['limit'] : 10;
		$order = !empty($param_['order']) ? $param_['order'] : 'a.sort DESC, a.id DESC';

		$model = Loader::model(ucfirst($table_name), 'model', false, 'admin');
		$CACHE = !APP_DEBUG ? __METHOD__ . implode('', $param_) : false;

		$result =
		$model->view($table_name . ' a', true)
		->view('type t', ['name' => 'type_name'], 't.id=a.type_id', 'LEFT')
		->view('level l', ['name' => 'level_name'], 'l.id=a.access_id', 'LEFT')
		->view('category c', ['name' => 'cat_name'], 'c.id=a.category_id')
		->view('admin ad', ['username' => 'editor_name'], 'a.user_id=ad.id')
		->where($map)
		->limit($limit)
		->order($order)
		->cache($CACHE)
		->select();

		$list = [];
		foreach ($result as $value) {
			$value = $value->toArray();
			if ($value['is_link']) {
				$value['url'] = Url::build('/jump/' . $value['category_id'] . '/' . $value['id']);
			} else {
				$value['url'] = Url::build('/article/' . $value['category_id'] . '/' . $value['id']);
			}
			$list[] = $value;
		}

		return $list;
	}

	/**
	 * tags标签函数
	 * @access public
	 * @param
	 * @return array
	 */
	public static function tagTags()
	{
		$map = ['lang' => Lang::detect()];

		$tags = new IndexTags;
		$CACHE = !APP_DEBUG ? __METHOD__ . implode('', $map) : false;

		$result =
		$tags->where($map)
		->cache($CACHE)
		->select();

		$data = [];
		foreach ($result as $value) {
			$data[] = $value->toArray();
		}

		return $data;
	}

	/**
	 * 获得模型表
	 * @access protected
	 * @param
	 * @return array
	 */
	protected static function __getModelTable($cid_)
	{
		$map = [
			'c.id' => $cid_,
			'c.lang' => Lang::detect()
		];

		$category = new IndexCategory;
		$CACHE = !APP_DEBUG ? __METHOD__ . $cid_ : false;

		$result =
		$category->view('category c', 'id')
		->view('model m', ['name' => 'model_name'], 'm.id=c.model_id AND m.name!=\'external\'')
		->view('category cc', 'pid', 'c.id=cc.pid', 'LEFT')
		->where($map)
		->cache($CACHE)
		->find();

		$data = $result ? $result->toArray() : [];

		return $data ? $data['model_name'] : '';
	}
}
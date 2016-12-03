<?php
/**
 *
 * 文章|下载|单页|图文|产品 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CommonAccount.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\logic;
use think\Model;
use think\Request;
use think\Lang;
use think\Url;
use think\Loader;
use app\admin\model\Category as IndexCategory;
use app\admin\model\Fields as IndexFields;
use app\admin\model\TagsArticle as IndexTagsArticle;
class Article extends Model
{
	protected $request    = null;
	protected $model_name = null;

	protected function initialize()
	{
		parent::initialize();

		$this->request = Request::instance();
	}

	public function setTableModel($name_)
	{
		$this->model_name = $name_;
	}

	/**
	 * 列表数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getListData()
	{
		$id = $this->getChild();

		$map = [
			// 'a.category_id' => ['IN', $id], 查询表不同会有错误
			'a.category_id' => $this->request->param('cid/f'),
			'a.is_pass'     => 1,
			'a.lang'        => Lang::detect(),
			'a.show_time'   => ['ELT', time()]
		];
		$order = 'a.sort DESC, a.update_time DESC';


		$model = Loader::model(ucfirst($this->model_name), 'model', false, 'admin');

		$result =
		$model->view($this->model_name . ' a', 'id,title,keywords,description,thumb,category_id,hits,comment_count,create_time,update_time,type_id,access_id,is_link,url')
		->view('type t', ['name' => 'type_name'], 't.id=a.type_id', 'LEFT')
		->view('level l', ['name' => 'level_name'], 'l.id=a.access_id', 'LEFT')
		->view('category c', ['name' => 'cat_name'], 'c.id=a.category_id')
		->view('admin ad', ['username' => 'editor_name'], 'a.user_id=ad.id')
		->where($map)
		->cache(!APP_DEBUG)
		->paginate();

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

		$page = $result->render();

		return ['list' => $list, 'page' => $page];
	}

	/**
	 * 获得子栏目ID
	 * @access protected
	 * @param  string $pid_
	 * @return string
	 */
	protected function getChild($pid_='')
	{
		$pid_ = !empty($pid_) ? $pid_ : $this->request->param('cid/f');

		$map = [
			'pid'  => ['IN', "$pid_"],
			'lang' => Lang::detect()
		];

		$category = new IndexCategory;
		$result =
		$category->field(['id'])
		->where($map)
		->cache(!APP_DEBUG)
		->select();

		if (!$result) {
			return $pid_;
		}

		$data = [];
		foreach ($result as $value) {
			$value = $value->toArray();
			$data[] = $value['id'];
		}
		$id = implode(',', $data);

		$parent = $id ? $this->getChild($id) : '';

		$id = $parent && $id <> $parent ? $id . ',' . $parent : $id;

		return $id;
	}

	public function getArticle()
	{
		$map = [
			'a.category_id' => $this->request->param('cid/f'),
			'a.id' => $this->request->param('id/f'),
			'a.is_pass'     => 1,
			'a.lang'        => Lang::detect(),
			'a.show_time'   => ['ELT', time()]
		];
		$order = 'a.sort DESC, a.update_time DESC';


		$model = Loader::model(ucfirst($this->model_name), 'model', false, 'admin');

		$result =
		$model->view($this->model_name . ' a', true)
		->view('type t', ['name' => 'type_name'], 't.id=a.type_id', 'LEFT')
		->view('level l', ['name' => 'level_name'], 'l.id=a.access_id', 'LEFT')
		->view('category c', ['name' => 'cat_name'], 'c.id=a.category_id')
		->view('admin ad', ['username' => 'editor_name'], 'a.user_id=ad.id')
		->where($map)
		->cache(!APP_DEBUG)
		->find();

		$data = $result ? $result->toArray() : [];

		$data['content'] = htmlspecialchars_decode($data['content']);

		$data['field'] = $this->getFieldsData();
		$data['tags'] = $this->getTagsData();

		if (in_array($this->model_name, ['picture', 'product'])) {
			$data['album'] = $this->getAlbumData();
		}

		return $data;
	}

	/**
	 * 查询相册数据
	 * @access protected
	 * @param
	 * @return array
	 */
	protected function getAlbumData()
	{
		$map = ['main_id' => $this->request->param('id/f')];

		$album = Loader::model($this->model_name . 'Album', 'model', false, 'admin');
		$result =
		$album->field(true)
		->where($map)
		->select();

		$list = [];
		foreach ($result as $value) {
			$list[] = $value->toArray();
		}

		return $list;
	}

	/**
	 * 查询字段数据
	 * @access protected
	 * @param  string $table_name_ 表名
	 * @return array
	 */
	protected function getFieldsData()
	{
		$map = ['f.category_id' => $this->request->param('cid/f')];
		$table_name = $this->model_name . '_data d';

		$fields = new IndexFields;
		$result =
		$fields->view('fields f', ['id', 'name' => 'field_name'])
		->view('fields_type t', ['name' => 'field_type'], 'f.type_id=t.id')
		->view($table_name, ['data' => 'field_data'], 'f.id=d.fields_id AND d.main_id=' . $this->request->param('id/f'), 'LEFT')
		->where($map)
		->select();

		$list = [];
		foreach ($result as $value) {
			$list[] = $value->toArray();
		}

		return $list;
	}

	/**
	 * 查询标签数据
	 * @access protected
	 * @param
	 * @return array
	 */
	protected function getTagsData()
	{
		$map = [
			'a.category_id' => $this->request->param('cid/f'),
			'a.article_id'  => $this->request->param('id/f')
		];

		$tags = new IndexTagsArticle;
		$result =
		$tags->view('tags_article a', 'tags_id')
		->view('tags t', 'name', 't.id=a.tags_id')
		->where($map)
		->select();

		$list = [];
		foreach ($result as $value) {
			$value = $value->toArray();
			$list[] = $value['name'];
		}

		return implode(' ', $list);
	}
}
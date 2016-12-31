<?php
/**
 *
 * 内容 - 内容 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ContentContent.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/14
 */
namespace app\admin\logic;
use think\Model;
use think\Request;
use think\Lang;
use think\Loader;
use think\Config;
use think\Session;
use app\admin\logic\ContentContentData as AdminContentContentData;
use app\admin\model\Tags as AdminTags;
use app\admin\model\TagsArticle as AdminTagsArticle;
class ContentContent extends Model
{
	protected $request       = null;
	protected $table_model   = null;

	public $data_model = null;
	public $table_name = null;
	public $type_data  = null;
	public $level_data = null;

	protected function initialize()
	{
		parent::initialize();

		$this->request = Request::instance();

		// 内容数据业务层
		$this->data_model = new AdminContentContentData;
		// 分类
		$this->type_data = $this->data_model->getTypeData();
		// 权限
		$this->level_data = $this->data_model->getLevelData();

		// 表名
		$this->table_name = $this->data_model->getModelTable();

		// 对应表模型
		$this->table_model = $this->table_name ? Loader::model(ucfirst($this->table_name)) : null;
	}

	/**
	 * 列表数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getListData()
	{
		$cid = $this->request->param('pid/f', 0);	// 用于内容管理中栏目显示

		$map = ['category_id' => $this->request->param('cid/f', $cid)];
		if ($key = $this->request->param('key')) {
			$map['remark'] = ['LIKE', '%' . $key . '%'];
		}

		if ($this->table_name == 'link') {
			$order = 'is_pass ASC, sort DESC, update_time DESC';
		} elseif (in_array($this->table_name, ['message', 'feedback'])) {
			$order = 'is_pass ASC, update_time DESC';
		} else {
			$order = 'is_pass ASC, is_com DESC, is_top DESC, is_hot DESC, sort DESC, update_time DESC';
		}

		$result =
		$this->table_model->field(true)
		->where($map)
		->order($order)
		->paginate();

		$list = [];
		foreach ($result as $value) {
			$list[] = $value->toArray();
		}

		$page = $result->render();

		return ['list' => $list, 'page' => $page, 'table_name' => $this->table_name];
	}

	/**
	 * 添加数据
	 * @access public
	 * @param
	 * @return boolean
	 */
	public function added()
	{
		$data = [
			'title'       => $this->request->post('title'),
			'logo'        => $this->request->post('logo'),
			'keywords'    => $this->request->post('keywords'),
			'description' => $this->request->post('description'),
			'content'     => $this->request->post('content', '', Config::get('content_filter')),
			'thumb'       => $this->request->post('thumb', ''),
			'category_id' => $this->request->post('category_id/f'),
			'type_id'     => $this->request->post('type_id/f', 0),
			'is_pass'     => $this->request->post('is_pass/d', 0),
			'is_com'      => $this->request->post('is_com/d', 0),
			'is_top'      => $this->request->post('is_top/d', 0),
			'is_hot'      => $this->request->post('is_hot/d', 0),
			'username'    => $this->request->post('username', ''),
			'origin'      => $this->request->post('origin', ''),
			'user_id'     => Session::get(Config::get('USER_AUTH_KEY')),
			'url'         => $this->request->post('url', ''),
			'down_url'    => $this->request->post('down_url', ''),
			'is_link'     => $this->request->post('is_link/d', 0),
			'show_time'   => $this->request->post('show_time/f', 0, 'trim,strtotime'),
			'access_id'   => $this->request->post('access_id/f', 0),
			'lang'        => Lang::detect(),
		];

		$this->table_model->allowField(true)
		->isUpdate(false)
		->data($data)
		->save();

		$this->AEField($this->table_model->id);
		$this->AEAlbum($this->table_model->id);
		$this->AETags($this->table_model->id);

		return $this->table_model->id ? true : false;
	}

	/**
	 * 查询编辑数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getEditorData()
	{
		if ($this->table_name == 'page') {
			$map = ['category_id' => $this->request->param('cid/f')];
		} else {
			$map = ['id' => $this->request->param('id/f')];
		}

		$result =
		$this->table_model->field(true)
		->where($map)
		->find();

		$data = !empty($result) ? $result->toArray() : [];

		if (empty($data)) {
			return null;
		}

		// 非友链
		if ($this->table_name != 'link') {
			$data['content'] = htmlspecialchars_decode($data['content']);

			$data['field_data'] = $this->data_model->getEditorFieldsData($data, $this->table_name);

			$data['tags'] = $this->data_model->getEditorTagsData($data);
		}

		// 图文 产品
		if (in_array($this->table_name, ['picture', 'product'])) {
			$data['album_data'] = $this->data_model->getEditorAlbumData($this->table_name);
		}

		return $data;
	}

	/**
	 * 编辑数据
	 * @access public
	 * @param
	 * @return boolean
	 */
	public function editor()
	{
		$data = [
			'title'       => $this->request->post('title'),
			'logo'        => $this->request->post('logo'),
			'keywords'    => $this->request->post('keywords'),
			'description' => $this->request->post('description'),
			'content'     => $this->request->post('content', '', Config::get('content_filter')),
			'thumb'       => $this->request->post('thumb', ''),
			'category_id' => $this->request->post('category_id/f'),
			'type_id'     => $this->request->post('type_id/f', 0),
			'is_pass'     => $this->request->post('is_pass/d', 0),
			'is_com'      => $this->request->post('is_com/d', 0),
			'is_top'      => $this->request->post('is_top/d', 0),
			'is_hot'      => $this->request->post('is_hot/d', 0),
			'username'    => $this->request->post('username', ''),
			'origin'      => $this->request->post('origin', ''),
			'user_id'     => Session::get(Config::get('USER_AUTH_KEY')),
			'url'         => $this->request->post('url', ''),
			'down_url'    => $this->request->post('down_url', ''),
			'is_link'     => $this->request->post('is_link/d', 0),
			'show_time'   => $this->request->post('show_time/f', 0, 'trim,strtotime'),
			'access_id'   => $this->request->post('access_id/f', 0),
			// 'lang'        => Lang::detect(),
		];

		$id = $this->request->post('id/f');
		$map = ['id' => $id];

		$result =
		$this->table_model->allowField(true)
		->isUpdate(true)
		->save($data, $map);

		$this->AEField();
		$this->AEAlbum();
		$this->AETags();

		return $result ? true : false;
	}

	/**
	 * 删除数据
	 * @access public
	 * @param
	 * @return boolean
	 */
	public function remove()
	{
		$id = $this->request->param('id/f');
		$map = ['id' => $id];

		$this->table_model->where($map);
		$result = $this->table_model->delete();

		return $result ? true : false;
	}

	/**
	 * 添加编辑相册
	 * @access protected
	 * @param  mixed $master_id 添加文章ID
	 * @return mixed
	 */
	protected function AEAlbum($master_id=false)
	{
		if (!in_array($this->table_name, ['picture', 'product'])) {
			return true;
		}

		$id = $master_id ? $master_id : $this->request->post('id/f');

		$model = Loader::model(ucfirst($this->table_name) . 'Album');

		$map = ['main_id' => $id];

		$model->where($map)
		->delete();

		$album_image = $this->request->post('album_image/a');
		$album_thumb = $this->request->post('album_thumb/a');
		if (empty($album_image)) {
			return true;
		}

		$added_data = [];
		foreach ($album_image as $key => $value) {
			$added_data[] = [
				'main_id' => $id,
				'thumb'   => $album_thumb[$key],
				'image'   => $value
			];
		}

		if (!empty($added_data)) {
			$model->saveAll($added_data);
		}
	}

	/**
	 * 添加编辑字段
	 * @access protected
	 * @param  mixed $master_id 添加文章ID
	 * @return mixed
	 */
	protected function AEField($master_id=false)
	{
		if (in_array($this->table_name, ['link', 'external'])) {
			return true;
		}

		$id = $master_id ? $master_id : $this->request->post('id/f');

		$fields = $this->request->post('fields/a', '', Config::get('content_filter'));
		if (empty($fields)) {
			return true;
		}

		$model = Loader::model(ucfirst($this->table_name) . 'Data');

		$added_data = [];
		foreach ($fields as $key => $value) {
			$map = [
				'main_id' => $id,
				'fields_id' => $key,
			];

			$is =
			$model->where($map)
			->value('id');

			if ($is) {
				$editor_data = ['data' => $value];

				$model->where($map)
				->update($editor_data);

			} else {
				$added_data[] = [
					'main_id'   => $id,
					'fields_id' => $key,
					'data'      => $value
				];
			}
		}

		if (!empty($added_data)) {
			$model->saveAll($added_data);
		}
	}

	/**
	 * 添加编辑字段
	 * @access protected
	 * @param  mixed $master_id 添加文章ID
	 * @return mixed
	 */
	protected function AETags($master_id=false)
	{
		if (in_array($this->table_name, ['link', 'external'])) {
			return true;
		}

		$id = $master_id ? $master_id : $this->request->post('id/f');

		$tags = $this->request->post('tags');

		// 标签为空删除关联关系
		if (empty($tags)) {
			$map = ['article_id' => $id];

			$tags_art_model = new AdminTagsArticle;
			$tags_art_model->where($map)
			->delete();

			return true;
		}

		$tags = explode(' ', strtolower($tags));

		// 搜索关联标签
		$map = [
			'name' => [
				'IN',
				implode(',', $tags)
			]
		];

		$tags_model = new AdminTags;
		$result =
		$tags_model->field(true)
		->where($map)
		->select();

		$data = $tags_id = $tags_name = [];
		foreach ($result as $value) {
			$data[] = $value = $value->toArray();
			if (in_array($value['name'], $tags)) {
				$tags_id[] = $value['id'];
				$tags_name[] = $value['name'];
			}
		}

		// 关联标签数小于标签数，说明有新的标签，插入新标签
		if (count($data) < count($tags)) {
			foreach ($tags as $key => $value) {
				if (!in_array($value, $tags_name)) {
					$added_data[] = ['name' => $value];
				}
			}
			$tags_model->saveAll($added_data);
		}

		// 删除原有关联
		$map = ['article_id' => $id];
		$tags_art_model = new AdminTagsArticle;
		$tags_art_model->where($map)
		->delete();

		// 插入新关联
		foreach ($tags_id as $key => $value) {
			$added_data[] = [
				'tags_id' => $value,
				'category_id' => $this->request->post('category_id/f'),
				'article_id' => $id
			];

			$count =
			$tags_art_model->where(['tags_id' => $value])
			->count();

			$tags_model->allowField(true)
			->isUpdate(true)
			->save(['number' => $count], ['id' => $value]);
		}
		if (!empty($added_data)) {
			$tags_art_model->saveAll($added_data);
		}
	}
}
<?php
/**
 *
 * 回收站 - 内容 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ContentRecycle.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/14
 */
namespace app\admin\logic;
use think\Model;
use think\Request;
use think\Loader;
use app\admin\logic\ContentContentData as AdminContentContentData;
class ContentRecycle extends Model
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
		$map = ['category_id' => $this->request->param('cid/f')];
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

		$this->table_model->field(true);
		$this->table_model->where($map);
		$this->table_model->order($order);
		$result =
		$this->table_model->onlyTrashed()->paginate();

		$list = [];
		foreach ($result as $value) {
			$list[] = $value->toArray();
		}

		$page = $result->render();

		return ['list' => $list, 'page' => $page, 'table_name' => $this->table_name];
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

		$this->table_model->field(true);
		$this->table_model->where($map);
		$result =
		$this->table_model->find();

		$data = !empty($result) ? $result->toArray() : [];

		if (empty($data)) {
			return null;
		}

		if ($this->table_name != 'link') {
			$data['content'] = !empty($data['content']) ? htmlspecialchars_decode($data['content']) : '';

			$data['field_data'] = $this->data_model->getEditorFieldsData($data, $this->table_name);
			$data['tags'] = $this->data_model->getEditorTagsData($data);
		}

		if (in_array($this->table_name, ['picture', 'product'])) {
			// 图文 产品
			# code...
		}

		return $data;
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
		$result =
		$this->table_model->delete(true);

		if ($this->table_name != 'link') {
			$map = ['main_id' => $id];

			$model = Loader::model(ucfirst($this->table_name) . '_data');
			$result =
			$model->where($map)->delete();
		}

		if (in_array($this->table_name, ['picture', 'product'])) {
			// 图文 产品
			$map = ['main_id' => $id];

			$model = Loader::model(ucfirst($this->table_name) . '_album');
			$result =
			$model->where($map)->delete();
		}

		return $result ? true : false;
	}
}
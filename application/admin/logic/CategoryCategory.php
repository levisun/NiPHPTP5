<?php
/**
 *
 * 栏目管理 - 栏目 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CategoryCategory.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/25
 */
namespace app\admin\logic;
use think\Model;
use think\Request;
use think\Lang;
use app\admin\model\Category as AdminCategory;
use app\admin\model\Models as AdminModels;
use app\admin\model\Level as AdminLevel;
class CategoryCategory extends Model
{
	protected $request = null;

	protected function initialize()
	{
		parent::initialize();

		$this->request = Request::instance();
	}

	/**
	 * 列表数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getListData()
	{
		$map = [
			'c.pid' => 0,
			'c.lang' => Lang::detect()
		];
		if ($key = $this->request->param('key')) {
			$map['c.name'] = ['LIKE', '%' . $key . '%'];
		}

		$cid = $this->request->param('pid/f', 0);	// 用于内容管理中栏目显示

		if ($pid = $this->request->param('id/f', $cid)) {
			$map['c.pid'] = $pid;
		}

		$category = new AdminCategory;
		$result =
		$category->view('category c', 'id,pid,name,type_id,model_id,is_show,is_channel,sort')
		->view('model m', ['name'=>'model_name'], 'm.id=c.model_id')
		->view('category cc', ['id'=>'child'], 'c.id=cc.pid', 'LEFT')
		->where($map)
		->group('c.id')
		->order('c.type_id ASC, c.sort ASC, c.id DESC')
		->select();

		$data = [];
		foreach ($result as $value) {
			$data[] = $value->toArray();
		}

		return $data;
	}

	/**
	 * 获得父级栏目数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getParent()
	{
		$map = ['id' => $this->request->param('pid/f', 0)];

		$category = new AdminCategory;
		$result =
		$category->field(true)
		->where($map)
		->find();

		$data = !empty($result) ? $result->toArray() : [];

		$data['id']   = !empty($data['id']) ? $data['id'] : 0;
		$data['pid']  = !empty($data['pid']) ? $data['pid'] : 0;
		$data['name'] = !empty($data['name']) ? $data['name'] : Lang::get('select parent');

		return $data;
	}

	/**
	 * 获得导航类型
	 * @access public
	 * @param
	 * @return array
	 */
	public function getCategoryType()
	{
		return [
			['id' => 1, 'name' => Lang::get('ctype top')],
			['id' => 2, 'name' => Lang::get('ctype main')],
			['id' => 3, 'name' => Lang::get('ctype foot')],
			['id' => 4, 'name' => Lang::get('ctype other')]
		];
	}

	/**
	 * 获得模型
	 * @access public
	 * @param
	 * @return array
	 */
	public function getCategoryModel()
	{
		$map = ['status' => 1];

		$category = new AdminModels;
		$result =
		$category->field(true)
		->where($map)
		->order('sort DESC')
		->select();

		$data = [];
		foreach ($result as $value) {
			$data[] = $value->toArray();
		}

		return $data;
	}

	/**
	 * 获得会员等级
	 * @access public
	 * @param
	 * @return array
	 */
	public function getLevel()
	{
		$map = ['status' => 1];

		$level = new AdminLevel;
		$result =
		$level->field(true)
		->where($map)
		->select();

		$data = [];
		foreach ($result as $value) {
			$data[] = $value->toArray();
		}

		return $data;
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
			'name'            => $this->request->post('name'),
			'aliases'         => $this->request->post('aliases'),
			'seo_title'       => $this->request->post('seo_title'),
			'seo_keywords'    => $this->request->post('seo_keywords'),
			'seo_description' => $this->request->post('seo_description'),
			'image'           => $this->request->post('image'),
			'type_id'         => $this->request->post('type_id/f', 0),
			'model_id'        => $this->request->post('model_id/f', 0),
			'is_show'         => $this->request->post('is_show/f', 0),
			'is_channel'      => $this->request->post('is_channel/f', 0),
			'access_id'       => $this->request->post('access_id/f', 0),
			'pid'             => $this->request->post('pid/f', 0),
			'url'             => $this->request->post('url'),
			'lang'            => Lang::detect(),
		];

		$category = new AdminCategory;
		$category->data($data)
		->allowField(true)
		->isUpdate(false)
		->save();

		return $category->id ? true : false;
	}

	/**
	 * 查询编辑数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getEditorData()
	{
		$map = ['c.id' => $this->request->param('id/f')];

		$category = new AdminCategory;
		$result =
		$category->view('category c', true)
		->view('category cc', ['name'=>'parentname'], 'c.pid=cc.id', 'LEFT')
		->where($map)
		->find();

		return !empty($result) ? $result->toArray() : [];
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
			'name'            => $this->request->post('name'),
			'aliases'         => $this->request->post('aliases'),
			'seo_title'       => $this->request->post('seo_title'),
			'seo_keywords'    => $this->request->post('seo_keywords'),
			'seo_description' => $this->request->post('seo_description'),
			'image'           => $this->request->post('image'),
			'type_id'         => $this->request->post('type_id/f', 0),
			'model_id'        => $this->request->post('model_id/f', 0),
			'is_show'         => $this->request->post('is_show/f', 0),
			'is_channel'      => $this->request->post('is_channel/f', 0),
			'access_id'       => $this->request->post('access_id/f', 0),
			'pid'             => $this->request->post('pid/f', 0),
			'url'             => $this->request->post('url'),
			'lang'            => Lang::detect(),
		];
		$map = ['id' => $this->request->post('id/f')];

		$category = new AdminCategory;
		$result =
		$category->allowField(true)
		->isUpdate(true)
		->save($data, $map);

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
		$map = ['pid' => $id];

		$category = new AdminCategory;
		$result =
		$category->field(true)
		->where($map)
		->find();

		$data = !empty($result) ? $result->toArray() : null;
		if (!empty($data)) {
			return 'error child remove';
		}

		$map = ['id' => $id];

		$result = $category->where($map)->delete();

		return $result ? true : false;
	}

	/**
	 * 排序
	 * @access public
	 * @param
	 * @return boolean
	 */
	public function listSort()
	{
		$post = $this->request->post('sort/a');
		foreach ($post as $key => $value) {
			$data[] = [
				'id' => $key,
				'sort' => $value,
			];
		}

		$category = new AdminCategory;
		$result =
		$category->saveAll($data);

		return true;
	}
}
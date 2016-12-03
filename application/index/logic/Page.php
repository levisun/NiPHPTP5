<?php
/**
 *
 * 单页 - 逻辑层
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
use app\admin\model\Page as IndexPage;
class Page extends Model
{
	protected $request    = null;
	protected $model_name = null;

	protected function initialize()
	{
		parent::initialize();

		$this->request = Request::instance();
	}

	/**
	 * 页面数据
	 * 单页面数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getListData()
	{
		$map = [
			'a.category_id' => $this->request->param('cid/f'),
			'a.is_pass'     => 1,
			'a.lang'        => Lang::detect()
		];

		$model = new IndexPage;
		$result =
		$model->view('page a', true)
		->view('type t', ['name' => 'type_name'], 't.id=a.type_id', 'LEFT')
		->view('level l', ['name' => 'level_name'], 'l.id=a.access_id', 'LEFT')
		->view('category c', ['name' => 'cat_name'], 'c.id=a.category_id')
		->where($map)
		->cache(!APP_DEBUG)
		->find();

		$list = $result ? $result->toArray() : '';
		$list['content'] = htmlspecialchars_decode($list['content']);

		return ['list' => $list, 'page' => ''];
	}
}
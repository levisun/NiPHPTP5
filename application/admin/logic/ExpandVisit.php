<?php
/**
 *
 * 访问统计 - 扩展 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ExpandVisit.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/14
 */
namespace app\admin\logic;
use think\Model;
use think\Request;
use app\admin\model\Visit as AdminVisit;
use app\admin\model\Searchengine as AdminSearchengine;
class ExpandVisit extends Model
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
		$this->delLog();

		if ($this->request->param('method')) {
			$obj = new AdminSearchengine;
		} else {
			$obj = new AdminVisit;
		}

		$result =
		$obj->field(true)
		->paginate();

		$list = [];
		foreach ($result as $value) {
			$list[] = $value->toArray();
		}

		$page = $result->render();

		return ['list' => $list, 'page' => $page];
	}

	/**
	 * 删除过期日志
	 * @access public
	 * @param
	 * @return array
	 */
	private function delLog()
	{
		$map = [
			'date' => [
				'ELT', strtotime('-90 days')
			],
		];

		// 删除过期的搜索日志(保留三个月)
		$searchengine = new AdminSearchengine;
		$searchengine->where($map)
		->delete();

		// 删除过期的访问日志(保留三个月)
		$visit = new AdminVisit;
		$visit->where($map)
		->delete();
	}
}
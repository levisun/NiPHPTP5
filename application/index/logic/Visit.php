<?php
/**
 *
 * 搜索引擎 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Visit.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\logic;
use think\Model;
use think\Request;
use app\admin\model\Searchengine as IndexSearchengine;
use app\admin\model\Visit as IndexVisit;
class Visit extends Model
{
	protected $request    = null;

	protected function initialize()
	{
		parent::initialize();

		$this->request = Request::instance();
	}

	/**
	 * 写入访问日志
	 * @access public
	 * @param
	 * @return void
	 */
	public function visit()
	{
		$key = $this->isSpider();
		if ($key !== false) {
			return false;
		}

		$ip = new \net\IpLocation();
		$area = $ip->getlocation($this->request->ip());
		if ($area['ip'] == '0.0.0.0' || $area['ip'] == '127.0.0.1') {
			return false;
		}

		$map = [
			'ip'      => $area['ip'],
			'ip_attr' => $area['country'] . $area['area'],
			'date'    => strtotime(date('Y-m-d'))
		];

		$model = new IndexVisit;

		$result =
		$model->field(true)
		->where($map)
		->value('ip');

		if ($result) {
			$model->where($map)
			->setInc('count');
		} else {
			$model->allowField(true)
			->isUpdate(false)
			->data($map)
			->save();
		}

		$this->remove('IndexVisit');
	}

	/**
	 * 写入搜索日志
	 * @access public
	 * @param
	 * @return void
	 */
	public function searchengine()
	{
		$key = $this->isSpider();
		if ($key === false) {
			// return false;
		}
		$key = 'GOOGLE';
		$map = [
			'name' => $key,
			'date' => strtotime(date('Y-m-d'))
		];

		$model = new IndexSearchengine;

		$result =
		$model->field(true)
		->where($map)
		->value('name');

		if ($result) {
			$model->where($map)
			->setInc('count');
		} else {
			$model->allowField(true)
			->isUpdate(false)
			->data($map)
			->save();
		}

		$this->remove('IndexSearchengine');
	}

	/**
	 * 删除过期的搜索日志(保留半年)
	 * @access protected
	 * @param
	 * @return void
	 */
	protected function remove($model_name)
	{
		$map = [
			'date' => ['ELT', strtotime('-180 days')],
		];

		if ($model_name == 'IndexSearchengine') {
			$model = new IndexSearchengine;
		} else {
			$model = new IndexVisit;
		}

		$model->where($map)
		->delete();
	}

	/**
	 * 判断搜索引擎蜘蛛
	 * @access protected
	 * @param
	 * @return mixed
	 */
	protected function isSpider()
	{
		$info = $this->request->header();

		if (empty($info['user-agent'])) {
			return false;
		}

		$searchengine = [
			'GOOGLE'         => 'googlebot',
			'GOOGLE ADSENSE' => 'mediapartners-google',
			'BAIDU'          => 'baiduspider+',
			'MSN'            => 'msnbot',
			'YODAO'          => 'yodaobot',
			'YAHOO'          => 'yahoo! slurp;',
			'Yahoo China'    => 'yahoo! slurp china;',
			'IASK'           => 'iaskspider',
			'SOGOU'          => 'sogou web spider',
			'SOGOU'          => 'sogou push spider'
		];

		$spider = strtolower($info['user-agent']);
		foreach ($searchengine as $key => $value) {
			if (strpos($spider, $value) !== false) {
				return $key;
			}
		}
		return false;
	}
}
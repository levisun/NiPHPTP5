<?php
/**
 *
 * 常用设置 - 公众 - 逻辑层
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
use think\Loader;
use think\Lang;
use think\Session;
use app\admin\model\Config as IndexConfig;
use app\admin\model\Category as IndexCategory;
class Common extends Model
{
	protected $request = null;
	protected $to_html = [
		'bottom_message',
		'copyright',
		'script'
	];

	// 表名
	public $table_name = null;

	protected function initialize()
	{
		parent::initialize();

		$this->request = Request::instance();

		$this->table_name = $this->getModelTable();
	}

	/**
	 * 获得当前栏目和父级栏目数据
	 * @access public
	 * @param  intval $cid_
	 * @return array
	 */
	public function getCategoryData($cid_=0)
	{
		$cid_ = $cid_ ? $cid_ : $this->request->param('cid/f');

		$data = [];

		$map = [
			'id' => $cid_,
			'lang' => Lang::detect()
		];

		$category = new IndexCategory;
		$result =
		$category->field(['id', 'pid', 'name', 'seo_title', 'seo_keywords', 'seo_description'])
		->where($map)
		->find();

		$self = $result ? $result->toArray() : [];

		if (!empty($self['pid'])) {
			$data = $this->getCategoryData($self['pid']);
		}

		$data[] = $self;

		krsort($data);

		return $data;
	}

	/**
	 * 获得网站基本设置数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getWetsiteData()
	{
		$map = [
			'name' => [
				'in',
				'website_name,website_keywords,website_description,bottom_message,copyright,script,'
				. $this->request->module() . '_theme'
			],
			'lang' => Lang::detect()
		];

		$config = new IndexConfig;
		$result =
		$config->field(true)
		->where($map)
		->cache(!APP_DEBUG)
		->select();

		$data = [];
		foreach ($result as $value) {
			$value = $value->toArray();
			if (in_array($value['name'], $this->to_html)) {
				$data[$value['name']] = htmlspecialchars_decode($value['value']);
			} else {
				$data[$value['name']] = $value['value'];
			}
		}

		return $data;
	}

	/**
	 * 获得模型表
	 * @access protected
	 * @param
	 * @return array
	 */
	protected function getModelTable()
	{
		if (!$this->request->has('cid', 'param')) {
			return null;
		}

		$map = [
			'c.id' => $this->request->param('cid/f'),
			'c.lang' => Lang::detect()
		];

		$category = new IndexCategory;
		$result =
		$category->view('category c', 'id')
		->view('model m', ['name' => 'model_name'], 'm.id=c.model_id AND m.name!=\'external\'')
		->view('category cc', 'pid', 'c.id=cc.pid', 'LEFT')
		->where($map)
		->cache(!APP_DEBUG)
		->find();

		$data = $result ? $result->toArray() : [];

		return $data ? $data['model_name'] : '';
	}
}
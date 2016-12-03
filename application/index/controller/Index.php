<?php
/**
 *
 * 首页 - 控制器
 *
 * @package   NiPHPCMS
 * @category  index\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Account.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\controller;
use think\Loader;
use app\index\controller\Common;
class Index extends Common
{
	protected $beforeActionList = [
		'first'
	];

	/**
	 * 首页
	 * @access public
	 * @param
	 * @return string
	 */
	public function index()
	{
		return $this->fetch();
	}

	/**
	 * 列表页
	 * @access public
	 * @param
	 * @return string
	 */
	public function entry()
	{
		$model = ['article', 'download', 'picture', 'product'];
		if (in_array($this->table_name, $model)) {
			$model = Loader::model('Article', 'logic');
			$model->setTableModel($this->table_name);
		} else {
			$model = Loader::model($this->table_name, 'logic');
		}

		$data = $model->getListData();

		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);

		// trace($data);

		return $this->fetch('entry/' . $this->table_name);
	}

	/**
	 * 内容页
	 * @access public
	 * @param
	 * @return string
	 */
	public function article()
	{
		$web_info = $this->beforeArticle();

		$model = Loader::model('Article', 'logic');
		$model->setTableModel($this->table_name);

		$data = $model->getArticle();
		$this->assign('data', $data);

		$web_info['title'] = $data['title'] . ' - ' . $web_info['title'];
		$web_info['keywords'] = $data['keywords'] ? $data['keywords'] : $web_info['keywords'];
		$web_info['description'] = $data['description'] ? $data['description'] : $web_info['description'];

		$this->assign('__TITLE__', $web_info['title']);
		$this->assign('__KEYWORDS__', $web_info['keywords']);
		$this->assign('__DESCRIPTION__', $web_info['description']);

		return $this->fetch('article/' . $this->table_name);
	}

	/**
	 * 跳转
	 * @access public
	 * @param
	 * @return string
	 */
	public function jump()
	{
		# code...
	}

	protected function first()
	{
		if ($this->request->has('cid', 'param')) {
			$web_info = $this->getCatWebInfo();


		} else {
			$web_info = [
				'title' => $this->website_data['website_name'],
				'keywords' => $this->website_data['website_keywords'],
				'description' => $this->website_data['website_description']
			];
		}
		$this->assign('__TITLE__', $web_info['title']);
		$this->assign('__KEYWORDS__', $web_info['keywords']);
		$this->assign('__DESCRIPTION__', $web_info['description']);
	}

	protected function before()
	{

	}

	/**
	 * 安栏目获得网站标题、关键词、描述
	 * @access protected
	 * @param
	 * @return arrays
	 */
	protected function getCatWebInfo()
	{
		$web_title = $web_keywords = $web_description = '';
		if ($this->request->has('cid', 'param')) {
			$data = $this->common_model->getCategoryData();

			foreach ($data as $value) {
				$web_title .= $value['seo_title'] ? $value['seo_title'] : $value['name'] . ' - ';
			}

			$web_keywords = $data[0]['seo_keywords'];
			$web_description = $data[0]['seo_description'];

			$web_keywords = $web_keywords ? $web_keywords : $this->website_data['website_keywords'];
			$web_description = $web_description ? $web_description : $this->website_data['website_description'];
		}

		$web_title .= $this->website_data['website_name'];

		return [
			'title' => $web_title,
			'keywords' => $web_keywords,
			'description' => $web_description
		];
	}
}

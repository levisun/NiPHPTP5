<?php
/**
 *
 * 扩展 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Expand.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/01
 */
namespace app\admin\controller;
use app\admin\controller\Common;
use think\Loader;
use think\Url;
use think\Lang;
class Expand extends Common
{

	/**
	 * 系统操作日志
	 * @access public
	 * @param
	 * @return string
	 */
	public function log()
	{
		$data = parent::select('ExpandActionLog');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		return $this->fetch();
	}

	/**
	 * 数据备份
	 * @access public
	 * @param
	 * @return string
	 */
	public function databack()
	{
		// 备份
		if ($this->method == 'back') {
			$model = Loader::model('ExpandDataback', 'logic');
			$result = $model->createZipSql();
			if (true === $result) {
				$this->actionLog('databack_back');
				$url = Url::build($this->request->action());
				$this->success(Lang::get('success backup'), $url);
			} else {
				$this->error(Lang::get('error backup'));
			}
		}

		// 下载
		if ($this->method == 'down') {
			$this->actionLog('databack_down');

			define('UPLOAD_PATH', './pulbic/upload/');
			$file = decrypt($this->request->param('id'));
			\net\Http::download($file, 'databack ' . date('Ymd') . '.zip');
		}

		// 删除
		if ($this->method == 'remove') {
			$file = decrypt($this->request->param('id'));
			\util\File::delete($file);
			$this->actionLog('databack_remove');

			$url = Url::build($this->request->action());
			$this->success(Lang::get('success remove'), $url);
		}

		// 还原
		if ($this->method == 'reduction') {
			$result = Loader::model('ExpandDataback', 'logic')->reduction();

			$url = Url::build($this->request->action());
			$this->success(Lang::get('success reduction'), $url);
		}

		$data = parent::select('ExpandDataback');
		$this->assign('list', $data);
		return $this->fetch();
	}

	/**
	 * 在线升级
	 * @access public
	 * @param
	 * @return mxied
	 */
	public function upgrade()
	{
		halt('TODO');
	}

	/**
	 * 错误日志
	 * @access public
	 * @param
	 * @return mxied
	 */
	public function elog()
	{
		if ($this->method == 'show') {
			$data = Loader::model('ExpandELog', 'logic')->getOneData();
			$this->assign('data', $data);
			return $this->fetch('elog_show');
		}

		$data = parent::select('ExpandELog');
		$this->assign('list', $data);
		return $this->fetch();
	}

	/**
	 * 访问统计
	 * @access public
	 * @param
	 * @return mxied
	 */
	public function visit()
	{
		$data = parent::select('ExpandVisit');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);

		if ($this->method == 'searchengine') {
			return $this->fetch('searchengine');
		} else {
			return $this->fetch();
		}
	}
}
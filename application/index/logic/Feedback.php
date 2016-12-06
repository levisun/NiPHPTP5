<?php
/**
 *
 * 反馈 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CommonAccount.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/12/06
 */
namespace app\index\logic;
use think\Model;
use think\Request;
use think\Lang;
use think\Url;
use think\Loader;
use app\admin\model\Feedback as IndexFeedback;
use app\admin\model\Fields as IndexFields;
class Feedback extends Model
{
	protected $request = null;

	protected function initialize()
	{
		parent::initialize();

		$this->request = Request::instance();
	}

	public function getListData()
	{
		$feedback = new IndexFeedback;

		$data = $this->getFields();
		trace($data);
	}

	/**
	 * 查询字段数据
	 * @access protected
	 * @param  string $table_name_ 表名
	 * @return array
	 */
	protected function getFields()
	{
		$map = ['f.category_id' => $this->request->param('cid/f')];

		$fields = new IndexFields;
		$CACHE = !APP_DEBUG ? __METHOD__ . implode('', $map) : false;

		$result =
		$fields->view('fields f', ['id', 'name' => 'field_name'])
		->view('fields_type t', ['name' => 'field_type'], 'f.type_id=t.id')
		->where($map)
		->cache($CACHE)
		->select();

		$list = [];
		foreach ($result as $value) {
			$value = $value->toArray();
			$value['input'] = toFieldsType($value);
			$list[] = $value;
		}

		return $list;
	}
}
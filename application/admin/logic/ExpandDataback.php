<?php
/**
 *
 * 数据备份 - 扩展 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ExpandDataback.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/05
 */
namespace app\admin\logic;
use think\Model;
use think\Request;
use think\Config;
class ExpandDataback extends Model
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
		$list = \util\File::get('./backup/');

		rsort($list);

		// 删除过期备份
		$days = strtotime('-180 days');
		foreach ($list as $key => $value) {
			if (strtotime($value['time']) <= $days) {
				\File::delete('./backup/' . $value['name']);
				unset($list[$key]);
			} else {
				$list[$key]['id'] = encrypt('./backup/' . $value['name']);
			}
		}

		return $list;
	}

	/**
	 * 备份数据库
	 * @access public
	 * @param
	 * @return boolean
	 */
	public function createZipSql($limit_=7000)
	{
		$dir = TEMP_PATH . 'BACK' . date('YmdHis') . '/';
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}

		$tables = $this->getTables();
		$tables_sql = '';
		foreach ($tables as $table) {
			$tableRs = $this->query('SHOW CREATE TABLE `' . $table . '`');
			if (!empty($tableRs[0]['Create Table'])) {
				$tables_sql .= "\r\nDROP TABLE IF EXISTS `{$table}`;\r\n";
				$tables_sql .= $tableRs[0]['Create Table'] . ';';

				$field = $this->query('SHOW COLUMNS FROM `' . $table . '`');
				$fieldRs = array();
				foreach ($field as $val) {
					$fieldRs[] = $val['Field'];
				}

				$this->table($table);
				$count =
				$this->count();

				$count = ceil($count / $limit_);
				for ($i=0; $i < $count; $i++) {
					$firstRow = $i * $limit_;

					$result =
					$this->table($table)
					->field($fieldRs)
					->limit($firstRow, $limit_)
					->select();

					$table_data = [];
					foreach ($result as $key => $value) {
						$table_data[] = $value->toArray();
					}

					$insert_sql = "INSERT INTO `{$table}` (`" . implode('`,`', $fieldRs) . "`) VALUES ";
					$values = array();
					foreach ($table_data as $data) {
						$values[] = '(\'' . implode('\',\'', $data) . '\')';
					}
					$insert_sql .= implode(',', $values) . ';';

					$num = 700001 + $i;
					file_put_contents($dir . $table . '_' . $num . '.sql', $insert_sql);
				}
			}
		}
		file_put_contents($dir . 'tables.sql', $tables_sql);

		// 打包备份
		$zip = new \util\Pclzip('');
		$zip->zipname = './backup/back ' . date('YmdHis') . '.zip';
		$zip->create($dir, PCLZIP_OPT_REMOVE_PATH, $dir);

		// 删除临时文件
		\util\File::delete($dir);

		return true;
	}

	/**
	 * 获得库中所有表
	 * @access private
	 * @param
	 * @return array
	 */
	private function getTables()
	{
		$result = $this->query('SHOW TABLES FROM ' . Config::get('database.database'));
		$tables = array();
		foreach ($result as $key => $value) {
			$tables[] = current($value);
		}
		return $tables;
	}

	/**
	 * 还原数据
	 * @access public
	 * @param
	 * @return boolean
	 */
	public function reduction()
	{
		$file = decrypt($this->request->param('id'));
		$dir = explode('/', $file);
		$name = array_pop($dir);
		$name = explode('.', $name);

		$dir = TEMP_PATH . $name[0] . '/';

		$zip = new \util\Pclzip('');
		$zip->zipname = $file;
		$zip->extract(PCLZIP_OPT_PATH, $dir);

		$list = \util\File::get($dir . '/');
		foreach ($list as $key => $value) {
			if ($value['name'] == 'tables.sql') {
				$sql = file_get_contents($dir . $value['name']);
				unset($list[$key]);
			}
		}
		$execute_sql = explode(';', $sql);
		array_pop($execute_sql);

		foreach ($list as $key => $value) {
			$execute_sql[] = file_get_contents($dir . $value['name']);
		}
		$this->batchQuery($execute_sql);

		// 删除临时文件
		\util\File::delete($dir);

		return true;
	}
}
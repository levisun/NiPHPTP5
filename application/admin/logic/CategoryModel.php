<?php
/**
 *
 * 栏目管理 - 栏目 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CategoryModel.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/25
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Config;
use app\admin\model\Models as ModelModels;

class CategoryModel extends Model
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
        $map = [];
        if ($key = $this->request->param('key')) {
            $map['remark'] = ['LIKE', '%' . $key . '%'];
        }

        $models = new ModelModels;
        $result =
        $models->field(true)
        ->where($map)
        ->paginate();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        $page = $result->render();

        return ['list' => $list, 'page' => $page];
    }

    /**
     * 基本模型表类用于新增模型
     * @access public
     * @param
     * @return array
     */
    public function getModel()
    {
        $map = [
            'table_name' => [
                'in', 'article,picture,download,page,product,feedback,message',
            ],
        ];
        $field = ['id', 'name', 'table_name'];

        $models = new ModelModels;
        $result =
        $models->field($field)
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
        $prefix = Config::get('database.prefix');
        $table_name = $this->request->post('table_name');
        $model_table = $this->request->post('model_table');
        // 获得表结构
        $result = $this->query('SHOW CREATE TABLE `' . $prefix . $model_table . '`');
        $create_table = $result[0]['Create Table'] . ';';

        $result = $this->query('SHOW CREATE TABLE `' . $prefix . $model_table . '_data`');
        $create_table .= $result[0]['Create Table'] . ';';

        // 替换表名
        $create_table = str_ireplace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $create_table);
        $create_table = str_ireplace($model_table, $table_name, $create_table);

        // 非必要数据替换为空
        $patterns = ['/AUTO_INCREMENT=(\d+)/', '/COMMENT=\'(.*?)\'/'];
        $replacements = ['', ''];
        $create_table = preg_replace($patterns, $replacements, $create_table);
        $create_table = explode(';', $create_table);

        $data = [
            'name'       => $this->request->post('name'),
            'table_name' => $this->request->post('table_name'),
            'status'     => $this->request->post('status/f', 1),
            'remark'     => $this->request->post('remark')
        ];

        $models = new ModelModels;

        foreach ($create_table as $value) {
            if ($value) {
                $models->execute($value);
            }
        }

        $models->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        return $models->id ? true : false;
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = ['id' => $this->request->param('id/f')];

        $models = new ModelModels;
        $result =
        $models->field(true)
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
            'name'   => $this->request->post('name'),
            'status' => $this->request->post('status/f', 1),
            'remark' => $this->request->post('remark')
        ];
        $map = ['id' => $this->request->post('id/f')];

        $models = new ModelModels;
        $result =
        $models->allowField(true)
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
        $map = ['id' => $this->request->param('id/f')];

        // 系统表名 禁止删除
        $no_table_name = [
            'article',
            'picture',
            'download',
            'page',
            'product',
            'feedback',
            'message',
            'link',
            'external'
        ];

        $models = new ModelModels;
        $table_name =
        $models->where($map)
        ->value('table_name');

        if (in_array($table_name, $no_table_name)) {
            return 'error system model';
        }

        $prefix = Config::get('database.prefix');

        $result =
        $models->where($map)
        ->delete();
        if ($result) {
            $drop_table = 'DROP TABLE IF EXISTS `' . $prefix . $table_name . '`;';
            $this->execute($drop_table);
            $drop_table = 'DROP TABLE IF EXISTS `' . $prefix . $table_name . '_data`;';
            $this->execute($drop_table);
        }

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

        $models = new ModelModels;
        $result =
        $models->saveAll($data);

        return true;
    }
}

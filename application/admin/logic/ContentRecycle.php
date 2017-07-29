<?php
/**
 *
 * 回收站 - 内容 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ContentRecycle.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/14
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Loader;
use app\admin\logic\ContentContentData as ModelContentContentData;

class ContentRecycle extends Model
{
    protected $request       = null;
    protected $table_model   = null;

    public $dataModel = null;
    public $tableName = null;
    public $typeData  = null;
    public $levelData = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();

        // 内容数据业务层
        $this->dataModel = new ModelContentContentData;
        // 分类
        $this->typeData = $this->dataModel->getTypeData();
        // 权限
        $this->levelData = $this->dataModel->getLevelData();

        // 表名
        $this->tableName = $this->dataModel->getModelTable();

        // 对应表模型
        $this->table_model = $this->tableName ? Loader::model(ucfirst($this->tableName)) : null;
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
            'category_id' => $this->request->param('cid/f'),
            ];
        if ($key = $this->request->param('key')) {
            $map['remark'] = ['LIKE', '%' . $key . '%'];
        }

        if ($this->tableName == 'link') {
            $order = 'is_pass ASC, sort DESC, update_time DESC';
        } elseif (in_array($this->tableName, ['message', 'feedback'])) {
            $order = 'is_pass ASC, update_time DESC';
        } else {
            $order = 'is_pass ASC, is_com DESC, is_top DESC, is_hot DESC, sort DESC, update_time DESC';
        }

        $this->table_model->field(true)
        ->where($map)
        ->order($order);
        $result =
        $this->table_model->onlyTrashed()->paginate();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        $page = $result->render();

        return ['list' => $list, 'page' => $page, 'tableName' => $this->tableName];
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        if ($this->tableName == 'page') {
            $map = ['category_id' => $this->request->param('cid/f')];
        } else {
            $map = ['id' => $this->request->param('id/f')];
        }

        $result =
        $this->table_model->onlyTrashed()
        ->field(true)
        ->where($map)
        ->find();

        $data = !empty($result) ? $result->toArray() : [];

        if (empty($data)) {
            return null;
        }

        // 非友链
        if ($this->tableName != 'link') {
            $data['content'] = htmlspecialchars_decode($data['content']);

            $data['field_data'] = $this->dataModel->getEditorFieldsData($data, $this->tableName);

            $data['tags'] = $this->dataModel->getEditorTagsData($data);
        }

        // 图文 产品
        if (in_array($this->tableName, ['picture', 'product'])) {
            $data['album_data'] = $this->dataModel->getEditorAlbumData($this->tableName);
        }

        return $data;
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
        $map = ['id' => $id];

        $result =
        $this->table_model->onlyTrashed()
        ->where($map)
        ->delete();

        if ($this->tableName != 'link') {
            $map = ['main_id' => $id];

            $model = Loader::model(ucfirst($this->tableName) . '_data');
            $result =
            $model->where($map)
            ->delete();
        }

        if (in_array($this->tableName, ['picture', 'product'])) {
            // 图文 产品
            $map = ['main_id' => $id];

            $model = Loader::model(ucfirst($this->tableName) . '_album');
            $result =
            $model->where($map)
            ->delete();
        }

        return true;
        return $result ? true : false;
    }
}

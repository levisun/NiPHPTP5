<?php
/**
 *
 * 文章|下载|单页|图文|产品 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Article.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Url;
use think\Loader;
use think\Cache;
use app\admin\model\Category as IndexCategory;
use app\admin\model\Fields as IndexFields;
use app\admin\model\TagsArticle as IndexTagsArticle;

class Article extends Model
{
    protected $request    = null;
    protected $model_name = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 设置模型名
     * @access public
     * @param  string $name 模型名
     * @return void
     */
    public function setTableModel($name)
    {
        $this->model_name = $name;
    }

    /**
     * 列表数据
     * @access public
     * @param
     * @return array
     */
    public function getListData()
    {
        // $id = $this->getChild(); 查询表不同会有错误

        $map = [
            // 'a.category_id' => ['IN', $id], 查询表不同会有错误
            'a.category_id' => $this->request->param('cid/f'),
            'a.is_pass'     => 1,
            'a.lang'        => Lang::detect(),
            'a.show_time'   => ['ELT', strtotime(date('Y-m-d'))]
        ];

        $CACHE = check_key($map, __METHOD__);

        if ($CACHE && $list = Cache::get($CACHE)) {
            return $list;
        }

        $order = 'a.sort DESC, a.update_time DESC';

        $model = Loader::model(ucfirst($this->model_name), 'model', false, 'admin');
        $CACHE = check_key($map, __METHOD__);

        $result =
        $model->view($this->model_name . ' a', 'id,title,keywords,description,thumb,category_id,hits,comment_count,create_time,update_time,type_id,access_id,is_link,url')
        ->view('type t', ['name' => 'type_name'], 't.id=a.type_id', 'LEFT')
        ->view('level l', ['name' => 'level_name'], 'l.id=a.access_id', 'LEFT')
        ->view('category c', ['name' => 'cat_name'], 'c.id=a.category_id')
        ->view('admin ad', ['username' => 'editor_name'], 'a.user_id=ad.id')
        ->where($map)
        ->order($order)
        // ->cache($CACHE)
        ->paginate();

        $list = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            if ($value['is_link']) {
                $value['url'] = Url::build('/jump/' . $value['category_id'] . '/' . $value['id']);
            } else {
                $value['url'] = Url::build('/article/' . $value['category_id'] . '/' . $value['id']);
            }
            $value['cat_url'] = Url::build('/list/' . $value['category_id']);
            $list[] = $value;
        }

        $page = !empty($result) ? $result->render() : '';

        $data = ['list' => $list, 'page' => $page];

        if ($CACHE) {
            Cache::set($CACHE, $data);
        }

        return $data;
    }

    /**
     * 获得子栏目ID
     * @access protected
     * @param  string $pid_
     * @return string
     */
    protected function getChild($pid_='')
    {
        $pid_ = !empty($pid_) ? $pid_ : $this->request->param('cid/f');

        $map = [
            'pid'  => ['IN', "$pid_"],
            'lang' => Lang::detect()
        ];

        $category = new IndexCategory;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $category->field(['id'])
        ->where($map)
        ->cache($CACHE)
        ->select();

        if (!$result) {
            return $pid_;
        }

        $data = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $data[] = $value['id'];
        }

        $id = implode(',', $data);

        $parent = $id ? $this->getChild($id) : '';

        $id = $parent && $id <> $parent ? $id . ',' . $parent : $id;

        return $id;
    }

    /**
     * 内容数据
     * @access public
     * @param
     * @return array
     */
    public function getArticle()
    {
        $map = [
            'a.category_id' => $this->request->param('cid/f'),
            'a.id'          => $this->request->param('id/f'),
            'a.is_pass'     => 1,
            'a.lang'        => Lang::detect(),
            'a.show_time'   => ['ELT', strtotime(date('Y-m-d'))]
        ];
        $order = 'a.sort DESC, a.update_time DESC';

        $model = Loader::model(ucfirst($this->model_name), 'model', false, 'admin');
        $CACHE = check_key($map, __METHOD__);

        $result =
        $model->view($this->model_name . ' a', true)
        ->view('type t', ['name' => 'type_name'], 't.id=a.type_id', 'LEFT')
        ->view('level l', ['name' => 'level_name'], 'l.id=a.access_id', 'LEFT')
        ->view('category c', ['name' => 'cat_name'], 'c.id=a.category_id')
        ->view('admin ad', ['username' => 'editor_name'], 'a.user_id=ad.id')
        ->where($map)
        ->cache($CACHE)
        ->find();

        $data = $result ? $result->toArray() : [];

        if (!empty($data)) {
            $data['content'] = htmlspecialchars_decode($data['content']);

            $data['field'] = $this->getFieldsData();
            $data['tags'] = $this->getTagsData();

            if (in_array($this->model_name, ['picture', 'product'])) {
                $data['album'] = $this->getAlbumData();
            }

            $this->hits();
        }
        return $data;
    }

    /**
     * 更新阅读数
     * @access protected
     * @param
     * @return void
     */
    protected function hits()
    {
        $map = [
            'category_id' => $this->request->param('cid/f'),
            'id'          => $this->request->param('id/f'),
            'is_pass'     => 1,
            'lang'        => Lang::detect(),
            'show_time'   => ['ELT', strtotime(date('Y-m-d'))]
        ];

        $model = Loader::model(ucfirst($this->model_name), 'model', false, 'admin');
        $model->where($map)
        ->setInc('hits');
    }

    /**
     * 查询相册数据
     * @access protected
     * @param
     * @return array
     */
    protected function getAlbumData()
    {
        $map = ['main_id' => $this->request->param('id/f')];

        $album = Loader::model($this->model_name . 'Album', 'model', false, 'admin');
        $CACHE = check_key($map, __METHOD__);

        $result =
        $album->field(true)
        ->where($map)
        ->cache($CACHE)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        return $list;
    }

    /**
     * 查询字段数据
     * @access protected
     * @param  string $table_name_ 表名
     * @return array
     */
    protected function getFieldsData()
    {
        $map = ['f.category_id' => $this->request->param('cid/f')];
        $table_name = $this->model_name . '_data d';

        $fields = new IndexFields;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $fields->view('fields f', ['id', 'name' => 'field_name'])
        ->view('fields_type t', ['name' => 'field_type'], 'f.type_id=t.id')
        ->view($table_name, ['data' => 'field_data'], 'f.id=d.fields_id AND d.main_id=' . $this->request->param('id/f'), 'LEFT')
        ->where($map)
        ->cache($CACHE)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        return $list;
    }

    /**
     * 查询标签数据
     * @access protected
     * @param
     * @return array
     */
    protected function getTagsData()
    {
        $map = [
            'a.category_id' => $this->request->param('cid/f'),
            'a.article_id'  => $this->request->param('id/f')
        ];

        $tags = new IndexTagsArticle;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $tags->view('tags_article a', 'tags_id')
        ->view('tags t', 'name', 't.id=a.tags_id')
        ->where($map)
        ->cache($CACHE)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $list[] = $value['name'];
        }

        return implode(' ', $list);
    }
}

<?php
/**
 *
 * 商品管理 - 商城 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: MallGoods.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/01/03
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Config;
use think\Cache;
use app\admin\model\MallGoods as AdminMallGoods;
use app\admin\model\MallType as AdminMallType;
use app\admin\model\MallBrand as AdminMallBrand;
use app\admin\model\MallGoodsPromote as AdminMallGoodsPromote;
use app\admin\model\MallGoodsAlbum as AdminMallGoodsAlbum;

class MallGoods extends Model
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
        $map = ['g.lang' => Lang::detect()];
        if ($key = $this->request->param('key')) {
            $map['g.name'] = ['LIKE', '%' . $key . '%'];
        }

        $goods = new AdminMallGoods;

        $result =
        $goods->view('mall_goods g', 'id,name,thumb,price,is_pass,is_show,is_com,is_top,is_hot,sort')
        ->view('mall_type t', ['name'=>'type_name'], 't.id=g.type_id')
        ->view('mall_brand b', ['name'=>'brand_name'], 'b.id=g.brand_id', 'LEFT')
        ->view('mall_goods_promote p', ['promote_price', 'promote_start_time', 'promote_ent_time'], 'p.goods_id=g.id', 'LEFT')
        ->where($map)
        ->order('id DESC')
        ->paginate();

        $list = [];
        foreach ($result as $key => $value) {
            $value = $value->toArray();
            $value['price'] = to_yen($value['price']);
            $value['promote_price'] = to_yen($value['promote_price']);
            $list[] = $value;
        }

        $page = $result->render();

        return ['list' => $list, 'page' => $page];
    }

    /**
     * 添加数据
     * @access public
     * @param
     * @return boolean
     */
    public function added()
    {
        // 商品信息录入
        $data = [
            'name'         => $this->request->post('name'),
            'type_id'      => $this->request->post('type_id/d'),
            'brand_id'     => $this->request->post('brand_id/d'),
            'price'        => $this->request->post('price/f') * 100,
            'market_price' => $this->request->post('market_price/f') * 100,
            'number'       => $this->request->post('number/d', 2000),
            'thumb'        => $this->request->post('thumb'),
            'content'      => $this->request->post('content', '', Config::get('content_filter')),
            'is_pass'      => $this->request->post('is_pass/d', 1),
            'is_show'      => $this->request->post('is_show/d', 1),
            'is_com'       => $this->request->post('is_com/d', 0),
            'is_top'       => $this->request->post('is_top/d', 0),
            'is_hot'       => $this->request->post('is_hot/d', 0),
        ];

        $goods = new AdminMallGoods;
        $goods->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        // 促销信息录入
        $data = [
            'goods_id'      => $goods->id,
            'promote_price' => $this->request->post('promote_price/f') * 100,
            'promote_start_time' => $this->request->post('promote_start_time/f', 0, 'trim,strtotime'),
            'promote_end_time'   => $this->request->post('promote_end_time/f', 0, 'trim,strtotime'),
        ];

        $promote = new AdminMallGoodsPromote;
        $promote->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        // 商品相册录入
        $album_image = $this->request->post('album_image/a');
        $album_thumb = $this->request->post('album_thumb/a');

        $album = new AdminMallGoodsAlbum;
        $data = ['goods_id' => $goods->id];
        foreach ($album_image as $key => $value) {
            $data['thumb'] = $album_thumb[$key];
            $data['image'] = $value;
            $album->data($data)
            ->allowField(false)
            ->isUpdate(false)
            ->save();
        }

        return $goods->id ? true : false;
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = [
            'g.lang' => Lang::detect(),
            'g.id' => $this->request->param('id/f')
        ];

        $goods = new AdminMallGoods;
        $result =
        $goods->view('mall_goods g')
        ->view('mall_goods_promote p', ['promote_price', 'promote_start_time', 'promote_ent_time'], 'p.goods_id=g.id', 'LEFT')
        ->where($map)
        ->find();

        $data = [];
        if (!empty($result)) {
            $data = $result->toArray();
            $data['price'] = $data['price'] / 100;
            $data['market_price'] = $data['market_price'] / 100;
            $data['content'] = htmlspecialchars_decode($data['content']);
            $data['promote_price'] = $data['promote_price'] ? $data['promote_price'] / 100 : $data['promote_price'];
        }

        return $data;
    }

    /**
     * 编辑数据
     * @access public
     * @param
     * @return boolean
     */
    public function editor()
    {}

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

        $goods = new AdminMallGoods;
        $goods->where($map);
        $result = $goods->delete();

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

        $goods = new AdminMallGoods;
        $result =
        $goods->saveAll($data);

        return true;
    }

    /**
     * 商品分类树形结构
     * @access public
     * @param
     * @return array
     */
    public function getType()
    {
        $map = ['lang' => Lang::detect()];

        $type = new AdminMallType;
        $result =
        $type->field(true)
        ->where($map)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        return to_option_goods_type($list);
    }

    /**
     * 商品品牌
     * @access public
     * @param
     * @return array
     */
    public function getBrand()
    {
        $map = ['lang' => Lang::detect()];

        $brand = new AdminMallBrand;
        $result =
        $brand->field(true)
        ->where($map)
        ->select();

        $list = [];
        foreach ($result as $key => $value) {
            $list[] = $value->toArray();
        }

        return $list;
    }
}

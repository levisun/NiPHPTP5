<?php
/**
 *
 * 商品品牌 - 公众 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  mall\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Brand.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\mall\logic;

use think\Request;
use think\Lang;
use think\Url;
use app\admin\model\MallBrand as ModelMallBrand;

class Brand
{
    protected $request = null;

    public function __construct()
    {
        $this->request = Request::instance();
    }

    /**
     * 获得商品品牌
     * @access public
     * @param
     * @return array
     */
    public function getBrand()
    {
        $map = [
            'b.lang' => Lang::detect()
        ];

        if ($this->request->has('cid')) {
            $map['type_id'] = $this->request->param('cid/f');
        }

        $order = 'b.sort ASC, b.id DESC';

        $brand = new ModelMallBrand;

        $result =
        $result =
        $brand->view('mall_brand b', 'id,type_id,name,image')
        ->view('mall_type t', ['name'=>'type_name'], 't.id=b.type_id')
        ->where($map)
        ->order($order)
        ->cache(!APP_DEBUG)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $data[] = $value->toArray();
        }

        return $data;
    }
}

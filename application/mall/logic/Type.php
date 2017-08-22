<?php
/**
 *
 * 商品分类 - 公众 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  mall\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Type.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\mall\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Url;
use app\admin\model\MallType as ModelMallType;

class Type extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 获得商品分类
     * @access public
     * @param
     * @return array
     */
    public function getType()
    {
        $map = [
            'pid' => 0,
            'is_show' => 1,
            'lang' => Lang::detect()
        ];
        $field = [
            'id',
            'name',
            'pid',
            'image',
        ];
        $order = 'sort ASC, id DESC';

        $type = new ModelMallType;

        $result =
        $type->field($field)
        ->where($map)
        ->order($order)
        ->cache(!APP_DEBUG)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $data[] = $value->toArray();
        }

        return $this->getChild($data);
    }

    /**
     * 获得商品子类
     * @access protected
     * @param  array $data
     * @return array
     */
    protected function getChild($data)
    {
        $type = new ModelMallType;

        $map = [
            'is_show' => 1,
            'lang' => Lang::detect()
        ];
        $field = [
            'id',
            'name',
            'pid',
            'image',
        ];
        $order = 'sort ASC, id DESC';

        foreach ($data as $key => $value) {
            $type_data[$key] = $value;
            $type_data[$key]['url'] = Url::build('/mall/list/' . $value['id']);

            // 查询子类
            $map['pid'] = $value['id'];

            $result =
            $type->field($field)
            ->where($map)
            ->order($order)
            ->cache(!APP_DEBUG)
            ->select();

            $child = [];
            foreach ($result as $value) {
                $child[] = $value->toArray();
            }

            if (!empty($child)) {
                // 递归查询子类
                $_child = $this->getChild($child);
                $child = !empty($_child) ? $_child : $child;
                $type_data[$key]['child'] = $child;
            }
        }

        return $type_data;
    }

    /**
     * 获得当前类下所有类ID
     * @access protected
     * @param  int       $id
     * @return int
     */
    public function getCurrentId()
    {
        if (!$this->request->has('cid')) {
            return false;
        }

        $id = $this->request->param('cid/f');

        $parent_id = $this->getParentId($id);

        $child_id = $this->getChildId($parent_id);

        return $child_id;
    }

    /**
     * 获得子类ID
     * @access protected
     * @param  int       $id
     * @return int
     */
    protected function getChildId($id)
    {
        $map = [
            'pid' => (int) $id,
            'is_show' => 1,
            'lang' => Lang::detect()
        ];
        $order = 'sort ASC, id DESC';

        $type = new ModelMallType;

        $result =
        $type->field('id')
        ->where($map)
        ->order($order)
        ->cache(!APP_DEBUG)
        ->select();

        $type_data = [];
        foreach ($result as $key => $value) {
            $value = $value->toArray();
            $type_data[] = $value['id'];

            $_type = $this->getChildId($value['id']);
            if ($_type) {
                $type_data = array_merge($type_data, $_type);
            }
        }

        return $type_data;
    }

    /**
     * 获得父类ID
     * @access protected
     * @param  int       $cid
     * @return int
     */
    protected function getParentId($id)
    {
        $map = [
            'id' => (int) $id,
            'is_show' => 1,
            'lang' => Lang::detect()
        ];
        $field = [
            'id',
            'pid',
        ];
        $order = 'sort ASC, id DESC';

        $type = new ModelMallType;

        $result =
        $type->field($field)
        ->where($map)
        ->order($order)
        ->cache(!APP_DEBUG)
        ->find();

        $type_data = $result ? $result->toArray() : [];

        if ($type_data) {
            if (!$type_data['pid']) {
                return $type_data['id'];
            }
            return $this->getParentId($type_data['pid']);
        }
    }
}

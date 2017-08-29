<?php
/**
 *
 * 留言 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Message.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/12/06
 */
namespace app\index\logic;

use think\Request;
use think\Lang;
use think\Config;
use think\Cookie;
use think\Cache;
use net\IpLocation as NetIpLocation;
use app\admin\model\Message as ModelMessage;
use app\admin\model\MessageData as ModelMessageData;
use app\admin\model\Fields as ModelFields;
use app\admin\model\Type as ModelType;

class Message
{
    protected $request = null;

    public function __construct()
    {
        $this->request = Request::instance();
    }

    /**
     * 反馈自定义字段与分类数据
     * @access public
     * @param
     * @return array
     */
    public function getListData()
    {
        $message = new ModelMessage;

        $data['field'] = $this->getFields();
        $data['type']  = $this->getType();

        return ['list' => $data, 'page' => ''];
    }

    /**
     * 添加
     * @access public
     * @param
     * @return array
     */
    public function added()
    {
        $ip = new NetIpLocation;
        $area = $ip->getlocation($this->request->ip(0, true));

        $data = [
            'title'       => $this->request->post('title'),
            'username'    => $this->request->post('username'),
            'content'     => $this->request->post('content'),
            'category_id' => $this->request->param('cid/f'),
            'type_id'     => $this->request->post('type/f', 0),
            'mebmer_id'   => Cookie::has(Config::get('USER_AUTH_KEY')) ?
                                Cookie::has(Config::get('USER_AUTH_KEY')) : 0,
            'ip'          => $this->request->ip(0, true),
            'ip_attr'     => $area['country'] . $area['area'],
            'lang'        => Lang::detect(),
        ];

        $message = new ModelMessage;

        $message->allowField(true)
        ->isUpdate(false)
        ->data($data)
        ->save();


        // 自定义字段
        $fields = $this->request->post('fields/a');
        if (empty($fields)) {
            return true;
        }

        $added_data = [];
        foreach ($fields as $key => $value) {
            $added_data[] = [
                'main_id'   => $message->id,
                'fields_id' => $key,
                'data'      => $value
            ];
        }

        $message_data = new ModelMessageData;

        $message_data->saveAll($added_data);

        return true;
    }

    /**
     * 查询字段数据
     * @access protected
     * @param
     * @return array
     */
    protected function getFields()
    {
        $map = ['f.category_id' => $this->request->param('cid/f')];

        $fields = new ModelFields;

        $result =
        $fields->view('fields f', ['id', 'name' => 'field_name'])
        ->view('fields_type t', ['name' => 'field_type'], 'f.type_id=t.id')
        ->where($map)
        ->cache(!APP_DEBUG)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $value['input'] = to_option_type($value);
            $list[] = $value;
        }

        return $list;
    }

    /**
     * 分类数据
     * @access protected
     * @param
     * @return array
     */
    protected function getType()
    {
        $map = ['category_id' => $this->request->param('cid/f')];

        $type = new ModelType;

        $result =
        $type->field(true)
        ->where($map)
        ->cache(!APP_DEBUG)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        return $list;
    }
}

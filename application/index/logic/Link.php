<?php
/**
 *
 * 友链 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Link.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\logic;

use think\Request;
use think\Lang;
use think\Url;
use think\Cache;
use app\admin\model\Link as ModelLink;

class Link
{
    protected $request = null;

    public function __construct()
    {
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
        $cid = $this->request->param('cid/f');
        $map = [
            'l.category_id' => $cid,
            'l.is_pass'     => 1,
            'l.lang'        => Lang::detect()
        ];
        $order = 'l.sort DESC, l.type_id ASC, l.update_time DESC';

        $link = new ModelLink;

        $result =
        $link->view('link l', 'id,logo,title,category_id,type_id,description')
        ->view('type t', ['name' => 'type_name'], 't.id=l.type_id', 'LEFT')
        ->where($map)
        ->order($order)
        ->cache(!APP_DEBUG)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $value['url'] = Url::build('/jump/' . $value['category_id'] . '/' . $value['id']);
            $list[] = $value;
        }

        return ['list' => $list, 'page' => ''];
    }
}

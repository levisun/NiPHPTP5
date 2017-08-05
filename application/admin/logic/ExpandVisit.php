<?php
/**
 *
 * 访问统计 - 扩展 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ExpandVisit.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/14
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use app\admin\model\Visit as ModelVisit;
use app\admin\model\Searchengine as ModelSearchengine;
use app\admin\model\RequestLog as ModelRequest;

class ExpandVisit extends Model
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
        $this->delLog();

        $order = 'date DESC, count DESC';

        if ($this->request->param('method') == 'searchengine') {
            $obj = new ModelSearchengine;
        } elseif ($this->request->param('method') == 'request') {
            $obj = new ModelRequest;
            $order = 'update_time DESC';
        } else {
            $obj = new ModelVisit;
        }

        $result =
        $obj->field(true)
        ->order($order)
        ->paginate();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        $page = $result->render();

        return ['list' => $list, 'page' => $page];
    }

    /**
     * 删除过期日志
     * @access public
     * @param
     * @return array
     */
    private function delLog()
    {
        $map = [
            'date' => [
                'ELT', strtotime('-90 days')
            ],
        ];

        // 删除过期的搜索日志(保留三个月)
        $searchengine = new ModelSearchengine;
        $searchengine->where($map)
        ->delete();

        // 删除过期的访问日志(保留三个月)
        $visit = new ModelVisit;
        $visit->where($map)
        ->delete();

        // 删除过期的请求日志(保留三个月)
        $map = [
            'create_time' => [
                'ELT', strtotime('-90 days')
            ],
        ];
        $visit = new ModelRequest;
        $visit->where($map)
        ->delete();
    }
}

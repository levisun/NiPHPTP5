<?php
/**
 *
 * 系统日志 - 扩展 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CommonUpload.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/27
 */
namespace app\admin\logic;
use think\Model;
use think\Request;
use app\admin\model\ActionLog as AdminActionLog;
class ExpandActionLog extends Model
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
        $action = new AdminActionLog;

        // 删除过期的日志(保留三个月)
        $map = ['create_time' => ['ELT', strtotime('-90 days')]];
        $action->where($map)
        ->delete();

        $result =
        $action->view('action_log l', 'action_ip,model,record_id,remark,create_time')
        ->view('action a', 'title', 'a.id=l.action_id')
        ->view('admin u', 'username', 'u.id=l.user_id')
        ->view('role_admin ra', 'user_id', 'ra.user_id=l.user_id')
        ->view('role r', ['name'=>'role_name'], 'r.id=ra.role_id')
        ->order('l.create_time DESC')
        ->paginate();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        $page = $result->render();

        return ['list' => $list, 'page' => $page];
    }
}
<?php
/**
 *
 * 请求错误锁定 - 公众 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CommonRequest.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/08/15
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use net\IpLocation;
use app\admin\model\RequestLog as ModelRequestLog;

class CommonRequest extends Model
{

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 记录请求日志
     * 登录错误IP锁定
     * @access public
     * @param
     * @return void
     */
    public function requestLog($success = false)
    {
        $ip = new IpLocation();
        $request_log = new ModelRequestLog;

        // 删除过期的日志(保留三个月)
        $map = ['create_time' => ['ELT', strtotime('-90 days')]];
        $request_log->where($map)
        ->delete();

        // 日志是否存在
        $map = [
            'ip'     => $this->request->ip(0, true),
            'module' => $this->request->module(),
        ];

        $result =
        $request_log->where($map)
        ->value('ip');

        if ($result) {
            $data = [
                'count' => $success ? 0 : ['exp', 'count+1']
            ];
            $request_log->allowField(true)
            ->isUpdate(true)
            ->save($data, $map);
        } else {
            $area = $ip->getlocation($this->request->ip(0, true));
            $data = [
                'ip'     => $this->request->ip(0, true),
                'module' => $this->request->module(),
                'count'  => 1,
            ];
            $request_log->data($data)
            ->allowField(true)
            ->isUpdate(false)
            ->save();
        }
    }

    /**
     * IP请求错误
     * 大于三次请求并在3小时内
     * @access public
     * @param
     * @return void
     */
    public function ipRequestError()
    {
        $ip = new IpLocation();
        $request_log = new ModelRequestLog;

        $map = [
            'ip'          => $this->request->ip(0, true),
            'module'      => $this->request->module(),
            'count'       => ['EGT', 3],
            'update_time' => ['EGT', strtotime('-3 hours')]
        ];

        $result =
        $request_log->where($map)
        ->find();

        return $result ? true : false;
    }
}
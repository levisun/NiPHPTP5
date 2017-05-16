<?php
/**
 *
 * 系统信息 - 设置 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: SettingsInfo.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Config;
use util\File;
use app\admin\model\Member as AdminMember;
use app\admin\model\Feedback as AdminFeedback;
use app\admin\model\Message as AdminMessage;
use app\admin\model\Link as AdminLink;
use app\admin\model\Ads as AdminAds;
use app\admin\model\Visit as AdminVisit;

class SettingsInfo extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 获得系统信息
     * @access public
     * @param
     * @return array
     */
    public function getSysInfo()
    {
        $sys_data = [
            'os' => PHP_OS,
            'env' => $_SERVER['SERVER_SOFTWARE'],
            'php_version' => PHP_VERSION,
            'db_type' => Config::get('database.type'),
        ];

        $db_version =
        $this->query('SELECT version()');
        $sys_data['db_version'] = $db_version[0]['version()'];

        $sys_data['feedback'] = $this->feedback();
        $sys_data['message']  = $this->message();
        $sys_data['link']     = $this->link();
        $sys_data['ads']      = $this->ads();

        $member = $this->member();
        $sys_data['member'] = $member['count'];
        $sys_data['member_reg'] = $member['reg'];

        $result = $this->visit();
        $sys_data['visit']['date'] = $result['date'];
        $sys_data['visit']['count'] = $result['count'];

        return $sys_data;
    }

    /**
     * 会员简报
     * @access private
     * @param
     * @return array
     */
    private function member()
    {
        $member = new AdminMember;

        $result['count'] =
        $member->count();

        $map = ['status' => 0];
        $result['reg'] =
        $member->where($map)
        ->count();

        return $result;
    }

    /**
     * 反馈简报
     * @access private
     * @param
     * @return int
     */
    private function feedback()
    {
        $feedback = new AdminFeedback;

        $result =
        $feedback->count();

        return $result;
    }

    /**
     * 留言简报
     * @access private
     * @param
     * @return int
     */
    private function message()
    {
        $message = new AdminMessage;

        $result =
        $message->count();

        return $result;
    }

    /**
     * 友情链接简报
     * @access private
     * @param
     * @return int
     */
    private function link()
    {
        $link = new AdminLink;

        $result =
        $link->count();

        return $result;
    }

    /**
     * 广告简报
     * @access private
     * @param
     * @return int
     */
    private function ads()
    {
        $ads = new AdminAds;

        $map = ['end_time' => ['egt', time()]];

        $result =
        $ads->where($map)
        ->count();

        return $result;
    }

    /**
     * 访问简报
     * @access private
     * @param
     * @return array
     */
    private function visit()
    {
        $visit = new AdminVisit;
        $result = $visit
        ->field(true)
        ->where(['date' => ['egt', strtotime('-7 days')]])
        ->select();

        $date = $count = [];
        foreach ($result as $key => $value) {
            $value = $value->toArray();
            $date[$value['date']] = date('Y-m-d', $value['date']);
            if (empty($count[$value['date']])) {
                $count[$value['date']] = $value['count'];
            } else {
                $count[$value['date']] += $value['count'];
            }
        }
        $visit = [
            'date'  => '\'' . implode("','", $date) . '\'',
            // 'count' => '[' . implode('],[', $count) . ']'
        ];
        $num = 0;
        foreach ($count as $key => $value) {
            $visit['count'][] = '[' . date('ymd', $key) . ', ' . $value . ']';
            $num++;
        }
        if (!empty($visit['count'])) {
            $visit['count'] = implode(',', $visit['count']);
        } else {
            $visit['count'] = '';
        }

        return $visit;
    }
}

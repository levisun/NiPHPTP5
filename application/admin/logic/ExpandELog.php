<?php
/**
 *
 * 错误日志 - 扩展 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ExpandELog.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/15
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use util\File;

class ExpandELog extends Model
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
        $dir = $this->request->param('name');
        $dir = $dir ? decrypt($dir) . DS : $dir;

        $list = File::get(LOG_PATH . $dir);

        rsort($list);

        // 删除过期日志
        $days = strtotime('-180 days');
        foreach ($list as $key => $value) {
            if (strtotime($value['time']) <= $days) {
                File::delete(LOG_PATH . $value['name'] . DS);
                unset($list[$key]);
            } else {
                $list[$key]['id'] = encrypt($value['name']);
            }
        }

        return $list;
    }

    /**
     * 查看数据
     * @access public
     * @param
     * @return array
     */
    public function getOneData()
    {
        $dir = $this->request->param('name');
        $dir = $dir ? decrypt($dir) . DS : $dir;

        $name = $this->request->param('id');
        $name = $name ? decrypt($name) : $name;

        return file_get_contents(LOG_PATH . $dir . $name);
    }
}

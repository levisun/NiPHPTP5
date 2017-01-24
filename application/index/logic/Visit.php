<?php
/**
 *
 * 访问 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Visit.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\logic;

use think\Model;
use think\Request;
use net\IpLocation;
use app\admin\model\Searchengine as IndexSearchengine;
use app\admin\model\Visit as IndexVisit;

class Visit extends Model
{
    protected $request    = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 写入访问日志
     * @access public
     * @param
     * @return void
     */
    public function visit()
    {
        $key = $this->isSpider();
        if ($key !== false) {
            return false;
        }

        $ip = new IpLocation();
        $area = $ip->getlocation($this->request->ip(0, true));

        $visit_ip = include(CONF_PATH . 'visit.php');
        if (in_array($area['ip'], $visit_ip)) {
            return false;
        }

        $map = [
            'ip'      => $area['ip'],
            'date'    => strtotime(date('Y-m-d'))
        ];

        $model = new IndexVisit;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $model->field(true)
        ->where($map)
        ->cache($CACHE)
        ->value('ip');

        if ($result) {
            $model->where($map)
            ->setInc('count');
        } else {
            $map['ip_attr'] = $area['country'] . $area['area'];
            $model->allowField(true)
            ->isUpdate(false)
            ->data($map)
            ->save();
        }

        $this->remove('IndexVisit');
    }

    /**
     * 写入搜索日志
     * @access public
     * @param
     * @return void
     */
    public function searchengine()
    {
        $key = $this->isSpider();
        if ($key === false) {
            return false;
        }
        $map = [
            'name' => $key,
            'date' => strtotime(date('Y-m-d'))
        ];

        $model = new IndexSearchengine;

        $result =
        $model->field(true)
        ->where($map)
        ->value('name');

        if ($result) {
            $model->where($map)
            ->setInc('count');
        } else {
            $model->allowField(true)
            ->isUpdate(false)
            ->data($map)
            ->save();
        }

        $this->remove('IndexSearchengine');
    }

    /**
     * 删除过期的搜索日志(保留三个月)
     * @access protected
     * @param
     * @return void
     */
    protected function remove($model_name)
    {
        $map = [
            'date' => ['ELT', strtotime('-90 days')],
        ];

        if ($model_name == 'IndexSearchengine') {
            $model = new IndexSearchengine;
        } else {
            $model = new IndexVisit;
        }

        $model->where($map)
        ->delete();
    }

    /**
     * 判断搜索引擎蜘蛛
     * @access protected
     * @param
     * @return mixed
     */
    protected function isSpider()
    {
        $info = $this->request->header();

        if (empty($info['user-agent'])) {
            return false;
        }

        $searchengine = [
            'GOOGLE'         => 'googlebot',
            'GOOGLE ADSENSE' => 'mediapartners-google',
            'BAIDU'          => 'baiduspider+',
            'MSN'            => 'msnbot',
            'YODAO'          => 'yodaobot',
            'YAHOO'          => 'yahoo! slurp;',
            'Yahoo China'    => 'yahoo! slurp china;',
            'IASK'           => 'iaskspider',
            'SOGOU'          => 'sogou web spider',
            'SOGOU'          => 'sogou push spider'
        ];

        $spider = strtolower($info['user-agent']);
        foreach ($searchengine as $key => $value) {
            if (strpos($spider, $value) !== false) {
                return $key;
            }
        }
        return false;
    }
}

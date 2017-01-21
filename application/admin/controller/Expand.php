<?php
/**
 *
 * 扩展 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Expand.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/01
 */
namespace app\admin\controller;
use think\Url;
use think\Lang;
use net\Http;
use util\File;
use app\admin\controller\Base;
use app\admin\logic\ExpandDataback as AdminExpandDataback;
use app\admin\logic\ExpandELog as AdminExpandELog;
class Expand extends Base
{

    /**
     * 系统操作日志
     * @access public
     * @param
     * @return string
     */
    public function log()
    {
        $data = parent::select('ExpandActionLog');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);
        return $this->fetch();
    }

    /**
     * 数据备份
     * @access public
     * @param
     * @return string
     */
    public function databack()
    {
        $model = new AdminExpandDataback;

        // 备份
        if ($this->method == 'back') {
            $result = $model->createZipSql();
            if (true === $result) {
                $this->actionLog('databack_back');
                $url = Url::build($this->request->action());
                $this->success(Lang::get('success backup'), $url);
            } else {
                $this->error(Lang::get('error backup'));
            }
        }

        // 优化/修复表
        if ($this->method == 'optimize') {
            $result = $model->optimize();
            if (true === $result) {
                $this->actionLog('databack_optimize');
                $url = Url::build($this->request->action());
                $this->success(Lang::get('success optimize'), $url);
            } else {
                $this->error(Lang::get('error optimize', ['date'=>date('Y-m-d H:i:s')]));
            }
        }

        // 下载
        if ($this->method == 'down') {
            $this->actionLog('databack_down');

            // define('UPLOAD_PATH', './pulbic/upload/');
            $file = ROOT_PATH . 'public' . DS . 'backup' . DS . decrypt($this->request->param('id'));
            Http::download($file, 'databack ' . date('Ymd') . '.zip');
        }

        // 删除
        if ($this->method == 'remove') {
            $file = ROOT_PATH . 'public' . DS . 'backup' . DS .  decrypt($this->request->param('id'));
            File::delete($file);
            $this->actionLog('databack_remove');

            $url = Url::build($this->request->action());
            $this->success(Lang::get('success remove'), $url);
        }

        // 还原
        if ($this->method == 'reduction') {
            $result = $model->reduction();

            $url = Url::build($this->request->action());
            $this->success(Lang::get('success reduction'), $url);
        }

        $data = parent::select('ExpandDataback');
        $this->assign('list', $data);
        return $this->fetch();
    }

    /**
     * 在线升级
     * @access public
     * @param
     * @return mxied
     */
    public function upgrade()
    {
        halt('TODO');
    }

    /**
     * 错误日志
     * @access public
     * @param
     * @return mxied
     */
    public function elog()
    {
        if ($this->method == 'show') {
            $model = new AdminExpandELog;
            $data = $model->getOneData();
            $this->assign('data', $data);
            return $this->fetch('elog_show');
        }

        $data = parent::select('ExpandELog');
        $this->assign('list', $data);
        return $this->fetch();
    }

    /**
     * 访问统计
     * @access public
     * @param
     * @return mxied
     */
    public function visit()
    {
        $data = parent::select('ExpandVisit');
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);

        if ($this->method == 'searchengine') {
            return $this->fetch('searchengine');
        } else {
            return $this->fetch();
        }
    }
}
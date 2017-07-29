<?php
/**
 *
 * 缓存 - 内容 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ContentCache.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/14
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Cache;
use util\File as UtilFile;

class ContentCache extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 删除缓存
     * @access public
     * @param
     * @return boolean
     */
    public function remove()
    {
        $type = $this->request->param('type');

        if ($type == 'cache') {
            Cache::clear();
            return 'cache';
        }

        if ($type == 'compile') {
            $list = UtilFile::get(RUNTIME_PATH . 'temp' . DS);

            // 删除编辑缓存
            foreach ($list as $key => $value) {
                UtilFile::delete(RUNTIME_PATH . 'temp' . DS . $value['name']);
            }
            return 'compile';
        }

        return false;
    }
}

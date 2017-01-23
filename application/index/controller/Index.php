<?php
/**
 *
 * 首页 - 控制器
 *
 * @package   NiPHPCMS
 * @category  index\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Index.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\controller;

use think\Url;
use think\Lang;
use app\index\controller\Base;

class Index extends Base
{
    protected $beforeActionList = [
        'first',
    ];

    /**
     * 首页
     * @access public
     * @param
     * @return string
     */
    public function index()
    {
        return $this->fetch();
    }
}

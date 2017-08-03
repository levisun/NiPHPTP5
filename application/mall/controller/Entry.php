<?php
/**
 *
 * 列表 - 控制器
 *
 * @package   NiPHPCMS
 * @category  mall\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Entry.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\mall\controller;

use think\Url;
use think\Lang;
use app\mall\controller\Base;

class Entry extends Base
{

    public function index()
    {
        return order_no();
    }
}

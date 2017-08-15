<?php
/**
 *
 * 关注回复 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  wechat\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Attention.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\wechat\logic;

use think\Model;
use think\Lang;
use think\Request;
use think\Cache;
use app\wechat\logic\Common as LogicCommon;
use app\admin\model\Reply as ModelReply;

class Attention extends LogicCommon
{

    public function reply()
    {
        $map = [
            'type' => 2,
            'lang' => Lang::detect()
        ];

        $model = new ModelReply;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $model->field(true)
        ->where($map)
        ->order('id DESC')
        ->cache($CACHE)
        ->select();

        return $this->toReply($result);
    }
}

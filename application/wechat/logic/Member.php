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
use app\wechat\logic\Common;
use app\admin\model\MemberWechat;

class Member extends Common
{

    /**
     * 更新微信用户信息
     * @access public
     * @param  array  $data
     * @param  string $openid
     * @param  int    $subscribe
     * @return void
     */
    public function wechatMemberInfo($data, $openid, $subscribe = 1)
    {
        if (empty($data)) {
            $data = [
                'openid' => $openid,
                'subscribe' => $subscribe
            ];
        } else {
            $data['subscribe'] = $subscribe;
        }

        $member = new MemberWechat;

        $map = ['openid' => $openid];
        $result =
        $member->field(true)
        ->where($map)
        ->find();

        if (!$result) {
            $member->allowField(true)
            ->isUpdate(false)
            ->data($data)
            ->save();
        } else {
            $member->allowField(true)
            ->isUpdate(true)
            ->save($data, $map);
        }
    }
}

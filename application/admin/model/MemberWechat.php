<?php
/**
 *
 * 微信会员信息表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: MemberWechat.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/02/07
 */
namespace app\admin\model;

use think\Model;

class MemberWechat extends Model
{
    protected $name = 'member_wechat';
    protected $autoWriteTimestamp = false;
    protected $updateTime = false;
    protected $pk = 'id';
    protected $field = [
        'id',
        'subscribe',
        'openid',
        'nickname',
        'sex',
        'city',
        'country',
        'province',
        'language',
        'headimgurl',
        'subscribe_time',
        'unionid',
        'remark',
        'groupid',
        'tagid_list',
    ];
}

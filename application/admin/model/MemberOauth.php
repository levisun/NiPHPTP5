<?php
/**
 *
 * 第三方登录会员表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: MemberOauth.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/02/07
 */
namespace app\admin\model;

use think\Model;

class MemberOauth extends Model
{
    protected $name = 'member_oauth';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    protected $pk = 'id';
    protected $field = [
        'id',
        'user_id',
        'openid',
        'nick',
        'type',
        'create_time',
    ];
}

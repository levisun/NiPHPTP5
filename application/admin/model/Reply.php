<?php
/**
 *
 * 微信回复表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Reply.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/03
 */
namespace app\admin\model;

use think\Model;

class Reply extends Model
{
    protected $name = 'reply';
    protected $autoWriteTimestamp = false;
    protected $updateTime = false;
    protected $pk = 'id';
    protected $field = [
        'id',
        'keyword',
        'title',
        'content',
        'type',
        'image',
        'url',
        'sort',
        'status',
        'lang'
    ];
}

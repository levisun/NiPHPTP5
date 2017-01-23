<?php
/**
 *
 * 评论表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Comment.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/03
 */
namespace app\admin\model;

use think\Model;

class Comment extends Model
{
    protected $name = 'comment';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    protected $pk = 'id';
    protected $field = [
        'id',
        'category_id',
        'content_id' ,
        'user_id',
        'pid',
        'content',
        'is_pass',
        'is_report',
        'support',
        'report_time',
        'ip',
        'ip_attr',
        'create_time',
        'lang'
    ];
}

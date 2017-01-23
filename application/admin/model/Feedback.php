<?php
/**
 *
 * 反馈表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Feedback.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Feedback extends Model
{
    use SoftDelete;
    protected $name = 'feedback';
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'update_time';
    protected $deleteTime = 'delete_time';
    protected $pk = 'id';
    protected $field = [
        'id',
        'title',
        'username',
        'content',
        'category_id',
        'type_id',
        'mebmer_id',
        'is_pass',
        'create_time',
        'update_time',
        'delete_time',
        'lang'
    ];
}

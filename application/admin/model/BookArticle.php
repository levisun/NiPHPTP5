<?php
/**
 *
 * 书库文章表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: BookArticle.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/09/08
 */
namespace app\admin\model;

use think\Model;

class BookArticle extends Model
{
    protected $name = 'book_article';
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'update_time';
    protected $deleteTime = 'delete_time';
    protected $pk = 'id';
    protected $field = [
        'id',
        'title',
        'content',
        'book_id',
        'is_pass',
        'sort',
        'hits',
        'comment_count',
        'show_time',
        'update_time',
        'delete_time',
        'create_time',
        'access_id',
    ];
}

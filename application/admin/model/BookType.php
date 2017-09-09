<?php
/**
 *
 * 书库分类表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: BookType.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/09/08
 */
namespace app\admin\model;

use think\Model;

class BookType extends Model
{
    protected $name = 'book_type';
    protected $autoWriteTimestamp = false;
    protected $updateTime = false;
    protected $pk = 'id';
    protected $field = [
        'id',
        'name',
        'description'
    ];
}

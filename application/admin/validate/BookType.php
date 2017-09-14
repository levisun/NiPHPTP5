<?php
/**
 *
 * 书库分类 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: BookType.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/09/12
 */
namespace app\admin\validate;

use think\Validate;

class BookType extends Validate
{
    protected $rule = [
        'id'          => ['require', 'number'],
        'name'        => ['require', 'length:2,255', 'unique:book_type', 'token'],
        'description' => ['max:555'],
    ];

    protected $message = [
        'id.require'      => '{%illegal operation}',
        'id.number'       => '{%illegal operation}',
        'name.require'    => '{%error typename require}',
        'name.length'     => '{%error typename length not}',
        'name.unique'     => '{%error typename unique}',
        'description.max' => '{%error description length not}',
    ];

    protected $scene = [
        'added' => [
            'name',
            'description',
        ],
        'editor' => [
            'id',
            'name',
            'description',
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];
}

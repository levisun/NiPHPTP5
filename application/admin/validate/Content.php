<?php
/**
 *
 * 内容 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Content.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/28
 */
namespace app\admin\validate;

use think\Validate;

class Content extends Validate
{
    protected $rule = [
        'id'           => ['require', 'number'],
        'title'        => ['require', 'length:4,255'/*, 'token'*/],
        'keywords'     => ['max:255'],
        'description'  => ['max:500'],
        'content'      => ['require'],
        'thumb'        => ['max:255'],
        'category_id'  => ['require', 'number'],
        'type_id'      => ['number'],
        'is_pass'      => ['number'],
        'is_com'       => ['number'],
        'is_top'       => ['number'],
        'is_hot'       => ['number'],
        'sort'         => ['number'],
        'username'     => ['max:20'],
        'origin'       => ['max:255'],
        'url'          => ['url', 'max:500'],
        'down_url'     => ['url', 'max:500'],
        'is_link'      => ['number'],
        'show_time'    => ['date'],
        'access_id'    => ['number'],
    ];

    protected $message = [
        'id.require'           => 'illegal operation',
        'id.number'            => 'illegal operation',
        'title.require'        => 'error content title require',
        'title.length'         => 'error content title length not',
        'keywords.max'         => 'error keywords length not',
        'description.max'      => 'error description length not',
        'content.require'      => 'error content require',
        'thumb.max'            => 'error thumb length not',
        'category_id.require'  => 'error category_id require',
        'category_id.number'   => 'error category_id number',
        'type_id.number'       => 'error type_id number',
        'is_pass.number'       => 'error is_pass number',
        'is_com.number'        => 'error is_com number',
        'is_top.number'        => 'error is_top number',
        'is_hot.number'        => 'error is_hot number',
        'sort.number'          => 'error sort number',
        'username.max'         => 'error username length not',
        'origin.max'           => 'error aorigin length not',
        'url.url'              => 'error url url',
        'url.max'              => 'error url length not',
        'down_url.url'         => 'error down_url url',
        'down_url.max'         => 'error down_url length not',
        'is_link.number'       => 'error is_link number',
        'show_time.date'       => 'error show_time date',
        'access_id.number'     => 'error access_id number',
    ];

    protected $scene = [
        'added' => [
            'title',
            'keywords',
            'description',
            // 'content',
            'thumb',
            'category_id',
            'type_id',
            'is_pass',
            'is_com',
            'is_top',
            'is_hot',
            'username',
            'origin',
            'user_id',
            'url',
            'down_url',
            'is_link',
            'show_time',
            'access_id'
        ],
        'editor' => [
            'id',
            'title',
            'keywords',
            'description',
            // 'content',
            'thumb',
            'category_id',
            'type_id',
            'is_pass',
            'is_com',
            'is_top',
            'is_hot',
            'username',
            'origin',
            'user_id',
            'url',
            'down_url',
            'is_link',
            'show_time',
            'access_id'
        ],

        'page_added' => [
            'title',
            'keywords',
            'description',
            'content',
            'thumb',
            'category_id',
            'type_id',
            'username',
            'origin',
            'user_id',
            'access_id'
        ],
        'page_editor' => [
            'id',
            'title',
            'keywords',
            'description',
            'content',
            'thumb',
            'category_id',
            'type_id',
            'username',
            'origin',
            'user_id',
            'access_id'
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];
}

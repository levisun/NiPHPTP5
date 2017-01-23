<?php
/**
 *
 * 幻灯片 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Banner.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/28
 */
namespace app\admin\validate;

use think\Validate;

class Banner extends Validate
{
    protected $rule = [
        'id'     => ['require', 'number'],
        'pid'    => ['require', 'number'],
        'name'   => ['require', 'length:2,255', 'token'],
        'title'  => ['require', 'length:2,255', 'token'],
        'width'  => ['require', 'number'],
        'height' => ['require', 'number'],
        'image'  => ['require', 'max:255'],
        'url'    => ['require', 'url', 'max:500'],
        'hits'   => ['number'],
        'sort'   => ['number'],
    ];

    protected $message = [
        'id.require'     => 'illegal operation',
        'id.number'      => 'illegal operation',
        'pid.require'    => 'error pid require',
        'pid.number'     => 'error pid number',
        'name.require'   => 'error name require',
        'name.length'    => 'error name length not',
        'title.require'  => 'error title require',
        'title.length'   => 'error title length not',
        'width.require'  => 'error width require',
        'width.number'   => 'error width number',
        'height.require' => 'error height require',
        'height.number'  => 'error height number',
        'image.require'  => 'error image require',
        'image.length'   => 'error image length not',
        'url.require'    => 'error url require',
        'url.url'        => 'error url url',
        'url.length'     => 'error url length not',
        'hits.number'    => 'error sort number',
    ];

    protected $scene = [
        'added' => [
            'pid',
            'title',
            'image',
            'url',
        ],
        'added_main' => [
            'name',
            'width',
            'height',
        ],
        'editor' => [
            'id',
            'title',
            'image',
            'url',
        ],
        'editor_main' => [
            'id',
            'name',
            'width',
            'height',
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];
}

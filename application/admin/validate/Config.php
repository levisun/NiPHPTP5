<?php
/**
 *
 * 设置 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Config.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/24
 */
namespace app\admin\validate;

use think\Validate;

class Config extends Validate
{
    protected $rule = [
        'name'  => ['require', 'max:20', 'token'],
        'value' => ['require', 'max:500'],
        'lang'  => ['require', 'max:5'],

        // 基本设置
        'website_name' => ['require', 'max:500'],

        // 语言设置
        'system'         => ['require'],
        'website'        => ['require'],
        'lang_switch_on' => ['require'],

        // 图片设置
        'auto_image'             => ['require', 'number'],
        'article_module_width'   => ['require', 'number'],
        'article_module_height'  => ['require', 'number'],
        'picture_module_width'   => ['require', 'number'],
        'picture_module_height'  => ['require', 'number'],
        'download_module_width'  => ['require', 'number'],
        'download_module_height' => ['require', 'number'],
        'page_module_width'      => ['require', 'number'],
        'page_module_height'     => ['require', 'number'],
        'product_module_width'   => ['require', 'number'],
        'product_module_height'  => ['require', 'number'],
        'job_module_width'       => ['require', 'number'],
        'job_module_height'      => ['require', 'number'],
        'link_module_width'      => ['require', 'number'],
        'link_module_height'     => ['require', 'number'],
        'ask_module_width'       => ['require', 'number'],
        'ask_module_height'      => ['require', 'number'],
        'add_water'              => ['require', 'number'],
        'water_type'             => ['require', 'number'],
        'water_location'         => ['require', 'number'],
        'water_text'             => ['require'],
        'water_image'            => ['require'],

        // 安全效率
        'content_check'          => ['require'],
        'member_login_captcha'   => ['require', 'number'],
        'website_submit_captcha' => ['require', 'number'],
        'website_static'         => ['require'],
        'upload_file_max'        => ['require', 'number'],
        'upload_file_type'       => ['require'],

        // 邮件设置
        'smtp_host'       => ['require'],
        'smtp_port'       => ['require', 'number'],
        'smtp_username'   => ['require'],
        'smtp_password'   => ['require'],
        'smtp_from_email' => ['require'],
        'smtp_from_name'  => ['require'],

        // 微信接口
        'wechat_token'          => ['require'],
        'wechat_encodingaeskey' => ['require'],
        'wechat_appid'          => ['require'],
        'wechat_appsecret'      => ['require'],

        // 商城
        'mall_name'         => ['require', 'max:500'],
        'mall_postage'      => ['require', 'max:500'],
        'mall_free_postage' => ['require', 'max:500'],
        'mall_fast_mail'    => ['require', 'max:500'],
    ];

    protected $message = [
        'name.require'  => 'please enter name',
        'name.max'      => 'name length shall not exceed 30',
        'value.require' => 'please enter value',
        'value.max'     => 'value length shall not exceed 500',
        'lang.require'  => 'please enter lang',
        'lang.max'      => 'lang length shall not exceed 5',

        // 基本设置
        'website_name.require' => 'please enter website name',
        'website_name.max'     => 'website name length shall not exceed 500',

        // 语言设置
        'system.require'         => 'error system default lang',
        'website.require'        => 'error website default lang',
        'lang_switch_on.require' => 'error domain auto',

        // 图片设置
        'auto_image.require'             => 'error image auto image',
        'auto_image.number'              => 'error image auto image',
        'article_module_width.require'   => 'error image article module',
        'article_module_width.number'    => 'error image article module',
        'article_module_height.require'  => 'error image article module',
        'article_module_height.number'   => 'error image article module',
        'picture_module_width.require'   => 'error image picture module',
        'picture_module_width.number'    => 'error image picture module',
        'picture_module_height.require'  => 'error image picture module',
        'picture_module_height.number'   => 'error image picture module',
        'download_module_width.require'  => 'error image download module',
        'download_module_width.number'   => 'error image download module',
        'download_module_height.require' => 'error image download module',
        'download_module_height.number'  => 'error image download module',
        'page_module_width.require'      => 'error image page module',
        'page_module_width.number'       => 'error image page module',
        'page_module_height.require'     => 'error image page module',
        'page_module_height.number'      => 'error image page module',
        'product_module_width.require'   => 'error image product module',
        'product_module_width.number'    => 'error image product module',
        'product_module_height.require'  => 'error image product module',
        'product_module_height.number'   => 'error image product module',
        'job_module_width.require'       => 'error image job module',
        'job_module_width.number'        => 'error image job module',
        'job_module_height.require'      => 'error image job module',
        'job_module_height.number'       => 'error image job module',
        'link_module_width.require'      => 'error image link module',
        'link_module_width.number'       => 'error image link module',
        'link_module_height.require'     => 'error image link module',
        'link_module_height.number'      => 'error image link module',
        'ask_module_width.require'       => 'error image ask module',
        'ask_module_width.number'        => 'error image ask module',
        'ask_module_height.require'      => 'error image ask module',
        'ask_module_height.number'       => 'error image ask module',
        'add_water.require'              => 'error image add water',
        'add_water.number'               => 'error image add water',
        'water_type.require'             => 'error image water type',
        'water_type.number'              => 'error image water type',
        'water_location.require'         => 'error image water location',
        'water_location.number'          => 'error image water location',
        'water_text.require'             => 'error image water text',
        'water_image.require'            => 'error image water image',

        // 安全效率
        'content_check'          => 'error safe content check',
        'member_login_captcha'   => 'error safe member login captcha',
        'website_submit_captcha' => 'error safe website submit captcha',
        'website_static'         => 'error safe website static',
        'upload_file_max'        => 'error safe upload file max',
        'upload_file_type'       => 'error safe upload file type',

        // 邮件设置
        'smtp_host.require'       => 'error emailsms smtp host',
        'smtp_port.require'       => 'error emailsms smtp port',
        'smtp_port.number'        => 'error emailsms smtp port',
        'smtp_username.require'   => 'error emailsms smtp username',
        'smtp_password.require'   => 'error emailsms smtp password',
        'smtp_from_email.require' => 'error emailsms smtp from email',
        'smtp_from_name.require'  => 'error emailsms smtp from name',

        // 微信接口
        'wechat_token.require'          => 'error wechattoken require',
        'wechat_encodingaeskey.require' => 'error wechatencodingaeskey require',
        'wechat_appid.require'          => 'error wechatappid require',
        'wechat_appsecret.require'      => 'error wechatappsecret require',

        // 商城
        'mall_name.require'         => 'please enter mall name',
        'mall_name.max'             => 'mall name length shall not exceed 500',
        'mall_postage.require'      => 'please enter mall postage name',
        'mall_postage.max'          => 'mall postage name length shall not exceed 500',
        'mall_free_postage.require' => 'please enter mall free postage name',
        'mall_free_postage.max'     => 'mall free postage name length shall not exceed 500',
        'mall_fast_mail.require'    => 'please enter mall fast mail name',
        'mall_fast_mail.max'        => 'mall fast mail name length shall not exceed 500',
    ];

    protected $scene = [
        // 基本设置
        'basic' => [
            'website_name'
        ],

        // 语言设置
        'lang' => [
            'system',
            'website',
            'lang_switch_on'
        ],

        // 图片设置
        'image' => [
            'auto_image',
            'article_module_width',
            'article_module_height',
            'picture_module_width',
            'picture_module_height',
            'download_module_width',
            'download_module_height',
            'page_module_width',
            'page_module_height',
            'product_module_width',
            'product_module_height',
            'job_module_width',
            'job_module_height',
            'link_module_width',
            'link_module_height',
            'ask_module_width',
            'ask_module_height',
            'add_water',
            'water_type',
            'water_location',
            'water_text',
            'water_image',
        ],

        // 图片设置
        'safe' => [
            'content_check',
            'member_login_captcha',
            'website_submit_captcha',
            'website_static',
            'upload_file_max',
            'upload_file_type',
        ],

        // 邮件设置
        'email' => [
            'smtp_host',
            'smtp_port',
            'smtp_username',
            'smtp_password',
            'smtp_from_email',
            'smtp_from_name',
        ],

        // 微信接口
        'wechat' => [
            'wechat_token',
            'wechat_encodingaeskey',
            'wechat_appid',
            'wechat_appsecret'
        ],

        // 商城
        'mall' => [
            'mall_name',
            'mall_postage',
            'mall_free_postage',
            'mall_fast_mail'
        ],
    ];
}

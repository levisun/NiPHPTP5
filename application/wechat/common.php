<?php
/**
 *
 * 模块公共（函数）文件
 *
 * @package   NiPHPCMS
 * @category  wechat\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: common.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */

function is_url_param($url)
{
    $rule = '/^[?]+$/';
    return 1 === preg_match($rule, (string) $url);
}

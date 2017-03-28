<?php
/**
 *
 * 应用公共（函数）文件
 *
 * @package   NiPHPCMS
 * @category  \
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: common.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */

/**
 * 生成缓存KEY
 * @param  array  $array
 * @return string
 */
function check_key($array, $method)
{
    if (APP_DEBUG) {
        return false;
    }

    $key = $method;
    foreach ($array as $value) {
        if (is_array($value)) {
            $key .= check_key($value, '');
        } else {
            $key .= $value;
        }
    }
    return $key;
}

/**
 * 过滤XSS
 * @param  string $data
 * @return string
 */
function escape_xss($data)
{
    $search = [
        // 过滤PHP
        '/<\?php(.*?)\?>/si',
        '/<\?(.*?)\?>/si',
        '/<%(.*?)%>/si',
        '/<\?php|<\?|\?>|<%|%>/si',

        '/on([a-z].*?)["|\'](.*?)["|\']/si',

        '/<(javascript.*?)>(.*?)<(\/javascript.*?)>/si',
        '/<(\/?javascript.*?)>/si',
        '/<(vbscript.*?)>(.*?)<(\/vbscript.*?)>/si',
        '/<(\/?vbscript.*?)>/si',
        '/<(expression.*?)>(.*?)<(\/expression.*?)>/si',
        '/<(\/?expression.*?)>/si',
        '/<(applet.*?)>(.*?)<(\/applet.*?)>/si',
        '/<(\/?applet.*?)>/si',
        '/<(meta.*?)>(.*?)<(\/meta.*?)>/si',
        '/<(\/?meta.*?)>/si',
        '/<(xml.*?)>(.*?)<(\/xml.*?)>/si',
        '/<(\/?xml.*?)>/si',
        '/<(blink.*?)>(.*?)<(\/blink.*?)>/si',
        '/<(\/?blink.*?)>/si',
        '/<(link.*?)>(.*?)<(\/link.*?)>/si',
        '/<(\/?link.*?)>/si',
        '/<(script.*?)>(.*?)<(\/script.*?)>/si',
        '/<(\/?script.*?)>/si',
        '/<(embed.*?)>(.*?)<(\/embed.*?)>/si',
        '/<(\/?embed.*?)>/si',
        '/<(object.*?)>(.*?)<(\/object.*?)>/si',
        '/<(\/?object.*?)>/si',
        '/<(iframe.*?)>(.*?)<(\/iframe.*?)>/si',
        '/<(\/?iframe.*?)>/si',
        '/<(frame.*?)>(.*?)<(\/frame.*?)>/si',
        '/<(\/?frame.*?)>/si',
        '/<(frameset.*?)>(.*?)<(\/frameset.*?)>/si',
        '/<(\/?frameset.*?)>/si',
        '/<(ilayer.*?)>(.*?)<(\/ilayer.*?)>/si',
        '/<(\/?ilayer.*?)>/si',
        '/<(layer.*?)>(.*?)<(\/layer.*?)>/si',
        '/<(\/?layer.*?)>/si',
        '/<(bgsound.*?)>(.*?)<(\/bgsound.*?)>/si',
        '/<(\/?bgsound.*?)>/si',
        '/<(title.*?)>(.*?)<(\/title.*?)>/si',
        '/<(\/?title.*?)>/si',
        '/<(base.*?)>(.*?)<(\/base.*?)>/si',
        '/<(\/?base.*?)>/si',
        '/<(style.*?)>(.*?)<(\/style.*?)>/si',
        '/<(\/?style.*?)>/si',
        '/(javascript:)(.*?)(\))/si',
        '/<\!--.*?-->/s',
        '/<(\!.*?)>/si',
        '/<(\/?html.*?)>/si',
        '/<(\/?head.*?)>/si',
        '/<(\/?body.*?)>/si',

    ];

    /*$param = [
        'javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink',
        'link', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset',
        'ilayer', 'layer', 'bgsound', 'title', 'base', 'style'
    ];
    foreach ($param as $value) {
        $search[] = '/<(' . $value . '.*?)>(.*?)<(\/' . $value . '.*?)>/si';
        $search[] = '/<(\/?' . $value . '.*?)>/si';
    }*/

    /*$param = [
        'onabort', 'onactivate', 'onafterprint', 'onafterupdate',
        'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate',
        'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload',
        'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange',
        'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut',
        'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick',
        'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave',
        'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate',
        'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout',
        'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete',
        'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave',
        'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel',
        'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange',
        'onreadystatechange', 'onreset', 'onresize', 'onresizeend',
        'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete',
        'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange',
        'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'
    ];
    foreach ($param as $value) {
        $search[] = '/(' . $value . '.*?)["|\'](.*?)["|\']/si';
    }*/

    $data = preg_replace($search, '', $data);
    $data = preg_replace('/[  ]+/si', ' ', $data);      // 多余空格
    $data = preg_replace('/>[.\s]+/si', '>', $data);    // 多余回车

    // 转义特殊字符
    $strtr = [
        '*' => '&lowast;', '`' => '&acute;',
        '￥' => '&yen;', '™' => '&trade;', '®' => '&reg;', '©' => '&copy;',
        // '\'' => '&#39;', '"' => '&quot;', '<' => '&lt;', '>' => '&gt;',
        '　' => ' ',
        '０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4', '５' => '5',
        '６' => '6', '７' => '7', '８' => '8', '９' => '9',

        'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E', 'Ｆ' => 'F',
        'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J', 'Ｋ' => 'K', 'Ｌ' => 'L',
        'Ｍ' => 'M', 'Ｎ' => 'N', 'Ｏ' => 'O', 'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R',
        'Ｓ' => 'S', 'Ｔ' => 'T', 'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X',
        'Ｙ' => 'Y', 'Ｚ' => 'Z',

        'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd', 'ｅ' => 'e', 'ｆ' => 'f',
        'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i', 'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l',
        'ｍ' => 'm', 'ｎ' => 'n', 'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r',
        'ｓ' => 's', 'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x',
        'ｙ' => 'y', 'ｚ' => 'z',

        '（' => '(', '）' => ')', '〔' => '[', '〕' => ']', '【' => '[', '】' => ']',
        '〖' => '[', '〗' => ']', '｛' => '{', '｝' => '}', '％' => '%', '＋' => '+',
        '—' => '-', '－' => '-', '～' => '-', '：' => ':', '？' => '?', '！' => '!',
        '…' => '...', '‖' => '|', '｜' => '|',
        '〃' => '&quot;', '”' => '&quot;', '“' => '&quot;',  '’' => '&acute;',
        '‘' => '&acute;',
        '×' => '&times;', '÷' => '&divide;',
        ];
    $data = strtr($data, $strtr);

    return $data;
}

/**
 * 字符串加密
 * @param  mixed  $data    加密前的字符串
 * @param  string $authkey 密钥
 * @return mixed  加密后的字符串
 */
function encrypt($data, $authkey = '0af4769d381ece7b4fddd59dcf048da6') {
    if (is_array($data)) {
        $coded = array();
        foreach ($data as $key => $value) {
            $coded[$key] = encrypt($value, $authkey);
        }
        return $coded;
    } else {
        $coded = '';
        $keylength = strlen($authkey);
        for ($i = 0, $count = strlen($data); $i < $count; $i += $keylength) {
            $coded .= substr($data, $i, $keylength) ^ $authkey;
        }
        return str_replace('=', '', base64_encode($coded));
    }
}

/**
 * 字符串解密
 * @param  mixed  $data    加密后的字符串
 * @param  string $authkey 密钥
 * @return mixed  加密前的字符串
 */
function decrypt($data, $authkey = '0af4769d381ece7b4fddd59dcf048da6') {
    if (is_array($data)) {
        $coded = array();
        foreach ($data as $key => $value) {
            $coded[$key] = decrypt($value, $authkey);
        }
        return $coded;
    } else {
        $coded = '';
        $keylength = strlen($authkey);
        $data = base64_decode($data);
        for ($i = 0, $count = strlen($data); $i < $count; $i += $keylength) {
            $coded .= substr($data, $i, $keylength) ^ $authkey;
        }
        return $coded;
    }
}

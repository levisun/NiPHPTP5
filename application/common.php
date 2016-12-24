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
 * @param  array  $array_
 * @return string
 */
function check_key($array_, $method_)
{
	if (APP_DEBUG) {
		return false;
	}

	$key = $method_;
	foreach ($array_ as $value) {
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
 * @param  string $string_
 * @return string
 */
function escape_xss($string_)
{
	$search = [
		// 过滤PHP
		'/<\?php(.*?)\?>/si',
		'/<\?(.*?)\?>/si',
		'/<%(.*?)%>/si',
		'/<\?php|<\?|\?>|<%|%>/si'
	];

	$param = [
		'javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink',
		'link', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset',
		'ilayer', 'layer', 'bgsound', 'title', 'base'
	];
	foreach ($param as $value) {
		$search[] = '/<(' . $value . '.*?)>(.*?)<(\/' . $value . '.*?)>/si';
		$search[] = '/<(\/?' . $value . '.*?)>/si';
	}

	$param = [
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
	}

	$string_ = preg_replace($search, '', $string_);
	$string_ = preg_replace('/>[.\n\r]+</si', '><', $string_);

	// 转义特殊字符
	$strtr = array(
		'*' => '&lowast;', '`' => '&acute;',
		'￥' => '&yen;', '™' => '&trade;', '®' => '&reg;', '©' => '&copy;',
		// '\'' => '&#39;', '"' => '&quot;', '<' => '&lt;', '>' => '&gt;',
		'　' => ' ',
		'０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4', '５' => '5',
		'６' => '6', '７' => '7', '８' => '8', '９' => '9', 'Ａ' => 'A', 'Ｂ' => 'B',
		'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E', 'Ｆ' => 'F', 'Ｇ' => 'G', 'Ｈ' => 'H',
		'Ｉ' => 'I', 'Ｊ' => 'J', 'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N',
		'Ｏ' => 'O', 'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T',
		'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y', 'Ｚ' => 'Z',
		'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd', 'ｅ' => 'e', 'ｆ' => 'f',
		'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i', 'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l',
		'ｍ' => 'm', 'ｎ' => 'n', 'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r',
		'ｓ' => 's', 'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x',
		'ｙ' => 'y', 'ｚ' => 'z', '（' => '(', '）' => ')', '〔' => '[', '〕' => ']',
		'【' => '[', '】' => ']', '〖' => '[', '〗' => ']', '｛' => '{', '｝' => '}',
		'％' => '%', '＋' => '+', '—' => '-', '－' => '-', '～' => '-', '：' => ':',
		'？' => '?', '！' => '!', '…' => '...', '‖' => '|', '｜' => '|',
		'〃' => '&quot;', '”' => '&quot;', '“' => '&quot;',  '’' => '&acute;',
		'‘' => '&acute;'
		);
	$string_ = strtr($string_, $strtr);

	return $string_;
}

/**
 * 字符串加密
 * @param  mixed  $string_  加密前的字符串
 * @param  string $authkey_ 密钥
 * @return mixed  加密后的字符串
 */
function encrypt($string_, $authkey_='0af4769d381ece7b4fddd59dcf048da6') {
	if (is_array($string_)) {
		$_coded = array();
		foreach ($string_ as $key => $value) {
			$_coded[$key] = encrypt($value, $authkey_);
		}
		return $_coded;
	} else {
		$coded = '';
		$keylength = strlen($authkey_);
		for ($i = 0, $count = strlen($string_); $i < $count; $i += $keylength) {
			$coded .= substr($string_, $i, $keylength) ^ $authkey_;
		}
		return str_replace('=', '', base64_encode($coded));
	}
}

/**
 * 字符串解密
 * @param  mixed  $string_ 加密后的字符串
 * @param  string $key     密钥
 * @return mixed  加密前的字符串
 */
function decrypt($string_, $authkey_='0af4769d381ece7b4fddd59dcf048da6') {
	if (is_array($string_)) {
		$_coded = array();
		foreach ($string_ as $key => $value) {
			$_coded[$key] = decrypt($value, $authkey_);
		}
		return $_coded;
	} else {
		$coded = '';
		$keylength = strlen($authkey_);
		$string_ = base64_decode($string_);
		for ($i = 0, $count = strlen($string_); $i < $count; $i += $keylength) {
			$coded .= substr($string_, $i, $keylength) ^ $authkey_;
		}
		return $coded;
	}
}
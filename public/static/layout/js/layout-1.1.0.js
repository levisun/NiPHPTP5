/**
 *
 * 布局JS库
 *
 * @package   NiPHPCMS
 * @category  static
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: layout.js $
 * @link      http://www.NiPHP.com
 * @since     2017/04/09
 */

var Layout = new Object;

/**
 * 版本号
 */
Layout.VERSION = "1.1.0";

Layout.pathName = location.pathname;
Layout.projectName = Layout.pathName.substring(0, Layout.pathName.substr(1).indexOf("/") + 1);

/**
 * 执行脚本目录
 */
Layout.phpself = Layout.pathName.substring(
    Layout.pathName.substr(1).indexOf("/") + 1,
    Layout.pathName.substr(1).indexOf(".php") + 5
    ) + "/";

/**
 * 域名
 */
if (window.location.host == "localhost") {
    Layout.domain = location.protocol + "//" + window.location.host + Layout.projectName + "/";
} else {
    Layout.domain = location.protocol + "//" + window.location.host + "/";
    Layout.phpself = "";
}

/**
 * 审核数据合法性
 */
Layout.checkdate = function(element) {
    var error = "";
    jQuery(element + " input").each(function(){
        var validate = jQuery(this).attr("validate");
        if (Layout.isVar(validate)) {
            var array = Layout.explode("|", validate),
                msg = Layout.explode("|", jQuery(this).attr("validate-msg"));
            for (var i = 0; i <= array.length - 1; i++) {
                var check = Layout.validate(this, array[i], msg[i]);
                if (check != true) {
                    error = check;
                    return false;
                } else {
                    error = true;
                }
            }

        }
    });

    return error;
}

/**
 * 验证 核心方法
 * Layout.validate(element, "min:20", "error")
 */
Layout.validate = function(element, rule, message) {
    var value = jQuery(element).val(),
        array = Layout.explode(":", rule);
        rule = array[0];
    var mixed = array[1];
    switch (rule) {
        case "require":
            // 必须
            result = value != "";
            break;

        case "accepted":
            // 接受
            result = value == 1 || value == "on" || value == "yes";
            break;

        case "date":
            // 是否是一个有效日期
            result = new Date(value).getDate() == value.substring(value.length - 2);
            break;

        case "alpha":
            // 只允许字母
            result = value.match(/^[A-Za-z]+$/);
            break;

        case "alphaNum":
            // 只允许字母和数字
            result = value.match(/^[A-Za-z0-9]+$/);
            break;

        case "alphaDash":
            // 只允许字母、数字和下划线_及破折号-
            result = value.match(/^[A-Za-z0-9\-\_]+$/);
            break;

        case "chs":
            // 只允许汉字
            result = value.match(/^[\u4E00-\u9FA5\uF900-\uFA2D]+$/);
            break;

        case "chsAlpha":
            // 只允许汉字、字母
            result = value.match(/^[\u4E00-\u9FA5\uF900-\uFA2Da-zA-Z]+$/);
            break;

        case "chsAlphaNum":
            // 只允许汉字、字母和数字
            result = value.match(/^[\u4E00-\u9FA5\uF900-\uFA2Da-zA-Z0-9]+$/);
            break;

        case "chsDash":
            // 只允许汉字、字母、数字和下划线_及破折号-
            result = value.match(/^[\u4E00-\u9FA5\uF900-\uFA2Da-zA-Z0-9\_\-]+$/);
            break;

        case "activeUrl":
            // 是否为有效的网址
        case "url":
            // 是否为一个URL地址
            result = value.match(/^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/)(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/);
            break;

        case "ip":
            // 是否为IP地址
            result = value.match(/^(([3-9]d?|[01]d{0,2}|2d?|2[0-4]d|25[0-5]).){3}([3-9]d?|[01]d{0,2}|2d?|2[0-4]d|25[0-5])/);
            break;

        case "float":
            // 是否为float
            result = value.match(/^\d+\.\d?/);
            break;

        case "number":
            // 是否为数字
        case "integer":
            // 是否为整型
            result = value.match(/^[\d]+$/);
            break;

        case "email":
            // 是否为数字
            result = value.match(/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/);
            break;

        case "length":
            result = value.length == mixed;
            break;

        case "max":
            result = value.length <= mixed;
            break;

        case "min":
            result = value.length >= mixed;
            break;

        default:
            result = value.match(rule);
            break;
    }

    if (result) {
        return true;
    } else {
        return message;
    }
}

/**
 * 循环获得内容等信息
 */
Layout.each = function(element) {
    var array = new Array();
    jQuery(element).each(function(){
        var ecah = new Array();
        ecah["name"] = jQuery(this).attr("name");
        ecah["value"] = jQuery(this).val();
        ecah["text"] = jQuery(this).text();
        ecah["html"] = jQuery(this).html();
        ecah[":checked"] = Layout.checked(this);
        ecah["id"] = jQuery(this).attr("id");
        ecah["class"] = jQuery(this).attr("class");

        array.push(ecah);
    });
    return array;
}

/**
 * 是否选中
 */
Layout.checked = function(element) {
    return jQuery(element).is(":checked");
};

/**
 * 分割字符串为数组
 */
Layout.explode = function (delimiter, string) {
    var array = new Array();
    array = string.split(delimiter);
    return array;
}

/**
 * 数组转字符串
 */
Layout.implode = function (glue, pieces) {
    var string = pieces.join(glue);
    return string;
}

/**
 * 刷新验证码
 * Layout.captcha(element, false);
 */
Layout.captcha = function (element, params) {
    var url = jQuery("img" + element).attr("src");
    if (!url) {
        return null;
    }

    var url_query = url.split("?"),
        url = url_query[0] + "?";

    if (url_query[1]) {
        var query = url_query[1].split("&captcha_time");
        url = url + query[0];
    }

    // 是否刷新input
    params = Layout.isVar(params, false);

    // input刷新
    jQuery(document).on("focus", "[name='password']", function(){
        if (!jQuery(this).val() && params) {
            var timenow = new Date().getTime();
            jQuery("img" + element).attr("src", url + "&captcha_time=" + timenow);
            jQuery("input" + element).val("");
        }
    });

    // img刷新
    jQuery(document).on("click", "img" + element, function(){
        var timenow = new Date().getTime();
        jQuery(this).attr("src", url + "&captcha_time=" + timenow);
        jQuery("input" + element).val("");
    });
}

/**
 * AJAX加载更多
 * var params = {"type": "get",  "data": {"p": 1}}
 * Layout.scrollBot(params, "function_name": "alert");
 */
Layout.scrollBot = function (params, function_name) {
    jQuery("body").append("<input type='hidden' id='Layout-scroll-page' value='1' />");
    jQuery("body").append("<input type='hidden' id='Layout-scroll-bot' value='true' />");
    jQuery(window).scroll(function () {
        var is = jQuery("#Layout-scroll-bot").val();
        if (is == "true" && jQuery(window).scrollTop() >= (jQuery(document).height() - jQuery(window).height()) / 1.05) {
            var page_num = jQuery("#Layout-scroll-page").val();
                page_num++;
            jQuery("#Layout-scroll-page").val(page_num);
            jQuery("#Layout-scroll-bot").val("false");

            params["data"]["p"] = page_num;
            var result = Layout.ajax(params);

            window[function_name](result);

            setTimeout("Layout.scrollBotTrue()", 1500);
        }
    });
}
Layout.scrollBotTrue = function () {
    jQuery("#Layout-scroll-bot").val("true");
}

/**
 * AJAX请求
 * var params = {"type": "get", "url": "url", "data": {"p": 1}}
 * Layout.ajax(params);
 */
Layout.ajax = function (params) {
    var ajax_result = "",
        ajax_type = Layout.isVar(params.type, "get"),
        ajax_url = Layout.isVar(params.url, "?ajax_url=undefined"),
        ajax_data = Layout.isVar(params.data, ""),
        ajax_async = Layout.isVar(params.async, false),
        ajax_cache = Layout.isVar(params.cache, false),
        ajax_data_type = Layout.isVar(params.data_type, "");

    jQuery.ajax({
        type: ajax_type,
        async: ajax_async,
        cache: ajax_cache,
        dataType: ajax_data_type,
        url: ajax_url,
        data: ajax_data,
        success: function(result){
            if (ajax_data_type == "json") {
                ajax_result = Layout.parseJSON(result);
            } else {
                ajax_result = result;
            }
        }
    });

    return ajax_result;
}

/**
 * 确认操作
 */
Layout.confirmOperation = function (element, lang) {
    jQuery(document).on("click", element, function(){
        return confirm(lang);
    });
}

/**
 * 点击提交表单
 * 用于a button等标签
 */
Layout.formSubmit = function (element, form) {
    jQuery(document).on("click", element, function(){
        jQuery(form).submit();
        return false;
    });
}

/**
 * 返回顶部
 */
Layout.scrollTop = function (element) {
    jQuery(window).scroll(function () {
        if (jQuery(window).scrollTop() >= (jQuery(document).height() - jQuery(window).height()) / 2) {
            jQuery(element).fadeIn(1000);
        } else {
            jQuery(element).fadeOut(500);
        }
    });

    jQuery(element).click(function(){
        jQuery("body,html").animate({scrollTop:0}, 300);
    });
}

/**
 * URL get参数
 */
Layout.getParam = function (name) {
    var reg = new RegExp("(^|&)" + key + "=([^&]*)(&|$)");
    var result = window.location.search.substr(1).match(reg);
    return result ? decodeURIComponent(result[2]) : null;
}

/**
 * 转换JSON数据
 */
Layout.parseJSON = function (result) {
    return eval("(" + result + ")");
}

/**
 * 变量是否存在
 */
Layout.isVar = function (var_name, def) {
    if (typeof(var_name) == "undefined") {
        if (typeof(def) == "undefined") {
            return false;
        } else {
            return def;
        }
    } else {
        return var_name;
    }
}

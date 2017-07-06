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
Layout.debug = false;

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
 * 自动隐藏
 */
Layout.autoHide = function(element, time) {
    var wait = Layout.isVar(time, 3);
    var interval = setInterval(function() {
        var time = --wait;
        if(time <= 0) {
          jQuery(element).hide();
          clearInterval(interval);
        };
    }, 1000);
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
 * 循环获得内容等信息
 */
Layout.each = function(element) {
    var array = new Array();
    jQuery(element).each(function(){
        var ecah = new Array();
        ecah["name"]   = jQuery(this).attr("name");
        ecah["value"]  = jQuery(this).val();
        ecah["text"]   = jQuery(this).text();
        ecah["html"]   = jQuery(this).html();
        ecah["width"]  = jQuery(this).width();
        ecah["height"] = jQuery(this).height();

        ecah[":checked"]     = Layout.checked(this);
        ecah["id"]           = jQuery(this).attr("id");
        ecah["class"]        = jQuery(this).attr("class");
        ecah["src"]          = jQuery(this).attr("src");
        ecah["title"]        = jQuery(this).attr("title");

        if (ecah["src"]) {
            // 图片实际宽高
            var img = new Image();
            img.src = ecah["src"];
            ecah["img_width"]  = img.width;
            ecah["img_height"] = img.height;
        }

        array.push(ecah);
    });
    return array;
}

/**
 * 调试输入日志
 */
Layout.debug = function(log) {
    console.log(log);
}

/**
 * 重定向
 */
Layout.redirect = function(url) {
    window.location.href = url;
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
 * URL get参数
 */
Layout.getParam = function (key) {
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

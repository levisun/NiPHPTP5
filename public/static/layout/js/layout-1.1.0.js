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
Layout.VERSION = '1.1.0';


Layout.pathName = location.pathname;
Layout.projectName = Layout.pathName.substring(0, Layout.pathName.substr(1).indexOf('/') + 1);

/**
 * 执行脚本目录
 */
Layout.phpself = Layout.pathName.substring(
    Layout.pathName.substr(1).indexOf('/') + 1,
    Layout.pathName.substr(1).indexOf('.php') + 5
    ) + '/';

/**
 * 域名
 */
Layout.domain = location.protocol + '//' + window.location.host + Layout.projectName;

/**
 * AJAX加载更多
 * var params = {"type": "get",  "data": {"p": 1}, "function_name": "alert"}
 * Layout.scrollBot(params, "");
 */
Layout.scrollBot = function (params, function_name) {
    jQuery(window).scroll(function () {
        if (jQuery(window).scrollTop() >= jQuery(document).height() - jQuery(window).height()) {
            var result = Layout.ajax(params);
            window[function_name](result);
        }
        return null;
    });
}

/**
 * AJAX请求
 * var params = {"type": "get",  "data": {"p": 1}, "function_name": "alert"}
 * Layout.scrollBot(params);
 */
Layout.ajax = function (params) {
    var ajax_result = "",
        ajax_type = Layout.isVar(params.type, "get"),
        ajax_url = Layout.isVar(params.url, '?ajax_url=undefined'),
        ajax_data = Layout.isVar(params.data, "");

    jQuery.ajax({
        type: ajax_type,
        async: false,
        cache: false,
        // dataType: "json",
        url: ajax_url,
        data: ajax_data,
        success: function(result){
            ajax_result = result;
        }
    });

    return ajax_result;
}

/**
 * 转换JSON数据
 */
Layout.parseJSON = function (result) {
    return eval('(' + result + ')');
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

/**
 *
 * 验证JS库
 *
 * @package   NiPHPCMS
 * @category  static
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: validate.js $
 * @link      http://www.NiPHP.com
 * @since     2017/04/09
 */

var Validate = new Object;

/**
 * 点击提交表单
 * 用于a button等标签
 */
Validate.formSubmit = function (element, form) {
    var style = "<style>#validate{position:absolute;top:0;right:0;bottom:0;left:0;display:none;}#validate-info-box{width:70%;margin:35% auto 0;border:1px solid #faebcc;border-radius:4px;padding:15px;background-color:#fcf8e3;color:#8a6d3b;}</style>",
        html = "<div id='validate'><div id='validate-info-box'>fff</div></div>";
    jQuery("body").append(style+html);

    jQuery(document).on("click", element, function(){
        var msg = Validate.checkdate(form);
        if (msg !== true) {
            jQuery("#validate").show();
            jQuery("#validate-info-box").text(msg);
            Validate.timeHide("#validate", 3);
            return false;
        } else {
            return true;
        }
    });
}

/**
 * 倒计时隐藏
 */
Validate.timeHide = function(element, wait) {
    var interval = setInterval(function(){
            var time = --wait;
            if (time <= 0) {
                jQuery(element).hide();
                clearInterval(interval);
            }
        }, 1000);
}

/**
 * 审核数据合法性
 */
Validate.checkdate = function(element) {
    var error = "";
    jQuery(element + " input").each(function(){
        var validate = jQuery(this).attr("validate");
        if (Layout.isVar(validate)) {
            var array = Layout.explode("|", validate),
                msg = Layout.explode("|", jQuery(this).attr("validate-msg"));
            for (var i = 0; i <= array.length - 1; i++) {
                var check = Validate.validate(this, array[i], msg[i]);
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
Validate.validate = function(element, rule, message) {
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

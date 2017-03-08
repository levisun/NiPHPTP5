var Layout = new Object;

Layout.VERSION = '1.0.0';
Layout.domain  = null;
Layout.phpself = null;

Layout.delElement = function (element, ele) {
    jQuery(element).click(function(){
        alert(1);
        var id = jQuery(this).attr("date-type");
        jQuery(ele + id).remove();
    });
}
Layout.addAlbum = function (element, ele) {
    jQuery(element).click(function(){
        var num = jQuery(ele).length;
        num++;
        var html = "<li id='album-"+num+"'><input type='text' name='album_image[]' id='album-image-"+num+"' class='form-control'><input type='hidden' name='album_thumb[]' id='album-thumb-"+num+"' class='form-control'><img src='' id='img-album-"+num+"' width='100' style='display:none'><button type='button' class='btn btn-success btn-sm np-upload' data-type='album' data-id='"+num+"' data-model=''>上传</button><button type='button' class='btn btn-success btn-sm np-album-del' date-id='"+num+"'>删除</button></li>";
        jQuery(ele).append(html);
    });
}

/**
 * 栏目 - 字段 - 选择字段所属栏目
 */
Layout.fieldsCategory = function (element, url) {
    jQuery(element).change(function(){
        var id = jQuery(element).val();
        var type = jQuery(element).attr('data-type');
        if (!id) {
            return false;
        }
        jQuery.ajax({
            type: 'post',
            async: false,
            cache: false,
            url: Layout.domain + Layout.phpself + url,
            data: {id: id, type: type},
            success: function(data){
                if (type == 1) {
                    jQuery('.op').remove();
                }
                jQuery('#category_id_' + type).after(data);
            }
        });
    });
}

/**
 * 选择地区
 */
Layout.selectRegion = function (element, url) {
    jQuery(element).change(function(){
        var id = jQuery(this).val(), type = jQuery(this).attr('data-type');
        jQuery.ajax({
            type: 'post',
            async: false,
            cache: false,
            url: Layout.domain + Layout.phpself + url,
            data: {id: id},
            success: function(data){
                jQuery(type + ' option.op').remove();
                jQuery(type).append(data);
            }
        });
    });
}

/**
 * 上传窗口
 */
Layout.newWinUpload = function (element, url) {
    jQuery(element).click(function(){
        var width = 530, height = 120;
        var left = (screen.width - width) / 2;
        var top = (screen.height - height) / 2 - 50;

        // 上传文件类型
        var type = jQuery(element).attr("data-type");
        // 上传文件模型
        var model = jQuery(element).attr("data-model");
        // 返回input和img的ID
        var id = jQuery(element).attr("data-id");

        window.open(
            Layout.domain + Layout.phpself + url + "?type=" + type + "&id=" + id + "&model=" + model,
            "uploadFile",
            "width=" + width + ",height=" + height + ",top=" + top + ",left=" + left
            );
    });
}

/**
 * AJAX加载更多
 */
Layout.ajaxPage = function (url, params) {
    jQuery(window).scroll(function () {
        if (jQuery(window).scrollTop() >= jQuery(document).height() - jQuery(window).height()) {
            jQuery.ajax({
                type: "post",
                async: false,
                cache: false,
                url: url,
                data: params,
                success: function(data){
                    return data;
                }
            });
        }
        return null;
    });
}

/**
 * 刷新验证码
 */
Layout.captcha = function (element) {
    // 文本档刷新
    jQuery("input" + element).focus(function(){
        var val = jQuery("input" + element).val();
        if (!val) {
            var timenow = new Date().getTime();
            var url = jQuery("img" + element).attr("src");
            var array = url.split("?");
            jQuery("img" + element).attr("src", array[0] + "?" + timenow);
        }
    });

    // 图片刷新
    jQuery("img" + element).click(function(){
        var timenow = new Date().getTime();
        var url = jQuery("img" + element).attr("src");
        var array = url.split("?");
        jQuery("img" + element).attr("src", array[0] + "?" + timenow);
        jQuery("input" + element).val("");
    });
}

/**
 * 确认操作
 */
Layout.confirmOperation = function (element, lang) {
    jQuery(element).click(function(){
        return confirm(lang);
    });
}

/**
 * 点击提交表单
 * 用于a button等标签
 */
Layout.formSubmit = function (element, form) {
    jQuery(element).click(function(){
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

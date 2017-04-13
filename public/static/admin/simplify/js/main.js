/**
 * 删除相册文件
 */
Layout.delAlbum = function (element, ele) {
    jQuery(document).on("click", element, function(){
        var id = jQuery(this).attr("date-id"),
        image = jQuery("#album-image-" + id).val(),
        thumb = jQuery("#album-thumb-" + id).val();
        if (image || thumb) {
            jQuery.ajax({
                type: 'post',
                async: false,
                cache: false,
                url: Layout.domain + Layout.phpself + "account/delupload.shtml",
                data: {image: image, thumb: thumb},
                success: function(data){
                }
            });
        }
        jQuery(ele + id).remove();
    });
}

/**
 * 添加相册上传表单
 */
Layout.addAlbum = function (element, ele) {
    jQuery(document).on("click", element, function(){
        var num = jQuery(ele + ' li').length;
        num++;
        var html = "<li id='album-"+num+"'><input type='text' name='album_image[]' id='album-image-"+num+"' class='form-control'><input type='hidden' name='album_thumb[]' id='album-thumb-"+num+"' class='form-control'><img src='' id='img-album-"+num+"' width='100' style='display:none'><button type='button' class='btn btn-success btn-sm np-upload' data-type='album' data-id='"+num+"' data-model=''>上传</button><button type='button' class='btn btn-success btn-sm np-album-del' date-id='"+num+"'>删除</button></li>";
        jQuery(ele).append(html);
    });
}

/**
 * 栏目 - 字段 - 选择字段所属栏目
 */
Layout.fieldsCategory = function (element, url) {
    jQuery(document).on("change", element, function(){
        var id = jQuery(this).val();
        var type = jQuery(this).attr('data-type');
        if (!id) {
            return false;
        }

        var params = {
            "type": "post",
            "url": Layout.domain+Layout.phpself+url,
            "data": {"id": id, "type": type}
        };
        var result = Layout.ajax(params);
        if (type == 1) {
            jQuery('.op').remove();
        }
        jQuery('#category_id_' + type).after(result);
    });
}

/**
 * 选择地区
 */
Layout.selectRegion = function (element, url) {
    jQuery(document).on("change", element, function(){
        var id = jQuery(this).val(), type = jQuery(this).attr('data-type');

        var params = {
            "type": "post",
            "url": Layout.domain+Layout.phpself+url,
            "data": {"id": id}
        };
        var result = Layout.ajax(params);
        jQuery(type + ' option.op').remove();
        jQuery(type).append(result);
    });
}

/**
 * 上传窗口
 */
Layout.newWinUpload = function (element, url) {
    jQuery(document).on("click", element, function(){
        var width = 530, height = 120;
        var left = (screen.width - width) / 2;
        var top = (screen.height - height) / 2 - 50;

        // 上传文件类型
        var type = jQuery(this).attr("data-type");
        // 上传文件模型
        var model = jQuery(this).attr("data-model");
        // 返回input和img的ID
        var id = jQuery(this).attr("data-id");

        window.open(
            Layout.domain + Layout.phpself + url + "?type=" + type + "&id=" + id + "&model=" + model,
            "uploadFile",
            "width=" + width + ",height=" + height + ",top=" + top + ",left=" + left
            );
    });
}

/**
 * 刷新验证码
 */
Layout.captcha = function (element) {
    // 文本档刷新
    jQuery(document).on("focus", "input" + element, function(){
        var val = jQuery("input" + element).val();
        if (!val) {
            var timenow = new Date().getTime();
            var url = jQuery("img" + element).attr("src");
            var array = url.split("?");
            jQuery("img" + element).attr("src", array[0] + "?" + timenow);
        }
    });

    // 图片刷新
    jQuery(document).on("click", "img" + element, function(){
        var timenow = new Date().getTime();
        var url = jQuery("img" + element).attr("src");
        var array = url.split("?");
        jQuery("img" + element).attr("src", array[0] + "?" + timenow);
        jQuery("input" + element).val("");
    });
}
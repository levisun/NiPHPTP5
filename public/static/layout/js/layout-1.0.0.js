var Layout = new Object;

Layout.VERSION = '1.0.0';
Layout.domain  = null;
Layout.phpself = null;

/**
 * 删除元素
 */
Layout.remove = function (element) {
	jQuery(element).remove();
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
			Layout.domain + url + "?type=" + type + "&id=" + id + "&model=" + model,
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
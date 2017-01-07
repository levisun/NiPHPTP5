/**
 * 刷新验证码
 */
function NPVerify(idClass_) {
	var url = jQuery(idClass_).attr("data-url");
	var timenow = new Date().getTime();
	jQuery(idClass_).attr("src", url+"?"+timenow);
}

/**
 * 上传窗口
 */
function NPUpload(idClass_, url_) {
	var width = 530;
	var height = 120;
	var left = (screen.width - width) / 2;
	var top = (screen.height - height) / 2 - 50;

	// 上传文件类型
	var type = jQuery(idClass_).attr("data-type");
	// 上传文件模型
	var model = jQuery(idClass_).attr("data-model");
	// 返回input和img的ID
	var id = jQuery(idClass_).attr("data-id");

	window.open(domain + url_ + "&type="+type+"&id="+id+"&model="+model, "uploadFile", "width="+width+",height="+height+",top="+top+",left="+left);
}

jQuery(function($){

});
jQuery(function($){
	jQuery(window).scroll(function () {
		if (jQuery(window).scrollTop() >= 100) {
			jQuery("#scrollTop").fadeIn(1000);
		} else {
			jQuery("#scrollTop").fadeOut(500);
		}
	});

	//当点击跳转链接后，回到页面顶部位置
	jQuery("#scrollTop").click(function(){
		jQuery("body,html").animate({scrollTop:0}, 300);
		return false;
	});


	jQuery(window).scroll(function () {
		// 滚动到底部
		if (jQuery(window).scrollTop() >= jQuery(document).height() - jQuery(window).height()) {
			// alert('ffff');
			/*
			jQuery.ajax({
				type: "post",
				async: false,
				url: "",
				data: {id: id},
				success: function(data){
					jQuery().remove();
					jQuery().append(data);
				}
			});
			*/
		};
	});
});
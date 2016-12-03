<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
wx.config({
	debug: false,
	appId: '{$signPackage.appId}',
	timestamp: {$signPackage.timestamp},
	nonceStr: '{$signPackage.nonceStr}',
	signature: '{$signPackage.signature}',
	jsApiList: [
		'onMenuShareTimeline',
		'onMenuShareAppMessage'
	]
});
wx.ready(function(){
	wx.onMenuShareTimeline({
		title: '风靡全国的1元惊喜，1元就可能实现大梦想！快来一起实现大梦想吧！',
		desc: '{$goods.goods_style_name}',
		link: 'http://www.youtuiyou.com/m/oneyuan_goods.php?id={$smarty.get.id}',
		imgUrl: 'http://www.youtuiyou.com/{$goods.goods_thumb}',
		trigger: function (res) {
			// 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
			//alert('用户点击分享到朋友圈');
		},
		success: function (res) {

		},
		cancel: function (res) {
		},
		fail: function (res) {
			alert(JSON.stringify(res));
		}
	});
	wx.onMenuShareAppMessage({
		title: '风靡全国的1元惊喜，1元就可能实现大梦想！快来一起实现大梦想吧！',
		desc: '{$goods.goods_style_name}',
		link: 'http://www.youtuiyou.com/m/oneyuan_goods.php?id={$smarty.get.id}',
		imgUrl: 'http://www.youtuiyou.com/{$goods.goods_thumb}',
		trigger: function (res) {
			// 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
			// alert('用户点击发送给朋友');
		},
		success: function (res) {
		},
		cancel: function (res) {
		},
		fail: function (res) {
			alert(JSON.stringify(res));
		}
	});
});
</script>
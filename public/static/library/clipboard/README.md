复制
<button class="btn" data-clipboard-action="copy" data-clipboard-target="div">复制</button>
<script>
var clipboard = new Clipboard('.btn');

clipboard.on('success', function(e) {
    console.log(e);
    alert("复制成功！");
});

clipboard.on('error', function(e) {
    console.log(e);
});
</script>
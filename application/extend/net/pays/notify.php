<meta charset="UTF-8">
<?php
include('./Pay.class.php');
include('./WxPay.class.php');

$pay = new WxPay();
$pay->notify();
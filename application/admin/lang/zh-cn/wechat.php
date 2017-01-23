<?php
return [
    'server'         => 'URL(服务器地址)',
    'token'          => 'Token(令牌)',
    'encodingaeskey' => 'EncodingAESKey(消息加解密密钥)',
    'appid'          => 'AppID(应用ID)',
    'appsecret'      => 'AppSecret(应用密钥)',

    'error wechattoken require'          => 'Token(令牌)不得为空',
    'error wechatencodingaeskey require' => 'EncodingAESKey(消息加解密密钥)不得为空',
    'error wechatappid require'          => 'AppID(应用ID)不得为空',
    'error wechatappsecret require'      => 'AppSecret(应用密钥)不得为空',


    'keyword'  => '关键词',
    'title'    => '回复标题',
    'reply'    => '回复内容',
    'image'    => '回复图片',
    'url'      => '跳转链接',
    'img info' => '图片为空是文字消息，不为空是图文消息。',

    'error keyword require'    => '关键词不得为空',
    'error keyword length not' => '关键词长度不得小于2位长大于30位',
    'error title require'      => '回复标题不得为空',
    'error title max'          => '回复标题长度不得大于50位',
    'error content require'    => '回复内容不得为空',
    'error content max'        => '回复内容长度不得大于500位',
    'error type number'        => '回复类型格式不正确',
    'error image max'          => '回复图片长度不得大于250',
    'error url require'        => '跳转链接不得为空',
    'error url max'            => '跳转链接长度不得大于500',
];

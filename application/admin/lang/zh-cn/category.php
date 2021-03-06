<?php
return [
    // 栏目
    'show child'    => '查看子栏目',
    'add child'     => '添加子栏目',
    'name'          => '栏目名',
    'aliases'       => '别名',
    'type'          => '栏目类型',
    'parent'        => '上级栏目',
    'model'         => '模型',
    'isshow'        => '显示',
    'ischannel'     => '频道页',
    'image'         => '栏目图片',
    'title'         => '标题',
    'keywords'      => '关键词',
    'description'   => '描述',
    'access'        => '权限',
    'url'           => '链接地址',
    'select model'  => '请选择所属模型',
    'select parent' => '顶级栏目',
    'select access' => '请选择访问权限',

    'error catname require'    => '栏目名称不得为空',
    'error catname length not' => '栏目长度不得小于2位并大于250位',
    'error catname unique'     => '栏目名已存在',
    'error aliases length not' => '别名长度不得小于4位并大于250位',
    'error aliases unique'     => '别名已存在',
    'error aliases alpha'      => '别名必须为字母',
    'error type'               => '栏目类型不得为空并必须为数字',
    'error model'              => '栏目模型不得为空并必须为数字',
    'error access'             => '访问权限不得为空并必须为数字',
    'error url'                => '链接地址格式不正确',
    'error child remove'       => '该栏目下有子栏目，请先删除子栏目',

    'modelname'                  => '模型名',
    'tablename'                  => '表名',
    'modeltable'                 => '基于模型',

    'error modelname require'    => '请输入模型名',
    'error modelname length not' => '模型名长度不得小于4位并大于250位',
    'error modelname unique'     => '模型名已存在',
    'error tablename require'    => '请输入表名',
    'error tablename length not' => '表名长度不得小于4位并大于250位',
    'error tablename unique'     => '表名已存在',
    'error tablename alpha'      => '表名必须为字母',
    'error modeltable require'   => '基于模型不得为空',
    'error modeltable alpha'     => '基于模型必须为字母',
    'error remark length not'    => '备注长度不得大于200位',
    'error status number'        => '状态必须为数字',
    'error system model'         => '系统模块禁止删除',

    'fieldsname'                         => '字段名',
    'fieldscategory'                     => '所属栏目',
    'fieldstype'                         => '字段类型',
    'isrequire'                          => '必填',
    'select category'                    => '请选择所属栏目',
    'select type'                        => '请选择字段类型',
    'error fieldsname require'           => '字段名不得为空',
    'error fieldscategory require array' => '所属栏目不得为空',
    'error fieldstype require number'    => '字段类型不得为空并必须为数字',
    'error isrequire require number'     => '是否为必填不得为空并必须为数字',

    'type text'     => '文本类型',
    'type number'   => '数字类型',
    'type email'    => '邮箱类型',
    'type url'      => '超链接类型',
    'type currency' => '货币类型',
    'type abc'      => '字母类型',
    'type idcards'  => '身份证类型',
    'type phone'    => '移动电话类型',
    'type landline' => '固话类型',
    'type age'      => '年龄类型',
    'type date'     => '日期类型',

    'typename'                     => '分类名',
    'error typename require'       => '分类名不得为空',
    'error typename length not'    => '分类名长度不得小于2位并大于250位',
    'error category_id require'    => '所属栏目不得为空',
    'error category_id number'     => '所属栏目必须为数字',
    'error description length not' => '备注长度不得大于500位',

    'ctype top'   => '顶部导航',
    'ctype main'  => '主导航',
    'ctype foot'  => '底部导航',
    'ctype other' => '其它导航',
];

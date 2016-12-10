# NiPHPTP5

> NiPHPTP5的运行环境要求PHP5.4以上。

> NiPHPTP5基于ThinkPHP5框架开发，使用时请先下载[ThinkPHP5框架](http://www.thinkphp.cn/)

> 安装ThinkPHP5框架后，替换application和public目录。

## 目录结构

~~~
www  WEB部署目录（或者子目录）
├─application           应用目录
│  ├─admin              后台管理模块目录
│  │  ├─controller      控制器目录
│  │  ├─lang            语言包目录
│  │  ├─logic           业务目录
│  │  ├─model           模型目录
│  │  ├─validate        验证器目录
│  │  ├─view            视图目录
│  │  ├─common.php      模块函数文件
│  ├─config             配置目录
│  │  ├─admin           后台配置目录
│  │  ├─index           前台配置目录
│  │  ├─command.php     命令行工具配置文件
│  │  ├─config.php      公共配置文件
│  │  ├─database.php    数据库配置文件
│  │  ├─route.php       路由配置文件
│  │  ├─tags.php        应用行为扩展定义文件
│  ├─extend             扩展类库目录
│  ├─index              前台模块目录
│  │  ├─controller      控制器目录
│  │  ├─lang            语言包目录
│  │  ├─logic           业务目录
│  │  ├─validate        验证器目录
│  │  ├─common.php      模块函数文件
│  ├─common             公共模块目录（可以更改）
├─public                WEB目录（对外访问目录）
│  ├─backup             数据库备份目录
│  ├─static             静态库目录
│  ├─theme              模板目录
│  ├─upload             上传目录
│  └─.htaccess          用于apache的重写
│  ├─admin.php          后台模块入口文件
│  ├─index.php          前台入口文件
│  ├─router.php         快速测试文件
│
~~~

## 版权信息

版权所有Copyright © 2006-2016 by niphp.com (http://niphp.com)

All rights reserved。
# xhgui
中文简化版xhgui，并修复其中部分bug，去掉了composer中php相关部分的依赖引入
去掉了原始的install.php,单元测试及nginx配置信息,
修复了目前已发现的部分xhgui问题。

# 相关前提
1. 本地已经安装好mongo
2. 本地已经有php环境

# 安装文档
参考：https://zhuanlan.zhihu.com/p/144500444

关键点：

## PHP配置

我的docker中是apache，所以用另外一种方案，直接进入docker后修改一下php.ini配置:

auto_prepend_file=/你的XHGUI路径/xhgui/external/header.php

## XHGui 配置Mongodb

直接修改xhgui/config/config.default.php 其中mongodb的ip地址请根据本地实际情况来

'db.host' => getenv('XHGUI_MONGO_HOST') ?: 'mongodb://172.17.0.9:27017',
'db.db' => getenv('XHGUI_MONGO_DATABASE') ?: 'xhprof',

## XHGui 配置生成日志的频率，采样规则

还是修改config.default.php中的配置信息

'profiler.enable' => function() { 
   // url 中包含debug=1则百分百捕获 
   // 说明，这里可以加上自定义的采样规则，可以通过$_SERVER等来判断
   if(!empty($_GET['debug'])){ 
       return True; 
   }else{ 
       // 1%采样 
       return rand(1, 100) === 42; 
   } 
} 
## mongo 配置

mongo 
> use xhprof 
> db.results.ensureIndex( { 'meta.SERVER.REQUEST_TIME' : -1 } ) 
> db.results.ensureIndex( { 'profile.main().wt' : -1 } ) 
> db.results.ensureIndex( { 'profile.main().mu' : -1 } ) 
> db.results.ensureIndex( { 'profile.main().cpu' : -1 } ) 
> db.results.ensureIndex( { 'meta.url' : 1 } ) 


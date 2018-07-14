<?php
require_once '../mini/core/FrameWork.php';
use mini\core\FrameWork as FrameWork;

//加载并实例化控制器
$results = FrameWork::init();
//获取模块、控制器和操作的值
$module = $results['module'];
$controller = $results['controller'];
$action = $results['action'];
//定义文件路径
$parent_directory = dirname(dirname(__FILE__));//获取上级目录
$parent_directory = str_replace('\\','/',$parent_directory);//修改目录分隔符
//获取网站的URL
$site_address = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'];
//定义框架根目录
define('__ROOT__',$parent_directory.'/');
//定义static目录
define('__STATIC__',$site_address.'/static');//在模板中使用{$smarty.const.__STATIC__}
//定义view目录
define('__VIEW__',$parent_directory.'/application/'.$module.'/view/');
//定义runtime路径
define('__RUNTIME__',$parent_directory.'/runtime/');
//定义自动加载的文件
$files = [
    'helper' => __ROOT__.'mini/core/helper.php',
    'database' => __ROOT__.'config/database.php',
    'db' => __ROOT__.'mini/db/Db.php',
    'model' => __ROOT__.'mini/db/Model.php',
    'template' => __ROOT__.'mini/template/View.php',
    'paginate' => __ROOT__.'mini/plugins/pagination.php',
];
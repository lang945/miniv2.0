<?php

//加载控制器文件
require_once realpath(dirname(dirname(dirname(__FILE__))).'/config/load.php');
require_once realpath(dirname(dirname(dirname(__FILE__))).'/application/'.$module.'/controller/'.$controller.'.php');

/*
 *
 *实例化控制器类
 * 1.使用new关键字实例化
 * 2.使用ReflectionClass()方式实例化
 */

/*
 * 方法1
 * use application\index\controller as Index;
 *$instance = new Index\Index();
 *$instance->index();
 *
*/
//定义带有名称空间的类名
define('__CLASS_NAME__','application\\'.$module.'\\controller\\'.$controller);
//方法2

try {
    $class = new ReflectionClass(__CLASS_NAME__);//建立控制器类的反射类
    $instance = $class->newInstanceArgs();//实例化控制器类
    $method = $class->getMethod($action);//获取控制器类中的方法
    $method->invoke($instance);//执行$action方法
    //var_dump($instance);
    //var_dump($method);
} catch (Exception $e) {
    die("Not gonna make it in here:".$e->getMessage());//not gonna make is in here翻译为'不会在这里实现'
}


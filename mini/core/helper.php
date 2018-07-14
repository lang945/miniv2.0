<?php

//定义dump的助手函数
function dump($var)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

//定义get助手函数
function get($param=null)
{
    //获取所有的URL参数值
    if(is_null($param)){
        return $_GET ? $_GET : false;
    }
    //获取单个URL参数值
    return isset($_GET[$param]) ? $_GET[$param] : false;
}

//定义post助手函数
function post($param=null)
{
    //获取所有的URL参数值
    if(is_null($param)){
        return $_POST ? $_POST : false;
    }
    //获取单个URL参数值
    return isset($_POST[$param]) ? $_POST[$param] : false;
}
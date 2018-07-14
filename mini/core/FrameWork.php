<?php

namespace mini\core;

class FrameWork
{
    private static $results;

    //初始化方法
    public static function init()
    {
        //获取URL关键信息
        $requestUri = $_SERVER['REQUEST_URI'];
        $scriptName = $_SERVER['SCRIPT_NAME'];
        //解析URL
        $request = str_replace($scriptName,'',$requestUri);
        $request = ltrim($request,'/');
        $requestArray = explode('?',$request);
        $moduleControllerAction = $requestArray[0];
        $moduleControllerAction = explode('/',$moduleControllerAction);
        //array_filter()方法是过滤掉数组中值为null,false和''的元素
        $moduleControllerAction = array_filter($moduleControllerAction);
        //定义默认模块、控制器和操作
        $defaultConfig = [
            'module' => 'index',
            'controller' => 'Index',
            'action' => 'index',
        ];
        //返回module、controller和action
        if(count($moduleControllerAction) < 3){
            if(isset($moduleControllerAction[0])) {
                if ($moduleControllerAction[0] == 'index') {
                    if (isset($moduleControllerAction[1])) {
                        if ($moduleControllerAction[1] == 'index') {
                            self::$results = ['module' => $defaultConfig['module'], 'controller' => $defaultConfig['controller'], 'action' => $defaultConfig['action']];
                        }
                    } else {
                        self::$results = ['module' => $defaultConfig['module'], 'controller' => $defaultConfig['controller'], 'action' => $defaultConfig['action']];
                    }
                }
            }else{
                self::$results = ['module' => $defaultConfig['module'], 'controller' => $defaultConfig['controller'], 'action' => $defaultConfig['action']];
            }
        }else{
            self::$results = ['module' => $moduleControllerAction[0],'controller' => $moduleControllerAction[1],'action' => $moduleControllerAction[2]];
        }
        return self::$results;
    }
}

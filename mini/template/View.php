<?php

namespace{
    require_once 'libs/Smarty.class.php';
}

namespace mini\template {

    class View
    {
        protected static $smarty;
        protected $flag = 0;
        public $e = 0;

        public function __construct()
        {
            //初始化Smarty类
            self::$smarty = new \Smarty();
        }

        protected function view($template,$params=null,$cache_id=null)
        {
            //自定义设置Smarty相关的属性
            self::$smarty->setTemplateDir(__VIEW__.$template);//设置模版文件路径
            self::$smarty->setCompileDir(__RUNTIME__.'temp/');//设置编译后文件存放路径
            //self::$smarty->setLeftDelimiter('{% ');//设置左边定界符
            //self::$smarty->setRightDelimiter(' %}');//设置右边定界符
            self::$smarty->caching = true;//开启缓存
            self::$smarty->cache_lifetime = 30;//设置缓存有效时间为30秒
            self::$smarty->setCacheDir(__RUNTIME__.'cache/');//设置缓存目录
            //self::$smarty->setPluginsDir('libs/plugins/');//设置模板扩充插件路径
            //self::$smarty->setConfigDir('config/');//设置配置文件目录
           //调用assign方法
            if(!$this->flag && !is_null($params)){
                $this->assign($params,null);
            }
            //调用Smarty类的display方法
            try{
                self::$smarty->display(__VIEW__.$template,$cache_id);
                /*
                if(self::$smarty->isCached(__VIEW__.$template)){
                    echo 'All data have cached...';
                }
                */
                $this->e = 1;
            }catch(\Exception $e){
                $this->e = $e->getMessage();
            }

            return $this->e;
        }

        protected function assign($param,$value=null,$isCached=false){
            //调用Smarty类的assign方法
            if(is_array($param)){
                self::$smarty->assign($param,null,$isCached);
            }else{
                self::$smarty->assign($param,$value,$isCached);
            }
            $this->flag = 1;
        }
    }
}
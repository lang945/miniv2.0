<?php

namespace mini\template\custom;
use mini\template\custom\Tags as Tag;

class View
{
    //定义成员属性
    protected $args,$isTag;
    private $flag = 0;
    private $isStr = 0;
    public $file;

    //加载视图
    public function view($template,$params=null)
    {
        //给模板变量赋值
        if(!$this->flag && !is_null($params)){
            $result = $this->assign($params);
            if(gettype($result) == 'array'){
                $tag = new Tags();
                //dump($result);
                $tag->swap($template,$result);//使用swap方法渲染模版
            }
            if($this->isStr){
                //使用render方法渲染模板
                $this->render(__VIEW__.$template,__ROOT__.'runtime/temp/');
            }
        }else{
            if(gettype($this->isTag) == 'array'){
                //dump($this->isTag);
                $tag = new Tags();
                $tag->swap($template,$this->isTag);//使用swap方法渲染模版
            }
            if($this->isStr){
                //使用render方法渲染模板
                $this->render(__VIEW__.$template,__ROOT__.'runtime/temp/');
            }
        }
    }

    //视图的渲染
    public function render($source,$destination)
    {
        //获取模板文件内容
        $contents = file_get_contents($source,FILE_USE_INCLUDE_PATH);
        //替换文件的内容
        $updateContents = str_replace("{\$","<?php echo htmlentities(\$this->args['",$contents);
        $updateContents = preg_replace("/}/","']);?>",$updateContents);
        //将修改后的文件内容保存到另一个文件
        $this->file = time().'.php';
        file_put_contents($destination.$this->file,$updateContents);
        //重新加载文件
        require_once ''.$destination.$this->file.'';
    }

    //模板变量赋值
    public function assign($key,$value=null)
    {
        if(is_array($key)){
            foreach($key as $k => $v){
                if(gettype($v) == 'array') {
                    $this->isTag = $v;
                }else{
                    $this->args[$k] = $v;
                    //dump($this->args[$k]);
                    $this->isStr = 1;
                }
            }
        }else{
            if(is_array($value)){
                $this->isTag = $value;
            }else{
                $this->args[$key] = $value;
                $this->isStr = 1;
            }
        }
        $this->flag = 1;
        return $this->isTag;
    }
}
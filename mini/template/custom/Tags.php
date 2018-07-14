<?php

namespace mini\template\custom;

class Tags
{
    protected $file;
    private $args,$i;

    public function swap($template,$param){
        $this->for(__VIEW__.$template,__ROOT__.'runtime/temp/',$param);
    }

    private function for($source,$destination,$params)
    {
        //获取模板文件内容
        $contents = file_get_contents($source,FILE_USE_INCLUDE_PATH);
        //替换文件的内容
        /*
        if(is_array($params)){
            foreach($params as $key => $value){
                $this->args = $params[$key];
                //dump($this->args);
            }
        }else{
            $params = explode(',',$params);
            $this->args = $params[0];
        }
        */
        $this->args = $params;
        $updateContents = preg_replace('/{\s{0,}list name=\'\$\w+\'(\s){0,},(\s){0,}id=/',"<?php \n for(\$this->i=0;\$this->i<count(",$contents);
        $updateContents = preg_replace('/\'\$\w+\'\s{0,}}/',"\$this->args)-1;\$this->i++){\n echo \"<pre>\";",$updateContents);
        $updateContents = preg_replace('/{\$\w+\./',"echo htmlentities(\$this->args[\$this->i]['",$updateContents);
        $updateContents = preg_replace('/}/',"']);",$updateContents);
        $updateContents = preg_replace("/({\/\s{0,}list\s{0,}\'\]\);)/","echo \"</pre>\";} \n ?>",$updateContents);


        //将修改后的文件内容保存到另一个文件
        $this->file = time().'.php';
        file_put_contents($destination.$this->file,$updateContents);
        //重新加载文件
        require_once ''.$destination.$this->file.'';
    }
}

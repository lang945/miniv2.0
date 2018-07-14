<?php
namespace{
    //判断APP_PATH是否定义过，已达到路径访问控制
    defined('APP_PATH') OR exit('access is denied...');
}
namespace application\index\controller {

    use mini\template\View as View;

    class Index extends View
    {
        public function index()
        {
            $title = 'mini';
            $content = ":)\n欢迎使用mini框架";
            //模板变量赋值
            $this->assign('title', $title);
            $this->assign('content', $content);
            //渲染模板
            $this->view('index/index.html');
        }
    }
}
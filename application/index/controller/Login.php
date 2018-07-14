<?php

namespace{
    defined('APP_PATH') OR exit('access is denied...');
}
namespace application\index\controller {

    class Login extends \mini\template\View
    {
        public function index()
        {
            $title = '用户登录';
            $content = 'Hi,World...';
            //模板赋值
            /*
            $this->assign('title',$title);
            $this->assign('content',$content);
            */
            //$this->assign(['title' => $title,'content' => $content]);

            $this->view('index/login.html', ['title' => $title, 'content' => $content]);
        }
    }
}
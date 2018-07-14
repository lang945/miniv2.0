<?php
namespace{
    //判断APP_PATH是否定义过，已达到路径访问控制
    defined('APP_PATH') OR exit('access is denied...');
}
namespace application\admin\controller {

    use mini\db\Db as Db;
    use mini\db\Model as Model;
    use mini\template\View as View;

    class Index extends View
    {
        protected $args;

        public function index()
        {
            $title = 'mini';
            $content = ":)\n欢迎使用mini框架";
            //模板变量赋值
            $this->assign(['title' => $title,'content' => $content]);
            //渲染模板
            $this->view('index/index.html');
        }

        public function db()
        {
            //$row = Db::paginate('user',get('page'),3,'id>=4','id desc');
            //dump($row);
            $title = "Hi";
            $row = Model::table('user')
                       ->paginate(3);

            $this->assign(['title' => $title,'content' => $row]);
            $this->view('index/user.html');
        }
    }
}
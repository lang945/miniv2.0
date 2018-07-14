<?php

namespace mini\db {

    class Db
    {
        private static $instance;
        protected static $db,$stmt,$sql,$result;
        public static $key,$value;

        //禁止外部调用构造方法
        private function __construct()
        {
            //dump(\CONNECTION['type']);
        }

        //禁止外部访问clone方法
        private function __clone()
        {

        }

        //使用特定的方法进行类的实例化
        public static function newInstance()
        {
            if( !(self::$instance instanceof self) ){
                self::$instance = new static();
            }
            return self::$instance;
        }
        //连接方法
        private static function connect()
        {
            try {
                //连接数据库
                self::$db = new \PDO("".\CONNECTION['type'].":host=".\CONNECTION['host'].";dbname=".\CONNECTION['database']."", "".\CONNECTION['user']."", "".\CONNECTION['password']."");
            } catch (\PDOException $e) {
                die('Fatal error:' . $e->getMessage());
            }
        }

        //sql语句的limit子句
        public static function limit($value)
        {
            self::$sql = '';

            for($i=0;$i<count($value)-1;$i++):
                $value[$i] = gettype($value[$i]) == 'string' ? 0 : $value[$i];
                $value[$i+1] = gettype($value[$i+1]) == 'string' ? 1 : $value[$i+1];
                self::$sql .= " limit ".$value[$i].",".$value[$i+1];
            endfor;
            return self::$sql;
        }

        //sql语句的where条件设置
        public static function where($params)
        {
            self::$sql = '';
            self::$value = '';

            if(is_array($params)){
                foreach($params as $key => $value){
                    self::$sql .= $key . "=:".$key." and ";
                    self::$value .= "$value,";
                    self::$key .= ":$key,";
                }
                self::$sql = preg_replace('/and $/', '',self::$sql);
                //处理key和value
                self::$key = explode(',',self::$key);
                self::$key = array_filter(self::$key);
                self::$value = explode(',',self::$value);
                self::$value = array_filter(self::$value);
                for($i=0;$i<count(self::$key);$i++){
                    self::$key[''.self::$key[$i].''] = self::$value[$i];
                    unset(self::$key[$i]);
                }
            }else{
                self::$sql .= self::escape($params);//sql拼接容易引发sql注入,需要对特殊字符进行转义;
            }
            //dump(self::$key);
            //dump("where=".self::$sql);
            return " where ".self::$sql;
        }
        //针对sql中的特殊字符进行过滤
        private static function escape($string){
            //转义分号
            $string = str_replace(";","?",$string);
            //转义引号
            $string = str_replace("'","?",$string);
            $string = str_replace("\"","?",$string);
            //转义'--'和'\'
            $string = str_replace("--","?",$string);
            $string = str_replace("\\","?",$string);
            //禁用or防止类似于'or 1=1'的sql攻击
            $string = str_replace(" or",'?',$string);
            return $string;
        }

        //sql语句的查询显示列内容设置
        public static function field($variables)
        {
            self::$sql = '';

            if(!is_null($variables)){
                self::$sql .= "select ".self::escape($variables)." from ";//sql拼接容易引发sql注入,需要对特殊字符进行转义;
            }
            return self::$sql;
        }
        //sql语句中order语句设置
        public static function order($statement=null)
        {
            self::$sql = '';

            if(!is_null($statement)){
                self::$sql .= " order by ".self::escape($statement);
            }
            return self::$sql;
        }

        //query查询方法
        public static function query($table,$fields=null,$where=null,$order=null,$limit=null)
        {
            //连接数据库
            self::connect();

            //分情况查询数据
            if (!is_null($fields) && !empty($fields)) {
                //获取指定数据
                if(!is_null($where) && !empty($where)){
                    if(!is_null($order) && !empty($order)){
                        if(!is_null($limit) && !empty($limit)){
                            self::$sql = self::field($fields).self::escape($table).self::where($where).self::order($order).self::limit($limit);//sql拼接容易引发sql注入,需要对特殊字符进行转义
                        }else{
                            self::$sql = self::field($fields).self::escape($table).self::where($where).self::order($order);
                        }
                    }else{
                        if(!is_null($limit) && !empty($limit)){
                            self::$sql = self::field($fields).self::escape($table).self::where($where).self::limit($limit);
                        }else{
                            self::$sql = self::field($fields).self::escape($table).self::where($where);
                        }
                    }
                }else{
                    if(!is_null($order) && !empty($order)){
                        if(!is_null($limit) && !empty($limit)){
                            self::$sql = self::field($fields).self::escape($table).self::order($order).self::limit($limit);
                        }else{
                            self::$sql = self::field($fields).self::escape($table).self::order($order);
                        }
                    }else{
                        if(!is_null($limit) && !empty($limit)){
                            self::$sql = self::field($fields).self::escape($table).self::limit($limit);
                        }else{
                            self::$sql = self::field($fields).self::escape($table);
                        }
                    }
                }

                //dump(self::$sql);
                //dump(self::$key);
                self::$stmt = self::$db->prepare(self::$sql);
                self::$stmt->execute(self::$key);
                while($row = self::$stmt->fetchAll(self::$db::FETCH_ASSOC)){
                    self::$result = $row;
                    //dump($row);
                };
            } else {
                //获取所有数据
                //查询数据
                /*
                *sql注入语句
                *1.分号
                $sql = "select * from user where id = 2;delete from user where id = 2";
                $user = "'lang';update user set password = '1234567890' where user = 'lang' -- \'";
                $sql = "select user,password from user where user = $user and password = 'P@ssw0rd123'";
                *2.分号和引号以及横杠反斜杠
                $user = "admin' ;update user set password = '0123456aa' where user = 'admin' -- \'";
                $sql = "select user,password from `$table` where user = '$user' and password = '123456' ";
                //使用query查询:根本无法防止sql注入
                foreach (self::$db->query($sql) as $row) {
                    dump($row);
                }
                //使用预处理语句查询
                self::$stmt = self::$db->prepare($sql);//到这步还是无法防止sql注入
                self::$stmt = self::$db->prepare($sql);
                self::$stmt->execute(array($user,'0123456aa'));
                */
                /*
                 *防止sql注入的方法:关键在于sql语句的书写
                 *
                 *1.将$sql写成以下形式
                    $sql = "select user,password from `$table` where user = :user and password = :password";
                    self::$stmt = self::$db->prepare($sql);
                    //self::$stmt->execute(array(':user' => $user,':password' => '0123456aa'));
                    //或使用参数绑定
                    self::$stmt->bindParam(':user',$user,PDO::PARAM_STR,12);
                    self::$stmt->bindParam(':password','0123456aa',PDO::PARAM_STR,12);
                *2.将$sql写成以下形式
                    $sql = "select user,password from `$table` where user = ? and password = ?";
                    self::$stmt = self::$db->prepare($sql);
                    //self::$stmt->execute(array($user,'0123456aa'));
                    //或使用参数绑定
                    self::$stmt->bindParam(1,$user,PDO::PARAM_STR,12);
                    self::$stmt->bindParam(2,'0123456aa',PDO::PARAM_STR,12);
                */
                //这里使用第1种方式
                if(!is_null($where) && !empty($where)){
                    if(!is_null($order) && !empty($order)){
                        self::$sql = "select * from ".self::escape($table).self::where($where).self::order($order);
                        //dump(self::$sql);
                    }else{
                        self::$sql = "select * from ".self::escape($table).self::where($where);
                    }
                }else{
                    if(!is_null($order) && !empty($order)){
                        self::$sql = "select * from ".self::escape($table).self::order($order);
                        //dump(self::$sql);
                    }else{
                        self::$sql = "select * from ".self::escape($table);
                    }
                }
                //dump(self::$sql);
                self::$stmt = self::$db->prepare(self::$sql);
                self::$stmt->execute(self::$key);
                while($rows = self::$stmt->fetchAll(self::$db::FETCH_ASSOC)){
                    self::$result = $rows;
                    //dump($rows);
                }
            }
            //关闭游标
            self::$stmt->closeCursor();
            //关闭资源
            self::$stmt = null;
            //关闭连接
            self::$db = null;
            return self::$result;
            //dump(self::$result);
        }

        //find查询方法:仅仅查询1条记录
        public static function find($table,$field=null,$where=null)
        {
            //设置sql语句
            if(!is_null($field) && !empty($field)){
                if(!is_null($where) && !empty($where)){
                    self::$sql = self::field($field).self::escape($table).self::where($where).self::limit([0,1]);
                }else{
                    self::$sql = self::field($field).self::escape($table).self::limit([0,1]);
                }
            }else{
                if(!is_null($where) && !empty($where)){
                    self::$sql = "select * from ".self::escape($table).self::where($where).self::limit([0,1]);
                }else{
                    self::$sql = "select * from ".self::escape($table).self::limit([0,1]);
                }
            }
            //dump(self::$sql);
            //操作数据库
            self::connect();
            self::$stmt = self::$db->prepare(self::$sql);
            //dump(self::$key);
            self::$stmt->execute(self::$key);
            while($row = self::$stmt->fetch(self::$db::FETCH_ASSOC)){
                self::$result = $row;
            }
            //关闭资源
            self::$stmt->closeCursor();
            self::$stmt = null;
            self::$db = null;
            //返回结果
            return self::$result;
        }

        //新增方法
        public static function insert($table,$data)
        {
            //对数据进行处理
            foreach($data as $key => $value):
                    $value = gettype($value) == 'string' ? "'".self::escape($value)."'" : $value;//对字符串进行特殊处理
                    //将key和value分别存储在数组中
                    self::$key[] = "`".$key."`";
                    self::$value[] = $value;
            endforeach;
            //dump(self::$key);
            //书写sql语句
            self::$sql = "insert into ".self::escape($table)."(".implode(',',self::$key).") values(".implode(',',self::$value).")";
            //dump(self::$sql);
            //操作数据库
            self::connect();
            self::$stmt = self::$db->prepare(self::$sql);
            $row = self::$stmt->execute();
            //关闭资源
            self::$stmt = null;
            self::$db = null;
            //返回执行结果
            return $row  == 1 ? '新增了1条数据....' : '操作异常...';
        }

        //更新方法
        public static function update($table,$where,$condition,$values=null)
        {
            self::connect();
            if(is_array($condition)){
                foreach($condition as $key => $value){
                    $value = gettype($value) == 'string' ? "'".self::escape($value)."'" : $value;
                    self::$value[] = $key."=".$value;
                }
                //dump(self::$value);
                self::$value = implode(',',self::$value);
                //dump(self::$value);
                self::$sql = "update ".self::escape($table)." set ".self::$value.self::where($where);
            }else{
                $values = gettype($values) == 'string' ? "'".self::escape($values)."'" : $values;
                self::$sql = "update ".self::escape($table)." set ".self::escape($condition)."=".$values.self::where($where);
            }
            dump(self::$sql);
            dump(self::$key);
            self::$stmt = self::$db->prepare(self::$sql);
            self::$stmt->execute(self::$key);
            $row = self::$stmt->rowCount();//返回上一个由insert,update和delete语句执行后影响的行数
            //关闭资源
            self::$stmt = null;
            self::$db = null;
            //返回结果
            return $row == 1 ? '成功更新了1条数据...' : '更新了0条数据...';
        }

        //删除方法
        public static function delete($table,$variable)
        {
            self::connect();
            self::$sql = "delete from ".self::escape($table).self::where($variable);
            //dump(self::$sql);
            self::$stmt = self::$db->prepare(self::$sql);
            self::$stmt->execute(self::$key);
            $row = self::$stmt->rowCount();
            //关闭资源
            self::$stmt = null;
            self::$db = null;
            //返回结果
            return $row == 1 ? '删除了1条数据...' : '操作失败...';
        }

        //获取表的所有记录
        public static function records($table,$where=null)
        {
            if(!is_null($where) && !empty($where)){
                self::$sql = "select count(*) as count from ".self::escape($table).self::where($where);
            }else{
                self::$sql = "select count(*) as count from ".self::escape($table);
            }
            //执行sql操作
            self::connect();
            self::$stmt = self::$db->prepare(self::$sql);
            self::$stmt->execute();
            $count = self::$stmt->fetch(self::$db::FETCH_ASSOC);
            //关闭资源
            self::$stmt = null;
            self::$db = null;
            return $count['count'];
        }

        //分页显示数据:关键在于页码和每页显示的记录数量设置
        public static function paginate($table,$page,$number,$where=null,$order=null)
        {

            //获取数据库表的所有记录条数
            $count = self::records($table,$where);
            //初始化sql
            self::$sql = '';
            //计算总页数
            $totalPage = ceil($count/$number);
            //pagination($totalPage);
            //设置页码的范围
            $page = max(1,$page);
            //每页的起始数
            $offset = ($page - 1) * $number;
            //书写sql语句
            if(!is_null($where) && !empty($where)){

                if(!is_null($order) && !empty($order)){
                    self::$sql = "select * from ".self::escape($table).self::where($where).self::order($order).self::limit([$offset,$number]);
                }else{
                    self::$sql = "select * from ".self::escape($table).self::where($where).self::limit([$offset,$number]);
                }
            }else{
                self::$sql = "select * from ".self::escape($table).self::limit([$offset,$number]);
            }

            //操作数据库
            self::connect();
            self::$stmt = self::$db->prepare(self::$sql);
            self::$stmt->execute(self::$key);
            while($row = self::$stmt->fetchAll(self::$db::FETCH_ASSOC)){
                self::$result = $row;
            }
            //关闭资源
            self::$stmt->closeCursor();
            self::$stmt = null;
            self::$db = null;
            //返回结果
            self::$result['total'] = $totalPage;
            return self::$result;
        }

        /*
        public function __destruct()
        {
            is_null(self::$db) ? exit('Goodbye...') : exit(self::$db);
        }
        */
    }
}

<?php

namespace mini\db;
use mini\db\Db as Db;

//定义Model类用于'链式操作'
class Model
{
    protected static $table,$fields,$where,$order,$keys,$values;

    public static function table($table=null)
    {
        self::$table = $table;
        return new static();
    }

    public function field($fields=null)
    {
        self::$fields = $fields;
        return $this;
    }

    public function where($where=null)
    {
        self::$where = $where;
        return $this;
    }

    public function order($order=null)
    {
        self::$order = $order;
        return $this;
    }

    public function set($key,$value=null)
    {
        self::$keys = $key;
        self::$values = $value;
        return $this;

    }

    //调用Db类的query方法
    public function select()
    {
        $results = Db::query(self::$table,self::$fields,self::$where,self::$order);
        return $results;
    }

    //调用Db类的find方法
    public function find()
    {
        $result = Db::find(self::$table,self::$fields,self::$where);
        return $result;
    }

    //调用Db类的insert方法
    public function create($data)
    {
        $effect = Db::insert(self::$table,$data);
        return $effect;
    }

    //调用Db类的update方法
    public function update()
    {
        if(!is_null(self::$values)){
            $row = Db::update(self::$table,self::$where,self::$keys);
        }else{
            $row = Db::update(self::$table,self::$where,self::$keys,self::$values);
        }
        return $row;
    }

    //调用Db类的delete方法
    public function delete()
    {
        $effect = Db::delete(self::$table,self::$where);
        return $effect;
    }

    //分页方法
    public function paginate($num)
    {
        $row = Db::paginate(self::$table,get('page'),$num,self::$where,self::$order);
        return $row;
    }
}

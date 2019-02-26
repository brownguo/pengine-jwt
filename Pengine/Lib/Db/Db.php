<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/2/21
 * Time: 下午1:20
 */

class Db
{
    private static $_instance;

    protected $dsn;
    protected $dbh;
    protected $res; //result
    protected static $dbname;

    private function __construct($db_config)
    {
//        try{
//            $this->dsn = sprintf('mysql:host=%s;dbname=%s',$db_config['host'],$db_config['name']);
//
//            $this->dbh = new PDO($this->dsn,$db_config['user'],$db_config['pass']);
//
//            $this->dbh->exec(sprintf('SET character_set_connection=%s,character_set_results=%s,character_set_client=binary',
//                $db_config['charset'],$db_config['charset']));
//
//        }catch (PDOException $e){
//            throw new Exception('MySQL Error: '.$e->getMessage());
//        }
//
//        $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public static function getInstance()
    {
        $config = Config::get('db.mysql');
        if(!(static::$_instance instanceof medoo))
        {
            static::$_instance = new medoo($config);
        }
        return static::$_instance;
    }

    public function __clone()
    {
        trigger_error('Clone is not allow!',E_USER_ERROR);
    }

    public function query($sql,$mode = 'ALL')
    {
        if(is_string($sql) && !empty($sql))
        {
            $recordset = $this->dbh->query($sql);

            if($recordset)
            {
                $this->res = $recordset;
                switch ($mode)
                {
                    case 'ALL':
                        $ret = $this->fetchAll();
                        break;
                    case 'ROW':
                        $ret = $this->fetch();
                }
            }
        }
        return $ret;
    }

    public function exec($sql)
    {
        $res = $this->dbh->query($sql);

        if($res)
        {
            $this->res = $res;
        }
        else
        {
            return $res;
        }
    }

    public function getFields($t_name)
    {
        $sql  = 'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME="'.$t_name.'" AND TABLE_SCHEMA="'.Config::get('db.mysql.name').'"';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $key=>$value)
        {
            $ret[$value['COLUMN_NAME']] = 1;
        }
        return $ret;
    }


    public function fetch()
    {
        return $this->res->fetch();
    }

    public function fetchAll()
    {
        return $this->res->fetchAll();
    }

    public function fetchColumn()
    {
        return $this->res->fetchColumn();
    }

    public function insert($t_name,$data)
    {
        $sql = "INSERT INTO ".$t_name."(".implode(',',array_keys($data)).") VALUES(".implode(',',array_values($data)).")";
        echo $sql;
        return $this->exec($sql);
    }
}
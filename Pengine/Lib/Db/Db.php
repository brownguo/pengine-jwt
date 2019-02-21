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

    private function __construct($db_config)
    {
        try{
            $this->dsn = sprintf('mysql:host=%s;dbname=%s',$db_config['host'],$db_config['name']);

            $this->dbh = new PDO($this->dsn,$db_config['user'],$db_config['pass']);

            $this->dbh->exec(sprintf('SET character_set_connection=%s,character_set_results=%s,character_set_client=binary',
                $db_config['charset'],$db_config['charset']));

        }catch (PDOException $e){
            throw new Exception('MySQL Error: '.$e->getMessage());
        }
    }

    public static function getInstance()
    {
        $config = Config::get('db.mysql');
        if(!(static::$_instance instanceof self))
        {
            static::$_instance = new self($config);
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
                $recordset->setFetchMode(PDO::FETCH_ASSOC);
                switch ($mode)
                {
                    case 'ALL':
                        $ret = $recordset->fetchAll();
                        break;
                    case 'ROW':
                        $ret = $recordset->fetch();
                }
            }
        }
        return $ret;
    }

}
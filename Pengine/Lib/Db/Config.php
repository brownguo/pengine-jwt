<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/2/21
 * Time: 下午3:30
 */

class Config
{
    public $config;
    public $configfilename;

    private function __construct()
    {
        $filename = BASE_PATH.'/App/Config/config.php';
        if(!file_exists($filename))
        {
            throw new Exception(sprintf('Config file [%s] not found',$filename));
        }
        $config = include $filename;
        if(!is_array($config) || empty($config))
        {
            throw new Exception('Invalid config file format');
        }
        $this->config = $config;
        $this->configfilename = $filename;
    }

    public static function instance($domain = 'main')
    {
        static $instance = array();
        if(empty($instance[$domain]))
        {
            $instance[$domain] = new self();
        }

        return $instance[$domain];
    }

    public static function get($uri,$domin = 'main')
    {
        $node  = static::instance($domin)->config;
        $paths = explode('.',$uri);

        while(!empty($paths))
        {
            $path = array_shift($paths);
            if(!isset($node[$path]))
            {
                return null;
            }
            $node = $node[$path];

        }
        return $node;
    }
}
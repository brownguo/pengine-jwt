<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/1/10
 * Time: 9:25 PM
 */

class Pengine
{
    protected static $startTime;

    public function __construct()
    {
        static::$startTime = microtime(true);
    }

    public static function run()
    {
        static::init();
        static::autoload();
        static::dispathch();
        static::checkEnv();
        static::rmRegisterGlobals();
    }

    protected static function init()
    {
        //static::$startTime = microtime(true);
    }

    protected static function autoload()
    {
        spl_autoload_register(function($name)
        {
            $LoadableModules = array('/App/Controller','/App/Model','App/Config','App/Model','App/View');

            foreach ($LoadableModules as $module)
            {
                $filename =  BASE_PATH.$module.'/'.$name . '.php';
                if (file_exists($filename))
                    require_once $filename;
            }
        });
    }

    protected static function dispathch()
    {
        $Uri      = $_SERVER['REQUEST_URI'];
        $Position = strpos($Uri, '?');

        $Url = $Position === false ? $Uri : substr($Uri, 0, $Position);
        $Url = trim($Url, '/');

        parse_str($_SERVER['QUERY_STRING'],$parse_arr);

        if($parse_arr)
        {
            $params = $parse_arr;
        }

        if($Url)
        {
            $UrlArray   = explode('/',$Url);
            $Controller = ucfirst($UrlArray[0]);
            $Action     = $UrlArray[1];
        }

        $Controller = $Controller.'Controller';

        if(!class_exists($Controller))
        {
            exit('Controller not found!');
        }
        if(!method_exists($Controller,$Action))
        {
            exit(sprintf('%s not found %s Action',$Controller,$Action));
        }

        call_user_func_array(array($Controller,$Action),array($params));
    }

    protected static function checkEnv()
    {
        if(APP_DEBUG)
        {
            error_reporting(E_ALL);
            ini_set('display_errors','on');
        }
        else
        {
            error_reporting(E_ALL);
            ini_set('display_errors','off');
            ini_set('log_errors','on');
        }
    }

    protected static function rmRegisterGlobals()
    {
        if(ini_get('register_globals'))
        {
            $rg_map = array('_SESSION','_POST','_GET','_COOKIES','_REQUEST','_SERVER','_ENV','_FILES');

            foreach ($rg_map as $func)
            {
                foreach ($GLOBALS[$func] as $key => $var)
                {
                    if($var == $GLOBALS[$key])
                    {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }
}
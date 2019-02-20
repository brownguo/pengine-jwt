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


    protected static $defaultController = 'IndexController';
    protected static $defaultAction     = 'index';

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
            $LoadableModules = array('/App/Controller','/App/Model','App/Config','App/Model','Pengine/Lib/Jwt');

            foreach ($LoadableModules as $module)
            {
                $filename =  BASE_PATH.$module.'/'.$name . '.php';
                if (file_exists($filename))
                    require_once $filename;
            }
        });
    }

    public static function loadLibrary($lib)
    {
        $lib_dir = BASE_PATH."Pengine/Lib/{$lib}/*.php";

        foreach (glob($lib_dir) as $file)
        {
            if(is_file($file))
            {
                require_once $file;
            }
        }


    }

    protected static function dispathch()
    {
        $params = array();

        $Uri      = $_SERVER['REQUEST_URI'];
        $Position = strpos($Uri, '?');

        $Url = $Position === false ? $Uri : substr($Uri, 0, $Position);
        $Url = trim($Url, '/');

        parse_str($_SERVER['QUERY_STRING'],$parse_arr);

        if(!empty($parse_arr))
        {
            $params = $parse_arr;
        }

        if($Url)
        {
            $UrlArray   = explode('/',$Url);
            $Controller = ucfirst($UrlArray[0]);
            $Action     = $UrlArray[1];
        }

        if(empty($Controller))
        {
            $Controller = static::$defaultController;
            $Action     = static::$defaultAction;
        }
        else
        {
            $Controller = $Controller.'Controller';
        }

        if(!class_exists($Controller))
        {
            exit('Controller not found!');
        }
        if(!method_exists($Controller,$Action))
        {
            exit(sprintf('[%s] not found [%s] Action',$Controller,$Action));
        }

        //call_user_func_array(array($Controller,$Action),array($params));

        static::loadMethod($Controller,$Action);
    }

    protected static function loadMethod($object,$func)
    {
        $object = new ReflectionClass($object);

        if($object->hasMethod($func))
        {
            $tmp = $object->getMethod($func);

            if($tmp->isPublic() && !$tmp->isAbstract())
            {
                $tmp->invoke($object->newInstance());
            }
            else if($tmp->isStatic())
            {
                $tmp->invoke(null);
            }
            else
            {
                exit("You do not have permission to access the requested data or object!");
            }
        }
        else
        {
            exit("Not found Function:".$func);
        }
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
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
    private static $loadFilesPath;
    private static $version;

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

    private static function setLoadPath()
    {
        static::$loadFilesPath = array('/App/Controller/'.static::$version,
            '/App/Model','App/Config', 'Pengine/Lib/Jwt',
            'Pengine/Lib/Db'
        );
    }


    protected static function init()
    {
        //static::$startTime = microtime(true);
    }

    protected static function autoload()
    {
        spl_autoload_register(function($name)
        {
            $LoadableModules = static::$loadFilesPath;

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
            $UrlArray           = explode('/',$Url);
            static::$version    = strtolower($UrlArray[0]);
            static::setLoadPath();

            //Mapping
            $router_map    = static::getMappingRouter();
            $mapping_url   = str_replace(static::$version.'/','',$Uri);

            //如果url有参数
            if(strpos($mapping_url,'?'))
            {
                $mapping_url = static::handleUriParams($mapping_url);
            }

            @$router_config = $router_map[$mapping_url];

            if(isset($router_config))
            {
                $rule = explode('/',$router_config);
                $Controller = $rule[0];
                $Action     = $rule[1];
            }
            else
            {
                if(count($UrlArray) > 2)
                {
                    $Controller         = ucfirst($UrlArray[1]);
                    $Action             = $UrlArray[2];
                }
            }
        }

        if(empty($Controller)) {
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

    protected static function handleUriParams($uri)
    {
        $mapping_url = substr($uri,0,strrpos($uri,"?"));
        return $mapping_url;
    }

    protected static function getMappingRouter()
    {
        $router_version = sprintf('router.%s',static::$version);
        return Config::get($router_version);
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

    public static function input($name,$default='',$filter=null,$datas=null) {
        static $_PUT	=	null;
        $var_auto_string = false;
        if(strpos($name,'/'))
        {
            list($name,$type) 	=	explode('/',$name,2);
        }
        elseif($var_auto_string)
        {
            $type   =   's';
        }
        if(strpos($name,'.'))
        {
            list($method,$name) =   explode('.',$name,2);
        }else
        {
            $method =   'param';
        }
        switch(strtolower($method))
        {
            case 'get'     :
                $input =& $_GET;
                break;
            case 'post'    :
                $input =& $_POST;
                break;
            case 'put'     :
                if(is_null($_PUT))
                {
                    parse_str(file_get_contents('php://input'), $_PUT);
                }
                $input 	=	$_PUT;
                break;
            case 'param'   :
                switch($_SERVER['REQUEST_METHOD'])
                {
                    case 'POST':
                        $input  =  $_POST;
                        break;
                    case 'PUT':
                        if(is_null($_PUT)){
                            parse_str(file_get_contents('php://input'), $_PUT);
                        }
                        $input 	=	$_PUT;
                        break;
                    default:
                        $input  =  $_GET;
                }
                break;
            case 'path'    :
                $input  =   array();
                if(!empty($_SERVER['PATH_INFO']))
                {
                    $depr   =   '/';
                    $input  =   explode($depr,trim($_SERVER['PATH_INFO'],$depr));
                }
                break;
            case 'request' :
                $input =& $_REQUEST;
                break;
            case 'session' :
                $input =& $_SESSION;
                break;
            case 'cookie'  :
                $input =& $_COOKIE;
                break;
            case 'server'  :
                $input =& $_SERVER;
                break;
            case 'globals' :
                $input =& $GLOBALS;
                break;
            case 'data'    :
                $input =& $datas;
                break;
            default:
                return null;
        }
        if(''==$name)
        { // 获取全部变量
            $data       =   $input;
            $filters    =   isset($filter)?$filter:'htmlspecialchars';
            if($filters) {
                if(is_string($filters)){
                    $filters    =   explode(',',$filters);
                }
                foreach($filters as $filter){
                    $data   =   array_map_recursive($filter,$data); // 参数过滤
                }
            }
        }elseif(isset($input[$name]))
        { // 取值操作
            $data       =   $input[$name];
            $filters    =   isset($filter)?$filter:'htmlspecialchars';
            if($filters)
            {
                if(is_string($filters))
                {
                    if(0 === strpos($filters,'/'))
                    {
                        if(1 !== preg_match($filters,(string)$data))
                        {
                            // 支持正则验证
                            return   isset($default) ? $default : null;
                        }
                    }
                    else
                    {
                        $filters    =   explode(',',$filters);
                    }
                }elseif(is_int($filters)){
                    $filters    =   array($filters);
                }

                if(is_array($filters))
                {
                    foreach($filters as $filter)
                    {
                        if(function_exists($filter))
                        {
                            $data   =   is_array($data) ? array_map_recursive($filter,$data) : $filter($data); // 参数过滤
                        }
                        else
                        {
                            $data   =   filter_var($data,is_int($filter) ? $filter : filter_id($filter));
                            if(false === $data)
                            {
                                return   isset($default) ? $default : null;
                            }
                        }
                    }
                }
            }
            if(!empty($type))
            {
                switch(strtolower($type))
                {
                    case 'a':	// 数组
                        $data 	=	(array)$data;
                        break;
                    case 'd':	// 数字
                        $data 	=	(int)$data;
                        break;
                    case 'f':	// 浮点
                        $data 	=	(float)$data;
                        break;
                    case 'b':	// 布尔
                        $data 	=	(boolean)$data;
                        break;
                    case 's':   // 字符串
                    default:
                        $data   =   (string)$data;
                }
            }
        }else
        { // 变量默认值
            $data       =    isset($default)?$default:null;
        }
        //is_array($data) && array_walk_recursive($data,'think_filter');
        return $data;
    }

}
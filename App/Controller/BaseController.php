<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/2/20
 * Time: 下午1:34
 */

use \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;
use \Firebase\JWT\BeforeValidException;
use \Firebase\JWT\ExpiredException;

class BaseController
{
    public function __construct()
    {
        Pengine::loadLibrary('Jwt');
        static::verification();
    }

    protected static function verification($token=1,$key=2)
    {
        echo "<pre>";
        print_r($_SERVER);
        try
        {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($token, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            print_r($arr);
        }
        catch(SignatureInvalidException $e)
        {
            echo $e->getMessage();
        }
        catch(BeforeValidException $e)
        {
            echo $e->getMessage();
        }
        catch(ExpiredException $e)
        {
            echo $e->getMessage();
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
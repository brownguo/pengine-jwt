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

    protected static function verification($token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93d3cuaGVsbG93ZWJhLm5ldCIsImF1ZCI6Imh0dHA6XC9cL3d3dy5oZWxsb3dlYmEubmV0IiwiaWF0IjoxNTUwNzIxMTQ5LCJuYmYiOjE1NTA3MjExNDksImV4cCI6MTU1MDcyODM0OSwiZGF0YSI6eyJ1c2VyaWQiOjEsInVzZXJuYW1lIjoiXHU2NzRlXHU1YzBmXHU5Zjk5In19.vM1PC0aA_FDaZ0-2vhrg4nBymFTDk3vgQGcJQCCXZJU',$key=2)
    {
        echo "<pre>";
        print_r($_SERVER);
        try
        {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($token, 344, ['HS256']); //HS256方式，这里要和签发的时候对应
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
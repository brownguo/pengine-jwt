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

    public $private_key;


    public function __construct()
    {
        Pengine::loadLibrary('Jwt');
        $this->setPrivateKey();
    }

    public function setPrivateKey()
    {
        $this->private_key = Config::get('key');
    }

    protected function verifyToken($token)
    {
        try {
            JWT::$leeway = 20;
            $decoded     = JWT::decode($token, $this->private_key, ['HS256']);
            $arr         = (array)$decoded;
            print_r($arr);
        }
        catch(SignatureInvalidException $e) {   //签名不正确
            echo $e->getMessage();
        }
        catch(BeforeValidException $e) {        //签名在某个时间点之后才能使用
            echo $e->getMessage();
        }
        catch(ExpiredException $e) {            //token过期了,尝试refresh
            echo $e->getMessage();
        }
        catch(Exception $e) {                   //其他错误
            echo $e->getMessage();
        }
    }
}
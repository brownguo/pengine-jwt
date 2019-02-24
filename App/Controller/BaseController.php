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

    protected $access_exp_time  = 3600;
    protected $refresh_exp_time = 7200;
    protected $token_type       = 'Bearer';

    public function __construct()
    {
        Pengine::loadLibrary('Jwt');
        $this->setPrivateKey();
    }

    protected function setPrivateKey()
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

    protected function Signature()
    {
        $key  = $this->private_key;

        $time = time();

        $token = array(
            'jti' =>'weiyiid',
            'iss' => 'http://test.jwt.com', //签发者 可选
            'aud' => 'http://test.jwt.com', //接收该JWT的一方，可选
            'sub' => 'http://test.jwt.com', //可以使用的作用域
            'iat' => $time, //签发时间
            'nbf' => $time , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'data'=> array(
                'user_id'=>201958697,
                'user_nm'=>'BrownGuo!',
            ),
        );
        $access_access = array(
            $token, 'scopes'=>'Access', 'exp' =>$time + $this->access_exp_time
        );
        $refresh_token = array(
            $token, 'scopes'=>'Refresh','exp' =>$time + $this->refresh_exp_time
        );

        $TokenList = array(
            'access_token'  => JWT::encode($access_access,$key),
            'refresh_token' => JWT::encode($refresh_token,$key),
            'token_type'=>'Bearer'
        );

        return $TokenList;
    }
}
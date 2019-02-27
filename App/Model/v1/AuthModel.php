<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/2/27
 * Time: 下午2:29
 */

use \Firebase\JWT\JWT;

class AuthModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function _Signature($userInfo)
    {
        $time = time();
        $key  = $this->private_key;

        $token = array(
            'jti' =>'weiyiid',
            'iss' => 'http://test.jwt.com', //签发者 可选
            'aud' => 'http://test.jwt.com', //接收该JWT的一方，可选
            'sub' => 'http://test.jwt.com', //可以使用的作用域
            'iat' => $time, //签发时间
            'nbf' => $time , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'data'=> array(
                $userInfo
            ),
        );
        $access_access = array(
            $token, 'scopes'=>'Access', 'exp' =>$time + $this->access_Exp
        );
        $refresh_token = array(
            $token, 'scopes'=>'Refresh','exp' =>$time + $this->refresh_Exp
        );

        $AuthTokenList = array(
            'access_token'  => JWT::encode($access_access,$key),
            'refresh_token' => JWT::encode($refresh_token,$key),
            'token_type'=>'Bearer'
        );

        return $AuthTokenList;
    }

    public function _verifyToken($token)
    {
        $key = $this->private_key;

        try {
            JWT::$leeway = 20;
            $decoded     = JWT::decode($token, $key, ['HS256']);
            $ret         = pengine::object_to_array($decoded);
            return $ret;
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
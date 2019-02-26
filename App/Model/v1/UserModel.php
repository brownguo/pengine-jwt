<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/2/24
 * Time: 10:45 AM
 */


use \Firebase\JWT\JWT;

class UserModel
{
    private static $private_key;
    private static $access_Exp = 3600;
    private static $refresh_Exp = 7200;

    public static function _doLogin($username,$password)
    {
        $userInfo = Db::getInstance()->get('account',
                array(
                    'Fid','Faccount','Fpassword','Fverify', 'FloginCount','Fnickname'
                ),
                array(
                    'Faccount'=>$username
                )
            );
        if($userInfo !== false)
        {
            $verify = md5(md5($password).$userInfo['Fverify'].$username);

            if($verify == $userInfo['Fpassword'])
            {
                static::_updateLoginInfo($userInfo);
                unset($userInfo['Fpassword'],$userInfo['Fverify']);
                static::_setPrivateKey();
                static::_Signature($userInfo);
            }
        }
    }

    protected static function _setPrivateKey()
    {
        static::$private_key = Config::get('key');
    }

    private static function _updateLoginInfo($userInfo)
    {
        $loginData = array(
            'FlastLoginTime'=> time(),
            'FloginCount'   => intval($userInfo['FloginCount']) + 1,
            'FlastLoginIp'  => pengine::get_client_ip(),
        );

        $ret = Db::getInstance()->update(
            'account',$loginData,
            array(
                'Fid'=>$userInfo['Fid'],
            )
        );
        return $ret;
    }

    private static function _Signature($userInfo)
    {
        $time = time();
        $key  = static::$private_key;

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
            $token, 'scopes'=>'Access', 'exp' =>$time + static::$access_Exp
        );
        $refresh_token = array(
            $token, 'scopes'=>'Refresh','exp' =>$time + static::$refresh_Exp
        );

        $TokenList = array(
            'access_token'  => JWT::encode($access_access,$key),
            'refresh_token' => JWT::encode($refresh_token,$key),
            'token_type'=>'Bearer'
        );

        echo "<pre>";
        print_r($TokenList);
        static::verifyToken($TokenList['access_token']);
        return $TokenList;
    }

    private static function verifyToken($token)
    {
        try {
            JWT::$leeway = 20;
            $decoded     = JWT::decode($token, static::$private_key, ['HS256']);
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
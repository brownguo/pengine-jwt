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
    public static function _doLogin($username,$password)
    {
        $userInfo = Db::getInstance()->get('account',
                array(
                    'Fid','Faccount','Fpassword','Fverify', 'FloginCount',
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
            }
        }
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

}
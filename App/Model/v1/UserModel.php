<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/2/24
 * Time: 10:45 AM
 */

class UserModel extends BaseModel
{
    private $AuthServices;

    public function __construct()
    {
        parent::__construct();
        $this->AuthServices = new AuthModel();
    }

    public function _doLogin($username,$password)
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
                $this->_updateLoginInfo($userInfo);
                unset($userInfo['Fpassword'],$userInfo['Fverify']);
                //获取签名
                return $this->AuthServices->_Signature($userInfo);
            }
        }
    }

    private function _updateLoginInfo($userInfo)
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
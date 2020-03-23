<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/2/20
 * Time: 下午1:34
 */

class BaseController
{

    public $private_key;

    protected $AuthServices;

    public function __construct()
    {
        Pengine::loadLibrary('Jwt');

        $this->AuthServices = new AuthModel();
        $this->_checkToken();
    }

    protected function _checkToken()
    {
        $token  = pengine::input('get.token');

        //没带token直接403
        if($token)
        {
            pengine::send_http_status(403);
        }
        else
        {
            $ret = $this->AuthServices->_verifyToken($token);

            if(!$ret)
            {
                //这里说明token有问题了,后续补一个403页面
                pengine::send_http_status(403);
            }
        }
    }
}
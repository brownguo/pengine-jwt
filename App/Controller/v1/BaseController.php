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

    protected $access_exp_time  = 3600;
    protected $refresh_exp_time = 7200;
    protected $token_type       = 'Bearer';
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

        if($token)
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
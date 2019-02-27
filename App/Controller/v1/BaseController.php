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

            print_r($ret);
        }
    }
}
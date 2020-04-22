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

        //不验证的路由
        $no_verify_router = Config::get('no_verify_router');

        //如果当前URL不存在no_verify_router数组里，则需要验证Token
        if(!in_array(Pengine::getRequestAction(),$no_verify_router))
        {
            $this->_checkToken();
        }
    }

    protected function _checkToken()
    {
        $token  = pengine::input('payload.token');

        if($token)
        {
            $ret = $this->AuthServices->_verifyToken($token);
            if(!$ret)
            {
                //这里说明token有问题了,后续补一个403页面，应该是exit，开发环境先这么写着。
                pengine::send_http_status(403);
            }
        }
        else
        {
            exit('Forbidden');
        }
    }

    protected function _checkAuthority()
    {

    }

    protected function _getAuthority()
    {

    }
}
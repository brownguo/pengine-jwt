<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/1/10
 * Time: 9:54 PM
 */

class UserController extends BaseController
{
    private $UserServices;

    public function __construct()
    {
        parent::__construct();
        $this->UserServices = new UserModel();
    }

    public function getRules()
    {
         echo "Call func success!";
    }

    public function login()
    {
        $username = pengine::input('get.username');
        $password = pengine::input('get.password');

        $res = $this->UserServices->_doLogin($username,$password);

        if(isset($res['access_token']))
        {
            pengine::ajaxReturn(array('code'=>200,'msg'=>'success','ret'=>$res));
        }
    }
}
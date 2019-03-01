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
         echo "<pre>";
         print_r(get_included_files());
    }

    public function login()
    {
        if(IS_POST)
        {
            $username = pengine::input('payload.userName');
            $password = pengine::input('payload.password');

            $res = $this->UserServices->_doLogin($username,$password);

            if(isset($res['access_token']))
            {
                $ret = array(
                    'code'=>200,
                    'msg'=>'success',
                    'ret'=>$res
                );
                pengine::ajaxReturn($ret);
            }
        }

    }
}
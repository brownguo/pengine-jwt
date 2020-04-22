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
                    'code'  =>  200,
                    'msg'   =>  'success',
                    'data'  => array(
                        'token'     => $res,
                        'userInfo'  => array(
                            'uid'  => 1,
                            'username' => 'BrownGuo',
                        ),
                        'authList' => array(
                            'orders_all_list','orders_detail_by_id',
                        )
                    )
                );
                pengine::ajaxReturn($ret);
            }
            else
            {
                $ret = array(
                    'code'  =>  201,
                    'msg'   =>  'error',
                );
                pengine::ajaxReturn($ret);
            }
        }
        else
        {
            Pengine::send_http_status(500);
        }

    }

    public function testlogin()
    {
        $this->UserServices->_getRoleList();
    }
}
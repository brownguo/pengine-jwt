<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/1/10
 * Time: 9:54 PM
 */

use \Firebase\JWT\JWT;

class IndexController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo "Default Action!\n";
    }

    public function test()
    {

        echo "<pre>";

        BaseModel::test();
        $key = $this->private_key;
        $time = time(); //当前时间

        $token = array(
            'jti' =>'weiyiid',
            'iss' => 'http://test.jwt.com', //签发者 可选
            'aud' => 'http://test.jwt.com', //接收该JWT的一方，可选
            'sub' => 'http://test.jwt.com',
            'iat' => $time, //签发时间
            'nbf' => $time , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'data'=> array(
                'user_id'=>201958697,
                'user_nm'=>'BrownGuo!',
            ),
        );
        $access_access = array(
            $token, 'scopes'=>'Access','exp'=>$time+3600
        );
        $refresh_token = array(
            $token, 'scopes'=>'Refresh','exp'=>$time+7200
        );

        $TokenList = array(
            'access_token'  => JWT::encode($access_access,$key),
            'refresh_token' => JWT::encode($refresh_token,$key),
            'token_type'=>'Bearer'
        );

        //Header("HTTP/1.1 201 Created");

        print_r($TokenList);
        $this->verifyToken($TokenList['access_token']);
    }
}
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
        $key = '344'; //key
        $time = time(); //当前时间
        $token = [
            'iss' => 'http://test.jwt.com', //签发者 可选
            'aud' => 'http://test.jwt.com', //接收该JWT的一方，可选
            'iat' => $time, //签发时间
            'nbf' => $time , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $time+7200, //过期时间,这里设置2个小时
            'data' => [ //自定义信息，不要定义敏感信息
                'userid' => 1,
                'username' => '李小龙'
            ]
        ];

        $token = array(
            'iss' => 'http://test.jwt.com', //签发者 可选
            'iat' => time(),
            'data' => array(
                'userid' => 1,
                'uname'  => 'BrownGuo!',
            )
        );

        $access_token           = $token; //access token.
        $access_token['scopes'] = 'role_access';    //token标识
        $access_token['exp']    = time() + 7200;    //token过期时间

        $refresh_token           = $token;
        $refresh_token['scopes'] = 'role_refresh';
        $refresh_token['exp']    = time() + 7200;    //token过期时间

        $TokenList = array(
            'access_token'  => JWT::encode($access_token,$key),
            'refresh_token' => JWT::encode($refresh_token,$key),
            'token_type'=>'bearer'
        );

        Header("HTTP/1.1 201 Created");
        echo json_encode($TokenList); //返回给客户端token信息

    }
}
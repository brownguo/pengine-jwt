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
        $key = '344'; //key
        $time = time(); //当前时间
        $token = [
            'iss' => 'http://www.helloweba.net', //签发者 可选
            'aud' => 'http://www.helloweba.net', //接收该JWT的一方，可选
            'iat' => $time, //签发时间
            'nbf' => $time , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $time+7200, //过期时间,这里设置2个小时
            'data' => [ //自定义信息，不要定义敏感信息
                'userid' => 1,
                'username' => '李小龙'
            ]
        ];
        $jwt =  JWT::encode($token, $key); //输出Token
        echo $jwt;
    }
}
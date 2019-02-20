<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/1/10
 * Time: 9:54 PM
 */

use \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;
use \Firebase\JWT\BeforeValidException;
use \Firebase\JWT\ExpiredException;

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
        print_r(get_included_files());
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
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($jwt, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            print_r($arr);
        } catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            echo $e->getMessage();
        }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            echo $e->getMessage();
        }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
            echo $e->getMessage();
        }catch(Exception $e) {  //其他错误
            echo $e->getMessage();
        }
    }
}
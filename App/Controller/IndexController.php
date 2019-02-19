<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/1/10
 * Time: 9:54 PM
 */

class IndexController
{

    public function index()
    {
        echo "Default Action!\n";
    }

    public function test()
    {
        echo "<pre>";
        print_R($_GET);

        $token = [
            'iss' => 'http://www.helloweba.net', //签发者 可选
            'iat' => time(), //签发时间
            'data' => [ //自定义信息，不要定义敏感信息
                'userid' => 1,
            ]
        ];
        Pengine::loadLibrary('JWT');
        print_r(\Firebase\JWT\JWT::encode($token,123));
        echo "Instance is Test!\n";

        print_r(get_included_files());

    }

}
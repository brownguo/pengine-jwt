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
        print_r(\Firebase\JWT\JWT::encode(111));
        echo "Instance is Test!\n";
    }

}
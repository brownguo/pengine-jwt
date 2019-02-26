<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/1/10
 * Time: 9:54 PM
 */

use \Firebase\JWT\JWT;

class UserController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo "Default Action!\n";
    }

    public function login()
    {

        $username = pengine::input('get.username');
        $password = pengine::input('get.password');

        UserModel::_doLogin($username,$password);
    }
}
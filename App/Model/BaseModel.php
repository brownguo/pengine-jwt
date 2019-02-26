<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/1/10
 * Time: 9:54 PM
 */

class BaseModel
{
    public static function test()
    {
        $data = array(
            'Faccount'=>'account',
            'Fpassword'=>'password',
            'Fnickname'=>'nikename',
            'Fverify'  =>'verify',
            'FlastLoginTime'=>'123',
            'FloginCount'=>'login_count',
            'FlastLoginIp'=>'loginip',
            'FcreateTime'=>'1112222333'
        );
        $datau = array(
            'Faccount'=>'account',
            'Fpassword'=>'password',
            'Fnickname'=>'nikename',
            'Fverify'  =>'verify',
            'FlastLoginTime'=>'江湖!!',
            'FloginCount'=>'login_count',
            'FlastLoginIp'=>'loginip',
            'FcreateTime'=>'1112222333'
        );

        //print_r(Db::getInstance()->select('account','*'));
    }
}
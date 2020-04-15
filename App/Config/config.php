<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2019/1/10
 * Time: 9:48 PM
 */

return array(
    'db' => array(
        'mysql'=>array(
            'database_type' => 'mysql',
            'database_name' => 'pengine',
            'server'        => 'localhost',
            'username'      => 'root',
            'password'      => '',
            'charset'       => 'utf8',
            'port'          => 3306,
            'prefix'        => 't_',
            'option'        => [
                PDO::ATTR_CASE => PDO::CASE_NATURAL
            ]
        ),
    ),
    'key'   =>'1gHuiop975cdashyex9Ud23ldsvm2Xq',

    'router'=>array(
            'v1'=>array(
                '/users/login'  =>'user/login',
                '/test/test'    =>'user/index',
                '/auth/rule/get'=>'user/getRules',
                '/orders/list/get'=>'orders/getorderlist'       //获取订单列表
            ),
            'v2'=>array(
                '/test/test' =>'user/login'
            )
    ),

    'no_verify_router'=>array(
        '/users/login'
    ),

    'error_code'=>array(
        200001 => 'Expired token',                  //令牌过期
        200002 => 'Signature verification failed',  //签名验证失败
        200003 => 'Cannot handle token',    //签名在某个时间点之后才能使用
        200004 => 'Signature Fatal error',  //其他错误
        400001 => 'Error in account or password', //账号或者密码错误
    )
);
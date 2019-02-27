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
                '/auth/rule/get'=>'user/getRules'
            ),
            'v2'=>array(
                '/test/test' =>'user/login'
            )
    )
);
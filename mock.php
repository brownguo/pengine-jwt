<?php
    $ret = array(
        'code' => 200,
        'msg'  => 'success',
        'data' => array(

            'token'=>array(
                'access_token' => 'access_token_value',
                'exp'          => 3600
            ),
            'userInfo' => array(
                'uid'       => 9813761,
                'nickname'  => 'BrownGuo'
            ),
            'authList' => array(
                'orders'=>array(
                    'icon' => 'bars',
                    'name' => 'orders',
                    'routes' => array(
                       array(
                           'icon'      => 'rocket',
                           'path'      => '/orders/all-list',
                           'name'      => 'all-list',
                           'component' => './Orders/OrderList'
                       ),
                       array(
                           'path'       => '/orders/detail/:id',
                           'hideInMenu' => true,
                           'component'  => './Orders/BasicProfile'
                       )
                    )
                ),
                'component' => '404'
            )
        )
    );

    print_r(json_encode($ret,JSON_UNESCAPED_UNICODE))
?>
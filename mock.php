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
                    'search' => true,
                    'edit'   => true,
                    'verify' => true,
                ),
            )
        )
    );

    print_r(json_encode($ret,JSON_UNESCAPED_UNICODE))
?>
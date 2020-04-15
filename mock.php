<?php
    //mock 一些数据结构
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
            'authList' => array('orders_all_list','orders_detail_by_id'),

            'orderList'=>array(
                array(
                    'id'                 =>'128173821831',
                    'name'               => '杜甫',
                    'mobile_no'          => '13111112222',
                    'callNo'             => 2912,
                    'status'             => 1,
                    'create_at'          => date('Y-m-d H:i:s',time()),
                    'order_verify_at'    => date('Y-m-d H:i:s',time()+30)
                )
            ),
            'pagination' => array(
                'total'     =>  1,
                'pageSize'  =>  10,
                'current'   =>  1
            )
        )
    );

    print_r(json_encode($ret,JSON_UNESCAPED_UNICODE))
?>
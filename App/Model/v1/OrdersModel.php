<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2020/3/23
 * Time: 下午12:42
 */

class OrdersModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOrderList()
    {
        $orderList = Db::getInstance()->select('orders',
            array(
                'id','order_id','account_name','mobile_number','callNo', 'order_status','created_at','update_at','create_by'
            )
        );

        return array(
            'orderlist' => $orderList,
            'count'     => count($orderList),
            'pageSize'  => 10,
            'current'   => 1
        );
    }
}
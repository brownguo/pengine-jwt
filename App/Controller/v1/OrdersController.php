<?php
/**
 * Created by PhpStorm.
 * User: guoyexuan
 * Date: 2020/3/23
 * Time: 下午12:40
 */

class OrdersController extends BaseController
{
    private $ordersServices;

    public function __construct()
    {
        parent::__construct();
        $this->ordersServices = new OrdersModel();
    }

    public function getOrderList()
    {
        $ret = $this->ordersServices->getOrderList();
        if($ret)
        {
            $data = array(
                'code' => 200,
                'msg'  => 'success',
                'list' => $ret['orderlist'],
                'pagination' => array(
                    'total'     =>  $ret['count'],
                    'pageSize'  =>  $ret['pageSize'],
                    'current'   =>  $ret['current']
                )
            );
            pengine::ajaxReturn($data,'JSON');
        }
    }
}
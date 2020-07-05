<?php
/**
 *  文件：OrderService.php
 *  author:daixianhua
 *  时间：2020/7/5-8:39
 */


namespace app\index\service;


use app\common\model\Order;
use app\common\OrderQueue;

class OrderService
{
    public function addOrder($oorder_type = '1', $order_from = '3', $buyer_id = '102', $user_name = 'test', $order_status = '1')
    {
        $yCode=array('A','B','C','D','E','F','G','H','I','J');
        $Order_no=$yCode[intval(date('Y'))-2011].strtoupper((dechex(date('m')))).sprintf('%02d',rand(0,99));
        $order=Order::insert([
            'order_no'=>$Order_no,
            'order_type'=>$oorder_type,
            'order_from'=>$order_from,
            'buyer_id'=>$buyer_id,
            'user_name'=>$user_name,
            'order_status'=>$order_status,
        ]);
        //加入队
        OrderQueue::pushToList($order->order_id);
        echo  "success";
    }
}
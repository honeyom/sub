<?php

namespace app\common\model;

use think\Model;

class Order extends Model
{
    //
    protected $pk='order_id';
    public function getOrderStatusAttr($value){
        $data=[
            0=>'待付款',
            1=>'代发货',
            2=>'待收货',
            3=>'已收货',//已收货
            4=>'交易成功',//已收货
            5=>'已关闭',
            -1=>'退款中',
            -2=>'已退款',
        ];
        return $data[$value];
    }
}

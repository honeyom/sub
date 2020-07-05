<?php
/**
 *  文件：OrderQueue.php
 *  author:daixianhua
 *  时间：2020/7/5-9:07
 */


namespace app\common;
use app\common\model\Order;
use think\facade\Cache;
class OrderQueue
{
    /***
     * 订单信息
     * @var
     */
    private $order_queue;//订单状态
    private $key;//键
    private $exprie_time=60;//
    public $order_id;//订单id
    public function __construct()
    {
        $this->key="Order_QUEUE_KEY";
        $this->order_queue=$this->queryNotReceiveOrder();
    }

    /***
     * 获得订单状态
     */
    public function queryNotReceiveOrder(){
        $lists=Order::where('order_status=1')->field('order_id')->page(10)->select()->toArray();
        $data=[];
        foreach ($lists as $key=>$value){//取得状态为1的id
            $data[]=$value['order_id'];
        }
        return $data;
    }

    /***
     * 新订单添加到队列
     * @param $order_ids
     * @return bool
     */
    public function pushToList($order_ids){
        if (!is_array($order_ids)){
            $this->order_id=$order_ids;
            $this->pushToQueue();//
            return true;
        }
        foreach ($order_ids as $key=>$value){
            $this->order_id=$value;
            $this->pushToQueue();
        }
        return true;
    }
    public function pushToQueue(){
        if (!$this->order_id){
            return "没有订单不执行此方法";
        }
        if($this->order_queue){
            array_unshift($this->order_queue,$this->order_id);
        }else{
            $this->order_queue[]=$this->order_id;
        }
        $this->order_queue=$this->array_unique();
        $redis=Cache::store('redis')->handler();//开启redis;
        foreach ($this->order_queue as $key=>$value){
            $redis->lpush($this->key,$value);
        }
        return true;
    }
    public function array_unique(){
        return array_unique($this->order_queue);
    }
    public function pullFromQueue(){
        $redis=Cache::store('redis')->handler();
         $llen=$redis->lLen($this->key);
         if (!empty($llen)){
             for ($i=0;$i<$llen;$i++){
                 echo "你的商品已发货";
                 $key=Order::where([
                     'order_status'=>1,
                     'order_id'=>$redis->rPop($this->key),
                 ])->data(['order_status'=>2])->update();
                 echo $key."<br>";
                 echo "继续推送订单";
             }
         }else{
             echo "没有可以推送的订单";
         }
    }
    public function clearOneOrder(){
        if ($this->order_queue){
            $key=array_search($this->order_id,$this->order_queue);//搜索键值，返回键名
            if (!$key && $key=0){
                return true;
            }
            unset($this->order_queue[$key]);
            \cache($this->key,$this->order_queue,$this->exprie_time);
        }
        return true;
    }
}
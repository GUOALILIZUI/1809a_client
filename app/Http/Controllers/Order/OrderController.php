<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsModel;
use App\Model\OrderModel;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function orderList(Request $request){
        $uid=$request->input('uid');
        $order_id=$request->input('order_id');
        
        $info=DB::table('order')
            ->join('order_detail','order.order_id','=','order_detail.order_id')
            ->where('order_pay_status',1)
            ->first();

        return $info = ['errno'=>0, 'pay'=>$info,];

//        print_r($info);die;
//        $str=json_encode($info);
//        $url='http://lumen.1809a.com/orderlist?uid='.$uid;
////        $url='http://alili.gege12.vip/centent';
//        $urlInfo=curl_init();
//        curl_setopt($urlInfo,CURLOPT_URL,$url);
//        curl_setopt($urlInfo,CURLOPT_POST,1);
//        //禁止浏览器输出 变量
//        curl_setopt($urlInfo, CURLOPT_RETURNTRANSFER,1);
//        curl_setopt($urlInfo,CURLOPT_POSTFIELDS,$str);
//        $cc=curl_exec($urlInfo);
//        print_r($cc);
//        curl_close($urlInfo);
    }


}

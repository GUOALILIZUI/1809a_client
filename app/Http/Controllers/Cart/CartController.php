<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CartModel;

class CartController extends Controller
{
    //
    public function cart(Request $request){
        $id=$request->input('uid');
        $goods_id=$request->input('goods_id');
        $goods_name=$request->input('goods_name');
        $goods_selfprice=$request->input('goods_selfprice');
        $buy_number=$request->input('buy_number');
        $selPriceAun=$buy_number*$goods_selfprice;
        $cartInfo=[
            'uid'=>$id,
            'goods_id'=>$goods_id,
            'goods_name'=>$goods_name,
            'goods_selfprice'=>$goods_selfprice,
            'buy_number'=>$buy_number,
            'selPriceAun'=>$selPriceAun,
            'ctime'=>time()
        ];

        $str=json_encode($cartInfo,JSON_UNESCAPED_UNICODE);
//        $url='http://lumen.1809a.com/cart';
        $url='http://alili.gege12.vip/cart';
        $urlInfo=curl_init();
        curl_setopt($urlInfo,CURLOPT_URL,$url);
        curl_setopt($urlInfo,CURLOPT_POST,1);
        //禁止浏览器输出 变量
        curl_setopt($urlInfo, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($urlInfo,CURLOPT_POSTFIELDS,$str);
        $cc=curl_exec($urlInfo);
        print_r($cc);
        curl_close($urlInfo);

    }

    public function cartList(Request $request){
        $uid=$request->input('uid');
        $cartInfo=CartModel::where(['uid'=>$uid,'cart_status'=>1])->get();
        $str=json_encode($cartInfo);
//        $url='http://lumen.1809a.com/cartlist';
        $url='http://alili.gege12.vip/cartlist';
        $urlInfo=curl_init();
        curl_setopt($urlInfo,CURLOPT_URL,$url);
        curl_setopt($urlInfo,CURLOPT_POST,1);
        //禁止浏览器输出 变量
        curl_setopt($urlInfo, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($urlInfo,CURLOPT_POSTFIELDS,$str);
        $cc=curl_exec($urlInfo);
        print_r($cc);
        curl_close($urlInfo);

    }
}

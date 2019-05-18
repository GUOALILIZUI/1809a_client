<?php

namespace App\Http\Controllers\Goods;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use App\Model\GoodsModel;

class GoodsController extends Controller
{
    public function goodsList()
    {
//        $url='http://lumen.1809a.com/goodslist';
        $url='http://alili.gege12.vip/goodslist';
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $cc=curl_exec($ch);
//        var_dump($cc);
    }



    public function cenTent(Request $request){
        $goods_id=$_GET['goods_id'];
        $goodsInfo=GoodsModel::where('goods_id',$goods_id)->first()->toArray();
        $str=json_encode($goodsInfo,JSON_UNESCAPED_UNICODE);
//        $url='http://lumen.1809a.com/centent';
        $url='http://alili.gege12.vip/centent';
        $urlInfo=curl_init();
        curl_setopt($urlInfo,CURLOPT_URL,$url);
        curl_setopt($urlInfo,CURLOPT_POST,1);
        //禁止浏览器输出 变量
        curl_setopt($urlInfo, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($urlInfo,CURLOPT_POSTFIELDS,$str);
        $cc=curl_exec($urlInfo);
        print_r($cc);
        curl_close($urlInfo);


    }}

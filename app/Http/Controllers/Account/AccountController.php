<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsModel;

class AccountController extends Controller
{
    //
    public function account(Request $request){
        $goods_id=$request->input('id');
        $uid=$request->input('uid');

//        $url='http://lumen.1809a.com/account?uid='.$uid;
        $url='http://alili.gege12.vip/account?uid='.$uid;

//        $url='http://alili.gege12.vip/centent';
        $urlInfo=curl_init();
        curl_setopt($urlInfo,CURLOPT_URL,$url);
        curl_setopt($urlInfo,CURLOPT_POST,1);
        //禁止浏览器输出 变量
        curl_setopt($urlInfo, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($urlInfo,CURLOPT_POSTFIELDS,$goods_id);
        $cc=curl_exec($urlInfo);
        print_r($cc);
        curl_close($urlInfo);

    }
}

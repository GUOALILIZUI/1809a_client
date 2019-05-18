<?php

namespace App\Http\Controllers\One;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class OneController extends Controller
{
    //
    public function oneIndex(){
        return view('one.index');
    }

    /**
     * @param Request $request
     * 对称加密
     */

    public function oneInfo(Request $request){
       $name= $request->input('name');
       $pass= $request->input('pass');
       $method = 'AES-256-CBC';
       $passwd = 'zzxxcc';
       $option=OPENSSL_RAW_DATA;
       $iv='QWERTYUIOPQWERTY';
       $oldPass=openssl_encrypt($pass,$method,$passwd,$option,$iv);
       $newPass=base64_encode($oldPass);

        $url='http://lumen_1809a.com/info';

        // print_r($info);exit;
        $dataInit=curl_init();
        curl_setopt($dataInit,CURLOPT_URL,$url);
        curl_setopt($dataInit,CURLOPT_POST,1);
        //禁止浏览器输出 变量
        curl_setopt($dataInit, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($dataInit,CURLOPT_POSTFIELDS,$newPass);
        $cc=curl_exec($dataInit);
        print_r($cc);
        curl_close($dataInit);

    }

    /**
     * @param int $n
     * 凯撒加密
     */
    public function  actii($n=3){
        $int2='';
        $str='abc';
        $length=strlen($str);
        for($i=0;$i<$length;$i++){
            $int=ord($str[$i])+$n;
            $int2.=chr($int);
        }

        $url='http://lumen_1809a.com/int';
        // print_r($info);exit;
        $dataInit=curl_init();
        curl_setopt($dataInit,CURLOPT_URL,$url);
        curl_setopt($dataInit,CURLOPT_POST,1);
        //禁止浏览器输出 变量
        curl_setopt($dataInit, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($dataInit,CURLOPT_POSTFIELDS,$int2);
        $cc=curl_exec($dataInit);
        print_r($cc);
        curl_close($dataInit);

    }


    /**
     * 非对称加密
     */
    public function rsaTest(){
        $data=[
            'name'=>'alili',
            'age'=>3
        ];

        $jsonStr=json_encode($data);

        $key=openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
        openssl_private_encrypt($jsonStr,$en_data,$key);
        $newInfo=base64_encode($en_data);

        $url='http://lumen_1809a.com/rsaTest';
        $dataInit=curl_init();
        curl_setopt($dataInit,CURLOPT_URL,$url);
        curl_setopt($dataInit,CURLOPT_POST,1);
        //禁止浏览器输出 变量
        curl_setopt($dataInit, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($dataInit,CURLOPT_POSTFIELDS,$newInfo);
        $cc=curl_exec($dataInit);
        print_r($cc);
        curl_close($dataInit);
    }


    /**
     * 签名
     */
    public function sign(){
        $data=[
            'name'=>'alili',
            'price'=>200,
            'goods_name'=>'雪糕'
        ];
        $jsonStr=json_encode($data);

        $key=openssl_get_privatekey('file://'.storage_path('app/keys/private.pem'));

        //设计签名
        openssl_sign($jsonStr,$signature,$key);
        $b64=base64_encode($signature);

        $url='http://lumen_1809a.com/sign?sign='.urlencode($b64);
        $dataInit=curl_init();
        curl_setopt($dataInit,CURLOPT_URL,$url);
        curl_setopt($dataInit,CURLOPT_POST,1);
        //禁止浏览器输出 变量
        curl_setopt($dataInit, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($dataInit,CURLOPT_POSTFIELDS,$jsonStr);
        curl_setopt($dataInit,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        $cc=curl_exec($dataInit);
        print_r($cc);
        curl_close($dataInit);
    }
}

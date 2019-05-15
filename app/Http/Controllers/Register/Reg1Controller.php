<?php

namespace App\Http\Controllers\Register;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ZkUserModel;
use Illuminate\Support\Facades\Redis;

class RegController extends Controller
{
    //
    public function regIndex(){
        return view('reg.regindex');
    }

    /**
     * @param Request $request
     * 注册
     */

    public function regInfo(Request $request){
        $user_name=$request->input('user_name');
        $email=$request->input('email');
        $pass1=$request->input('pass1');
        $pass2=$request->input('pass2');

        $data=[
            'user_name'=>$user_name,
            'email'=>$email,
            'pass1'=>$pass1,
            'pass2'=>$pass2
        ];

        $str=json_encode($data);
        $k=openssl_get_privatekey('file://'.storage_path('app/keys/private.pem'));
        openssl_private_encrypt($str,$en_data,$k);
        $newStr=base64_encode($en_data);
//        print_r($a);exit;
        $url='http://lumen_1809a.com/regInfo';
        $urlInfo=curl_init();
        curl_setopt($urlInfo,CURLOPT_URL,$url);
        curl_setopt($urlInfo,CURLOPT_POST,1);
        //禁止浏览器输出 变量
        curl_setopt($urlInfo, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($urlInfo,CURLOPT_POSTFIELDS,$newStr);
        $cc=curl_exec($urlInfo);
        print_r($cc);
        curl_close($urlInfo);





    }

    public function token(){
//       $info=$_GET;
//        $lkey='zk_token'.$info['id'];
//        Redis::set($lkey,$info['token']);
//        Redis::expire($lkey,604800);

//        echo '加入缓存成功';
        print_r($_GET);
    }


    public function a(){
        return view('reg.a');
    }
}

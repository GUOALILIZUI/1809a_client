<?php

namespace App\Http\Controllers\User;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class UserRegController extends Controller
{
    //注册
    public function reg(Request $request){
        $name=$request->input('name');
        $email=$request->input('email');
        $pass1=$request->input('pass1');
        $pass2=$request->input('pass2');
        $age=$request->input('age');

        //验证邮箱
        $emailInfo=UserModel::where('email',$email)->first();
        if($emailInfo){
            $response=[
                'errno'=>50001,
                'msg'=>'邮箱已被注册'
            ];
            die (json_encode($response,JSON_UNESCAPED_UNICODE));
        }

        //验证密码
        if($pass1!=$pass2){
            $response=[
                'errno'=>50002,
                'msg'=>'两次密码不一致'
            ];
            die (json_encode($response,JSON_UNESCAPED_UNICODE));
        }

        //密码加密
        $pass=password_hash($pass1,PASSWORD_BCRYPT);

        //入库
        $data=[
            'name'=>$name,
            'email'=>$email,
            'age'=>$age,
            'pass'=>$pass,
        ];
        $res=UserModel::insertGetId($data);
        if($res){
            $response=[
                'errno'=>0,
                'msg'=>'ok'
            ];
            die(json_encode($response)) ;
        }else{
            $response=[
                'errno'=>50003,
                'msg'=>'注册失败'
            ];
           die(json_encode($response,JSON_UNESCAPED_UNICODE)) ;
        }
    }

    //登录
    public function login(Request $request){
        $email=$request->input('email');
        $pass=$request->input('pass');
        $emailInfo=UserModel::where('email',$email)->first();
        if($emailInfo){
            if(password_verify($pass,$emailInfo->pass)){

                $token=$this->getLoginToken($emailInfo->uid);
                $tokenKey='login_token'.$emailInfo->uid;
                Redis::set($tokenKey,$token);
                Redis::expire($tokenKey,604800);

                $response=[
                    'errno'=>0,
                    'msg'=>'登陆成功',
                    'data'=>[
                        'token'=>$token
                    ]
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE)) ;

            }else{
                $response=[
                    'errno'=>50005,
                    'msg'=>'登录失败'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE)) ;
            }

        }else{
            $response=[
                'errno'=>50004,
                'msg'=>'用户不存在'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE)) ;
        }
    }

    //token
    protected function getLoginToken($uid){
        $token=substr(sha1(md5(time().Str::random(10).$uid)),5,15);
        return $token;
    }

    /*
     *
     * 个人中心
     */
    public function cenTer(){
        echo '个人中心';
    }
}

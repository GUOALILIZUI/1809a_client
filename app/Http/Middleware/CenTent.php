<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CenTent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token=$request->input('token');
        $uid=$request->input('uid');

        //验证参数
        if(empty($token) || empty($uid)){
            $response=[
                'errno'=>50009,
                'msg'=>'缺少参数'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

        $key="login_token".$uid;
        $redisToken=Redis::get($key);
        if($redisToken){
                if($token==$redisToken){
                    //TODO token有效记录日志
                }else{
                    $response=[
                        'errno'=>50007,
                        'msg'=>'token值无效'
                    ];
                    die(json_encode($response,JSON_UNESCAPED_UNICODE));
                }

        }else{
            $response=[
                'errno'=>50006,
                'msg'=>'请先登录'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        return $next($request);
    }
}

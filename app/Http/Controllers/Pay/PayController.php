<?php

namespace App\Http\Controllers\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\OrderModel;

class PayController extends Controller
{
    public $app_id;
    public $gate_way;
    public $notify_url;
    public $return_url;
    public $rsaPrivateKeyFilePath;
    public $aliPubKey;
    public function __construct()
    {
        $this->app_id = env('ALIPAY_APPID');
        $this->gate_way = 'https://openapi.alipaydev.com/gateway.do';
        $this->notify_url = env('ALIPAY_NOTIFY_URL');
        $this->return_url = env('ALIPAY_RETURN_URL');
        $this->rsaPrivateKeyFilePath = storage_path('app/alipay/private.pem');    //应用私钥
        $this->aliPubKey = storage_path('app/alipay/public.pem'); //支付宝公钥
    }
    public function test()
    {
        echo $this->aliPubKey;echo '</br>';
        echo $this->rsaPrivateKeyFilePath;echo '</br>';
    }


    /**
     * @param Request $request
     * @return string订单支付
     */
    public function pay(Request $request)
    {

        $order_id=$_GET['order_id'];

        //验证订单状态 是否已支付 是否是有效订单
        $order_info = DB::table('order')->where(['order_id'=>$order_id])->first();
//        print_r($order_info);die;
        //判断订单是否被支付
        if($order_info->order_pay_status!= 1){
            die("订单已支付，请勿重复支付");
        }
        //业务参数
        $bizcont = [
            'subject'           => 'Lening-Order: ' .$order_id,
            'out_trade_no'      => $order_id,
            'total_amount'      => $order_info->sun,
            'product_code'      => 'QUICK_WAP_WAY',
        ];
        //公共参数
        $data = [
            'app_id'   => $this->app_id,
            'method'   => 'alipay.trade.wap.pay',
            'format'   => 'JSON',
            'charset'   => 'utf-8',
            'sign_type'   => 'RSA2',
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'   => '1.0',
            'notify_url'   => $this->notify_url,        //异步通知地址
            'return_url'   => $this->return_url,        // 同步通知地址
            'biz_content'   => json_encode($bizcont),
        ];

        //签名
        $sign = $this->rsaSign($data);
        $data['sign'] = $sign;
        $param_str = '?';
        foreach($data as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $url = rtrim($param_str,'&');
        $url = $this->gate_way . $url;

        header("Location:".$url);       // 重定向到支付宝支付页面
    }


    public function rsaSign($params) {
        return $this->sign($this->getSignContent($params));
    }


    protected function sign($data) {
        $priKey = file_get_contents($this->rsaPrivateKeyFilePath);
        $res = openssl_get_privatekey($priKey);
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        if(!$this->checkEmpty($this->rsaPrivateKeyFilePath)){
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }


    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, 'UTF-8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }


    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;
        return false;
    }
    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }
    /**
     * 支付宝异步通知
     */
    public function notify()
    {
        $p = json_encode($_POST);
//        $p=file_get_contents("php://input");
        $log_str = "\n>>>>>> " .date('Y-m-d H:i:s') . ' '.$p . " \n";
        file_put_contents('/tmp/alipay_notify.log',$log_str,FILE_APPEND);
        $data=json_decode($p,true);
        if($data['trade_status']=='TRADE_SUCCESS'){
            $where=[
                'order_id'=>$data['out_trade_no'],
            ];
            DB::table('order')->where($where)->update(['order_pay_status'=>2]);
            DB::table('order_detail')->where($where)->update(['pay_status'=>2]);
//            DB::table('cart')->where($where)->update(['pay_status'=>2]);


        }

        echo 'success';
        //TODO 验签 更新订单状态
    }
    /**
     * 支付宝同步通知
     */
    public function aliReturn()
    {
//        echo '<pre>';print_r($_GET);echo '</pre>';
        echo '支付成功';
    }
}



//<?php
//
//namespace App\Http\Controllers\Pay;
//
//use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
//
//class PayController extends Controller
//{
//    //
//    public function pay(Request $request){
//        $order_id=$_GET['order_id'];
//        $url='http://lumen.1809a.com/pay?order_id='.$order_id;
////        $url='http://alili.gege12.vip/centent';
//        $urlInfo=curl_init();
//
//        curl_setopt($urlInfo, CURLOPT_URL, $url);
//        curl_setopt($urlInfo, CURLOPT_HEADER, 0);
//
//        $cc=curl_exec($urlInfo);
//        curl_close($urlInfo);
//
//    }
//}
//


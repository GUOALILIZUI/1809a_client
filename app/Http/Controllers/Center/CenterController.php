<?php

namespace App\Http\Controllers\Center;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;;

class CenterController extends Controller
{

    public function center(Request $request){
        $token=$_GET['token'];
        $id=$_GET['id'];
        $url='http://lumen.1809a.com/center?token='.$token+'&id='.$id;
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $cc=curl_exec($ch);
        $oo=curl_errno($ch);
        var_dump($oo);
    }

    public function a(){
        return view('reg.a');
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;

class UserController extends Controller
{
    public function getUser(){
         //get
         $uid=$_GET['id'];
         $data=[];
    }
}

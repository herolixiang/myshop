<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController.php extends Controller
{
    public function event()
    {
        echo $_GET['echostr'];
        die();
    }
}

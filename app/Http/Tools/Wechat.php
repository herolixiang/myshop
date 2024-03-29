<?php
namespace App\Http\Tools;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class Wechat{

    public  $request;
    public  $client;
    public function __construct(Request $request,Client $client)
    {
        $this->request = $request;
        $this->client = $client;
    }

     /**
     * 上传微信素材资源
     */
    // public function upload_source($up_type,$type,$title='',$desc=''){
    //     $file = $this->request->file($type);
    //     $file_ext = $file->getClientOriginalExtension();          //获取文件扩展名
    //     //重命名
    //     $new_file_name = time().rand(1000,9999). '.'.$file_ext;
    //     //文件保存路径
    //     //保存文件
    //     $save_file_path = $file->storeAs('wechat/video',$new_file_name);       //返回保存成功之后的文件路径
    //     $path = './storage/'.$save_file_path;
    //     // dd($path);
    //     if($up_type  == 1){
    //         $url='https://api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $this->get_access_token().'&type='.$type;
    //     }elseif($up_type == 2){
    //         $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->get_access_token().'&type='.$type;
    //     }
    //     $multipart = [
    //         [
    //             'name'     => 'media',
    //             'contents' => fopen(realpath($path), 'r')
    //         ],
    //     ];
    //     if($type == 'video' && $up_type == 2){
    //         $multipart[] = [
    //                 'name'     => 'description',
    //                 'contents' => json_encode(['title'=>$title,'introduction'=>$desc])
    //         ];
    //     }
    //     $response = $this->client->request('POST',$url,[
    //         'multipart' => $multipart
    //     ]);
    //     //返回信息
    //     $body = $response->getBody();
    //     unlink($path);
    //     return $body;
    // }


	public function post($url, $data){
        //初使化init方法
        $ch = curl_init();
        //指定URL
        curl_setopt($ch, CURLOPT_URL, $url);
        //设定请求后返回结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //声明使用POST方式来进行发送
        curl_setopt($ch, CURLOPT_POST, 1);
        //发送什么数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //忽略证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //忽略header头信息
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //设置超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //发送请求
        $output = curl_exec($ch);
        //关闭curl
        curl_close($ch);
        //返回数据
        return $output;
    }

    public function get_access_token(){
        //获取access_token
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $access_token_key = 'wechat_access_token';
        if($redis->exists($access_token_key)){
            //去缓存拿
            $access_token = $redis->get($access_token_key);
        }else{
            //去微信接口拿
            $access_re = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET'));
            $access_result = json_decode($access_re,1);
            $access_token = $access_result['access_token'];
            $expire_time = $access_result['expires_in'];
            //加入缓存
            $redis->set($access_token_key,$access_token,$expire_time);
        }
        return $access_token;
    }
}
?>
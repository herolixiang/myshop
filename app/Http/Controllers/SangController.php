<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Sang;
use App\Model\Aes;
use App\Model\Rsa;
class SangController extends Controller
{
 	public function add(Request $request)
 	{
 		//var_dump($request->file);die;
 		$name= $request->input('name');
        $price=$request->input('price');
         //文件上传
        $path="";
        if ($request->hasFile('file')) {
            $path = $request->file->store('img/'.date("Y-n-j"));
            // dd($res);
        }
        $res=Sang::insert([
            'name'=>$name,
            'price'=>$price,
            'tu'=>$path
        ]);
        if($res){
            return json_encode(['code'=>200,'msg'=>'添加成功']);
        }else{
            return json_encode(['code'=>201,'msg'=>'添加失败,程序异常,请联系管理员']);
        }
 	}

 	public function list(Request $request)
 	{
 		$name =$request->input('name');
        $where =[];
        $whereOr=[];
        if(isset($name)){
            $where[]= ['name','like',"%$name%"];
        }
        if(isset($name)){
            $whereOr[]= ['price','like',"%$name%"];
        }
        // var_dump($where);die;
 		$data= Sang::where($where)->orwhere($whereOr)->paginate(2)->toArray();
 		//二维数组改值
 		if(!empty($name)) {
 			foreach ($data['data'] as $key => $value) {
 				$data['data'][$key]['name']=str_replace($name,"<b style='color:red'>".$name."</b>",$value['name']);
 				$data['data'][$key]['price']=str_replace($name,"<b style='color:red'>".$name."</b>",$value['price']);
 			}
 			// var_dump($data);die;
 		}
        return json_encode(['code'=>200,'data'=>$data]);
        // $obj = new Aes('1234567890123456');
        // $data=json_encode($data);
        // $data = $obj->encrypt($data);


        // $obj = new Aes('1234567890123456');
        // $data="name=李翔&age=19&mobile=18434551398";
        // $data = $obj->encrypt($data);

        // $queryParts = explode('&', $eStr);
        // $params = array();
        // foreach ($queryParts as $param) {
        //    $item = explode('=', $param);
        //    $params[$item[0]] = $item[1];
        // }
        
        //举个粒子
        // $Rsa = new Rsa();
        // // $keys = $Rsa->new_rsa_key(); //生成完key之后应该记录下key值，这里省略
        // // p($keys);
        // $privkey = file_get_contents("Rsa.pem");//$keys['privkey'];
        // $pubkey  = file_get_contents("Aes.pem");//$keys['pubkey'];
        // //echo $privkey;die;
        // //初始化rsaobject
        // $Rsa->init($privkey, $pubkey,TRUE);
         
        // //原文
        // $data ='啊啥说法客户收到发货的世纪杀手';
         
        // $data = json_encode($data);
        // //私钥加密示例
        // $data = $Rsa->priv_encode($data);
        // // 解密
        // $data = $Rsa->pub_decode($data);
                // return json_encode($data);// 加密的
        //         return json_decode($data);// 解密的
 		
 	}

    public function del()
    {
        $id=request()->id;
       //s dd($id);
        $res=Sang::where(['id'=>$id])->delete();
        if($res){
            return json_encode(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json_encode(['code'=>201,'msg'=>'删除失败']);
        }
    }
}

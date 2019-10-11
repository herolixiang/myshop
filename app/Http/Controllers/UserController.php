<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tools\Tools;
use DB;

class UserController extends Controller
{
	public $tools;
	public function __construct(Tools $tools)
	{
		$this->tools=$tools;
	}
	public function index()
	{
		$redis=$this->tools->getRedis();
		$redis->incr('num');

		// echo "list 展示";
		$query=request()->all();
        $where = [];
        if ($query['user_name']??'') {
            $where[]=['user_name','like',"%$query[user_name]%"];
        }
        if ($query['user_nian']??'') {
            $where['user_nian']= $query['user_nian'];
        }

		$pagesize=config('app.pageSize');
		$data=DB::table('user')->where($where)->paginate($pagesize);
		return view('/user/list',['data'=>$data,'query'=>$query]);
	}

	public function create()
    {
    	$redis =new \Redis();
    	$redis->connect('127.0.0.1','6379');
    	$num=$redis->get('num');
    	echo $num."<br/>";
    	
        // echo "add 添加";

         //查询省份
        $provinceInfo=$this->getAreaInfo(0);
        // print_r($provinceInfo);exit;
        return view('user/add',compact('provinceInfo'));
    }

     public function store(Request $request)
    {
       $data=$request->except(['_token']);
        //文件上传
        if ($request->hasFile('user_logo') ) {
            $res=$this->upload($request,'user_logo');
            // dd($res);
            if ($res['code']) {
                $data['user_logo']= $res['imgurl'];
            }
        }
       $res=DB::table('user')->insert($data);
       // dd($res);
       if ($res) {
           return redirect('/user/list');
       }else{
           return error('添加失败','/user/add');
       }
    }

    //文件上传
    public function upload(Request $request,$file)
    {
        // dd($file);
        if ($request->file($file)->isValid()) {
            $photo=$request->file($file);
            // dump($photo);exit;

            // $extension = $photo->extension();
            $store_result = $photo->store(date('Ymd'));

            // dump($store_result);exit;
            // $store_result = $photo->storeAs('photo', 'test.jpg');

            return ['code'=>1,'imgurl'=>$store_result];
        }else{
            return ['code'=>0,'message'=>'上传过程出错'];
        }
    }


    public function edit($id)
    {
        // dd($id);
        $data=DB::table('user')->where(['user_id'=>$id])->first();
        // dd($data);
        return view('user.edit',compact('data'));
    }


     public function update(Request $request)
    {
        $data=$request->except(['_token']);
        $user_id=$request->user_id;
        // echo $li_id;exit;
        $res=DB::table('user')->where(['user_id'=>$user_id])->update($data);
        if ($res) {
            return redirect('/user/list');
        }
    }


    public function destroy($id)
    {
    	// echo "del 删除";
        $res=DB::table('user')->where('user_id','=',$id)->delete();
        //dd($res);
        if ($res) {
            return redirect('/user/list');
        }
    }

      public function getAddressInfo()
    {
        
        $addressInfo=DB::table('user')->get();
        // dump($addressInfo);exit;
        if(!empty($addressInfo)){
            //处理省市区
            foreach ($addressInfo as $k => $v) {
                $addressInfo[$k]->province=DB::table('area')->where('id',$v->province)->value('name');
                $addressInfo[$k]->city=DB::table('area')->where('id',$v->city)->value('name');
                $addressInfo[$k]->area=DB::table('area')->where('id',$v->area)->value('name');
            }
            return $addressInfo;
        }else{
            return false;
        }
    }


    
     //获取地区
    public function getAreaInfo($pid)
    {
        $where=[
            ['pid','=',$pid]
        ];
        $areaInfo=DB::table('area')->where($where)->get();
        return $areaInfo;
    }
    
    //获取区域
    public function getArea()
    {
        // echo "获取区域";die;
        $id=request()->id;
        $aresInfo=$this->getAreaInfo($id);
        // print_r($aresInfo);die;

        echo json_encode($aresInfo);
    }

}

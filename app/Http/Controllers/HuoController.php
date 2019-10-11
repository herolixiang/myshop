<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Tools\Tools;
use DB;

class HuoController extends Controller
{
    // public $tools;
    // public function __construct(Tools $tools)
    // {
    //     $this->tools=$tools;
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //缓存
        //new实例化一下redis
        $redis =new \Redis();  
        //connect链接一下 就和调用一样
        $redis->connect('127.0.0.1','6379');  
        //incr原子计数器存访问次数
        $redis->incr('num'); 
        //get获取访问次数
        $num=$redis->get('num'); 
        // dd($num);
        //echo 输出访问次数
        echo $num."人访问"."<br/>";
        
        $query=request()->all();
        $where = [];
        if ($query['huo_name']??'') {
            $where[]=['huo_name','like',"%$query[huo_name]%"];
        }
        if ($query['huo_ku']??'') {
            $where['huo_ku']= $query['huo_ku'];
        }
        $pagesize=config('app.pageSize');
        $data=DB::table('huo')->where($where)->paginate($pagesize);

        return view('/huo/list',['data'=>$data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('huo.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except(['_token']);
        //文件上传
        if ($request->hasFile('huo_logo')) {
            $res=$this->upload($request,'huo_logo');
            // dd($res);
            if ($res['code']) {
                $data['huo_logo']= $res['imgurl'];
            }
        }
         //时间戳
        $data['huo_time']=time();
        $res=DB::table('huo')->insert($data);
       // dd($res);
       if ($res) {
           return redirect('/huo/list');
       }else{
           return error('添加失败','/huo/add');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=DB::table('huo')->where(['huo_id'=>$id])->first();
        // dd($data);
        return view('huo.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data=$request->except(['_token']);
         //文件上传
        if ($request->hasFile('huo_logo')) {
            $res=$this->upload($request,'huo_logo');
            // dd($res);
            if ($res['code']) {
                $data['huo_logo']= $res['imgurl'];
            }
        }
        $huo_id=$request->huo_id;
        // echo $li_id;exit;
        $res=DB::table('huo')->where(['huo_id'=>$huo_id])->update($data);
        if ($res) {
            return redirect('/huo/list');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res=DB::table('huo')->where('huo_id','=',$id)->delete();
        //dd($res);
        if ($res) {
            return redirect('/huo/list');
        }
    }
}

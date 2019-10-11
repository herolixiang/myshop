<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tools\Tools;
use DB;

class BrandController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools=$tools;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $redis=$this->tools->getRedis();
        $redis =new \Redis();
        $redis->connect('127.0.0.1','6379');
        $redis->incr('num');

        // echo "list 展示";
        $query=request()->all();
        $where = [];
        if ($query['brand_name']??'') {
            $where[]=['brand_name','like',"%$query[brand_name]%"];
        }
        if ($query['brand_pid']??'') {
            $where['brand_pid']= $query['brand_pid'];
        }
        $pagesize=config('app.pageSize');
        $data=DB::table('brand')->where($where)->paginate($pagesize);

        //缓存
        $num=$redis->get('num');
        echo $num."人访问"."<br/>";

        return view('/brand/list',['data'=>$data,'query'=>$query]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $redis =new \Redis();
        $redis->connect('127.0.0.1','6379');
        $redis->incr('num');
        $num=$redis->get('num');
        echo $num."<br/>";

        // echo "add 添加";
        return view('brand.add');
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
        if ($request->hasFile('brand_logo')) {
            $res=$this->upload($request,'brand_logo');
            // dd($res);
            if ($res['code']) {
                $data['brand_logo']= $res['imgurl'];
            }
        }

        //时间戳
        $data['brand_time']=time();
        $res=DB::table('brand')->insert($data);
       // dd($res);
       if ($res) {
           return redirect('/brand/list');
       }else{
           return error('添加失败','/brand/add');
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
         // echo "edit 修改";
         // dd($id);
        $data=DB::table('brand')->where(['brand_id'=>$id])->first();
        // dd($data);
        return view('brand.edit',compact('data'));
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
        //修改图片
        if ($request->hasFile('brand_logo')) {
            $res=$this->upload($request,'brand_logo');
            // dd($res);
            if ($res['code']) {
                $data['brand_logo']= $res['imgurl'];
            }
        }
        $brand_id=$request->brand_id;
        // echo $li_id;exit;
        $res=DB::table('brand')->where(['brand_id'=>$brand_id])->update($data);
        if ($res) {
            return redirect('/brand/list');
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
        // echo "del 删除";
         $res=DB::table('brand')->where('brand_id','=',$id)->delete();
        //dd($res);
        if ($res) {
            return redirect('/brand/list');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class YanController extends Controller
{
 	public function login()
 	{
 		return view('yan.login');
 	}

 	public function login_do(Request $request)
 	{
 		$yan_name=request()->yan_name;
 		$yan_pwd=request()->yan_pwd;
 		// dd($info);
 		$res=DB::table('yan')->where('yan_name','=',$yan_name)->where('yan_pwd','=',$yan_pwd)->first();
 		if(!empty($res)) {
 			session(['name'=>$yan_name]);
 			echo "<script>alert('登录成功');location.href='index';</script>";
 		}else{
 			echo "<script>alert('登录失败,用户名和密码不正确');location.href='login';</script>";
 		}
 	}

 	public function index()
 	{
 		$redis =new \Redis();
        $redis->connect('127.0.0.1','6379');
        $redis->incr('num');

 		$query=request()->all();
        $where = [];
        if ($query['yan1_name']??'') {
            $where[]=['yan1_name','like',"%$query[yan1_name]%"];
        }
        if ($query['yan1_long']??'') {
            $where['yan1_long']= $query['yan1_long'];
        }

 		$pagesize=config('app.pageSize');
 		$data=DB::table('yan1')->where($where)->paginate($pagesize);

 		$num=$redis->get('num');
        echo "当前页面浏览量".$num."次"."<br/>";

 		return view('yan.index',['data'=>$data,'query'=>$query]);
 	}
 	public function add_do(Request $request)
 	{
 		$data=$request->except(['_token']);
 		$data['yan1_time']=time();
        $res=DB::table('yan1')->insert($data);
       // dd($res);
       if ($res) {
           echo "<script>alert('发布成功');location.href='index';</script>";
       }else{
           echo "<script>alert('发布失败');location.href='index';</script>";
       }
 	}

 	 public function del($id)
    {
        // echo "del 删除";
         $res=DB::table('yan1')->where('yan1_id','=',$id)->delete();
        //dd($res);
        if ($res) {
            echo "<script>alert('删除成功');location.href='/yan/index';</script>";
        }
    }
}

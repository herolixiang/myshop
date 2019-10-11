<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class DiaoController extends Controller
{
 	public function add()
 	{
 		return view('diao.add');
 	}

 	public function add_do(Request $request)
 	{
 		$data=$request->except(['_token']);
 		$res=DB::table('diao')->insert($data);
       // dd($res);
       if ($res) {
           return redirect('/diao/list');
       }else{
           return error('添加失败','/diao/add');
       }
 	}
 	public function list()
 	{
 		return view('diao.list');
 	}

 	public function list_do(Request $request)
 	{
 		$post = request() -> all();
        // dd($post);
        unset($post['_token']);
        $a = DB::table('diao1')->insert($post);
       $b = $post['diao1_sex'];
        if($a){
            if($b == 1){
                // echo "<><";
                return redirect('/diao/list1');
            }else if($b == 2){
                return redirect('/diao/list2');
            }
        }else{
            return redirect()->back();
        }
 	}
 	public function list1()
 	{
 		return view('diao.list1');
 	}
 	public function list1_do(Request $request)
 	{
 		 $data = request() -> all();
        //dd($aa);
        unset($data['_token']);
        if(empty($data['aaa'])){
            echo "<script>window.location.href='/diao/list1',alert('必选项不能为空')</script>";die;
        }
        $a = DB::table('diao2')->insert($data);
        if($a){
            return redirect('diao/index');
        }else{
            return redirect()->back();
        }
 	}
 	public function list2()
 	{
 		return view('diao.list2');
 	}
 	public function list2_do(Request $request)
 	{
 		 $data = $request -> all();
        //dd($aa);
        unset($data['_token']);
        $a = DB::table('diao2')->insert($data);
        if($a){
            return redirect('diao/index');
        }else{
            return redirect()->back();
        }
 	}
  public function index()
  {
     $pagesize=config('app.pageSize');
     $data=DB::table('diao')->paginate($pagesize);
    return view('/diao/index',['data'=>$data]);
  }
  public function del($id)
  {
      $res=DB::table('diao')->where('diao_id','=',$id)->delete();
      //dd($res);
      if ($res) {
          return redirect('/diao/index');
      }
  }
}

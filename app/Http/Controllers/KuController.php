<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class KuController extends Controller
{
    public function login()
    {
       return view('/ku/login');
    }
    public function login_do(Request $request)
    {
          $info=$request->all();
          // dd($info);
          if($info['ku_pwd']!='wuye123456' ){
              echo "<script>alert('登录失败,用户名和密码不正确');location.href='login';</script>";
          }else if($info['ku_name']!='wuyeadmin'){
              echo "<script>alert('登录失败,用户名和密码不正确');location.href='login';</script>";
          }else{
              session([ 'name'=>$info['ku_name'] ]);  
              echo "<script>alert('登录成功');location.href='index';</script>";
          }
    }
    public function index()
    {
        return view('ku.index');
    }
    public function menadd()
    {
        $data=DB::table('ku2')->get();
        return view('ku.menadd',['data'=>$data]);
    }
     public function menlist1()
    {
       
        return view('ku.menlist1');
    }
     public function menlist1_do(Request $request)
    {
       $data=$request->except(['_token']);
        //时间戳
        $data['add_time']=time();
        $res=DB::table('ku1')->insert($data);
        $res=DB::table('ku2')->decrement('ku2_liang',1);
       if ($res) {
           echo "<script>alert('车辆进入成功');location.href='/ku/menadd';</script>";
       }else{
           return error('添加失败','/ku/menlist1');
       }
    }
     public function menlist2()
    {
       
        return view('ku.menlist2');
    }
     public function menlist2_do(Request $request)
    {
        $data=$request->except(['_token']);
        $ku1_name=$data['ku1_name'];
        $res = DB::table('ku1')->where(['ku1_name'=>$ku1_name])->update([
            'ku1_state'=>2,
            'del_time'=>time(),
        ]);
        $res=DB::table('ku2')->increment('ku2_liang',1);
        if ($res) {
           echo "<script>alert('车辆成功离开');location.href='/ku/menadd';</script>";
       }else{
           return error('添加失败','/ku/menlist2');
       }
    }

    public function cheadd()
    {
        return view('ku.cheadd');
    }
    public function cheadd_do(Request $request)
    {   
        $data=$request->except(['_token']);
        $ku2_liang=$data['ku2_liang'];
        $res=DB::table('ku2')->increment('ku2_liang',$ku2_liang);
        if ($res) {
           return redirect('/ku/index');
       }else{
           return error('添加失败','/ku/cheadd');
       }
    }
}
